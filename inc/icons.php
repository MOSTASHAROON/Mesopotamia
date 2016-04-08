<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

function mesopotamia_icon( $atts ) {
	$atts = shortcode_atts( apply_filters( 'mesopotamia_icon_atts', array(
		'icon'             => '',
		'size'             => '',
		'theme'            => 'mesopotamia',//normal
		'link'             => '',
		'target'           => '_self',
		'icon_color'       => '#ffffff',
//		'icon_hover_color'       => '#ffffff',
		'background_color' => '#333333',
//		'background_hover_color' => '#333333',
		'background_type'  => 'fa-circle',
	), $atts ), $atts, 'mesopotamia_icon' );

	$html = '';

	if ( ! empty( $atts['icon'] ) ) {

		switch ( $atts['theme'] ) {
			case 'mesopotamia':
				$link = '#';
				$size = empty( $atts['size'] ) ? '45px' : $atts['size'];
				if ( ! empty( $atts['link'] ) ) {
					$link = $atts['link'];
				}
				$html .= '<a href="' . $link . '" class="mesopotamia-icon" style="width: ' . $size . ';height: ' . $size . ';" target="' . $atts['target'] . '"><i class="fa ' . $atts['icon'] . '"></i></a>';
				break;

			case 'awesome':
				if ( ! empty( $atts['link'] ) ) {
					$html .= '<a href="' . $atts['link'] . '" target="' . $atts['target'] . '">';
				}

				$html .= '<span class="fa-stack fa-lg" style="font-size: ' . $atts['size'] . ';">';
				$html .= '<i class="fa ' . $atts['background_type'] . ' fa-stack-2x" style="color: ' . $atts['background_color'] . ';"></i>';
				$html .= '<i class="fa ' . $atts['icon'] . ' fa-stack-1x" style="color: ' . $atts['icon_color'] . ';"></i>';
				$html .= '</span>';
				if ( ! empty( $atts['link'] ) ) {
					$html .= '</a>';
				}
				break;
		}
	}

	return $html;
}

add_shortcode( 'mesopotamia_icon', 'mesopotamia_icon' );