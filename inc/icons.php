<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

function mesopotamia_icon( $atts ) {
	$atts = shortcode_atts( apply_filters( 'mesopotamia_icon_atts', array(
		'icon'                   => '',
		'size'                   => '',
		'link'                   => '',
		'target'                 => '_self',
		'icon_color'             => '#ffffff',
		'icon_hover_color'       => '#ffffff',
		'background_color'       => '#333333',
		'background_hover_color' => '#333333',
		'background_type'        => 'fa-circle',
	), $atts ), $atts, 'mesopotamia_icon' );

	$html = '';

	if ( ! empty( $atts['icon'] ) ) {
		if ( ! empty( $atts['link'] ) ) {
			$html .= '<a href="' . $atts['link'] . '" target="' . $atts['target'] . '">';
		}

		$html .= '<span class="fa-stack fa-lg" style="font-size: ' . $atts['size'] . ';">';
		$html .= '<i class="fa ' . $atts['background_type'] . ' fa-stack-2x" onMouseOver="this.style.color=\'' . $atts['background_hover_color'] . '\'" onMouseOut="this.style.color=\'' . $atts['icon_color'] . '\'" style="color: ' . $atts['background_color'] . ';"></i>';
		$html .= '<i class="fa ' . $atts['icon'] . ' fa-stack-1x" onMouseOver="this.style.color=\'' . $atts['icon_hover_color'] . '\'" onMouseOut="this.style.color=\'' . $atts['icon_color'] . '\'" style="color: ' . $atts['icon_color'] . ';"></i>';
		$html .= '</span>';
		if ( ! empty( $atts['link'] ) ) {
			$html .= '</a>';
		}
	}

	return $html;
}

add_shortcode( 'mesopotamia_icon', 'mesopotamia_icon' );