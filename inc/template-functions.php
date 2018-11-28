<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package memex
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function memex_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'memex_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function memex_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'memex_pingback_header' );

/**
 * Output a list of items
 * Input:
 * - posts
 * - a title
 *
 * Note: output markup should be identical to : 
 * template-parts/archive.php
 */
 
function memex_item_list( $memex_item_list, $memex_list_name ) {
	
	if ( $memex_item_list->have_posts() ) : ?>
	
	<div class="bloc-item-list">
	<h2><?php echo $memex_list_name; ?></h2>
			<ul class="ul-horiz-img grid">
				
	<?php
	while( $memex_item_list->have_posts() ) : $memex_item_list->the_post();  ?>
				<li class="post">
					<a href="<?php the_permalink(); ?>">
						<h3 class="entry-title"><?php the_title(); ?></h3>
						<?php 
						
//						echo memex_date( get_the_ID(), 
//							' (', // opening tag
//							')' // closing tag
//						);
						
						 ?>
					</a>
				</li>
	  <?php
	  endwhile; 
		?>
	</ul>
			
	</div><!-- .bloc-operators -->
	<?php
	wp_reset_postdata();
	endif; 
	
}

/**
 * Output the Event Date with one command.
 * Input: 
 * $id = Post ID
 * $open = opening tag : '<div class="date">
 * $close = closing tag : '</div>'
 * $link = true or false
 */

function memex_date( $id, $open, $close, $link ) {
	
	if ( function_exists('mem_date_processing') ) {
				
		$mem_date = mem_date_processing( 
			get_post_meta($id, '_mem_start_date', true) , 
			get_post_meta($id, '_mem_end_date', true)
		);
	
	}
		
	if ($mem_date["start-iso"] !="" ) { 
	
		$date = $open;
		
		if ( $link == true ) {
			$date .= '<a href="/'.$mem_date["date-year"].'/">';
		}
		
		if (!empty($mem_date["date-basic"])) {
		
			$date .= $mem_date["date-basic"];
		
			$date .= ' ';
		
		}
		
		$date .= $mem_date["date-year"];
		
		if ( $link == true ) {
			$date .= '</a>';
		}
		
		$date .= $close;
		
		return $date;
		
	}
	
}