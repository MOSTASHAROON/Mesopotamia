<?php
/**
 * Mesopotamia functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Mesopotamia
 */

if ( ! function_exists( 'mesopotamia_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function mesopotamia_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Mesopotamia, use a find and replace
		 * to change 'mesopotamia' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'mesopotamia', get_template_directory() . '/languages' );

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
			'primary' => esc_html__( 'Primary', 'mesopotamia' ),
			'footer'  => esc_html__( 'Footer', 'mesopotamia' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		/*
		 * Enable support for Post Formats.
		 * See https://developer.wordpress.org/themes/functionality/post-formats/
		 */
		add_theme_support( 'post-formats', array(
			'aside'
		) );
	}
endif;
add_action( 'after_setup_theme', 'mesopotamia_setup' );

/**
 * Get the value of a settings field
 *
 * @param string $option settings field name
 * @param string $section the section name this field belongs to
 * @param string $default default text if it's not found
 *
 * @return mixed
 */
function mesopotamia_get_option( $option, $section, $default = '' ) {

	$options = get_option( $section );

	if ( isset( $options[ $option ] ) ) {
		$returned_value = $options[ $option ];
	} else {
		$returned_value = $default;
	}

	$returned_value = apply_filters( 'mesopotamia_get_option', $returned_value, $option, $section, $default );

	return $returned_value;
}

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function mesopotamia_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'mesopotamia_content_width', 640 );
}

add_action( 'after_setup_theme', 'mesopotamia_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function mesopotamia_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'mesopotamia' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'No-results widgets', 'mesopotamia' ),
		'id'            => 'no-results-sidebar',
		'description'   => esc_html__( 'This widgets appear on the no results search page.', 'mesopotamia' ),
		'before_widget' => '<div class="post-box col-lg-4 col-md-4 col-sm-4"><section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section></div><!-- .post-box -->',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( '404 widgets', 'mesopotamia' ),
		'id'            => '404-sidebar',
		'description'   => esc_html__( 'This widgets appear on the 404 page.', 'mesopotamia' ),
		'before_widget' => '<div class="post-box col-lg-4 col-md-4 col-sm-4"><section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section></div><!-- .post-box -->',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	$top_footer = get_theme_mod( 'top_footer' );

	if ( $top_footer == true ) {
		$top_columns = (int) get_theme_mod( 'top_columns' );

		for ( $i = 1; $i <= $top_columns; $i ++ ) {
			register_sidebar( array(
				'name'          => esc_html__( 'Footer widget ', 'mesopotamia' ) . $i,
				'id'            => 'footer-sidebar-' . $i,
				'description'   => '',
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			) );
		}
	}
}

add_action( 'widgets_init', 'mesopotamia_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function mesopotamia_scripts() {

	wp_enqueue_script( 'mesopotamia-navigation', get_template_directory_uri() . '/js/navigation.js', array(),
		'20151215', true );

	wp_enqueue_script( 'mesopotamia-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js',
		array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_style( 'google-fonts',
		'https://fonts.googleapis.com/css?family=Ubuntu:400,700,700italic,500italic,500,400italic,300italic,300' );
	wp_enqueue_style( 'font-awesome',
		get_template_directory_uri() . '/lib/font-awesome/css/font-awesome.min.css' );
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/lib/bootstrap/css/bootstrap.min.css' );
	wp_enqueue_style( 'bootstrap-theme',
		get_template_directory_uri() . '/lib/bootstrap/css/bootstrap-theme.min.css', array(
			'bootstrap'
		) );

	if ( is_page_template( 'page-templates/full-width.php' ) ) {
		wp_enqueue_style( 'mesopotamia-layout', get_template_directory_uri() . '/layouts/full-width.css', array(
			'bootstrap-theme',
			'google-fonts',
			'font-awesome'
		) );
	} elseif ( is_page_template( 'page-templates/no-sidebar.php' ) ) {
		wp_enqueue_style( 'mesopotamia-layout', get_template_directory_uri() . '/layouts/no-sidebar.css', array(
			'bootstrap-theme',
			'google-fonts',
			'font-awesome'
		) );
	} elseif ( is_page_template( 'page-templates/scratch.php' ) ) {
		wp_enqueue_style( 'mesopotamia-layout', get_template_directory_uri() . '/layouts/scratch.css', array(
			'bootstrap-theme',
			'google-fonts',
			'font-awesome'
		) );
	} elseif ( is_page_template( 'page-templates/content-full-width.php' ) ) {
		wp_enqueue_style( 'mesopotamia-layout', get_template_directory_uri() . '/layouts/content-full-width.css', array(
			'bootstrap-theme',
			'google-fonts',
			'font-awesome'
		) );
	} else {
		wp_enqueue_style( 'mesopotamia-layout', get_template_directory_uri() . '/layouts/content-sidebar.css', array(
			'bootstrap-theme',
			'google-fonts',
			'font-awesome'
		) );
	}


	$skin = get_theme_mod( "skin" );

	if ( $skin == 'light' ) {
		wp_enqueue_style( 'mesopotamia-skin', get_template_directory_uri() . '/skins/light.css', array(
			'mesopotamia-layout'
		) );
	} elseif ( $skin == 'dark' ) {
		wp_enqueue_style( 'mesopotamia-skin', get_template_directory_uri() . '/skins/dark.css', array(
			'mesopotamia-layout'
		) );
	}


	wp_enqueue_style( 'mesopotamia-style', get_stylesheet_uri(), array(
		'mesopotamia-skin'
	) );

	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/lib/bootstrap/js/bootstrap.min.js',
		array( 'jquery' ) );

	wp_enqueue_script( 'mesopotamia-js', get_template_directory_uri() . '/js/script.js', array(
		'imagesloaded',
		'masonry',
		'bootstrap'
	) );
}

add_action( 'wp_enqueue_scripts', 'mesopotamia_scripts' );

/**
 * Converts a HEX value to RGB.
 *
 * @since Mesopotamia 1.0
 *
 * @param string $color The original color, in 3- or 6-digit hexadecimal form.
 *
 * @return array Array containing RGB (red, green, and blue) values for the given
 *               HEX code, empty array otherwise.
 */
function mesopotamia_hex2rgb( $color ) {
	$color = trim( $color, '#' );

	if ( strlen( $color ) === 3 ) {
		$r = hexdec( substr( $color, 0, 1 ) . substr( $color, 0, 1 ) );
		$g = hexdec( substr( $color, 1, 1 ) . substr( $color, 1, 1 ) );
		$b = hexdec( substr( $color, 2, 1 ) . substr( $color, 2, 1 ) );
	} else if ( strlen( $color ) === 6 ) {
		$r = hexdec( substr( $color, 0, 2 ) );
		$g = hexdec( substr( $color, 2, 2 ) );
		$b = hexdec( substr( $color, 4, 2 ) );
	} else {
		return array();
	}

	return array( 'red' => $r, 'green' => $g, 'blue' => $b );
}

/**
 * Check if the sidebar is enabled for the template
 *
 * @since Mesopotamia 1.0
 *
 * @param string $template The template that you want to check, acceptable are blog, search, and archive
 *
 * @return bool
 */
function mesopotamia_has_sidebar( $template ) {
	$disabled_sidebars = mesopotamia_get_array_of_options( array(
		'disable_blog_sidebar',
		'disable_search_sidebar',
		'disable_archive_sidebar'
	) );

	if ( in_array( $template, $disabled_sidebars ) ) {
		return false;
	}

	return true;
}

function mesopotamia_get_array_of_options( $options ) {
	$results = array();
	foreach ( $options as $option ) {
		$results[] = get_theme_mod( $option );
	}

	return $results;
}

function mesopotamia_sanitize_boolean( $bool ) {
	return filter_var( $bool, FILTER_VALIDATE_BOOLEAN );
}

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

/**
 * Load Bootstrap nav walker.
 */
require get_template_directory() . '/inc/wp_bootstrap_navwalker.php';

/**
 * Load inline style.
 */
require get_template_directory() . '/inc/inline-style.php';
