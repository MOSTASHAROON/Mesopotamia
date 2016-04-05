<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Mesopotamia
 */

get_header(); ?>
	<div class="row">
<?php if (  mesopotamia_has_sidebar( 'blog' ) ){ ?>
	<?php $grid = mesopotamia_get_option( 'grid', 'mesopotamia_general_settings', '8X4' ); ?>
	<?php if ( $grid == '8X4' ){ ?>
	<div class="col-md-8 col-xs-12">
	<?php }elseif ( $grid == '9X3' ){ ?>
	<div class="col-md-9 col-xs-12">
	<?php } ?>
	<?php } else { ?>
	<div class="col-md-12 col-xs-12">
<?php } ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<?php
			if ( have_posts() ) :

				if ( is_home() && ! is_front_page() ) : ?>
					<header>
						<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
					</header>

					<?php
				endif;
				?>
				<div class="mesopotamia-posts">
					<?php
					/* Start the Loop */
					while ( have_posts() ) : the_post();

						/*
						 * Include the Post-Format-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'template-parts/content', get_post_format() );

					endwhile;

					?>
				</div>
				<?php

				mesopotamia_paging_nav();

			else :

				get_template_part( 'template-parts/content', 'none' );

			endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->
	</div><!--col-md-* col-xs-12 -->
<?php
if (  mesopotamia_has_sidebar( 'blog' ) ) {
	get_sidebar();
}
get_footer();
