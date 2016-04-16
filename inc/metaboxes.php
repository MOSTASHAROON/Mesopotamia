<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

/**
 * Get the bootstrap!
 */
if ( file_exists( get_template_directory() . '/lib/cmb2/init.php' ) ) {
	require_once get_template_directory() . '/lib/cmb2/init.php';
} elseif ( file_exists( get_template_directory() . '/lib/CMB2/init.php' ) ) {
	require_once get_template_directory() . '/lib/CMB2/init.php';
}

add_action( 'cmb2_admin_init', 'mesopotamia_slider_revolution' );
/**
 * Define the metabox and field configurations.
 */
function mesopotamia_slider_revolution() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_mesopotamia_';

	/**
	 * Initiate the metabox
	 */
	$cmb = new_cmb2_box( array(
		'id'           => 'mesopotamia_slider_revolution',
		'title'        => __( 'Mesopotamia Slider Revolution Settings', 'mesopotamia' ),
		'object_types' => get_post_types( array( 'public' => true ) ), // Post type
		'context'      => 'normal',
		'priority'     => 'high',
		'show_names'   => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // Keep the metabox closed by default
	) );

	$rev_sliders = array();

	if ( class_exists( 'RevSlider' ) ) {

		$rev = new RevSlider();

		$arrSliders = $rev->getArrSliders();
		foreach ( (array) $arrSliders as $revSlider ) {
			$rev_sliders[ $revSlider->getAlias() ] = $revSlider->getTitle();
		}
	}

	$cmb->add_field( array(
		'name'             => __( 'Select Slider', 'mesopotamia' ),
		'desc'             => __( 'The Slider Revolution plugin must be active in order this option to work, Slider Revolution plugin available for free with Mesopotamia Pro', 'mesopotamia' ),
		'id'               => $prefix . 'slider_revolution',
		'type'             => 'select',
		'show_option_none' => true,
		'options'          => $rev_sliders,
	) );
}