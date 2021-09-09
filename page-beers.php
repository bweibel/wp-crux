<?php
/**
 * * Template Name: Beers Template
 * The template for displaying all beers
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

use WP_Query;

get_header();

wp_rig()->print_styles( 'wp-rig-content', 'wp-rig-beers', 'wp-rig-flexslider' );

wp_enqueue_script('wp-rig-beerlist');

$taxQuery = array(
	'taxonomy'  => 'beer_series',
	'field'     => 'slug',
	'terms'     => 'archive',
	'operator'  => 'NOT IN',
);

// Make our beer query.
$sorting = 'ASC';
$args = array(
	'post_type' => 'crux_beer',
	'orderby' => 'menu_order',
	'order' => $sorting,
	'posts_per_page' => -1,
	'tax_query' => array( $taxQuery ),
);

$beer_query = new WP_Query( $args );

// Featured Query.

$args = array(
	'post_type'      => 'crux_beer',
	'posts_per_page' => -1,
	'meta_key'       => 'featured',
	'meta_value'     => 'true',
	'tax_query'      => array( $taxQuery ),
);

$featured_query = new WP_Query( $args );

// Archive Query.

$taxQuery = array(
	'taxonomy'  => 'beer_series',
	'field'     => 'slug',
	'terms'     => 'archive',
);

$archiveArgs = array(
	'post_type' => 'crux_beer',
	'orderby' => 'menu_order',
	'order' => $sorting,
	'posts_per_page' => -1,
	'tax_query' => array( $taxQuery ),
);

$archive_query = new WP_Query( $archiveArgs );

?>
	<main id="primary" class="site-main">
		<?php

		while ( have_posts() ) {
			the_post();
			get_template_part( 'template-parts/content/entry', 'page' );
		}
		?>

		<?php if ( $featured_query ->have_posts() ) : ?>
		<!-- the loop -->
		<section class="entry-content">
		<h2 class="text-centered">Featured Beers</h2>
		<div class="flexslider" id="featured-beers">
			<ul class="slides">

				<?php
				while ( $featured_query->have_posts() ) :
					$featured_query->the_post();
						get_template_part( 'template-parts/beers/featured-beer' );
				endwhile;
				?>

				<!-- end of the loop -->
				</ul>
			</div>
			<div class="featured-controls"></div>

		</section>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>


		<section class="entry-content">
			<h2 class="text-centered">What you'll find on the shelf & on tap beyond our tasting room</h2>
		</section>

		<?php if ( $beer_query->have_posts() ) : ?>
		<!-- the loop -->
			<section class="beer-container" id="list-container">
				<section class="filter-controls" id="filter-controls">
					<header class="filter-header">
						<h3>Filter</h3>
					</header>
					<?php get_template_part( 'template-parts/beers/beer_filter' ); ?>

				</section>
				<h2 id="filter-name"></h2>
				<ul id="beer-list" class="beer-list open">
					<?php
					while ( $beer_query->have_posts() ) :
						$beer_query->the_post();
							get_template_part( 'template-parts/beers/beer' );
							endwhile;
					?>
					<!-- end of the loop -->
				</ul>
			</section>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>

		<?php if ( $archive_query->have_posts() ) : ?>
		<!-- the loop -->
			<section class="beer-container archive" id="archive-container">
				<button class="button archive-button" id="archive-button">Explore The<br>Archives</button>
				<ul id="archive-list" class="beer-list hidden">
				<h2>The Archives</h2>
					<?php
					while ( $archive_query->have_posts() ) :
						$archive_query->the_post();
						get_template_part( 'template-parts/beers/beer' );
					endwhile;
					?>
					<!-- end of the loop -->
				</ul>
			</section>
		<?php endif; ?>

		<?php wp_reset_postdata(); ?>

		<?php
		// Additional Page Content (ACF).
		get_template_part( 'template-parts/acf/flexible', get_post_type(), array( 'row_group' => 'page_blocks') );
		?>

	</main><!-- #primary -->

	<script>
		jQuery(window).load( function() {
			jQuery( '.flexslider' ).flexslider({
				animation: "slide",
				pauseOnHover: true,
				itemWidth: 200,
				itemMargin: 20,
			});
		});
	</script>

<?php
get_footer();
