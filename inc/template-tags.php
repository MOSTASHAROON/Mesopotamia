<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Mesopotamia
 */

if ( ! function_exists( 'mesopotamia_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function mesopotamia_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			esc_html_x( '%s', 'post date', 'mesopotamia' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		$byline = sprintf(
			esc_html_x( '%s', 'post author', 'mesopotamia' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="posted-on"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span> ' . $posted_on . '&nbsp;&nbsp;</span><span class="byline"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> ' . $byline . '</span>'; // WPCS: XSS OK.

		$categories_list = mesopotamia_get_the_category();
		if ( $categories_list && mesopotamia_categorized_blog() ) {
			echo $categories_list;
		}
	}
endif;

if ( ! function_exists( 'mesopotamia_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function mesopotamia_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '<ul class="list-inline"><li><i class="fa fa-tag"></i> ', '</li><li><i class="fa fa-tag"></i> ', '</li></ul>' );
			if ( $tags_list ) {
				printf( '<span class="tags-links"> ' . esc_html__( '%1$s', 'mesopotamia' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link"> ';
			comments_popup_link( esc_html__( 'Leave a comment', 'mesopotamia' ), esc_html__( '1 Comment', 'mesopotamia' ), esc_html__( '% Comments', 'mesopotamia' ) );
			echo '</span>';
		}

		edit_post_link(
			sprintf(
			/* translators: %s: Name of current post */
				esc_html__( 'Edit %s', 'mesopotamia' ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			),
			'<span class="edit-link"><i class="fa fa-pencil"></i> ',
			'</span>'
		);
	}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function mesopotamia_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'mesopotamia_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'mesopotamia_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so mesopotamia_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so mesopotamia_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in mesopotamia_categorized_blog.
 */
function mesopotamia_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'mesopotamia_categories' );
}

add_action( 'edit_category', 'mesopotamia_category_transient_flusher' );
add_action( 'save_post', 'mesopotamia_category_transient_flusher' );

/*
 * Footer menu
 */

function mesopotamia_footer_menu() {
	if ( has_nav_menu( 'footer' ) ) {
		wp_nav_menu(
			array(
				'theme_location'  => 'footer',
				'container'       => 'div',
				'container_id'    => 'menu-footer',
				'container_class' => 'menu-footer',
				'menu_id'         => 'menu-footer-items',
				'menu_class'      => 'menu-items list-inline',
				'depth'           => 1,
				'fallback_cb'     => '',
			)
		);
	}
}

function mesopotamia_get_the_category() {
	$categories = get_the_category();

	if ( empty( $categories ) ) {
		return '';
	}

	global $wp_rewrite;

	$rel = ( is_object( $wp_rewrite ) && $wp_rewrite->using_permalinks() ) ? 'rel="category tag"' : 'rel="category"';

	$thelist = '<ul class="post-categories list-inline">';

	foreach ( $categories as $category ) {
		$thelist .= "<li>";
		$thelist .= '<i class="fa fa-folder-open"></i> <a href="' . esc_url( get_category_link( $category->term_id ) ) . '" ' . $rel . '>' . $category->name . '</a>';
		$thelist .= "</li>";
	}

	$thelist .= '</ul>';

	return $thelist;
}

function mesopotamia_post_nav() {
	?>
	<nav class="navigation post-navigation" role="navigation">
		<div class="post-nav-box">
			<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'mesopotamia' ); ?></h1>
			<div class="nav-links">
				<?php
				previous_post_link( '<div class="nav-previous"><div class="nav-indicator">' . _x( 'Previous Post:', 'Previous post', 'mesopotamia' ) . '</div>%link</div>', '%title' );
				next_post_link( '<div class="nav-next"><div class="nav-indicator">' . _x( 'Next Post:', 'Next post', 'mesopotamia' ) . '</div>%link</div>', '%title' );
				?>
			</div><!-- .nav-links -->
		</div><!-- .post-nav-box -->
	</nav><!-- .navigation -->
	<?php
}
