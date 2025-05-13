<?php

namespace App\Fields;

use Log1x\AcfComposer\Field;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Nodarbiba extends Field
{
    /**
     * The field group.
     *
     * @return array
     */
    public function fields()
    {
        $nodarbiba = new FieldsBuilder('nodarbiba');

        $nodarbiba
            ->setLocation('post_type', '==', 'nodarbibas');

        $nodarbiba
            ->addText('pricing', [
                'label' => 'Ilgums + Cena, atdalam savstarpēji ar |',
            ])
            ->addText('description', [
                'label' => 'Mazais Apraksts priekš Sākuma Lapas',
            ])
            ->addText('subtitle', [
                'label' => 'Apraksts zem virsraksta (Sākuma Lapa)',
            ])
            ->addTextarea('svg', [
                'label' => 'SVG kods',
            ]);

        return $nodarbiba->build();
    }
}
