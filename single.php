<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Mesopotamia
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
<?php $grid = get_theme_mod("grid"); ?>
<?php if ( $grid == '8X4' ){ ?>
	<div class="col-md-8 col-xs-12">
	<?php }elseif ( $grid == '9X3' ){ ?>
	<div class="col-md-9 col-xs-12">
<?php } ?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content-single', get_post_format() );

				mesopotamia_post_nav();

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->
	</div><!--col-md-* col-xs-12 -->
<?php
get_sidebar();
get_footer();
