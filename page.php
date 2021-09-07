<?php
/**
 * The template for displaying all pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

get_header();

wp_rig()->print_styles( 'wp-rig-content' );

?>
	<main id="primary" class="site-main">
		<?php

		while ( have_posts() ) {
			the_post();

			get_template_part( 'template-parts/content/entry', 'page' );
		}

		// Additional Page Content (ACF).
		get_template_part( 'template-parts/acf/flexible', get_post_type(), array( 'row_group' => 'page_blocks') );
		?>
	</main><!-- #primary -->
<?php
// get_sidebar();
get_footer();
