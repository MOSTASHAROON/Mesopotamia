<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

/**
 * Enqueues front-end CSS for the sidebar text color.
 *
 * @since Twenty Fifteen 1.0
 */
function mesopotamia_inline_css() {

	$first_main_color = mesopotamia_get_option('first_main_color','mesopotamia_general_settings','#ff6700');
	$second_main_color = mesopotamia_get_option('second_main_color','mesopotamia_general_settings','#00aeef');

	$css = '
		/* Mesopotamia Inline CSS */
/* Misc */
aside section h2, .mesopotamia-widgets h2 {
    border-top: 2px solid %1$s;
    color: %1$s;
}

article.thumbnail {
    border-top: 4px solid %2$s;
}

aside section {
    border-top: 4px solid %2$s;
}

a {
    color: %1$s;
}

a:hover, a:focus {
    color: %1$s;
}

/* Footer */
.site-footer a:hover {
    color: %1$s;
}

.footer-container {
    border-top: 4px solid %1$s;
}

/* Menus */
#site-navigation {
    border-top: 4px solid %1$s;
}

.navbar-brand {
    color: %1$s !important;
}

.comment-navigation .nav-previous a,
.posts-navigation .nav-previous a,
.post-navigation .nav-previous a,
.comment-navigation .nav-next a,
.posts-navigation .nav-next a,
.post-navigation .nav-next a {
    border-bottom: 4px solid %2$s;
}

.paging-navigation {
    border-top: 4px solid %2$s;
}

#primary-menu a:hover, #primary-menu a:active , #primary-menu li.active a{
    color: %1$s;
}

/* Posts and pages */
.entry-footer {
    border-top: 4px solid %1$s;
}

/* Search form */
.search-form .input-group {
    border-top: 5px solid %1$s;
}

.btn-search {
    color: %2$s;
}

.btn-search:hover {
    color: %2$s;
}

/* Scroll To Top Button */
.scrollToTop {
    color: %2$s;
}

/* Comments */
#submit, .comment-reply-link{
    border-bottom: 4px solid #00aeef;
}

.comment-reply-link:hover{
    color:  %2$s;
}

#comments article{
    border-left: 4px solid %2$s;
}
	';

	wp_add_inline_style( 'mesopotamia-style', sprintf( $css, $first_main_color,$second_main_color ) );
}
add_action( 'wp_enqueue_scripts', 'mesopotamia_inline_css', 11 );