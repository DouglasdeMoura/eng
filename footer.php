<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Eng
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<?php eng_social_links(); ?>
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'eng' ) ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'eng' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( esc_html__( 'Theme: %1$s by %2$s.', 'eng' ), 'eng', '<a href="http://douglasmoura.com" rel="designer">Douglas Moura</a>' ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
