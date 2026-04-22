<?php

namespace App\Providers;

use Illuminate\Support\Collection;
use Roots\Acorn\Sage\SageServiceProvider;

class ThemeServiceProvider extends SageServiceProvider
{
  /**
   * Register theme services.
   *
   * @return void
   */
  public function register()
  {
    parent::register();

    /**
     * Register theme support and navigation menus from the theme config.
     *
     * @return void
     */
    add_action('after_setup_theme', function (): void {
      Collection::make(config('theme.support'))
        ->map(fn($params, $feature) => is_array($params) ? [$feature, $params] : [$params])
        ->each(fn($params) => add_theme_support(...$params));

      Collection::make(config('theme.remove'))
        ->map(fn($entry) => is_string($entry) ? [$entry] : $entry)
        ->each(fn($params) => remove_theme_support(...$params));

      register_nav_menus(config('theme.menus'));

      Collection::make(config('theme.image_sizes'))
        ->each(fn($params, $name) => add_image_size($name, ...$params));
    }, 20);

    /**
     * Register sidebars from the theme config.
     *
     * @return void
     */
    add_action('widgets_init', function (): void {
      Collection::make(config('theme.sidebar.register'))
        ->map(fn($instance) => register_sidebar(
          array_merge(config('theme.sidebar.config'), $instance)
        ));
    });
    add_filter('wpcf7_autop_or_not', '__return_false');
    add_filter('wpcf7_form_elements', function ($content) {
      $content = preg_replace('/<(span).*?class="\s*(?:.*\s)?wpcf7-form-control-wrap(?:\s[^"]+)?\s*"[^\>]*>(.*)<\/\1>/i', '\2', $content);

      return $content;
    });
  }

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    parent::boot();

    // Load product sizes dynamically from global options
    add_filter('acf/load_field', function($field) {
      // Only target our specific field
      if (!isset($field['name']) || $field['name'] !== 'product_sizes') {
        return $field;
      }

      // Debug: Log that we reached this point
      error_log('=== ACF LOAD FIELD TRIGGERED FOR product_sizes ===');

      // Get variants from options - field is inside product_variant group
      $productVariant = get_field('product_variant', 'option');
      error_log('Product Variant: ' . print_r($productVariant, true));

      $variants = $productVariant['variant'] ?? [];
      error_log('Variants: ' . print_r($variants, true));

      if (!$variants || !is_array($variants)) {
        error_log('No variants found or not an array');
        // Return field with empty choices if no variants
        $field['choices'] = [];
        return $field;
      }

      $sizeChoices = [];

      foreach ($variants as $variant) {
        if (!empty($variant['size'])) {
          $size = $variant['size'];
          $price = !empty($variant['price']) ? ' - ' . $variant['price'] . ' €' : '';
          $sizeChoices[$size] = $size . $price;
        }
      }

      error_log('Final size choices: ' . print_r($sizeChoices, true));

      $field['choices'] = $sizeChoices;

      return $field;
    });

    // Register WordPress AJAX handlers for cart
    add_action('wp_ajax_add_to_cart', [$this, 'handleAddToCart']);
    add_action('wp_ajax_nopriv_add_to_cart', [$this, 'handleAddToCart']);

    add_action('wp_ajax_update_cart_quantity', [$this, 'handleUpdateQuantity']);
    add_action('wp_ajax_nopriv_update_cart_quantity', [$this, 'handleUpdateQuantity']);

    add_action('wp_ajax_remove_cart_item', [$this, 'handleRemoveItem']);
    add_action('wp_ajax_nopriv_remove_cart_item', [$this, 'handleRemoveItem']);

    add_action('wp_ajax_clear_cart', [$this, 'handleClearCart']);
    add_action('wp_ajax_nopriv_clear_cart', [$this, 'handleClearCart']);

    // Add custom columns for Pasūtījumi post type
    add_filter('manage_pasutijumi_posts_columns', [$this, 'addOrderColumns']);
    add_action('manage_pasutijumi_posts_custom_column', [$this, 'renderOrderColumns'], 10, 2);
    add_filter('manage_edit-pasutijumi_sortable_columns', [$this, 'makeOrderColumnsSortable']);

    // Sort orders by date descending (newest first)
    add_filter('pre_get_posts', [$this, 'sortOrdersByDate']);
  }

  /**
   * Handle add to cart AJAX request
   */
  public function handleAddToCart()
  {
    if (!session_id()) {
      session_start();
    }

    if (!isset($_SESSION['cart'])) {
      $_SESSION['cart'] = [];
    }

    $productId = (int) ($_POST['product_id'] ?? 0);
    $size = sanitize_text_field($_POST['size'] ?? '');
    $quantity = max(1, (int) ($_POST['quantity'] ?? 1));

    // Get size/price variants from options
    $productVariant = get_field('product_variant', 'option');
    $allVariants = $productVariant['variant'] ?? [];
    $variantMap = collect($allVariants)->keyBy('size')->toArray();
    $price = $variantMap[$size]['price'] ?? 0;

    if ($productId && $size && $price) {
      $cartKey = $productId . '_' . $size;

      if (isset($_SESSION['cart'][$cartKey])) {
        $_SESSION['cart'][$cartKey]['quantity'] += $quantity;
      } else {
        $_SESSION['cart'][$cartKey] = [
          'product_id' => $productId,
          'size' => $size,
          'quantity' => $quantity,
          'price' => $price
        ];
      }

      wp_send_json_success([
        'message' => 'Pievienots grozā!',
        'cart' => $_SESSION['cart'],
        'count' => array_sum(array_column($_SESSION['cart'], 'quantity'))
      ]);
    } else {
      wp_send_json_error(['message' => 'Nederīgi dati!']);
    }
  }

  /**
   * Handle update cart quantity AJAX request
   */
  public function handleUpdateQuantity()
  {
    if (!session_id()) {
      session_start();
    }

    $cartKey = sanitize_text_field($_POST['cart_key'] ?? '');
    $quantity = max(1, (int) ($_POST['quantity'] ?? 1));

    if (isset($_SESSION['cart'][$cartKey])) {
      $_SESSION['cart'][$cartKey]['quantity'] = $quantity;

      wp_send_json_success([
        'cart' => $_SESSION['cart'],
        'count' => array_sum(array_column($_SESSION['cart'], 'quantity'))
      ]);
    } else {
      wp_send_json_error();
    }
  }

  /**
   * Handle remove cart item AJAX request
   */
  public function handleRemoveItem()
  {
    if (!session_id()) {
      session_start();
    }

    $cartKey = sanitize_text_field($_POST['cart_key'] ?? '');

    if (isset($_SESSION['cart'][$cartKey])) {
      unset($_SESSION['cart'][$cartKey]);

      wp_send_json_success([
        'cart' => $_SESSION['cart'],
        'count' => array_sum(array_column($_SESSION['cart'], 'quantity'))
      ]);
    } else {
      wp_send_json_error();
    }
  }

  /**
   * Handle clear cart AJAX request
   */
  public function handleClearCart()
  {
    if (!session_id()) {
      session_start();
    }

    $_SESSION['cart'] = [];
    wp_send_json_success();
  }

  /**
   * Add custom columns to Pasūtījumi list
   */
  public function addOrderColumns($columns)
  {
    $new_columns = [];
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = 'Pasūtījums';
    $new_columns['order_status'] = 'Statuss';
    $new_columns['customer_info'] = 'Klients';
    $new_columns['total_amount'] = 'Summa';
    $new_columns['order_date'] = 'Datums';
    return $new_columns;
  }

  /**
   * Render custom column content
   */
  public function renderOrderColumns($column, $post_id)
  {
    switch ($column) {
      case 'order_status':
        $status = get_field('order_status', $post_id);
        $status_labels = [
          'sanemts' => '<span style="display:inline-block;padding:4px 12px;background:#dbeafe;color:#1e40af;border-radius:12px;font-size:12px;font-weight:600;">Saņemts</span>',
          'apstrade' => '<span style="display:inline-block;padding:4px 12px;background:#fef3c7;color:#92400e;border-radius:12px;font-size:12px;font-weight:600;">Apstrādē</span>',
          'izsutits' => '<span style="display:inline-block;padding:4px 12px;background:#ddd6fe;color:#5b21b6;border-radius:12px;font-size:12px;font-weight:600;">Izsūtīts</span>',
          'pabeigts' => '<span style="display:inline-block;padding:4px 12px;background:#d1fae5;color:#065f46;border-radius:12px;font-size:12px;font-weight:600;">Pabeigts</span>',
          'atcelts' => '<span style="display:inline-block;padding:4px 12px;background:#fee2e2;color:#991b1b;border-radius:12px;font-size:12px;font-weight:600;">Atcelts</span>',
        ];
        echo $status_labels[$status] ?? '—';
        break;

      case 'customer_info':
        $name = get_field('customer_name', $post_id);
        $email = get_field('customer_email', $post_id);
        $phone = get_field('customer_phone', $post_id);
        echo '<strong>' . esc_html($name) . '</strong><br>';
        echo '<small>' . esc_html($email) . '</small><br>';
        if ($phone) {
          echo '<small>' . esc_html($phone) . '</small>';
        }
        break;

      case 'total_amount':
        $total = get_field('total_amount', $post_id);
        echo '<strong style="color:#059669;font-size:14px;">€' . number_format($total, 2) . '</strong>';
        break;

      case 'order_date':
        $date = get_field('order_date', $post_id);
        if ($date) {
          echo date('d.m.Y H:i', strtotime($date));
        }
        break;
    }
  }

  /**
   * Make order columns sortable
   */
  public function makeOrderColumnsSortable($columns)
  {
    $columns['order_status'] = 'order_status';
    $columns['total_amount'] = 'total_amount';
    $columns['order_date'] = 'order_date';
    return $columns;
  }

  /**
   * Sort orders by date descending (newest first)
   */
  public function sortOrdersByDate($query)
  {
    if (!is_admin() || !$query->is_main_query()) {
      return;
    }

    if ($query->get('post_type') === 'pasutijumi') {
      $query->set('orderby', 'date');
      $query->set('order', 'DESC');
    }
  }
}
