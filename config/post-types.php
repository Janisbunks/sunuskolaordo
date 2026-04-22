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
    'produkti' => [
      'menu_icon' => 'dashicons-products',
      'supports' => ['title', 'editor', 'author', 'revisions', 'thumbnail', 'page-attributes'],
      'show_in_rest' => true,
      'publicly_queryable' => true,
      'has_archive' => 'produkti',
      'public' => true,
      'show_ui' => true,
      'show_in_menu' => true,
      'rewrite' => [
        'slug' => 'produkts',
        'with_front' => false
      ],
      'labels' => [
        'singular' => __('Produkts', 'radicle'),
        'plural' => __('Produkti', 'radicle'),
        'slug' => 'produkts',
      ]
    ],
    'pasutijumi' => [
      'menu_icon' => 'dashicons-clipboard',
      'supports' => ['title', 'revisions', 'thumbnail', 'page-attributes'],
      'show_in_rest' => false,
      'publicly_queryable' => false,
      'has_archive' => false,
      'public' => false,
      'show_ui' => true,
      'show_in_menu' => true,
      'menu_position' => 26,
      'capabilities' => [
        'create_posts' => false,
      ],
      'map_meta_cap' => true,
      'labels' => [
        'singular' => __('Pasūtījums', 'radicle'),
        'plural' => __('Pasūtījumi', 'radicle'),
        'slug' => 'pasutijums',
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
    'kategorija' => [
      'post_types' => ['produkti'],
      'hierarchical' => true,
      'show_ui' => true,
      'show_admin_column' => true,
      'query_var' => true,
      'show_in_rest' => true,
      'meta_box_cb' => null,
      'public' => true,
      'publicly_queryable' => true,
      'names' => [
        'singular' => __('Kategorija', 'radicle'),
        'plural' => __('Kategorijas', 'radicle'),
        'slug' => 'kategorija',
      ],
    ],
  ],
];
