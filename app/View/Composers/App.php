<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class App extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        '*',
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'container' => 'container px-4',
            'heading' => $this->pageHeading(),
            'siteName' => $this->siteName(),
        ];
    }

    /**
     * Returns the site name.
     *
     * @return string
     */
    public function siteName()
    {
        return get_bloginfo('name', 'display');
    }

    /**
     * Returns the page heading.
     *
     * @return string
     */
    public function pageHeading()
    {
        $heading = '';

        if(is_404()) {
            $heading = "Page Not Found";
        } elseif (get_field('h1')) {
            $heading = get_field('h1');
        } else {
            $heading = get_the_title();
        }

        return $heading;
    }
}
