<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Eng
 */

if ( ! function_exists( 'the_posts_navigation' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 */
function the_posts_navigation() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	?>
	<nav class="navigation posts-navigation" role="navigation">
		<h2 class="screen-reader-text"><?php esc_html_e( 'Posts navigation', 'eng' ); ?></h2>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( esc_html__( 'Older posts', 'eng' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( esc_html__( 'Newer posts', 'eng' ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'the_post_navigation' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 */
function the_post_navigation() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h2 class="screen-reader-text"><?php esc_html_e( 'Post navigation', 'eng' ); ?></h2>
		<div class="nav-links">
			<?php
				previous_post_link( '<div class="nav-previous">%link</div>', '%title' );
				next_post_link( '<div class="nav-next">%link</div>', '%title' );
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'eng_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function eng_posted_on() {
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
		//esc_html_x( 'Posted on %s', 'post date', 'eng' ),
		'<span class="screen-reader-text">Posted on</span><i class="genericon genericon-time"></i> %s',
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		'<span class="screen-reader-text">by</span><i class="genericon genericon-user"></i> %s', //esc_html_x
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

}
endif;

if ( ! function_exists( 'eng_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function eng_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' == get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'eng' ) );
		if ( $categories_list && eng_categorized_blog() ) {
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'eng' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'eng' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'eng' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( esc_html__( 'Leave a comment', 'eng' ), esc_html__( '1 Comment', 'eng' ), esc_html__( '% Comments', 'eng' ) );
		echo '</span>';
	}

	edit_post_link( esc_html__( 'Edit', 'eng' ), '<span class="edit-link">', '</span>' );
}
endif;

if ( ! function_exists( 'the_archive_title' ) ) :
/**
 * Shim for `the_archive_title()`.
 *
 * Display the archive title based on the queried object.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 *
 * @param string $before Optional. Content to prepend to the title. Default empty.
 * @param string $after  Optional. Content to append to the title. Default empty.
 */
function the_archive_title( $before = '', $after = '' ) {
	if ( is_category() ) {
		$title = sprintf( esc_html__( 'Category: %s', 'eng' ), single_cat_title( '', false ) );
	} elseif ( is_tag() ) {
		$title = sprintf( esc_html__( 'Tag: %s', 'eng' ), single_tag_title( '', false ) );
	} elseif ( is_author() ) {
		$title = sprintf( esc_html__( 'Author: %s', 'eng' ), '<span class="vcard">' . get_the_author() . '</span>' );
	} elseif ( is_year() ) {
		$title = sprintf( esc_html__( 'Year: %s', 'eng' ), get_the_date( esc_html_x( 'Y', 'yearly archives date format', 'eng' ) ) );
	} elseif ( is_month() ) {
		$title = sprintf( esc_html__( 'Month: %s', 'eng' ), get_the_date( esc_html_x( 'F Y', 'monthly archives date format', 'eng' ) ) );
	} elseif ( is_day() ) {
		$title = sprintf( esc_html__( 'Day: %s', 'eng' ), get_the_date( esc_html_x( 'F j, Y', 'daily archives date format', 'eng' ) ) );
	} elseif ( is_tax( 'post_format' ) ) {
		if ( is_tax( 'post_format', 'post-format-aside' ) ) {
			$title = esc_html_x( 'Asides', 'post format archive title', 'eng' );
		} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
			$title = esc_html_x( 'Galleries', 'post format archive title', 'eng' );
		} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
			$title = esc_html_x( 'Images', 'post format archive title', 'eng' );
		} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
			$title = esc_html_x( 'Videos', 'post format archive title', 'eng' );
		} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
			$title = esc_html_x( 'Quotes', 'post format archive title', 'eng' );
		} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
			$title = esc_html_x( 'Links', 'post format archive title', 'eng' );
		} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
			$title = esc_html_x( 'Statuses', 'post format archive title', 'eng' );
		} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
			$title = esc_html_x( 'Audio', 'post format archive title', 'eng' );
		} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
			$title = esc_html_x( 'Chats', 'post format archive title', 'eng' );
		}
	} elseif ( is_post_type_archive() ) {
		$title = sprintf( esc_html__( 'Archives: %s', 'eng' ), post_type_archive_title( '', false ) );
	} elseif ( is_tax() ) {
		$tax = get_taxonomy( get_queried_object()->taxonomy );
		/* translators: 1: Taxonomy singular name, 2: Current taxonomy term */
		$title = sprintf( esc_html__( '%1$s: %2$s', 'eng' ), $tax->labels->singular_name, single_term_title( '', false ) );
	} else {
		$title = esc_html__( 'Archives', 'eng' );
	}

	/**
	 * Filter the archive title.
	 *
	 * @param string $title Archive title to be displayed.
	 */
	$title = apply_filters( 'get_the_archive_title', $title );

	if ( ! empty( $title ) ) {
		echo $before . $title . $after;  // WPCS: XSS OK.
	}
}
endif;

if ( ! function_exists( 'the_archive_description' ) ) :
/**
 * Shim for `the_archive_description()`.
 *
 * Display category, tag, or term description.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 *
 * @param string $before Optional. Content to prepend to the description. Default empty.
 * @param string $after  Optional. Content to append to the description. Default empty.
 */
function the_archive_description( $before = '', $after = '' ) {
	$description = apply_filters( 'get_the_archive_description', term_description() );

	if ( ! empty( $description ) ) {
		/**
		 * Filter the archive description.
		 *
		 * @see term_description()
		 *
		 * @param string $description Archive description to be displayed.
		 */
		echo $before . $description . $after;  // WPCS: XSS OK.
	}
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function eng_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'eng_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'eng_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so eng_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so eng_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in eng_categorized_blog.
 */
function eng_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'eng_categories' );
}
add_action( 'edit_category', 'eng_category_transient_flusher' );
add_action( 'save_post',     'eng_category_transient_flusher' );

function eng_change_bloginfo_name( $text ) {
	if ( $text === 'Engenharia Livre' ) {
		$text = explode( ' ', $text);
		$text = "{$text[0]} <strong>{$text[1]}</strong>";
	}
	
	return $text;
}

function eng_social_links() {
	echo '<ul class="social-links">';
	array_map( function( $item ) {
		$url = get_theme_mod( 
			eng_sanitize_setting_id( $item, eng_customize_social_links()['prefix'] )
		);
		if ( ! empty( $url ) && filter_var($url, FILTER_VALIDATE_URL) ) {
			$class =  ( eng_sanitize_setting_id( $item ) === 'google' ) ? 'googleplus' : eng_sanitize_setting_id( $item );
			echo '<li><a href="'. $url .'"><i class="genericon genericon-'. $class .'"></i><span class="screen-reader-text">'. $item .'</span></a></li>';
		}
	}, eng_customize_social_links()['items'] );
	echo '</ul>';
}

function eng_thumbnail( $echo = true, $size = [670, 256] ) {
	$output = '<div class="entry-thumbnail">';
	if ( has_post_thumbnail() ) {
		if ( ! is_page() && ! is_single()  )
			$output .= '<a href="'. get_the_permalink()  .'">';
		$output .= str_replace( 'fit=', 'resize=', get_the_post_thumbnail( null, $size ) ); 
		//echo str_replace( 'fit=', 'resize=', get_the_post_thumbnail( null, $size ) );
		//print_r($size);
		//echo get_the_post_thumbnail(null, $size);
		if ( ! is_page() && ! is_single()  )
			$output .= '</a>';
	} else {
		//$output .= '<img src="http://novo.engenharialivre.com/wp-content/uploads/2015/08/photo-1436891620584-47fd0e565afb-e1440250721876-1024x372.jpeg" />';
	}
	$output .=  '</div>';

	if ( $echo === true  ) {
		echo $output;
	} else {
		return $output;
	}

}

function eng_featured_posts( $arg = null ) {
	if ( is_home() && is_front_page() && ! is_paged() ) {
		$category_id = get_theme_mod( 'eng_featured_posts_category' );
		if ( empty( $category_id ) )
			return;
		$posts_per_page = get_theme_mod( 'eng_featured_posts_amount' );
		$orderby = get_theme_mod( 'eng_featured_posts_orderby' );
		
		/** Start the query **/
		$query = new WP_Query([
			'cat' => $category_id,
			'posts_per_page' => $posts_per_page,
			'order' => 'DESC',
			//'orderby' => $orderby,
			'meta_query' => [
				['key' => '_thumbnail_id']
			]
		]);

		//Store posts ID in order the exclude them from the main query
		if ( $query->have_posts() ) {
			$ids = [];
			$i = 1;
			$output = '<section id="featured-posts" class="slides">';
			while ( $query->have_posts() ) {
				$query->the_post();
				$ids[] = get_the_ID();
				if ( $arg === null ) {
					$output .= '<article id="post-'. get_the_ID() .'" class="'. implode( ' ', get_post_class() ) .'">';
					$output .= eng_thumbnail( null, [960, 300] );
					$output .= '<div class="entry-header">';
					$output .= '<h2 class="entry-title"><a href="'. get_permalink() .'" rel="bookmark">'. get_the_title() .'</a></h2>';
					$output .= '<div class="entry-summary screen-reader-text">';
					$output .= get_the_excerpt();
					$output .= '</div>';
					$output .= '</div>';
					$output .= '</article>';				
				}
				$i++;
			}
			$output .= '</section>';
		}
		
		//Restore original Post Data
		wp_reset_postdata();

		if ( $arg === 'ids' ) {
			return $ids;
		} else {
			echo $output;
		}
	}
}

add_action( 'pre_get_posts', function( $query ) {
	if ( $query->is_home() && $query->is_main_query() )
		$query->set( 'post__not_in', eng_featured_posts( 'ids' ) );
} );

