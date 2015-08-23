<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Eng
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'eng' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<div class="site-branding">
			<?php if ( is_front_page() && is_home() ) : ?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php echo eng_change_bloginfo_name( get_bloginfo( 'name' ) ); ?></a></h1>
			<?php else : ?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php echo eng_change_bloginfo_name( get_bloginfo( 'name' ) ); ?></a></p>
			<?php endif; ?>
			<p class="site-description screen-reader-text"><?php bloginfo( 'description' ); ?></p>
		</div><!-- .site-branding -->
		
		<button class="menu-toggle btn" aria-controls="primary-menu" aria-expanded="false"><i class="genericon genericon-menu"></i><span class="screen-reader-text"><?php esc_html_e( 'Primary Menu', 'eng' ); ?></span></button>
		
		<nav id="site-navigation" class="main-navigation" role="navigation">
			<h2 class="navigation-title"><?php echo __( 'Menu', 'eng' ) ?></h2>
			<button class="close-menu"><i class="genericon genericon-close-alt"></i><span class="screen-reader-text"><?php echo __( 'Close menu', 'eng' ) ?></span></button>
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
			<?php echo eng_social_links() ?>
		</nav><!-- #site-navigation -->
		
		<button class="display-search btn" aria-controls="site-search" aria-expanded="false"><i class="genericon genericon-search"></i></button>
			
	</header><!-- #masthead -->
	
	<div class="site-search">
		<div class="search-container">
			<i class="genericon genericon-search"></i>
			<?php get_search_form( true ); ?>
			<button class="close-site-search" aria-controls="site-search" aria-expanded="false"><i class="genericon genericon-close-alt"></i></button>
		</div>
	</div>

	<div id="wrapper" class="site-wrapper">
		
		<?php eng_featured_posts(); ?>
		<div id="content" class="site-content">
