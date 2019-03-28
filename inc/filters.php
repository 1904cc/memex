<?php
/**
 * Various functions, filters, and actions used by the theme.
 *
 * @package memex
 */

/**
 * Filters the archive title. Note that we need this additional filter because core WP does
 * things like add "Archives:" in front of the archive title.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $title
 * @return string
 */


add_filter( 'get_the_archive_title', function ($title) {

    if ( is_category() ) {

            $title = single_cat_title( '', false );

        } elseif ( is_tag() ) {

            $title = single_tag_title( '', false );

        } elseif ( is_author() ) {

            $title = '<span class="vcard">' . get_the_author() . '</span>' ;

        }

    return $title;

});