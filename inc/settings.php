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
	$fields = array(
		'general' => array(
			array(
				'label' => __( 'Logo', 'mesopotamia' ),
				'name'  => 'mesopotamia_general_settings[logo]',
				'type'  => 'media_uploader_image',
				'button_type' => 'button',
				'classes'     => 'small app-upload-file',
				'value'       => 'Select Logo',
				'help'  => __( 'Perfect logo height for Mesopotamia theme is 50px', 'mesopotamia' )
			),
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
					'9X3' => __( '9X3', 'mesopotamia' ),
					'8X4' => __( '8X4', 'mesopotamia' )
				),
				'type'    => 'select',
				'default' => '8X4',
			)
		),
//		'tools'   => array(
//			array(
//				'label'   => __( 'Reset Settings', 'mesopotamia' ),
//				'name'    => 'mesopotamia_general_tools[reset]',
//				'type'    => 'button',
//				'button_type'    => 'button',
//				'value'    => 'Reset',
//				'help'  => __( 'Reset theme settings to the default settings.', 'mesopotamia' )
//
//			),
//		)
	);


	$tabs = array(
		'general' => 'General',
//		'tools'   => 'Tools'
	);

	$page = new MOSTASHAROON_Admin_Page();
	$page->setPluginUrl( get_template_directory_uri() )
	     ->setTabsHeaders( $tabs )
	     ->setActiveTab( 'general' )
	     ->setFields( $fields )
	     ->setPageTitle( 'Mesopotamia' )
	     ->add_sub_menu_page( 'themes.php', 'manage_options', 'mesopotamia' );
}

add_action( 'admin_menu', 'mesopotamia_admin_menu' );

function mesopotamia_save_settings() {
	update_option( 'mesopotamia_general_settings', $_POST['mesopotamia_general_settings'] );
//	update_option( 'mesopotamia_tools_settings', $_POST['mesopotamia_tools_settings'] );
}

add_action( 'mostasharoon_save_settings', 'mesopotamia_save_settings' );