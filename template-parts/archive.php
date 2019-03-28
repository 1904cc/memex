<?php
/**
 * Template fragment for displaying posts on archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package memex
 */
 

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('item'); ?>>
	<header class="entry-header">
		<?php
		if ( is_singular() ) :
		
			the_title( '<h1 class="entry-title">', '</h1>' );
		
		else :
			
			echo '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">';
			
				echo '<span class="entry-title">';
				
					the_title();
		
			      echo memex_date( 
			      	get_the_ID(), 
			      	' (', 
			      	')',
			      	false 
			      );
			      					
					// Check categories. In: ...
				
				// close title tag:
				echo '</span>';
			
			echo '</a>';
		
		endif;

		?>
	</header><!-- .entry-header -->

</article><!-- #post-<?php the_ID(); ?> -->
