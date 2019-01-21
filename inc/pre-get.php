<?php

/*
 * memex_pre_get
 *********************
 *
*/


/* Archives: Alphabetical Order
 ******************************
*/

function memex_category_order( $query ) {
  if ( $query->is_category() && !is_admin() ) {
     	$query->set( 'orderby', 'name');
      return $query;
  }
}

add_filter( 'pre_get_posts', 'memex_category_order' );