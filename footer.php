<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Mesopotamia
 */

?>

</div><!-- #content -->
</div><!-- #page -->
</div><!-- .container -->
<div class="container-fluid footer-container">
	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<?php printf( esc_html__( '© 2016 %1$s', 'mesopotamia' ), '<a href="https://mostasharoon.org" rel="designer">MOSTASHAROON</a>' ); ?>
		</div><!-- .site-info -->
		<?php mesopotamia_footer_menu(); ?>
	</footer><!-- #colophon -->
</div><!-- .container -->

<?php wp_footer(); ?>

</body>
</html>
