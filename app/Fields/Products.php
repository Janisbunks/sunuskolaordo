<?php

namespace App\Fields;

use Log1x\AcfComposer\Field;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Products extends Field
{
  /**
   * The field group.
   *
   * @return array
   */
  public function fields()
  {
    $products = new FieldsBuilder('products');

    $products
      ->setLocation('post_type', '==', 'produkti');

    $products
      ->addCheckbox('product_sizes', [
        'label' => 'Pieejamie Izmēri',
        'choices' => [],
        'layout' => 'vertical',
        'return_format' => 'value',
        'instructions' => 'Izvēlies, kuri izmēri ir pieejami šim produktam. Izmēri un cenas tiek pārvaldīti sadaļā Options > Product Variant.',
      ]);

    return $products->build();
  }
}
