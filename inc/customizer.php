<?php
/**
 * Mesopotamia Theme Customizer.
 *
 * @package Mesopotamia
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function mesopotamia_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}

add_action( 'customize_register', 'mesopotamia_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function mesopotamia_customize_preview_js() {
	wp_enqueue_script( 'mesopotamia_customizer', get_template_directory_uri() . '/js/customizer.js',
		array( 'customize-preview' ), '20170313', true );
}

add_action( 'customize_preview_init', 'mesopotamia_customize_preview_js' );

function register_mesopotamia_sections( $wp_customize ) {
	$wp_customize->add_section( "general", array(
		"title"    => __( "General", "mesopotamia" ),
		"priority" => 30,
	) );

	$wp_customize->add_section( "header", array(
		"title"    => __( "Header", "mesopotamia" ),
		"priority" => 31,
	) );

	$wp_customize->add_section( "footer", array(
		"title"    => __( "Footer", "mesopotamia" ),
		"priority" => 32,
	) );
}

add_action( "customize_register", "register_mesopotamia_sections" );

function register_mesopotamia_settings( $wp_customize ) {
	$wp_customize->add_setting( "first_main_color", array(
		"default"   => "#ff6700",
		"transport" => "refresh",
	) );

	$wp_customize->add_setting( "second_main_color", array(
		"default"   => "#00aeef",
		"transport" => "refresh",
	) );

	$wp_customize->add_setting( "grid", array(
		"default"   => "8X4",
		"transport" => "refresh",
	) );

	$wp_customize->add_setting( "skin", array(
		"default"   => "dark",
		"transport" => "refresh",
	) );

	$wp_customize->add_setting( "disable_blog_sidebar", array(
		"default"   => "",
		"transport" => "refresh",
	) );

	$wp_customize->add_setting( "disable_search_sidebar", array(
		"default"   => "",
		"transport" => "refresh",
	) );

	$wp_customize->add_setting( "disable_archive_sidebar", array(
		"default"   => "",
		"transport" => "refresh",
	) );

	$wp_customize->add_setting( "blog_slider_revolution", array(
		"default"   => "",
		"transport" => "refresh",
	) );

	$wp_customize->add_setting( "search_slider_revolution", array(
		"default"   => "",
		"transport" => "refresh",
	) );

	$wp_customize->add_setting( "archive_slider_revolution", array(
		"default"   => "",
		"transport" => "refresh",
	) );

	$wp_customize->add_setting( "logo", array(
		"default"   => "",
		"transport" => "refresh",
	) );

	$wp_customize->add_setting( "search", array(
		"default"   => false,
		"transport" => "refresh",
	) );

	$wp_customize->add_setting( "fixed_header", array(
		"default"   => false,
		"transport" => "refresh",
	) );

	$wp_customize->add_setting( "top_footer", array(
		"default"   => false,
		"transport" => "refresh",
	) );

	$wp_customize->add_setting( "top_columns", array(
		"default"   => '1',
		"transport" => "refresh",
	) );

	$wp_customize->add_setting( "copyright", array(
		"default"   => '© %year% <a href="' . esc_url( __( 'https://mostasharoon.org',
				'mesopotamia' ) ) . '" rel="designer">' . __( 'MOSTASHAROON', 'mesopotamia' ) . '</a>',
		"transport" => "refresh",
	) );

	do_action( 'register_mesopotamia_settings', $wp_customize );
}

add_action( "customize_register", "register_mesopotamia_settings" );

function register_mesopotamia_controls( $wp_customize ) {
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'first_main_color',
			array(
				'label'    => __( 'First Main Color', 'mesopotamia' ),
				'section'  => 'general',
				'settings' => 'first_main_color',
			) )
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'second_main_color',
			array(
				'label'    => __( 'Second Main Color', 'mesopotamia' ),
				'section'  => 'general',
				'settings' => 'second_main_color',
			) )
	);

	$wp_customize->add_control(
		'grid',
		array(
			'type'    => 'select',
			'label'   => __( 'Grid', 'mesopotamia' ),
			'section' => 'general',
			'choices' => array(
				'8X4' => __( '8X4', 'mesopotamia' ),
				'9X3' => __( '9X3', 'mesopotamia' ),
			),
		)
	);

	$wp_customize->add_control(
		'skin',
		array(
			'type'    => 'select',
			'label'   => __( 'Skin', 'mesopotamia' ),
			'section' => 'general',
			'choices' => array(
				'light' => __( 'Light', 'mesopotamia' ),
				'dark'  => __( 'Dark', 'mesopotamia' )
			),
		)
	);

	$wp_customize->add_control(
		'disable_blog_sidebar',
		array(
			'type'    => 'checkbox',
			'label'   => __( 'Disable sidebar for blog', 'mesopotamia' ),
			'section' => 'general'
		)
	);

	$wp_customize->add_control(
		'disable_search_sidebar',
		array(
			'type'    => 'checkbox',
			'label'   => __( 'Disable sidebar for search', 'mesopotamia' ),
			'section' => 'general'
		)
	);

	$wp_customize->add_control(
		'disable_archive_sidebar',
		array(
			'type'    => 'checkbox',
			'label'   => __( 'Disable sidebar for archive', 'mesopotamia' ),
			'section' => 'general'
		)
	);

	$rev_sliders = array();

	if ( class_exists( 'RevSlider' ) ) {

		$rev = new RevSlider();

		$arrSliders = $rev->getArrSliders();
		foreach ( (array) $arrSliders as $revSlider ) {
			$rev_sliders[ $revSlider->getAlias() ] = $revSlider->getTitle();
		}
	}

	$rev_sliders[''] = 'None';

	$wp_customize->add_control(
		'blog_slider_revolution',
		array(
			'type'    => 'select',
			'label'   => __( 'Select Slider Revolution For Blog Page', 'mesopotamia' ),
			'section' => 'general',
			'choices' => $rev_sliders,
		)
	);

	$wp_customize->add_control(
		'search_slider_revolution',
		array(
			'type'    => 'select',
			'label'   => __( 'Select Slider Revolution For Search Page', 'mesopotamia' ),
			'section' => 'general',
			'choices' => $rev_sliders,
		)
	);

	$wp_customize->add_control(
		'archive_slider_revolution',
		array(
			'type'    => 'select',
			'label'   => __( 'Select Slider Revolution For Archive/Category/Tag Page', 'mesopotamia' ),
			'section' => 'general',
			'choices' => $rev_sliders,
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'logo',
			array(
				'label'       => __( 'Upload a logo', 'theme_name' ),
				'section'     => 'header',
				'settings'    => 'logo',
				'description' => __( 'Perfect logo height for Mesopotamia theme is 50px', 'mesopotamia' )
//				'context'    => 'your_setting_context'
			)
		)
	);

	$wp_customize->add_control(
		'search',
		array(
			'type'    => 'checkbox',
			'label'   => __( 'Show search box in menu', 'mesopotamia' ),
			'section' => 'header'
		)
	);

	$wp_customize->add_control(
		'fixed_header',
		array(
			'type'    => 'checkbox',
			'label'   => __( 'Fixed header', 'mesopotamia' ),
			'section' => 'header'
		)
	);

	$wp_customize->add_control(
		'top_footer',
		array(
			'type'    => 'checkbox',
			'label'   => __( 'Enable top footer', 'mesopotamia' ),
			'section' => 'footer'
		)
	);

	$wp_customize->add_control(
		'top_columns',
		array(
			'type'    => 'select',
			'label'   => __( 'Number of columns', 'mesopotamia' ),
			'section' => 'footer',
			'choices' => array(
				'1' => __( '1', 'mesopotamia' ),
				'2' => __( '2', 'mesopotamia' ),
				'3' => __( '3', 'mesopotamia' ),
				'4' => __( '4', 'mesopotamia' ),
			),
		)
	);

	$wp_customize->add_control( new WP_Customize_Control(
		$wp_customize,
		"copyright",
		array(
			"label"    => __( 'Copyright', 'mesopotamia' ),
			"section"  => "footer",
			"settings" => "copyright",
			"type"     => "textarea",
		)
	) );

	do_action( 'register_mesopotamia_controls', $wp_customize );
}

add_action( "customize_register", "register_mesopotamia_controls" );