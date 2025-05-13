<?php

namespace App\View;

abstract class Helpers
{
    /**
     * Returns the current term object if we're on a term archive page, or `null`
     * otherwise
     *
     * @return ?\WP_Term The current term object.
     */
    public static function getTerm(): ?\WP_Term
    {
        $term = get_queried_object();

        if ($term !== null && $term instanceof \WP_Term) {
            return $term;
        }

        return null;
    }

    /**
     * If the term exists, return the name, otherwise return null.
     *
     * @return ?string The name of the term.
     */
    public static function getTermName(): ?string
    {
        return optional(self::getTerm())->name ?? null;
    }

    /**
     * It returns the description of the current term
     *
     * @return ?string The description of the term.
     */
    public static function getTermContent(): ?string
    {
        $term_id = get_queried_object_id();
        $description = term_description($term_id);

        return $description;
    }

    /**
     * Get the ID of the current page.
     *
     * @return ?string The ID of the current page.
     */
    public static function getPageId(): ?string
    {
        return get_the_ID();
    }

    /**
     * It gets the name of the current directory
     *
     * @return ?string The name of the directory.
     */
    public static function getDirectoryName(): ?string
    {
        $object = get_queried_object();
        $objectID = optional($object)->id ?? null;

        $term = get_the_terms($objectID, 'directory');
        $term = $term[0]->name ?? null;

        $termName = $object->taxonomy ?? null;
        $directoryName = ($termName == 'directory') ? $object->name : $term;

        return htmlspecialchars_decode($directoryName);
    }

    /**
     * If the post type is 'phone' and we're on a single post, return the post title
     *
     * @return ?string The phone number of the current post.
     */
    public static function getPhone(): ?string
    {
        $type = get_post_type();
        $number = ($type == 'phone' && is_single()) ? get_the_title() : null;

        return $number;
    }

    /**
     * It checks if the current page has a term.
     *
     * @return bool The term id
     */
    public static function hasTerm(): bool
    {
        return self::getTerm() !== null;
    }

    /**
     * Check if the queried object is a page
     *
     * @return bool
     */
    public static function isPage(): bool
    {
        return get_queried_object() && get_queried_object() instanceof \WP_Post;
    }

    /**
     * Check if the current term is an child term
     *
     * @return bool
     */
    public static function isChildTerm(): bool
    {
        return self::hasTerm() && self::getTerm()->parent !== 0;
    }
}
