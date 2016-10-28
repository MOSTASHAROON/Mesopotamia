<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

/**
 * Include theme options page library
 */
if ( ! class_exists( 'MOSTASHAROON_Admin_Page' ) ) {
	require_once( get_template_directory() . '/lib/mostasharoon-admin-page/mostasharoon-admin-page.php' );
}

function mesopotamia_admin_menu() {

	$rev_sliders = array();

	if ( class_exists( 'RevSlider' ) ) {

		$rev = new RevSlider();

		$arrSliders = $rev->getArrSliders();
		foreach ( (array) $arrSliders as $revSlider ) {
			$rev_sliders[ $revSlider->getAlias() ] = $revSlider->getTitle();
		}
	}

	$rev_sliders[''] = 'None';

	$fields = array(
		'general' => array(
			array(
				'label'   => __( 'First Main Color', 'mesopotamia' ),
				'name'    => 'mesopotamia_general_settings[first_main_color]',
				'type'    => 'color_picker',
				'default' => '#ff6700',
			),
			array(
				'label'   => __( 'Second Main Color', 'mesopotamia' ),
				'name'    => 'mesopotamia_general_settings[second_main_color]',
				'type'    => 'color_picker',
				'default' => '#00aeef',
			),
			array(
				'label'   => __( 'Grid', 'mesopotamia' ),
				'name'    => 'mesopotamia_general_settings[grid]',
				'options' => array(
					'8X4' => __( '8X4', 'mesopotamia' ),
					'9X3' => __( '9X3', 'mesopotamia' ),
				),
				'type'    => 'select',
				'default' => '8X4',
			),
			array(
				'label'   => __( 'Skin', 'mesopotamia' ),
				'name'    => 'mesopotamia_general_settings[skin]',
				'options' => array(
					'light' => __( 'Light', 'mesopotamia' ),
					'dark'  => __( 'Dark', 'mesopotamia' )
				),
				'type'    => 'select',
				'default' => '8X4',
			),
			array(
				'label'   => __( 'Disable sidebar for', 'mesopotamia' ),
				'name'    => 'mesopotamia_general_settings[disable_sidebar]',
				'options' => array(
					'blog'    => __( 'Blog', 'mesopotamia' ),
					'search'  => __( 'Search', 'mesopotamia' ),
					'archive' => __( 'Archive/Category/Tag', 'mesopotamia' )
				),
				'type'    => 'multi_check',
			),
			array(
				'label'   => __( 'Select Slider Revolution For Blog Page', 'mesopotamia' ),
				'name'    => 'mesopotamia_general_settings[blog_slider_revolution]',
				'options' => $rev_sliders,
				'type'    => 'select',
				'default' => '',
				'help'    => __( 'The Slider Revolution plugin must be active in order this option to work, Slider Revolution plugin available for free with Mesopotamia Pro', 'mesopotamia' )
			),
			array(
				'label'   => __( 'Select Slider Revolution For Search Page', 'mesopotamia' ),
				'name'    => 'mesopotamia_general_settings[search_slider_revolution]',
				'options' => $rev_sliders,
				'type'    => 'select',
				'default' => '',
				'help'    => __( 'The Slider Revolution plugin must be active in order this option to work, Slider Revolution plugin available for free with Mesopotamia Pro', 'mesopotamia' )
			),
			array(
				'label'   => __( 'Select Slider Revolution For Archive/Category/Tag Page', 'mesopotamia' ),
				'name'    => 'mesopotamia_general_settings[archive_slider_revolution]',
				'options' => $rev_sliders,
				'type'    => 'select',
				'default' => '',
				'help'    => __( 'The Slider Revolution plugin must be active in order this option to work, Slider Revolution plugin available for free with Mesopotamia Pro', 'mesopotamia' )
			),
		),
		'header'  => array(
			array(
				'label'       => __( 'Logo', 'mesopotamia' ),
				'name'        => 'mesopotamia_header_settings[logo]',
				'type'        => 'media_uploader_image',
				'button_type' => 'button',
				'classes'     => 'small app-upload-file',
				'value'       => 'Select Logo',
				'help'        => __( 'Perfect logo height for Mesopotamia theme is 50px', 'mesopotamia' )
			),
			array(
				'label'   => __( 'Show search box in menu', 'mesopotamia' ),
				'name'    => 'mesopotamia_header_settings[search]',
				'default' => 'no',
				'type'    => 'checkbox',
			),
			array(
				'label'   => __( 'Fixed header', 'mesopotamia' ),
				'name'    => 'mesopotamia_header_settings[fixed_header]',
				'default' => 'no',
				'type'    => 'checkbox',
			),
			array(
				'label'   => __( 'Enable UberMenu', 'mesopotamia' ),
				'name'    => 'mesopotamia_header_settings[UberMenu]',
				'default' => 'no',
				'type'    => 'checkbox',
				'help'    => __( 'The UberMenu plugin must be active in order this option to work, UberMenu plugin available for free with Mesopotamia Pro', 'mesopotamia' )
			),
		),
		'footer'  => array(
			array(
				'label' => __( 'Top Footer', 'mesopotamia' ),
				'type'  => 'legend',
			),
			array(
				'label'   => __( 'Enable top footer', 'mesopotamia' ),
				'name'    => 'mesopotamia_footer_settings[top_footer]',
				'default' => 'no',
				'type'    => 'checkbox',
			),
			array(
				'label'   => __( 'Number of columns', 'mesopotamia' ),
				'name'    => 'mesopotamia_footer_settings[top_columns]',
				'options' => array(
					'1' => __( '1', 'mesopotamia' ),
					'2' => __( '2', 'mesopotamia' ),
					'3' => __( '3', 'mesopotamia' ),
					'4' => __( '4', 'mesopotamia' ),
				),
				'type'    => 'select',
				'default' => '1',
			),
			array(
				'label' => __( 'Bottom Footer', 'mesopotamia' ),
				'type'  => 'legend',
			),
			array(
				'label'   => __( 'Copyright', 'mesopotamia' ),
				'name'    => 'mesopotamia_footer_settings[copyright]',
				'type'    => 'textarea',
				'default' => '© %year% <a href="'.esc_url(__('https://mostasharoon.org', 'mesopotamia' )).'" rel="designer">'.__('MOSTASHAROON', 'mesopotamia' ).'</a>',
				'help'    => __( 'Use %year% to refer to the current year.', 'mesopotamia' ),
			),
		),
	);


	$tabs = array(
		'general' => 'General',
		'header'  => 'Header',
		'footer'  => 'Footer',
	);

	$page = new MOSTASHAROON_Admin_Page();
	$page->setPluginUrl( get_template_directory_uri() )
	     ->setTabsHeaders( $tabs )
	     ->setActiveTab( 'general' )
	     ->setFields( $fields )
	     ->setPageTitle( 'Mesopotamia' )
	     ->add_theme_page( 'manage_options', 'mesopotamia' );
}

add_action( 'admin_menu', 'mesopotamia_admin_menu' );

function mesopotamia_save_settings() {
	if ( isset( $_POST['mesopotamia_general_settings'] ) && $_POST['mesopotamia_general_settings'] ) {
		update_option( 'mesopotamia_general_settings', array_map( "wp_kses_post", $_POST['mesopotamia_general_settings'] ) );
	}
	if ( isset( $_POST['mesopotamia_header_settings'] ) && $_POST['mesopotamia_header_settings'] ) {
		update_option( 'mesopotamia_header_settings', array_map( "wp_kses_post", $_POST['mesopotamia_header_settings'] ) );
	}

	if ( isset( $_POST['mesopotamia_footer_settings'] ) && $_POST['mesopotamia_footer_settings'] ) {
		update_option( 'mesopotamia_footer_settings', array_map( "wp_kses_post", $_POST['mesopotamia_footer_settings'] ) );
	}
}

add_action( 'mostasharoon_save_settings', 'mesopotamia_save_settings' );
