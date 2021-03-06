<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Mesopotamia
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php do_action( 'mesopotamia_body_top' ); ?>
<div class="container-fluid">
	<div id="page" class="site">
		<a class="skip-link screen-reader-text"
		   href="#content"><?php esc_html_e( 'Skip to content', 'mesopotamia' ); ?></a>

		<header id="masthead" class="site-header" role="banner">
            <?php do_action( 'mesopotamia_start_header_tag' ); ?>
			<?php if ( !function_exists( 'ubermenu' ) || ( true != mesopotamia_get_option( 'UberMenu', false ) ) ): ?>
				<div class="site-branding screen-reader-text">
					<?php
					if ( is_front_page() && is_home() ) : ?>
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"
						                          rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php else : ?>
						<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"
						                         rel="home"><?php bloginfo( 'name' ); ?></a></p>
						<?php
					endif;

					$description = get_bloginfo( 'description', 'display' );
					if ( $description || is_customize_preview() ) : ?>
						<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
						<?php
					endif; ?>
				</div><!-- .site-branding -->
				<?php $is_fixed_header = mesopotamia_get_option( 'fixed_header', false ); ?>
				<?php $fixed_class = ( $is_fixed_header == true ) ? 'navbar-fixed-top' : ''; ?>
				<nav class="navbar navbar-default <?php echo $fixed_class; ?> main-navigation" id="site-navigation"
				     role="navigation">
					<div class="container-fluid navbar-container-fluid">
						<!-- Brand and toggle get grouped for better mobile display -->
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse"
							        data-target="#bs-mesopotamia-navbar-collapse-1">
								<span class="sr-only"><?php esc_html_e( 'Toggle navigation', 'mesopotamia' ); ?></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
							<?php
							if ( function_exists( 'get_custom_logo' ) && has_custom_logo() ) {
								?>
                                <a class="navbar-brand" href="<?php echo esc_url(home_url()); ?>">
									<?php the_custom_logo(); ?>
                                </a>
								<?php
							}
							?>
                            <?php $mod = get_theme_mod('header_text');
							if ( $mod != 0 ) {
							?>
                            <a class="navbar-brand" href="<?php echo esc_url(home_url()); ?>">
                               <?php bloginfo( 'name' );?>
							</a>
                            <?php
                            }
                            ?>
						</div>
						<!-- Collect the nav links, forms, and other content for toggling -->
						<div class="collapse navbar-collapse" id="bs-mesopotamia-navbar-collapse-1">
							<?php
							wp_nav_menu( array(
									'theme_location' => 'primary',
									'menu_id'        => 'primary-menu',
									'depth'          => 2,
									'container'      => false,
									'menu_class'     => 'nav navbar-nav navbar-right',
									'fallback_cb'    => 'wp_bootstrap_navwalker::fallback',
									'walker'         => new wp_bootstrap_navwalker()
								)
							);
							?>
							<?php if ( true == mesopotamia_get_option( 'search', false ) ) { ?>
								<form class="navbar-form navbar-right mesopotamia-navbar-search-form" role="search">
									<div class="form-group">
										<input type="search" class="search-field form-control input-search" name="s"
										       placeholder="<?php esc_attr_e( 'Search ...', 'mesopotamia' ) ?>">
									</div>
								</form>
							<?php } ?>
						</div><!-- /.navbar-collapse -->
					</div>
				</nav><!-- #site-navigation -->
			<?php endif; ?>
		</header><!-- #masthead -->

		<div id="content" class="site-content">
