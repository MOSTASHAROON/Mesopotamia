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
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time> <i class="fa fa-pencil"></i> <time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			esc_html_x( '%s', 'post date', 'mesopotamia' ),
			'<a href="' . esc_url( mesopotamia_get_post_day_link() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		$byline = sprintf(
			esc_html_x( '%s', 'post author', 'mesopotamia' ),
			'<span class="author vcard"><i class="fa fa-user"> <a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></i></span>'
		);

		echo '<span class="posted-on"><i class="fa fa-calendar"></i> ' . $posted_on . '&nbsp;&nbsp;</span><span class="byline">' . $byline . '</span>'; // WPCS: XSS OK.

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
			echo '<span class="comments-link"><i class="fa fa-comments"></i> ';
			comments_popup_link( esc_html__( 'Leave a comment', 'mesopotamia' ), esc_html__( '1 Comment', 'mesopotamia' ), esc_html__( '% Comments', 'mesopotamia' ) );
			echo '</span>';
		}

		edit_post_link(
			sprintf(
			/* translators: %s: Name of current post */
				esc_html__( 'Edit %s', 'mesopotamia' ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			),
			' <span class="edit-link"><i class="fa fa-pencil"></i> ',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'mesopotamia_get_post_day_link' ) ) :

	function mesopotamia_get_post_day_link() {

		$archive_year  = get_the_time( 'Y' );
		$archive_month = get_the_time( 'm' );
		$archive_day   = get_the_time( 'd' );

		return get_day_link( $archive_year, $archive_month, $archive_day );
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
	<nav class="navigation post-navigation clearfix" role="navigation">
		<div class="post-nav-box">
			<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'mesopotamia' ); ?></h1>
			<div class="nav-links">
				<?php
				//				previous_post_link( '<div class="nav-previous"><div class="nav-indicator">' . _x( 'Previous', 'Previous post', 'mesopotamia' ) . '</div>%link</div>', '%title' );
				previous_post_link( '<div class="nav-previous"><div class="nav-indicator">%link</div></div>', _x( 'Previous', 'Previous post', 'mesopotamia' ) );
				next_post_link( '<div class="nav-next"><div class="nav-indicator">%link</div></div>', _x( 'Next', 'Next post', 'mesopotamia' ) );
				?>
			</div><!-- .nav-links -->
		</div><!-- .post-nav-box -->
	</nav><!-- .navigation -->
	<?php
}

//function mesopotamia_add_post_classes( $classes, $class, $post_id ) {
//	if ( ! is_single() ) {
//		$classes[] = 'thumbnail';
//	}
//
//	return $classes;
//}
//
//add_filter( 'post_class', 'mesopotamia_add_post_classes', 10, 3 );

if ( ! function_exists( 'mesopotamia_paging_nav' ) ) :
	/**
	 * Display navigation to next/previous set of posts when applicable.
	 *
	 * @since Twenty Fourteen 1.0
	 *
	 * @global WP_Query $wp_query WordPress Query object.
	 * @global WP_Rewrite $wp_rewrite WordPress Rewrite object.
	 */
	function mesopotamia_paging_nav() {
		global $wp_query, $wp_rewrite;

		// Don't print empty markup if there's only one page.
		if ( $wp_query->max_num_pages < 2 ) {
			return;
		}

		$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
		$pagenum_link = html_entity_decode( get_pagenum_link() );
		$query_args   = array();
		$url_parts    = explode( '?', $pagenum_link );

		if ( isset( $url_parts[1] ) ) {
			wp_parse_str( $url_parts[1], $query_args );
		}

		$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
		$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

		$format = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
		$format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

		// Set up paginated links.
		$links = paginate_links( array(
			'base'      => $pagenum_link,
			'format'    => $format,
			'total'     => $wp_query->max_num_pages,
			'current'   => $paged,
			'mid_size'  => 1,
			'add_args'  => array_map( 'urlencode', $query_args ),
			'prev_text' => __( '&larr; Previous', 'mesopotamia' ),
			'next_text' => __( 'Next &rarr;', 'mesopotamia' ),
		) );

		if ( $links ) :

			?>
			<nav class="navigation paging-navigation" role="navigation">
				<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'mesopotamia' ); ?></h1>
				<div class="pagination loop-pagination">
					<?php echo $links; ?>
				</div><!-- .pagination -->
			</nav><!-- .navigation -->
			<?php
		endif;
	}
endif;

add_filter( 'comment_form_default_fields', 'bootstrap3_comment_form_fields' );
function bootstrap3_comment_form_fields( $fields ) {
	$commenter = wp_get_current_commenter();

	$req      = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
	$html5    = current_theme_supports( 'html5', 'comment-form' ) ? 1 : 0;

	$fields = array(
		'author' => '<div class="form-group comment-form-author">' . '<label for="author">' . __( 'Name' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
		            '<input class="form-control" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></div>',
		'email'  => '<div class="form-group comment-form-email"><label for="email">' . __( 'Email' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
		            '<input class="form-control" id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></div>',
		'url'    => '<div class="form-group comment-form-url"><label for="url">' . __( 'Website' ) . '</label> ' .
		            '<input class="form-control" id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></div>'
	);

	return $fields;
}

add_filter( 'comment_form_defaults', 'bootstrap3_comment_form' );
function bootstrap3_comment_form( $args ) {
	$args['comment_field'] = '<div class="form-group comment-form-comment">
            <label for="comment">' . _x( 'Comment', 'noun' ) . '</label> 
            <textarea class="form-control" id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>
        </div>';
	$args['class_submit']  = 'btn btn-default'; // since WP 4.1
//	$args['title_reply'] = 'Ma';

	return $args;
}

// Customize Comment Output
function bootstrap3_comment_format( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment; ?>

<li <?php comment_class( 'media' ); ?> id="comment-<?php comment_ID(); ?>">
	<article class="thumbnail mesopotamia-comment">
		<div class="comment-meta media-left">
			<?php echo get_avatar( $comment, 48 ); ?>
			<p class="text-center comment-author"><?php comment_author_link(); ?></p>
		</div> <!-- .comment-meta -->
		<div class="comment-content media-body">
			<p class="comment-date text-right text-muted pull-right"><?php echo human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) ) . ' ago'; ?>
				&nbsp;<a class="comment-permalink"
				         href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"
				         title="Comment Permalink"><i class="icon-link"></i></a></p>
			<?php if ( $comment->comment_approved == '0' ) { // Awaiting Moderation ?>
				<em><?php _e( 'Your comment is awaiting moderation.' ) ?></em>
			<?php } ?>
			<?php comment_text(); ?>
			<div class="reply pull-right">
				<?php comment_reply_link( array_merge( $args, array(
					'reply_text' => __( '<i class="icon-reply"></i>&nbsp; Reply' ),
					'depth'      => $depth,
					'max_depth'  => $args['max_depth']
				) ) ); ?>
			</div>
		</div> <!-- .comment-content -->
	</article>
<?php }

// Add Class to Gravatar
add_filter( 'get_avatar', 'twbs_avatar_class' );
function twbs_avatar_class( $class ) {
	$class = str_replace( "class='avatar", "class='avatar media-object", $class );

	return $class;
}

// Add Class to Comment Reply Link
add_filter( 'comment_reply_link', 'twbs_reply_link_class' );
function twbs_reply_link_class( $class ) {
	$class = str_replace( "class='comment-reply-link", "class='comment-reply-link", $class );

	return $class;
}

function mesopotamia_widget_categories_dropdown_args( $cat_args ) {
	$cat_args['class'] = 'form-control';

	return $cat_args;
}

add_filter( 'widget_categories_dropdown_args', 'mesopotamia_widget_categories_dropdown_args', 10, 1 );
