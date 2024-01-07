<?php
/**
 * handeny functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package handeny
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function handeny_setup() {

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


	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'logo',
		array(
			'height'      => 40,
			'width'       => 112,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'handeny_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function handeny_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'handeny_content_width', 640 );
}
add_action( 'after_setup_theme', 'handeny_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */

/**
 * Enqueue scripts and styles.
 */
function handeny_scripts() {
	wp_enqueue_style( 'handeny-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_enqueue_style( 'handley-main', get_template_directory_uri() . '/css/main.min.css', array(), _S_VERSION );

	wp_enqueue_script( 'slick', get_template_directory_uri() . '/js/slick.min.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'handeny-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'handeny-main', get_template_directory_uri() . '/js/main.js', array('slick'), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'handeny_scripts' );

/**
* Custom Fonts
*
* 
*/
function enqueue_custom_fonts() {
	if(!is_admin()) {
		wp_register_style('lora', 'https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&display=swap');
		wp_register_style('marcellus', 'https://fonts.googleapis.com/css2?family=Marcellus&display=swap');
		wp_enqueue_style('lora');
		wp_enqueue_style('marcellus');
	}
}
add_action('wp_enqueue_scripts', 'enqueue_custom_fonts');

/**
 * Implement the Custom Header feature.
 */
function wpb_custom_new_menu() {
	register_nav_menu('primary',__( 'Primary' ));
}
add_action( 'init', 'wpb_custom_new_menu' );

function cc_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

register_sidebar();

function add_woocommerce_support() {
	add_theme_support( 'woocommerce' );
}
add_action('after_setup_theme', 'add_woocommerce_support');




