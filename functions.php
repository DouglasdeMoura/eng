<?php
/**
 * Eng functions and definitions.
 *
 * @link https://codex.wordpress.org/Functions_File_Explained
 *
 * @package Eng
 */

if ( ! function_exists( 'eng_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function eng_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Eng, use a find and replace
	 * to change 'eng' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'eng', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'eng' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', [
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	] );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', [
		'aside',
		'image',
		'video',
		'quote',
		'link',
	] );
}
endif; // eng_setup
add_action( 'after_setup_theme', 'eng_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function eng_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'eng_content_width', 640 );
}
add_action( 'after_setup_theme', 'eng_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function eng_widgets_init() {
	register_sidebar( [
		'name'          => esc_html__( 'Sidebar', 'eng' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	] );
}
add_action( 'widgets_init', 'eng_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function eng_scripts() {
	wp_enqueue_style( 'eng-style', get_template_directory_uri() . '/sass/style.php' );
	
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css' );
	
	wp_enqueue_style( 'eng-fonts', 'https://fonts.googleapis.com/css?family=Fira+Sans:500,300italic,300,700italic,700|Open+Sans:300,300italic,700,700italic' );

	wp_enqueue_script( 'eng-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	wp_enqueue_script( 'eng-scripts', get_template_directory_uri() . '/js/scripts.js', array(), '20130115', true );

	if ( is_front_page()  ) {
		wp_enqueue_script( 'slick-carousel', '//cdn.jsdelivr.net/jquery.slick/1.5.7/slick.min.js', ['jquery'], '1.5.7', true );
		wp_enqueue_script( 'slick', get_template_directory_uri() . '/js/slick.js', array(), '20130115', true );
		wp_enqueue_style( 'slick-style', '//cdn.jsdelivr.net/jquery.slick/1.5.7/slick.css' );
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'eng_scripts' );

function eng_new_excerpt_more() {
	$text = sprintf(
		/* translators: %s: Name of current post. */
		wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'eng' ), array( 'span' => array( 'class' => array() ) ) ),
		the_title( '<span class="screen-reader-text">"', '"</span>', false )
	);
	
	return '[...] <p><a class="read-more" href="' . get_permalink( get_the_ID() ) . '">'. $text .'</a></p>';
}
add_filter( 'excerpt_more', 'eng_new_excerpt_more' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
