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

	wp_localize_script(
		'handeny-main',
		'WPJS',
		array(
			'siteUrl' => get_template_directory_uri(),
		)
	);
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

function cc_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');



function theme_register_footer_menus() {
    register_nav_menus(
        array(
            'footer_menu_1' => esc_html__( 'Footer Menu 1', 'handeny' ),
            'footer_menu_2' => esc_html__( 'Footer Menu 2', 'handeny' ),
			'primary' => esc_html__('primary', 'handeny'),
			'login' => esc_html__('login', 'handeny'),
        )
    );
}

add_action( 'init', 'theme_register_footer_menus' );

function custom_footer_widget_one() {
	$args = array (
		'id'=> 'footer_widget-col-one',
		'name' => __('Footer column one', 'pugs-shop'),
		'description' => __('Column one', 'pugs-shop'),
		'before_title' => '<h3 class="title">',
		'after_title' => '</h3>',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>'
	);
	register_sidebar($args);
}
add_action('init','custom_footer_widget_one');

function custom_footer_widget_two() {
	$args = array (
		'id'=> 'footer_widget-col-two',
		'name' => __('Footer column two', 'pugs-shop'),
		'description' => __('Column two', 'pugs-shop'),
		'before_title' => '<h3 class="title">',
		'after_title' => '</h3>',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>'
	);
	register_sidebar($args);
}
add_action('init','custom_footer_widget_two');

function custom_footer_widget_three() {
	$args = array (
		'id'=> 'footer_widget-col-three',
		'name' => __('Footer column three', 'pugs-shop'),
		'description' => __('Column three', 'pugs-shop'),
		'before_title' => '<h3 class="title">',
		'after_title' => '</h3>',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>'
	);
	register_sidebar($args);
}
add_action('init','custom_footer_widget_three');

function custom_footer_widget_four() {
	$args = array (
		'id'=> 'footer_widget-col-four',
		'name' => __('Footer column four', 'pugs-shop'),
		'description' => __('Column four', 'pugs-shop'),
		'before_title' => '<h3 class="title">',
		'after_title' => '</h3>',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>'
	);
	register_sidebar($args);
}
add_action('init','custom_footer_widget_four');

function sidebarCart() {
	$args = array (
		'id'=> 'sidebar-1',
		'name' => __('Cart', 'pugs-shop'),
		'description' => __('Cart', 'pugs-shop'),
		'before_title' => '<h3 class="title">',
		'after_title' => '</h3>',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>'
	);
register_sidebar($args);
}
add_action('init','sidebarCart');










