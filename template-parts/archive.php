<?php
/**
 * Template fragment for displaying posts on archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package memex
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		if ( is_singular() ) :
		
			the_title( '<h1 class="entry-title">', '</h1>' );
		
		else :
		
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a>' );
			
			// Check Date!
			$current_post_id = get_the_ID();
			
			if ( function_exists('mem_date_processing') ) {
			
				$mem_date = mem_date_processing( 
					get_post_meta($current_post_id, '_mem_start_date', true) , 
					get_post_meta($current_post_id, '_mem_end_date', true)
				);
			
			}
			
			if ($mem_date["start-iso"] !="" ) { 
				
				echo' ('.$mem_date["date"].')';
				
			}
			
			// close title tag:
			echo '</h2>';
		
		endif;

		?>
	</header><!-- .entry-header -->

</article><!-- #post-<?php the_ID(); ?> -->
