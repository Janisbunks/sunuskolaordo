<?php

/**
 * Generate PDF invoice and send order notification email to seller.
 */
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/wp/wp-load.php';

use Dompdf\Dompdf;

session_start();
$cart = $_SESSION['cart'] ?? [];

// New cart structure: [cart_key => ['product_id', 'size', 'quantity', 'price']]
$items = [];
$total = 0;

if ($cart && is_array($cart)) {
  foreach ($cart as $cartKey => $cartItem) {
    $productId = $cartItem['product_id'] ?? 0;
    $size = $cartItem['size'] ?? '';
    $quantity = (int) ($cartItem['quantity'] ?? 0);
    $price = (float) ($cartItem['price'] ?? 0);

    if ($quantity > 0 && $price > 0) {
      $product = get_post($productId);
      if ($product) {
        $subtotal = $price * $quantity;
        $total += $subtotal;
        $items[] = [
          'name' => $product->post_title,
          'size' => $size,
          'qty' => $quantity,
          'price' => $price,
          'subtotal' => $subtotal,
        ];
      }
    }
  }
}

// Get customer data from GET or POST
$name = sanitize_text_field($_GET['name'] ?? $_POST['name'] ?? '');
$email = sanitize_email($_GET['email'] ?? $_POST['email'] ?? '');
$phone = sanitize_text_field($_GET['phone'] ?? $_POST['phone'] ?? '');
$notes = sanitize_textarea_field($_GET['notes'] ?? $_POST['notes'] ?? '');
$delivery_method = sanitize_text_field($_GET['delivery_method'] ?? $_POST['delivery_method'] ?? '');
$delivery_cost = (float) ($_GET['delivery_cost'] ?? $_POST['delivery_cost'] ?? 0);
$grand_total = (float) ($_GET['total'] ?? $_POST['total'] ?? $total);

// Delivery method labels
$delivery_labels = [
  'salaspils' => 'Izņemšana Salaspilī',
  'vienojoties' => 'Vienojoties par izņemšanu konkrētās dienās Ikšķilē, Ogrē, Ķekavā',
  'omniva' => 'Sūtīšana ar Omniva uz jūsu izvēlēto pakomātu'
];
$delivery_label = $delivery_labels[$delivery_method] ?? $delivery_method;

// Validate required fields
if (empty($name) || empty($email) || empty($items) || empty($delivery_method)) {
  wp_die('Trūkst nepieciešamo datu. Lūdzu atgriezieties un aizpildiet visus obligātos laukus, un pārliecinieties, ka jūsu grozs nav tukšs.');
}

// Send notification email to seller
$optionsContactInfo = get_field('contact_information', 'option');
$seller_emails = ['bunksjanis@gmail.com', 'sunuskolaordo@inbox.lv'];
$subject = sprintf('[%s] Jauns pasūtījums no %s', get_bloginfo('name'), $name);

$lines = [
  "Jauns pasūtījuma pieprasījums",
  "",
  "Klients: $name",
  "E-pasts: $email",
];
if ($phone) {
  $lines[] = "Telefons: $phone";
}
if ($notes) {
  $lines[] = "Piezīmes: $notes";
}
$lines[] = "Piegādes veids: $delivery_label";
if ($delivery_cost > 0) {
  $lines[] = "Piegādes izmaksas: €" . number_format($delivery_cost, 2);
}
$lines[] = "";
$lines[] = "Produkti:";

foreach ($items as $it) {
  $lines[] = sprintf("- %s (Izmērs: %s) x%d @ €%.2f = €%.2f", $it['name'], $it['size'], $it['qty'], $it['price'], $it['subtotal']);
}
$lines[] = "";
$lines[] = "Preču summa: €" . number_format($total, 2);
if ($delivery_cost > 0) {
  $lines[] = "Piegāde: €" . number_format($delivery_cost, 2);
}
$lines[] = "KOPĀ: €" . number_format($grand_total, 2);

// Generate unique order number using auto-increment
$last_order = get_posts([
  'post_type' => 'pasutijumi',
  'posts_per_page' => 1,
  'orderby' => 'date',
  'order' => 'DESC',
]);

$increment = 1;
if (!empty($last_order)) {
  // Extract increment from last order title
  $last_title = $last_order[0]->post_title;
  if (preg_match('/ORD-\d{8}-(\d{4})/', $last_title, $matches)) {
    $increment = (int)$matches[1] + 1;
  }
}

$order_number = 'ORD-' . date('Ymd') . '-' . str_pad($increment, 4, '0', STR_PAD_LEFT);

$order_post_id = wp_insert_post([
  'post_type' => 'pasutijumi',
  'post_title' => $order_number . ' - ' . $name,
  'post_status' => 'publish',
  'post_author' => 1,
]);

if ($order_post_id && !is_wp_error($order_post_id)) {
  // Save customer info
  update_field('order_status', 'sanemts', $order_post_id);
  update_field('customer_name', $name, $order_post_id);
  update_field('customer_email', $email, $order_post_id);
  update_field('customer_phone', $phone, $order_post_id);
  update_field('delivery_method', $delivery_label, $order_post_id);
  update_field('delivery_cost', $delivery_cost, $order_post_id);
  update_field('total_amount', $grand_total, $order_post_id);
  update_field('order_date', current_time('Y-m-d H:i:s'), $order_post_id);

  // Save order items
  $order_items_data = [];
  foreach ($items as $it) {
    $order_items_data[] = [
      'product_name' => $it['name'],
      'size' => $it['size'],
      'quantity' => $it['qty'],
      'price' => $it['price'],
      'subtotal' => $it['subtotal'],
    ];
  }
  update_field('order_items', $order_items_data, $order_post_id);
}

// Clear cart after successful order
$_SESSION['cart'] = [];

// Generate HTML for PDF with modern styling
ob_start(); ?>
<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'DejaVu Sans', 'Arial', sans-serif;
      padding: 30px;
      color: #1f2937;
      line-height: 1.4;
      font-size: 11px;
    }

    .header {
      border-bottom: 2px solid #10b981;
      padding-bottom: 15px;
      margin-bottom: 20px;
      position: relative;
    }

    .header-content {
      display: table;
      width: 100%;
    }

    .header-left {
      display: table-cell;
      vertical-align: middle;
    }

    .header-right {
      display: table-cell;
      vertical-align: middle;
      text-align: right;
      width: 200px;
    }

    .logo {
      max-width: 100px;
      height: auto;
    }

    h1 {
      color: #10b981;
      font-size: 24px;
      margin-bottom: 5px;
    }

    .company-name {
      font-size: 13px;
      color: #6b7280;
    }

    .invoice-number {
      font-size: 11px;
      color: #6b7280;
      margin-top: 3px;
    }

    .section {
      margin-bottom: 20px;
    }

    .section-title {
      font-size: 14px;
      font-weight: bold;
      color: #374151;
      margin-bottom: 10px;
      padding-bottom: 5px;
      border-bottom: 1px solid #e5e7eb;
    }

    .info-grid {
      display: table;
      width: 100%;
      margin-bottom: 20px;
    }

    .info-row {
      display: table-row;
    }

    .info-label {
      display: table-cell;
      font-weight: bold;
      padding: 4px 15px 4px 0;
      color: #6b7280;
      width: 130px;
      font-size: 11px;
    }

    .info-value {
      display: table-cell;
      padding: 4px 0;
      color: #1f2937;
      font-size: 11px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    th {
      background-color: #f3f4f6;
      text-align: left;
      padding: 8px;
      font-size: 11px;
      color: #374151;
      border-bottom: 2px solid #d1d5db;
    }

    td {
      padding: 8px;
      border-bottom: 1px solid #e5e7eb;
      font-size: 11px;
    }

    tr:last-child td {
      border-bottom: none;
    }

    .text-right {
      text-align: right;
    }

    .total-row {
      background-color: #ecfdf5;
      font-weight: bold;
      font-size: 12px;
    }

    .total-row td {
      padding: 10px 8px;
      color: #10b981;
    }

    .payment-info {
      background-color: #f9fafb;
      padding: 12px;
      border-radius: 6px;
      border-left: 3px solid #10b981;
      font-size: 10px;
    }

    .payment-info p {
      margin-bottom: 5px;
      line-height: 1.3;
    }

    .footer {
      margin-top: 20px;
      padding-top: 12px;
      border-top: 1px solid #e5e7eb;
      text-align: center;
      color: #6b7280;
      font-size: 9px;
      line-height: 1.3;
    }
  </style>
</head>

<body>
  <div class="header">
    <div class="header-content">
      <div class="header-left">
        <h1>RĒĶINS</h1>
        <div class="company-name"><?= htmlspecialchars(get_bloginfo('name')) ?></div>
        <div class="invoice-number">Rēķina Nr: <?= htmlspecialchars($order_number) ?></div>
      </div>
      <div class="header-right">
        <img src="https://sunuskolaordo.lv/content/uploads/2025/01/ORDO-logo.png" alt="Logo" class="logo">
      </div>
    </div>
  </div>

  <div class="section">
    <div class="section-title">Klienta Informācija</div>
    <div class="info-grid">
      <div class="info-row">
        <div class="info-label">Vārds, Uzvārds:</div>
        <div class="info-value"><?= htmlspecialchars($name) ?></div>
      </div>
      <div class="info-row">
        <div class="info-label">E-pasts:</div>
        <div class="info-value"><?= htmlspecialchars($email) ?></div>
      </div>
      <?php if ($phone): ?>
        <div class="info-row">
          <div class="info-label">Telefons:</div>
          <div class="info-value"><?= htmlspecialchars($phone) ?></div>
        </div>
      <?php endif; ?>
      <div class="info-row">
        <div class="info-label">Piegādes veids:</div>
        <div class="info-value"><?= htmlspecialchars($delivery_label) ?></div>
      </div>
      <?php if ($notes): ?>
        <div class="info-row">
          <div class="info-label">Piezīmes:</div>
          <div class="info-value"><?= htmlspecialchars($notes) ?></div>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <div class="section">
    <div class="section-title">Pasūtījuma Kopsavilkums</div>
    <table>
      <thead>
        <tr>
          <th>Produkts</th>
          <th>Izmērs</th>
          <th class="text-right">Daudzums</th>
          <th class="text-right">Cena</th>
          <th class="text-right">Summa</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($items as $it): ?>
          <tr>
            <td><?= htmlspecialchars($it['name']) ?></td>
            <td><?= htmlspecialchars($it['size']) ?></td>
            <td class="text-right"><?= $it['qty'] ?></td>
            <td class="text-right">€<?= number_format($it['price'], 2) ?></td>
            <td class="text-right">€<?= number_format($it['subtotal'], 2) ?></td>
          </tr>
        <?php endforeach; ?>
        <tr>
          <td colspan="4" class="text-right" style="font-weight: bold;">Preces Kopā:</td>
          <td class="text-right" style="font-weight: bold;">€<?= number_format($total, 2) ?></td>
        </tr>
        <?php if ($delivery_cost > 0): ?>
          <tr>
            <td colspan="4" class="text-right" style="font-weight: bold;">Piegāde:</td>
            <td class="text-right" style="font-weight: bold;">€<?= number_format($delivery_cost, 2) ?></td>
          </tr>
        <?php endif; ?>
        <tr class="total-row">
          <td colspan="4" class="text-right">KOPĀ APMAKSAI:</td>
          <td class="text-right">€<?= number_format($grand_total, 2) ?></td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="section">
    <div class="section-title">Maksājuma Informācija</div>
    <div class="payment-info">
      <p><strong>Saņēmējs:</strong> SIA "Suņu Skola Ordo"</p>
      <p><strong>Reģistrācijas nummurs:</strong> 40203476865</p>
      <p><strong>Adrese:</strong> Salaspils nov., Salaspils, Vītolu iela 3 - 6</p>
      <p><strong>Banka:</strong> A/S Swedbank</p>
      <p><strong>Konta nr:</strong> LV35HABA0551054540256</p>
      <p style="margin-top: 15px;"><em>Lūdzu, norādiet savu vārdu un pasūtījuma numuru maksājuma mērķī.</em></p>
    </div>
  </div>

  <div class="footer">
    <p>Paldies par jūsu pasūtījumu!</p>
    <p>Ja jums ir jautājumi, lūdzu, sazinieties ar mums: sunuskolaordo@inbox.lv</p>
  </div>
</body>

</html>
<?php
$html = ob_get_clean();

// Enable remote file access for images
$options = new \Dompdf\Options();
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Get the PDF output as string
$pdf_output = $dompdf->output();

// Save PDF to uploads directory and attach to order post
if (isset($order_post_id) && $order_post_id && !is_wp_error($order_post_id)) {
  $upload_dir = wp_upload_dir();
  $pdf_filename = $order_number . '.pdf';
  $pdf_filepath = $upload_dir['path'] . '/' . $pdf_filename;

  // Save PDF file
  file_put_contents($pdf_filepath, $pdf_output);

  // Create attachment
  $attachment = [
    'guid' => $upload_dir['url'] . '/' . basename($pdf_filepath),
    'post_mime_type' => 'application/pdf',
    'post_title' => $order_number . ' - Rēķins',
    'post_content' => '',
    'post_status' => 'inherit'
  ];

  $attach_id = wp_insert_attachment($attachment, $pdf_filepath, $order_post_id);

  // Generate attachment metadata
  require_once(ABSPATH . 'wp-admin/includes/image.php');
  $attach_data = wp_generate_attachment_metadata($attach_id, $pdf_filepath);
  wp_update_attachment_metadata($attach_id, $attach_data);

  // Set as featured/attached to the post
  set_post_thumbnail($order_post_id, $attach_id);

  // Save PDF to ACF file field for easy access
  update_field('invoice_pdf', $attach_id, $order_post_id);

  // Send email to customer with PDF attachment
  $customer_subject = 'Jūsu pasūtījums #' . $order_number . ' - ' . get_bloginfo('name');
  $customer_message = "Labdien, " . $name . "!\n\n";
  $customer_message .= "Paldies par jūsu pasūtījumu!\n\n";
  $customer_message .= "Pasūtījuma numurs: " . $order_number . "\n";
  $customer_message .= "Kopējā summa: €" . number_format($grand_total, 2) . "\n";
  $customer_message .= "Piegādes veids: " . $delivery_label . "\n\n";
  $customer_message .= "Rēķins ir pievienots šim e-pastam.\n\n";
  $customer_message .= "Sazināsimies ar jums 1-2 darba dienu laikā, lai apstiprinātu pasūtījumu un piegādes detaļas.\n\n";
  $customer_message .= "Ar cieņu,\n";
  $customer_message .= get_bloginfo('name');

  $customer_headers = ['Content-Type: text/plain; charset=UTF-8'];
  wp_mail($email, $customer_subject, $customer_message, $customer_headers, [$pdf_filepath]);

  // Send notification email to admin (without PDF)
  $admin_subject = '[' . get_bloginfo('name') . '] Jauns pasūtījums #' . $order_number;
  $admin_message = "Jauns pasūtījums ir saņemts!\n\n";
  $admin_message .= "Pasūtījuma numurs: " . $order_number . "\n";
  $admin_message .= "Klients: " . $name . "\n";
  $admin_message .= "E-pasts: " . $email . "\n";
  if ($phone) {
    $admin_message .= "Telefons: " . $phone . "\n";
  }
  $admin_message .= "Piegādes veids: " . $delivery_label . "\n";
  if ($delivery_cost > 0) {
    $admin_message .= "Piegādes izmaksas: €" . number_format($delivery_cost, 2) . "\n";
  }
  $admin_message .= "\nProduktи:\n";
  foreach ($items as $it) {
    $admin_message .= "- " . $it['name'] . " (Izmērs: " . $it['size'] . ") x" . $it['qty'] . " @ €" . number_format($it['price'], 2) . " = €" . number_format($it['subtotal'], 2) . "\n";
  }
  $admin_message .= "\nKopā: €" . number_format($grand_total, 2) . "\n\n";
  $admin_message .= "Skatīt pasūtījumu admin panelī:\n";
  $admin_message .= admin_url('post.php?post=' . $order_post_id . '&action=edit');

  $admin_headers = ['Content-Type: text/plain; charset=UTF-8'];

  // Send to both admin emails
  foreach ($seller_emails as $seller_email) {
    wp_mail($seller_email, $admin_subject, $admin_message, $admin_headers);
  }
}

// Stream PDF to browser
$dompdf->stream('rekins.pdf', ['Attachment' => false]);

exit;
