<?php
/**
 * Template part for displaying posts
 
 * Used in:
 * - single.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package memex
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('content'); ?>>
	
	<?php 
	if ( is_singular() ) {
		memex_show_backlink();
	}
	 ?>
	
	<header class="entry-header">
		<?php
		
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;
						
		echo memex_date( get_the_ID(), 
			'<div class="date">', // opening tag
			'</div>', // closing tag,
			true // link
		);
		
		?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php memex_post_thumbnail(); ?>
		<?php
			the_content( sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'memex' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'memex' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php 
		
		// Show related things
		
		get_template_part( 'template-parts/related', get_post_type() );
		
		get_search_form();
		
		?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
