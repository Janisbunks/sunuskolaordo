<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Post Types
    |--------------------------------------------------------------------------
    |
    | Post types to be registered with Extended CPTs
    | <https://github.com/johnbillion/extended-cpts>
    |
    */

    'post_types' => [
      'nodarbibas' => [
        'menu_icon' => 'dashicons-admin-page',
        'supports' => ['title', 'editor', 'author', 'revisions'],
        'show_in_rest' => true,
        'publicly_queryable' => true,
        'has_archive' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'labels' => [
          'singular' => __('Nodarbiba', 'radicle'),
          'plural' => __('Nodarbibas', 'radicle'),
          'slug' => 'nodarbiba',
        ]
      ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Taxonomies
    |--------------------------------------------------------------------------
    |
    | Taxonomies to be registered with Extended CPTs library
    | <https://github.com/johnbillion/extended-cpts>
    |
    */

    'taxonomies' => [
    ],
];
