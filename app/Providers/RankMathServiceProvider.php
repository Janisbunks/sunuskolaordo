<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use function Roots\bundle;

class RankMathServiceProvider extends ServiceProvider
{
    /**
     * Register assets services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * Filter to change breadcrumb settings.
         *
         * @param  array $settings Breadcrumb Settings.
         * @return array $setting.
         */
        add_filter( 'rank_math/frontend/breadcrumb/settings', function( $settings ) {
            $asset = \Roots\asset('/images/icons/breadcrumb-seperator.svg');

            $settings = array(
                'separator'      => '<img src="'. $asset . '" alt="Breadcrumb Separator" title="Breadcrumb Separator">',
            );
            return $settings;
        });

        /**
         * Filter to change breadcrumb args.
         *
         * @param  array $args Breadcrumb args.
         * @return array $args.
         */
        add_filter( 'rank_math/frontend/breadcrumb/args', function( $args ) {
            $args = array(
                'delimiter'   => '&nbsp;/&nbsp;',
                'wrap_before' => '<nav class="rank-math-breadcrumb font-inter flex items-center flex-wrap gap-1.25 mb-5 text-primary leading-130 tracking-wide [&_.last:last-of-type]:font-semibold [&_.last:last-of-type]:text-darkGrey [&_a:hover]:text-secondary [&_a]:transition-all [&_a]:duration-300"><p>',
                'wrap_after'  => '</p></nav>',
                'before'      => '',
                'after'       => '',
            );
            return $args;
        });

        /**
         * Filter to change breadcrumb html.
         *
         * @param  html  $html Breadcrumb html.
         * @param  array $crumbs Breadcrumb items
         * @param  class $class Breadcrumb class
         * @return html  $html.
         */
        add_filter( 'rank_math/frontend/breadcrumb/html', function( $html, $crumbs, $class ) {
            if ( is_front_page() ) {
                return '';
            }
            $html = strip_tags( $html, '<a><div><span><img><nav>' );
            return $html;
        }, 10, 3);
    }
}
