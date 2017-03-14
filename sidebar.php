<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Mesopotamia
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<?php $grid = get_theme_mod("grid"); ?>
<?php if ( $grid == '8X4' ) { ?>
	<div class="col-md-4 col-xs-12">
<?php } elseif ( $grid == '9X3' ) { ?>
	<div class="col-md-3 col-xs-12">
<?php } ?>


	<aside id="secondary" class="widget-area" role="complementary">
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	</aside><!-- #secondary -->
	</div><!-- .col-md-*>-->

<?php if ( ! is_page_template( 'page-templates/sidebar-content.php' ) ) { ?>
	</div><!-- .row -->
<?php } ?>