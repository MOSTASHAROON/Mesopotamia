<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Mesopotamia
 */

get_header(); ?>
	<div class="row">
<?php $grid = get_theme_mod("grid"); ?>
<?php if ( $grid == '8X4' ){ ?>
	<div class="col-md-8 col-xs-12">
	<?php }elseif ( $grid == '9X3' ){ ?>
	<div class="col-md-9 col-xs-12">
<?php } ?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'mesopotamia' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'mesopotamia' ); ?></p>

					<?php
					get_search_form();
					?>
					<div class="mesopotamia-widgets">
						<?php dynamic_sidebar( '404-sidebar' ); ?>
					</div><!-- .mesopotamia-widgets -->
				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->
	</div><!--col-md-* col-xs-12 -->
<?php
get_sidebar();
get_footer();
