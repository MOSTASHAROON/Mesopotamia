<?php
/**
 * Template part for displaying page content in scratch.php page template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Mesopotamia
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="caption">
		<div class="entry-content clearfix caption">
			<?php the_content(); ?>
		</div><!-- .entry-content -->
	</div>
</article><!-- #post-## -->
