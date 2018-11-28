<?php
/**
 * The template for displaying archive pages
 * Example: archive by category, by date...
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package memex
 */

get_header(); ?>

	<div id="primary" class="content-area content-list list-view">
		<main id="main" class="site-main">
			
			<?php 
			
			$current_year = get_the_time('Y');
			
			if ( have_posts() ) : ?>
		
					<header class="page-header">
						<?php

							echo '<h1 class="page-title year-title">'.$current_year.'</h1>';
							
						?>
					</header><!-- .page-header -->
					
					<?php
					/* Start the Loop */
					while ( have_posts() ) : the_post();
		
					endwhile;

				else :
		
					get_template_part( 'template-parts/content', 'none' );
		
				endif; 
				
				if ( is_year() ) {
							
					// perform several queries based on current year.
				
					$news_array = memex_archive_query( $current_year );
				
				}
						
				// Generate Output
				if ($news_array) {
				
					echo '<div id="grid" class="grid">';
	
					foreach ($news_array as $key => $item) {
							
							echo memex_echo_news( $item, 'archive' );
							
					}
					
					echo '</div><!-- #grid -->';
					
				}
				
				?>
		
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
