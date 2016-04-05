<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Mesopotamia
 */

get_header(); ?>
	<div class="row">
<?php if ( mesopotamia_has_sidebar( 'search' ) ){ ?>
	<?php $grid = mesopotamia_get_option( 'grid', 'mesopotamia_general_settings', '8X4' ); ?>
	<?php if ( $grid == '8X4' ){ ?>
	<div class="col-md-8 col-xs-12">
	<?php }elseif ( $grid == '9X3' ){ ?>
	<div class="col-md-9 col-xs-12">
	<?php } ?>
	<?php } else { ?>
	<div class="col-md-12 col-xs-12">
<?php } ?>
	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			if ( have_posts() ) : ?>

				<header class="page-header">
					<h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'mesopotamia' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
				</header><!-- .page-header -->
				<div class="mesopotamia-posts">
					<?php
					/* Start the Loop */
					while ( have_posts() ) : the_post();

						/**
						 * Run the loop for the search to output the results.
						 * If you want to overload this in a child theme then include a file
						 * called content-search.php and that will be used instead.
						 */
						get_template_part( 'template-parts/content', 'search' );

					endwhile;
					?>
				</div>
				<?php
				mesopotamia_paging_nav();
			else :
				get_template_part( 'template-parts/content', 'none' );

			endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->
	</div><!--col-md-* col-xs-12 -->
<?php
if ( mesopotamia_has_sidebar( 'search' ) ) {
	get_sidebar();
}
get_footer();
