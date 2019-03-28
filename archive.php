<?php
/**
 * The template for displaying archive pages
 * Example: archive by category
 *
 * Note: date/year uses the date.php template
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package memex
 */
 
setcookie(
 	"memexbacklink", 
 	$_SERVER['REQUEST_URI'], 
 	time() + (86400), "/");

get_header(); ?>

	<div id="primary" class="content-area content-list list-view">
		<main id="main" class="site-main">

				<?php
				if ( have_posts() ) : ?>
		
					<header class="page-header">
						<?php
						
						// Using Core function the_archive_title
						// Filtered with custom function ...
						
							the_archive_title( '<h1 class="page-title">', '</h1>' );
							
							the_archive_description( '<div class="archive-description">', '</div>' );
						?>
					</header><!-- .page-header -->
					
					<div id="grid" class="grid">
		
					<?php
					/* Start the Loop */
					while ( have_posts() ) : the_post();
		
						/*
						 * Include the Post-Format-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						 
						get_template_part( 'template-parts/archive', get_post_format() );
		
					endwhile;
					
					?>
					
					</div><!-- #grid -->
					
					<?php
		
					the_posts_navigation();
		
				else :
		
					get_template_part( 'template-parts/content', 'none' );
		
				endif; ?>
		
			
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
