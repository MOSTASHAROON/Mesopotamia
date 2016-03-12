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
	<div class="col-md-8 col-xs-12">
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
							<div class="post-box col-lg-4 col-md-4 col-sm-4">
								<article class="thumbnail">
									<div class="caption">
										<?php
										the_widget( 'WP_Widget_Recent_Posts' );
										?>
									</div><!-- .caption -->
								</article><!-- .thumbnail -->
							</div><!-- .post-box -->
							<div class="post-box col-lg-4 col-md-4 col-sm-4">
								<article class="thumbnail">
									<div class="caption">
										<?php
										// Only show the widget if site has multiple categories.
										if ( mesopotamia_categorized_blog() ) :
											?>

											<div class="widget widget_categories">
												<h2 class="widget-title"><?php esc_html_e( 'Most Used Categories', 'mesopotamia' ); ?></h2>
												<ul>
													<?php
													wp_list_categories( array(
														'orderby'    => 'count',
														'order'      => 'DESC',
														'show_count' => 1,
														'title_li'   => '',
														'number'     => 10,
													) );
													?>
												</ul>
											</div><!-- .widget -->

											<?php
										endif;
										?>
									</div><!-- .caption -->
								</article><!-- .thumbnail -->
							</div><!-- .post-box -->
							<div class="post-box col-lg-4 col-md-4 col-sm-4">
								<article class="thumbnail">
									<div class="caption">
										<?php
										/* translators: %1$s: smiley */
										$archive_content = '<p>' . sprintf( esc_html__( 'Try looking in the monthly archives. %1$s', 'mesopotamia' ), convert_smilies( ':)' ) ) . '</p>';
										the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );
										?>
									</div><!-- .caption -->
								</article><!-- .thumbnail -->
							</div><!-- .post-box -->
							<div class="post-box col-lg-4 col-md-4 col-sm-4">
								<article class="thumbnail">
									<div class="caption">
										<?php
										the_widget( 'WP_Widget_Tag_Cloud' );
										?>
									</div><!-- .caption -->
								</article><!-- .thumbnail -->
							</div><!-- .post-box -->
						</div><!-- .mesopotamia-widgets -->
					</div><!-- .page-content -->
				</section><!-- .error-404 -->

			</main><!-- #main -->
		</div><!-- #primary -->
	</div><!--col-md-8 col-xs-12 -->
<?php
get_sidebar();
get_footer();
