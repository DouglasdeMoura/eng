<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Eng
 */

?>
	
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<?php eng_thumbnail( true, [670, 256] ); ?>

	<header class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php eng_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	
	<footer class="entry-footer screen-reader-text">
		<?php eng_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
