<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Mesopotamia
 */

?>

<section class="no-results not-found">
	<header class="page-header page-header">
		<h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'mesopotamia' ); ?></h1>
	</header><!-- .page-header -->

	<div class="page-content">
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'mesopotamia' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php elseif ( is_search() ) : ?>

			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'mesopotamia' ); ?></p>
			<?php
				get_search_form();

		else : ?>

			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'mesopotamia' ); ?></p>
			<?php
				get_search_form();

		endif; ?>
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
</section><!-- .no-results -->
