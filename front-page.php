<?php
/**
 * Render your site front page, whether the front page displays the blog posts index or a static page.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#front-page-display
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

get_header();

$theme = get_template_directory_uri();

wp_rig()->print_styles( 'wp-rig-content', 'wp-rig-front-page' );


?>
	<main id="primary" class="site-main">
		<header class="entry-header">
			<?php
				get_template_part( 'template-parts/content/entry_thumbnail', get_post_type() );
			?>
				<section class="entry-title-container">
					<div class="content">
						<a href="/tasting-room/" class="button button-yellow">Visit Our<br> Tasting Room</a>
						<a href="/beer/" class="button button-gold">Explore<br> Our Beers</a>
					</div>
				</section>
		</header><!-- .entry-header -->
		<?php

		while ( have_posts() ) {
			the_post();

			// get_template_part( 'template-parts/content/entry', get_post_type() );
			// Additional Page Content (ACF).
			get_template_part( 'template-parts/acf/flexible', get_post_type(), array( 'row_group' => 'page_blocks') );
		}

		?>

	</main><!-- #primary -->
<?php
get_footer();
