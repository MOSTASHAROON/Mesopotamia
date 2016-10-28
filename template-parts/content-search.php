<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Mesopotamia
 */

?>
<?php if ( ! mesopotamia_has_sidebar( 'search' ) ){ ?>
<div class="post-box col-lg-3 col-md-3 col-sm-3">
	<?php } else { ?>
	<div class="post-box col-lg-4 col-md-4 col-sm-4">
		<?php } ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'thumbnail' ); ?>>

			<?php
			// Check if the post has a Post Thumbnail assigned to it.
			if ( has_post_thumbnail() ) {
				the_post_thumbnail();
			}
			?>
			<div class="caption">
				<header class="entry-header">
					<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

					<?php if ( 'post' === get_post_type() ) : ?>
						<div class="entry-meta">
							<?php mesopotamia_posted_on(); ?>
						</div><!-- .entry-meta -->
					<?php endif; ?>
				</header><!-- .entry-header -->
				<div class="entry-summary caption">
					<?php the_excerpt(); ?>
					<?php echo '<a href="' . get_permalink() . '" class="continue-reading" title="' . __( 'Continue Reading ', 'mesopotamia' ) . get_the_title() . '" rel="bookmark">Continue Reading</a>'; ?>
				</div><!-- .entry-summary -->

				<footer class="entry-footer">
					<?php mesopotamia_entry_footer(); ?>
				</footer><!-- .entry-footer -->
			</div>
		</article><!-- #post-## -->
	</div>
