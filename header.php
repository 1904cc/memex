<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package memex
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'memex' ); ?></a>

	<?php 
	
	// The Header is displayed only on the front page
	
	if ( is_front_page() && is_home() ) {
		
		?>
		<header id="masthead" class="site-header">
			<h1 class="site-title site-title-frontpage"><?php bloginfo( 'name' ); ?></h1>
		</header><!-- #masthead -->
		<?php
	
	} else {
	
	// Show some navigation back to front page.
	// In some cases, this navigation will be contextual, may lead back to some 
	// previous "global page", such as : Timeline, Artefacts, Operator.
	
	$memex_contextual_backlink = memex_contextual_backlink();
	
	?>
	<nav class="site-title site-title-link h1"><a href="<?php echo $memex_contextual_backlink; ?>" rel="home"><svg width="32px" height="32px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
	    <title>Close</title>
	    <desc>Close icon.</desc>
	    <defs></defs>
	    <g id="close" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="square">
	        <g id="Group" transform="translate(6.000000, 6.000000)" stroke="#000000" stroke-width="2">
	            <path d="M0.5,0.5 L19.0607112,19.0607112" id="Line"></path>
	            <path d="M0,19.5607112 L18.5607112,1" id="Line-Copy"></path>
	        </g>
	    </g>
	</svg></a></nav>
	<?php
	
	}
	
	 ?>

	<div id="content" class="site-content">
