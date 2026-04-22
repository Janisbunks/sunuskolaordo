<?php

namespace App\Fields;

use Log1x\AcfComposer\Field;
use StoutLogic\AcfBuilder\FieldsBuilder;

class ProductCategories extends Field
{
  /**
   * The field group.
   *
   * @return array
   */
  public function fields()
  {
    $productCategories = new FieldsBuilder('product_categories');

    $productCategories
      ->setLocation('taxonomy', '==', 'kategorija');

    $productCategories
      ->addImage('kategorijas_bilde', [
        'label' => 'Kategorijas bilde',
        'instructions' => 'Pievienojiet attēlu šai kategorijai',
        'return_format' => 'id',
        'preview_size' => 'medium',
      ]);

    return $productCategories->build();
  }
}
