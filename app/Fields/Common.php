<?php

namespace App\Fields;

use Log1x\AcfComposer\Field;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Common extends Field
{
    /**
     * The field group.
     *
     * @return array
     */
    public function fields()
    {
        $fields = new FieldsBuilder('Common');

        $fields
            ->setLocation('post_type', '==', 'all')
                ->or('taxonomy', '==', 'all');

        $fields
            ->addText('h1', [
                'instructions' => 'Specify a custom H1 to override the default setting.'
            ]);

        return $fields->build();
    }
}
