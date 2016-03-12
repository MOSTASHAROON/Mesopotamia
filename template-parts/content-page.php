<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Mesopotamia
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'thumbnail' ); ?>>

	<?php
	// Check if the post has a Post Thumbnail assigned to it.
	if ( has_post_thumbnail() ) {
		the_post_thumbnail();
	}
	?>
	<div class="caption">
		<header class="entry-header page-header caption">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</header><!-- .entry-header -->

		<div class="entry-content clearfix caption">
			<?php
			the_content();

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'mesopotamia' ),
				'after'  => '</div>',
			) );
			?>
		</div><!-- .entry-content -->

		<footer class="entry-footer">
			<?php
			edit_post_link(
				sprintf(
				/* translators: %s: Name of current post */
					esc_html__( 'Edit %s', 'mesopotamia' ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				),
				'<span class="edit-link"><i class="fa fa-pencil"></i> ',
				'</span>'
			);
			?>
		</footer><!-- .entry-footer -->
	</div>
</article><!-- #post-## -->
