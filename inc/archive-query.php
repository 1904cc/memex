<?php

/*
 * memex_archive_query
 *********************
 *
 * Permet de construire une archive par date, qui prend aussi bien en compte
 * les dates de publication que les dates d'événement.
 *
 * Cette fonction est utilisée sur:
 * - la page Agenda (cf page-templates/agenda.php)
 * - les pages archive par année (cf date.php)
 * - la navigation Previous/Next
 *
 * Le résultat peut être généré avec memex_echo_news()
 *
*/


function memex_archive_query( $current_year ) {
		
		if ( is_user_logged_in() ) {
		  delete_transient( 'memex_agenda_'.$current_year );
		}
		
		if ( false === ( $news_array = get_transient( 'memex_agenda_'.$current_year ) ) ) {
		
				$exclude_id = array();
				
				$no_date_query = new WP_Query( array( 
							'posts_per_page' => -1,
							'post_type' => 'any',
							'post__not_in' => $exclude_id,
							'year' => $current_year,
							
							'meta_query' => array(
								    array(
								     'key' => '_mem_start_date',
								     'compare' => 'NOT EXISTS'
								    ),
							),
				));
							
				if ( $no_date_query->have_posts() ) :
		  			  while( $no_date_query->have_posts() ) : $no_date_query->the_post();
		  			 		
		  			 		$exclude_id[] = get_the_ID();
		  			 		$news_array[] = memex_create_news() ;
		
		  				endwhile; 
				endif;
							
				// Second query: look for posts WITH Event Date = current year
					
				$has_date_query = new WP_Query( array( 
								'posts_per_page' => -1,
								'post_type' => 'any',
								'post__not_in' => $exclude_id,
								'meta_query' => array(
								    'relation' => 'AND',
								    array(
								        'key' => '_mem_start_date',
								        'value' => $current_year,
								        'compare' => '>=',
								    ),
								    array(
								        'key' => '_mem_start_date',
								        'value' => $current_year.'-12-32',
								        'compare' => '<=',
								    ),
									)
					));
					
					if ( $has_date_query->have_posts() ) :
							  while( $has_date_query->have_posts() ) : $has_date_query->the_post();
									  		  					 		  					 
									 $exclude_id[] = get_the_ID();
									 
									 $news_array[] = memex_create_news() ;
									 		  		 				    			 				
						 endwhile; 
					endif; 
									     	     
					// END of second query	
							
					// SORT everything (by "start-date-iso")
					if ( !empty( $news_array ) ) {
							usort($news_array, "memex_news_array_sort");
					}	
					
					set_transient( 'memex_agenda_'.$current_year , $news_array, 6 * HOUR_IN_SECONDS  ); 
					// * HOUR_IN_SECONDS
			
			} // end of get_transient test
			
			// return the result
			
			return $news_array;

}


/*
 * memex_cat_query
 *********************
 *
 * Permet de construire une archive par catégorie (en pied de page).
 * La catégorie est sélectionnée via un champ ACF.
 *
 * Le résultat sera généré avec memex_echo_news()
 *
*/

function memex_cat_query( $category_id ) {
		
		if ( is_user_logged_in() ) {
		    
		    delete_transient( 'memex_cat_'.$category_id );
		    
		}
		
		if ( false === ( $news_array = get_transient( 'memex_cat_'.$category_id ) ) ) {
		
				$exclude_id = array();
				
				$no_date_query = new WP_Query( array( 
							'posts_per_page' => -1,
							'post__not_in' => $exclude_id,
							'cat' => $category_id,
				));
							
				if ( $no_date_query->have_posts() ) :
		  			  while( $no_date_query->have_posts() ) : $no_date_query->the_post();
		  			 		
		  			 		$exclude_id[] = get_the_ID();
		  			 		$news_array[] = memex_create_news() ;
		
		  				endwhile; 
				endif;
							
					// SORT everything (by "start-date-iso")
					if ( !empty( $news_array ) ) {
							usort($news_array, "memex_news_array_sort");
					}	
					
					set_transient( 'memex_cat_'.$category_id , $news_array, 6 * HOUR_IN_SECONDS  ); 
					// * HOUR_IN_SECONDS
			
			} // end of get_transient test
			
			// return the result
			
			return $news_array;

}

/**
 * Helper function to sort items by "start-date-iso"
 * 
 */

function memex_news_array_sort($a,$b) {
  return $a['start-date-iso']<$b['start-date-iso'];
}



/**
 * CREATE NEWS:
 * Create an array of information for the Agenda template
 * 
 */

function memex_create_news() {

	$current_post_id = get_the_ID();
	$exclude_id[] = $current_post_id;
	 
	 // IMAGES
	 
	 if (function_exists('gallery_init')) {
	  
	 $img_info = gallery_init('medium');
	   		  					 
	 if ( empty( $img_info ) ) { 
	 	$img_url_custom = '';
	 	$img_url_large = '';
	 } else { // not empty!
	 	$img_url_custom = $img_info[0]["url-custom"];
	 	$img_url_large = $img_info[0]["url-large"];
	 }
	 
	 }
	 
	 // CONTENT
	 
	 // used to be : "content" => get_the_content(),
	 
	  $memex_content = apply_filters(
	  	'the_content', 
	  	get_the_content(
	  		sprintf(
	 	 			__( 'Continue reading %s', 'twentyfifteen' ),
	 	 			the_title( '<span class="screen-reader-text">', '</span>', false )
	 	 		) 
	 	 	) // get_the_content
	 	 );
	 
	 // Remove hyperlinks, to avoid nested hyperlinks.
	 
	 if ( function_exists('memex_disable_hyperlinks') ) {
	 
	 	$memex_content = memex_disable_hyperlinks( $memex_content );
	 
	 }
	 	
	 // DATE
	
	 $mem_date = mem_date_processing( 
	 	get_post_meta($current_post_id, '_mem_start_date', true) , 
	 	get_post_meta($current_post_id, '_mem_end_date', true)
	 );
	 
	 /*
	  * Prepare date values.
	  * Event date or publication date?
	 */
	 
	 if ($mem_date["start-iso"] !="" ) { 
	 
	 			// case 1: use MEM date
	 			
	 					// $date_start_raw = get_post_meta($current_post_id, '_mem_start_date', true);
	 				
	 					$date_string = $mem_date["date"];
	 					$date_short = $mem_date["date-short"];
	 					$date_num = $mem_date["date-num"];
	 					$date_year = $mem_date["start-year"];
	 					
	 					$start_date_iso = $mem_date["start-iso"];  // 2013-03-11T06:35
	 					$end_date_iso = $mem_date["end-iso"];
	 					$unix_start = $mem_date["start-unix"];
	 					$unix_end = $mem_date["end-unix"];
	 					$has_event_date = true;
	 			 
	   } else {
	   
	   	// case 2: no MEM date defined - use POST DATE as START DATE
	   				
	   				$date_string = get_the_date( 'l j F Y' ); // Mercredi 5 juin 2013
	   				$date_short = get_the_date( 'F Y' );
	   				$date_num = get_the_date( 'd.m.Y' );
	   				$date_year = get_the_date( 'Y' );
	   				
	   				$start_date_iso = get_the_date( 'Y-m-d\TH:i' );  // 2013-03-11T06:35
	   				$end_date_iso = $start_date_iso;
	   				$unix_start = strtotime( $start_date_iso );
	   				$unix_end = $unix_start;
	   				$has_event_date = false;
	   				
	   }
	 
	 $archive_array = array( 
	     	"id" => $current_post_id,
	     	"class" => get_post_class( '', $current_post_id ),
	     	"permalink" => get_permalink(), // NOTE: may return in form of /?p=191
	     	"slug" => get_post_field( 'post_name', $current_post_id ),
	     	"title" => get_the_title(),
	     	"content" => $memex_content,
	     	
	     	// IMAGES
	     	"url-custom" => $img_url_custom,
	     	"url-large" => $img_url_large,
	     	
	     	// DATES
	     	"date-string" => $date_string,
	     	"date-short" => $date_short,
	     	"date-num" => $date_num,
	     	"date-year" => $date_year,
	     	"date-pub" => get_the_date( 'l j F Y' ),
	     	"start-date-iso" => $start_date_iso,
	     	"end-date-iso" => $end_date_iso,
	     	"start-date-unix" => $unix_start,
	     	"end-date-unix" => $unix_end,
	     	"has-event" => $has_event_date,
	     
	     	 // DEBUG
	     	 // "date-start-raw" => $date_start_raw,
	     	
	  );
	  
	  return $archive_array;
	  
}



function memex_echo_news( $item, $context ) {
 				
 				$item_header_class = '';
 				
 				$item_header_class = join( ' ', $item["class"] );
 				
 				if (empty($item["url-custom"])) {
 					$item_header_class .= ' no-img';
 				} else { 
 					$item_header_class .= ' has-img';
 				}

 				echo '<article class="news-item item '.$item_header_class.'">';
 				
 					// Build URL
 					// Adresse web de WordPress (URL) = WordPress Address (URL) = get_site_url()
 					// Adresse web du site (URL) = Site Address (URL) = get_home_url
 					
 					// Note 1: $item["permalink"]; ne fonctionne pas bien pour les articles planifiés
 					
 					// Note 2: sur les sous pages (contexte: 'sub-page'), il faut prendre l'URL originale, 
 					// car elle contient un sous-élément: 
 					// p.ex. http://memexnet.ch/hors-cases/galerie-1-piece/
 					// ou http://memexnet.ch/residences/residence-curatoriale/
 					
 					if ( $context == 'sub-page' ) {
 					
 						$news_url = $item["permalink"];
 					
 					} else {
 						
 						$news_url = get_home_url().'/'.$item["slug"].'/';
 					
 					}
 					
 				echo '<header class="entry-header">';
 				
 				echo '<h2 class="entry-title">';
 					
 				echo '<a class="news-item-link entry-header" href="'.$news_url.'">';
 							 
 				echo $item["title"];
 							 
 				echo '';
 							 
 						if ( $item["has-event"] == true ) {
 							
							echo ' ('. $item["date-num"] .')'; 
										
 						} // end testing for Pub-Date
 						
 					?>
 						</a><!-- news-item-title -->
					</h2>
 				</header><!-- .entry-header -->
 			</article><!-- news-item -->
 
 	<?php
 
 }
 

function memex_read_more_link() {
   return '<div class="read-more">Lire la suite</div>';
//     return '';
}
add_filter( 'the_content_more_link', 'memex_read_more_link' );


