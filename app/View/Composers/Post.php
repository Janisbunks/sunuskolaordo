<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;
use App\View\Helpers;

class Post extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'partials.page-header',
        'partials.content',
        'partials.content-*',
        'sections.front-page.*',
    ];

    /**
     * Data to be passed to view before rendering, but after merging.
     *
     * @return array
     */
    public function override()
    {
        return [
            'title' => $this->title(),
        ];
    }

    /**
     * Returns the post title.
     *
     * @return string
     */
    public function title()
    {

        if (Helpers::hasTerm()) {
            $term = Helpers::getTerm();

            $h1 = ! empty(get_field('h1', $term)) ? get_field('h1', $term) : null;

            return $h1 ?? $term->name;
        }

        if ($this->view->name() !== 'partials.page-header') {
            $h1 = ! empty(get_field('h1', get_the_ID())) ? get_field('h1', get_the_ID()) : null;
        
            return $h1 ?? get_the_title();
        }

        if (is_home()) {
            if ($home = get_option('page_for_posts', true)) {
                return get_the_title($home);
            }

            return __('Latest Posts', 'radicle');
        }

        if (is_archive()) {
            return get_the_archive_title();
        }

        if (is_search()) {
            return sprintf(
                /* translators: %s is replaced with the search query */
                __('Search Results for %s', 'radicle'),
                get_search_query()
            );
        }

        if (is_404()) {
            return __('Not Found', 'radicle');
        }

        return get_the_title();
    }
}
