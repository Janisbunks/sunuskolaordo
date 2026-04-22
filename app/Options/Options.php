<?php

namespace App\Options;

use Log1x\AcfComposer\Options as Field;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Options extends Field
{
  /**
   * The option page menu name.
   *
   * @var string
   */
  public $name = 'Options';

  /**
   * The option page menu slug.
   *
   * @var string
   */
  public $slug = 'options';

  /**
   * The option page document title.
   *
   * @var string
   */
  public $title = 'Theme Options';

  /**
   * The option page permission capability.
   *
   * @var string
   */
  public $capability = 'edit_theme_options';

  /**
   * The option page menu position.
   *
   * @var int
   */
  public $position = PHP_INT_MAX;

  /**
   * The slug of another admin page to be used as a parent.
   *
   * @var string
   */
  public $parent = null;

  /**
   * The option page menu icon.
   *
   * @var string
   */
  public $icon = null;

  /**
   * Redirect to the first child page if one exists.
   *
   * @var bool
   */
  public $redirect = true;

  /**
   * The post ID to save and load values from.
   *
   * @var string|int
   */
  public $post = 'options';

  /**
   * The option page autoload setting.
   *
   * @var bool
   */
  public $autoload = true;

  /**
   * Localized text displayed on the submit button.
   *
   * @return string
   */
  public function updateButton()
  {
    return __('Update', 'acf');
  }

  /**
   * Localized text displayed after form submission.
   *
   * @return string
   */
  public function updatedMessage()
  {
    return __('Options Updated', 'acf');
  }

  /**
   * The option page field group.
   *
   * @return array
   */
  public function fields()
  {
    $options = new FieldsBuilder('options');

    $options
      ->addGroup('branding')
      ->addTab('logo')
      ->addImage('logo')
      ->addImage('logo_webp')
      ->addTab('secondary_logo')
      ->addImage('logo_secondary')
      ->addImage('logo_secondary_webp')
      ->addTab('mobile_logo')
      ->addImage('logo_mobile')
      ->addImage('logo_mobile_webp')
      ->endGroup()

      ->addGroup('contact_information')
      ->addTab('main_contact_information')
      ->addEmail('email_address')
      ->setConfig('validate_format', true)
      ->addText('phone_number', [
        'placeholder' => 'E.g. (123) 456-7890, 123-456-7890',
      ])
      ->endGroup()

      ->addGroup('pamatpaklausibas_nodarbibas')
      ->addRepeater('single_location')
      ->addText('title', [
        'label' => 'Vietas nosaukums (Akropole ...)'
      ])
      ->addText('date', [
        'label' => 'No "Datums" · "Diena" · "laiks"'
      ])
      ->addText('space', [
        'label' => 'Cik brīvas vietas?'
      ])
      ->endRepeater()
      ->endGroup()

      ->addGroup('product_variant')
      ->addRepeater('variant', [
        'label' => 'Izmēri un Cenas',
        'layout' => 'table',
      ])
      ->addText('size', ['label' => 'Izmērs'])
      ->addText('price', ['label' => 'Cena'])
      ->endRepeater()
      ->endGroup()

      ->addGroup('sertifikati')
      ->addRepeater('sertifikats')
      ->addText('title', [
        'label' => 'File Title',
        'required' => 1
      ])
      ->addFile('file', [
        'label' => 'Upload File',
        'instructions' => 'Upload PDF or image files',
        'required' => 1,
        'mime_types' => 'pdf, jpg, jpeg, png, gif',
        'return_format' => 'array'
      ])
      ->endRepeater()
      ->endGroup()

      ->addGroup('atsauksmes')
      ->addRepeater('atsauksme_single')
      ->addWysiwyg('description', [
        'label' => 'Apraksts',
      ])
      ->endRepeater()
      ->endGroup()

      ->addGroup('social_profiles')
      ->addRepeater('social_profile')
      ->addText('social_profile_name')
      ->addTextarea('svg_code', [
        'label' => 'Icon SVG Code',
        'rows' => 5,
        'instructions' => 'Paste The SVG Icon Code Here'
      ])
      ->addUrl('social_profile_url')
      ->endRepeater()
      ->endGroup();

    return $options->build();
  }
}
