<?php
/**
 * Template Name: Navigation
 *
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<?php
			while ( have_posts() ) : the_post();

				?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="page-header">
					<?php the_title( '<h1 class="page-title">', '</h1>' ); ?>
				</header><!-- .entry-header -->
			
				<div class="entry-content">
					<?php
						the_content();
						
					?>	
						<h2><?php _e( 'Categories' ); ?></h2>
				
						
						<?php
						// Show all Categories and Tags
						
						$cats = get_categories();
						$html = '';
						$counter = 1;
						
						foreach ( $cats as $cat ) {
							
							$cat_link = get_category_link( $cat->term_id );
									
							$html .= "<a href='{$cat_link}' title='{$cat->name} Tag' class='{$cat->slug}'>";
							$html .= "{$cat->name}</a>";
							
							if ( $counter === count($cats) ) {
							
							} else {
								$html .= ', ';
							}
							
							$counter++;
						}
						echo $html;
						
						?>
						<h2><?php _e( 'Tags' ); ?></h2>
						<?php
						
						// Produce a list of all existing Tags
		
						$tags = get_tags();
						
						$html = '';
						
						$counter = 1;
						
						foreach ( $tags as $tag ) {
							
							$tag_link = get_tag_link( $tag->term_id );
									
							$html .= "<a href='{$tag_link}' title='{$tag->name} Tag' class='{$tag->slug}'>";
							$html .= "{$tag->name}</a>";
							
							if ( $counter === count($tags) ) {
								// echo 'LAST';
							
							} else {
								$html .= ', ';
							}
							
							$counter++;
						
						}
				
						echo $html;
					?>

				</div><!-- .entry-content -->
			
			</article><!-- #post-<?php the_ID(); ?> -->
			
			<?php
			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
