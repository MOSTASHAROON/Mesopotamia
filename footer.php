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
<a href="#" class="scrollToTop"><i class="fa fa-chevron-up"></i></a>
<div class="container-fluid footer-container">
	<footer id="colophon" class="site-footer" role="contentinfo">

		<?php
		$top_footer = mesopotamia_get_option( 'top_footer', false );

		if ( $top_footer == true ) {
			echo '<div class="row">';
			$top_columns = mesopotamia_get_option( 'top_columns', '1' );
			switch ( $top_columns ) {
				case '1':
					echo '<div class="col-lg-12 col-md-12 col-sm-12">';
					?>
					<div class="supplementary">
						<div class="footer-widgets widget-area clear" role="complementary">
							<?php
							dynamic_sidebar( 'footer-sidebar-1' );
							?>
						</div><!-- .footer-widgets -->
					</div><!-- .supplementary -->
					<?php
					echo '</div>';
					break;
				case '2':
					echo '<div class="col-lg-6 col-md-6 col-sm-6">';
					?>
					<div class="supplementary">
						<div class="footer-widgets widget-area clear" role="complementary">
							<?php
							dynamic_sidebar( 'footer-sidebar-1' );
							?>
						</div><!-- .footer-widgets -->
					</div><!-- .supplementary -->
					<?php
					echo '</div>';

					echo '<div class="col-lg-6 col-md-6 col-sm-6">';
					?>
					<div class="supplementary">
						<div class="footer-widgets widget-area clear" role="complementary">
							<?php
							dynamic_sidebar( 'footer-sidebar-2' );
							?>
						</div><!-- .footer-widgets -->
					</div><!-- .supplementary -->
					<?php
					echo '</div>';
					break;
				case '3':
					echo '<div class="col-lg-4 col-md-4 col-sm-4">';
					?>
					<div class="supplementary">
						<div class="footer-widgets widget-area clear" role="complementary">
							<?php
							dynamic_sidebar( 'footer-sidebar-1' );
							?>
						</div><!-- .footer-widgets -->
					</div><!-- .supplementary -->
					<?php
					echo '</div>';

					echo '<div class="col-lg-4 col-md-4 col-sm-4">';
					?>
					<div class="supplementary">
						<div class="footer-widgets widget-area clear" role="complementary">
							<?php
							dynamic_sidebar( 'footer-sidebar-2' );
							?>
						</div><!-- .footer-widgets -->
					</div><!-- .supplementary -->
					<?php
					echo '</div>';

					echo '<div class="col-lg-4 col-md-4 col-sm-4">';
					?>
					<div class="supplementary">
						<div class="footer-widgets widget-area clear" role="complementary">
							<?php
							dynamic_sidebar( 'footer-sidebar-3' );
							?>
						</div><!-- .footer-widgets -->
					</div><!-- .supplementary -->
					<?php
					echo '</div>';
					break;
				case '4':
					echo '<div class="col-lg-3 col-md-3 col-sm-3">';
					?>
					<div class="supplementary">
						<div class="footer-widgets widget-area clear" role="complementary">
							<?php
							dynamic_sidebar( 'footer-sidebar-1' );
							?>
						</div><!-- .footer-widgets -->
					</div><!-- .supplementary -->
					<?php
					echo '</div>';

					echo '<div class="col-lg-3 col-md-3 col-sm-3">';
					?>
					<div class="supplementary">
						<div class="footer-widgets widget-area clear" role="complementary">
							<?php
							dynamic_sidebar( 'footer-sidebar-2' );
							?>
						</div><!-- .footer-widgets -->
					</div><!-- .supplementary -->
					<?php
					echo '</div>';

					echo '<div class="col-lg-3 col-md-3 col-sm-3">';
					?>
					<div class="supplementary">
						<div class="footer-widgets widget-area clear" role="complementary">
							<?php
							dynamic_sidebar( 'footer-sidebar-3' );
							?>
						</div><!-- .footer-widgets -->
					</div><!-- .supplementary -->
					<?php
					echo '</div>';

					echo '<div class="col-lg-3 col-md-3 col-sm-3">';
					?>
					<div class="supplementary">
						<div class="footer-widgets widget-area clear" role="complementary">
							<?php
							dynamic_sidebar( 'footer-sidebar-4' );
							?>
						</div><!-- .footer-widgets -->
					</div><!-- .supplementary -->
					<?php
					echo '</div>';
					break;
			}

			echo '</div>';
		}
		?>

		<div class="bottom-footer">
			<div class="site-info" id="copyright">


                <?php $copyright = mesopotamia_get_option( 'copyright', '');
				if($copyright){
				    esc_html_e( stripslashes( str_replace( "%year%", current_time( 'Y' ), $copyright ) ));
                }else {
					echo str_replace( "%year%", current_time( 'Y' ),'© %year% <a href="' . esc_url( __( 'https://mostasharoon.org',
							'mesopotamia' ) ) . '" rel="designer">' . __( 'MOSTASHAROON', 'mesopotamia' ) . '</a>');
				}
                ?>


			</div><!-- .site-info -->
			<?php mesopotamia_footer_menu(); ?>
		</div><!-- .bottom-footer -->
	</footer><!-- #colophon -->
</div><!-- .container -->

<?php wp_footer(); ?>

</body>
</html>
