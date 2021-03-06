<?php
/**
 * Template Name: Full Width
 */

get_header(); ?>

<?php do_action( 'mesopotamia_start_full_width_page' ); ?>

	<div class="row">
	<div class="col-xs-12">
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">

				<?php
				while ( have_posts() ) : the_post();

					get_template_part( 'template-parts/content', 'page' );

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
get_footer();
