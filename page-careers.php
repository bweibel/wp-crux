<?php
/**
 * Template Name: Career Template
 * The template for displaying all pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

use WP_Query;

// $theme = get_template_directory_uri();

// $order = get_field('order');

$args = array(
	'post_type' => 'crux_careers',
	'orderby' => 'date',
);
$career_query = new WP_Query( $args );

get_header();

wp_rig()->print_styles( 'wp-rig-content' );

?>
	<main id="primary" class="site-main">
		<?php

		while ( have_posts() ) {
			the_post();

			get_template_part( 'template-parts/content/entry', 'page' );
		}

		?>

		<div id="careers-list" class="careers-list">
		<?php if ( $career_query->have_posts() ) : ?>
		<!-- the loop -->
			<?php
			while ( $career_query->have_posts() ) :
				$career_query->the_post();
							get_template_part( 'template-parts/careers/career' );
							endwhile;
			?>
		<!-- end of the loop -->

				<?php wp_reset_postdata(); ?>
			<?php endif; ?>
		</div>

		<?php
		// Additional Page Content (ACF).
		get_template_part( 'template-parts/acf/flexible', get_post_type(), array( 'row_group' => 'page_blocks') );
		?>

	</main><!-- #primary -->
	<script>
		if ( 'loading' === document.readyState ) {
		// The DOM has not yet been loaded.
		document.addEventListener( 'DOMContentLoaded', initCareers );
		} else {
		// The DOM has already been loaded.
		initCareers();
		}

			function initCareers() {
				const listEl = document.getElementById('careers-list');
				const careerEls = [...document.getElementsByClassName('career')];

				console.log(careerEls);

				careerEls.forEach(career => {
					career.getElementsByClassName('career-header')[0]
						.addEventListener('click', e => {
							if (!career.classList.contains("open")) {
								career.classList.add("open");
							} else {
								career.classList.remove("open");
							}
					});
				})
			}


	</script>
<?php
// get_sidebar();
get_footer();
