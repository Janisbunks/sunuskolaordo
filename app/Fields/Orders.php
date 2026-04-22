<?php

namespace App\Fields;

use Log1x\AcfComposer\Field;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Orders extends Field
{
  /**
   * The field group.
   *
   * @return array
   */
  public function fields()
  {
    $orders = new FieldsBuilder('orders');

    $orders
      ->setLocation('post_type', '==', 'pasutijumi');

    $orders
      ->addSelect('order_status', [
        'label' => 'Pasūtījuma Statuss',
        'choices' => [
          'sanemts' => 'Saņemts',
          'pabeigts' => 'Pabeigts',
          'atcelts' => 'Atcelts',
        ],
        'default_value' => 'sanemts',
        'required' => 1,
        'wrapper' => [
          'width' => '50%',
        ],
      ])
      ->addFile('invoice_pdf', [
        'label' => 'Rēķina PDF',
        'instructions' => 'Lejupielādēt rēķinu PDF formātā',
        'return_format' => 'array',
        'library' => 'all',
        'readonly' => 1,
      ])
      ->addText('customer_name', [
        'label' => 'Vārds, Uzvārds',
        'readonly' => 1,
      ])
      ->addEmail('customer_email', [
        'label' => 'E-pasts',
        'readonly' => 1,
      ])
      ->addText('customer_phone', [
        'label' => 'Telefons',
        'readonly' => 1,
      ])
      ->addText('delivery_method', [
        'label' => 'Piegādes Veids',
        'readonly' => 1,
      ])
      ->addNumber('delivery_cost', [
        'label' => 'Piegādes Izmaksas (EUR)',
        'readonly' => 1,
        'step' => 0.01,
      ])
      ->addNumber('total_amount', [
        'label' => 'Kopējā Summa (EUR)',
        'readonly' => 1,
        'step' => 0.01,
      ])
      ->addRepeater('order_items', [
        'label' => 'Pasūtītās Preces',
        'button_label' => 'Pievienot Preci',
        'layout' => 'table',
        'readonly' => 1,
      ])
      ->addText('product_name', [
        'label' => 'Produkta Nosaukums',
        'readonly' => 1,
      ])
      ->addText('size', [
        'label' => 'Izmērs',
        'readonly' => 1,
      ])
      ->addNumber('quantity', [
        'label' => 'Daudzums',
        'readonly' => 1,
      ])
      ->addNumber('price', [
        'label' => 'Cena (EUR)',
        'readonly' => 1,
        'step' => 0.01,
      ])
      ->addNumber('subtotal', [
        'label' => 'Kopsumma (EUR)',
        'readonly' => 1,
        'step' => 0.01,
      ])
      ->endRepeater()
      ->addDateTimePicker('order_date', [
        'label' => 'Pasūtījuma Datums',
        'readonly' => 1,
        'display_format' => 'd/m/Y H:i',
        'return_format' => 'Y-m-d H:i:s',
      ]);

    return $orders->build();
  }
}
