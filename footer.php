<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package groak_dev
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
		<div class="site-info">
			<span class="sep"> | </span>
			<?php
				/* translators: 1: Theme name, 2: Theme author. */
                $this_theme = wp_get_theme();
                $authorURI = $this_theme->get('AuthorURI');
				printf( esc_html__( 'Developed by: %1$s by %2$s.', 'gr_d_' ), 'gr_d_', '<a href="'.$authorURI.'">Groak Development</a>' );
			?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
