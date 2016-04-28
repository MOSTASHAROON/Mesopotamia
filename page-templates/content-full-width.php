<?php
/**
 * Template Name: Content Full Width
 */

get_header(); ?>

<?php
$rev_slider = get_post_meta( get_the_ID(), '_mesopotamia_slider_revolution', true );

if ( $rev_slider && function_exists( 'putRevSlider' ) ) {

	echo '<div id="main-slideshow">';
	putRevSlider( $rev_slider );
	echo '</div>';
}
?>
	<div class="row">
	<div class="col-xs-12">
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
				<?php
				while ( have_posts() ) : the_post();
					get_template_part( 'template-parts/content', 'full-width' );
				endwhile; // End of the loop.
				?>
			</main><!-- #main -->
		</div><!-- #primary -->
	</div><!--col-md-* col-xs-12 -->
<?php
get_footer();
