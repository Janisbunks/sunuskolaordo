<?php

namespace App\View\Composers;

use Log1x\Navi\Facades\Navi;
use Roots\Acorn\View\Composer;

class Navigation extends Composer
{
  /**
   * List of views served by this composer.
   *
   * @var array
   */
  protected static $views = [
    'partials.navigation',
    'partials.mobile-menu',
    'partials.footer-menu',
  ];

  /**
   * Data to be passed to view before rendering.
   *
   * @return array
   */
  public function with()
  {

    return [
      'navigation' => $this->navigation(),
      'mobile-menu' => $this->navigation(),
      'footerNav' => $this->footerNav(),
    ];
  }

  /**
   * Returns the primary navigation.
   *
   * @return array
   */
  public function navigation()
  {
    if (Navi::build()->isEmpty()) {
      return;
    }

    return Navi::build()->toArray();
  }
  /**
   * Returns the Footer navigation.
   *
   * @return array|null
   */
  public function footerNav()
  {
    $menu = Navi::build('Footer Menu');

    if ($menu->isEmpty()) {
      return null;
    }

    return $menu->toArray();
  }
}
