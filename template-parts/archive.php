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
			
      echo memex_date( 
      	get_the_ID(), 
      	' (', 
      	')',
      	false 
      );
			
			// Check categories. In: ...
			
			// close title tag:
			echo '</h2>';
		
		endif;

		?>
	</header><!-- .entry-header -->

</article><!-- #post-<?php the_ID(); ?> -->
