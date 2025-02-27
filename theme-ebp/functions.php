<?php
/**
 * Theme ebp functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Theme_ebp
 */

if (!defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function theme_ebp_setup()
{
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Theme ebp, use a find and replace
	 * to change 'theme-ebp' to the name of your theme in all the template files.
	 */
	load_theme_textdomain('theme-ebp', get_template_directory() . '/languages');

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support('title-tag');

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support('post-thumbnails');

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__('Primary', 'theme-ebp'),
		)
	);

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

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'theme_ebp_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support('customize-selective-refresh-widgets');

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height' => 250,
			'width' => 250,
			'flex-width' => true,
			'flex-height' => true,
		)
	);
}
add_action('after_setup_theme', 'theme_ebp_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function theme_ebp_content_width()
{
	$GLOBALS['content_width'] = apply_filters('theme_ebp_content_width', 640);
}
add_action('after_setup_theme', 'theme_ebp_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function theme_ebp_widgets_init()
{
	register_sidebar(
		array(
			'name' => esc_html__('Sidebar', 'theme-ebp'),
			'id' => 'sidebar-1',
			'description' => esc_html__('Add widgets here.', 'theme-ebp'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		)
	);
}
add_action('widgets_init', 'theme_ebp_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function theme_ebp_scripts()
{
	// Enqueue theme stylesheet
	wp_enqueue_style('theme-ebp-style', get_stylesheet_uri(), array(), _S_VERSION);
	wp_style_add_data('theme-ebp-style', 'rtl', 'replace');

	// Enqueue additional styles
	wp_enqueue_style('fontawesome-css', get_bloginfo('stylesheet_directory') . '/assets/css/fontawesome.min.css', array(), '1.0.0');
	wp_enqueue_style('swiper-css', get_bloginfo('stylesheet_directory') . '/assets/css/swiper.min.css', array(), '1.0.0');
	wp_enqueue_style('theme-css', get_bloginfo('stylesheet_directory') . '/assets/css/theme.css', array(), '1.0.0');
	wp_enqueue_style('custom-css', get_bloginfo('stylesheet_directory') . '/assets/css/custom.css', array(), '1.0.0');

	// Enqueue scripts
	wp_enqueue_script('theme-ebp-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);
	wp_enqueue_script('main-js', get_bloginfo('stylesheet_directory') . '/assets/js/main.js', array(), '1.0.0', true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'theme_ebp_scripts');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}

function tt3child_register_acf_blocks()
{
	/**
	 * We register our block's with WordPress's handy
	 * register_block_type();
	 *
	 * @link https://developer.wordpress.org/reference/functions/register_block_type/
	 */
	register_block_type(__DIR__ . '/blocks/hero');
}
// Here we call our tt3child_register_acf_block() function on init.
add_action('init', 'tt3child_register_acf_blocks');

function wpCustomStyleSheet()
{
	//first register sthe style sheet and then enqueue
	wp_register_style('fontawesome-css', get_bloginfo('stylesheet_directory') . '/assets/css/fontawesome.min.css', false, '1.0.0');
	wp_register_style('swiper-css', get_bloginfo('stylesheet_directory') . '/assets/css/swiper.min.css', false, '1.0.0');
	wp_register_style('theme-css', get_bloginfo('stylesheet_directory') . '/assets/css/theme.css', false, '1.0.0');
	wp_register_style('custom-css', get_bloginfo('stylesheet_directory') . '/assets/css/custom.css', false, '1.0.0');
	wp_register_script('main-js', get_bloginfo('stylesheet_directory') . '/assets/js/main.js', false, '1.0.0');

	// enqueue
	
	wp_enqueue_style('fontawesome-css');
	wp_enqueue_style('swiper-css');
	wp_enqueue_style('theme-css');
	wp_enqueue_style('custom-css');
	wp_enqueue_script('main-js');
}
add_action('enqueue_block_editor_assets', 'wpCustomStyleSheet');

add_filter('wpcf7_form_elements', function ($content) {
	$content = preg_replace('/<(span).*?class="\s*(?:.*\s)?wpcf7-form-control-wrap(?:\s[^"]+)?\s*"[^\>]*>(.*)<\/\1>/i', '\2', $content);

	return $content;
});

add_filter('wpcf7_autop_or_not', '__return_false');
