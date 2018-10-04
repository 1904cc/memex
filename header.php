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
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
		</header><!-- #masthead -->
		<?php
	
	} else {
	
	// Show only some navigation back to front page.
	
	?>
	<nav class="site-title site-title-link"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">x</a></nav>
	<?php
	
	}
	
	 ?>

	<div id="content" class="site-content">
