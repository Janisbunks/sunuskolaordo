<?php

namespace App\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class PostTypesServiceProvider extends ServiceProvider
{
    /**
     * Register post types services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * Register the post types assets.
         *
         * @return void
         */
        add_action('init', function (): void {
            Collection::make(config('post-types.post_types'))
                ->each(function ($args, $post_type) {
                    $names = Arr::get($args, 'labels', []); // Change this line
                    register_extended_post_type(
                        $post_type,
                        $args,
                        $names                              // Change this line
                    );
                });
        }, 100);

        /**
         * Register the taxonomies.
         *
         * @return void
         */
        add_action('init', function (): void {
            Collection::make(config('post-types.taxonomies'))
                ->each(function ($args, $taxonomy) {
                    register_extended_taxonomy(
                        $taxonomy,
                        Arr::pull($args, 'post_types'),
                        $args,
                        Arr::pull($args, 'names')
                    );
                });
        }, 100);
    }
}
