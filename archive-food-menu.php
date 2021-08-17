<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

get_header();

wp_rig()->print_styles( 'wp-rig-content', 'wp-rig-careers' );

$theme = get_template_directory_uri();

?>
	<main id="primary" class="site-main careers">
		<?php
		if ( have_posts() ) {

			get_template_part( 'template-parts/content/page_header' );

			while ( have_posts() ) {
				the_post();

				// get_template_part( 'template-parts/content/entry', get_post_type() );
				?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry career' ); ?>>
				<?php
				get_template_part( 'template-parts/content/entry_header-careers', get_post_type() );

				if ( is_search() ) {
					get_template_part( 'template-parts/content/entry_summary', get_post_type() );
				} else {
					get_template_part( 'template-parts/content/entry_content', get_post_type() );
				}

				// get_template_part( 'template-parts/content/entry_footer', get_post_type() );
				?>
		</article><!-- #post-<?php the_ID(); ?> -->
				<?php
			}

			get_template_part( 'template-parts/content/pagination' );
		} else {
			get_template_part( 'template-parts/content/error' );
		}
		echo '<img src="' . $theme . '/assets/images/Crux_Shop.jpg" alt="Crux Employee" class="alignwide aligncenter">';

		?>
	</main><!-- #primary -->
<?php
get_sidebar();
get_footer();
