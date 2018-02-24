<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package memex
 */

if ( ! function_exists( 'memex_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function memex_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'memex' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'memex' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'memex_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function memex_entry_footer() {
	
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'memex' ) );
			
			// Retrieve category list in either HTML list or custom format. Generally used for quick, delimited (eg: comma-separated) lists of categories, as part of a post's entry meta. For a more powerful, list-based function, see wp_list_categories().
			
			$terms = get_the_terms( get_the_ID(), 'category' );
			
//			echo '<pre>';
//			var_dump($terms);
//			echo '</pre>';
			
			if ( ! empty( $terms ) ) {
			
				foreach ( $terms as $term ) {
				
	        echo '<p>Category: <a href="';
	        echo esc_url( get_term_link( $term->slug, 'category' ) );
	        echo '">'.$term->name.'</a></p>';
	        
	        // Other items in Category
	        
	        $categories_query = new WP_Query( array(
	        	'posts_per_page' => 4, // was 5
	        	'category_name' => $term->slug,
	        	// exclude the current post:
	        	'post__not_in' => array( get_the_ID() ),
	        	'orderby' => 'rand',
	        	) ); 
	        	
	        	$text_box_intro = 'Autres projets de la catégorie';
	        	$text_box_name = $categories_array[0]["name"];
	        	$text_box_link = home_url("/categorie/").$categories_array[0]["slug"];
	        	$text_box_type = 'categories';
	        	
	        	if ($categories_query->have_posts()) : 
	        	
	        		// include( TEMPLATEPATH . '/inc/default-box-title.php' );
	        		echo '<h3>Other items in '.$term->name.'</h3>';
	        	
	        	while( $categories_query->have_posts() ) : $categories_query->the_post();
	        
	        		// include( TEMPLATEPATH . '/inc/default-box.php' );
	        		echo '<li><a href="'.get_the_permalink().'">'.get_the_title().'</a></li>';
	        		
	         endwhile; 
	         endif;
	         wp_reset_postdata();
				        
				}
			
			}
			
			if ( $categories_list ) {
			
				/* translators: 1: list of categories. */
			// 	printf( '<span class="cat-links">' . esc_html__( 'Category: %1$s', 'memex' ) . '</span>', $categories_list ); // WPCS: XSS OK.
				
				// Other posts in same category?
				// Q: how many do we want to query?
				// 
				
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'memex' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Keyword: %1$s', 'memex' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
			
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'memex' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}

		
	}
endif;

if ( ! function_exists( 'memex_post_thumbnail' ) ) :
/**
 * Displays an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 */
function memex_post_thumbnail() {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	if ( is_singular() ) :
	?>

	<div class="post-thumbnail">
		<?php the_post_thumbnail(); ?>
	</div><!-- .post-thumbnail -->

	<?php else : ?>

	<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
		<?php
			the_post_thumbnail( 'post-thumbnail', array(
				'alt' => the_title_attribute( array(
					'echo' => false,
				) ),
			) );
		?>
	</a>

	<?php endif; // End is_singular().
}
endif;
