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

wp_rig()->print_styles( 'wp-rig-content', 'wp-rig-beers' );

$taxQuery = array(
	'taxonomy'  => 'beer-series',
	'field'     => 'slug',
	'terms'		=> 'archive',
	'operator'	=> 'NOT IN'
);

// Make our beer query
$sorting = 'ASC';
$args = array(
	'post_type' => 'crux_beer',
	'orderby' => 'menu_order',
	'order' => $sorting,
	'posts_per_page' => -1,
	'tax_query' => array($taxQuery),
);
$beer_query = new WP_Query( $args );

$taxQuery = array(
	'taxonomy'  => 'beer-series',
	'field'     => 'slug',
	'terms'		=> 'archive',
);

$archiveArgs = array(
	'post_type' => 'crux_beer',
	'orderby' => 'menu_order',
	'order' => $sorting,
	'posts_per_page' => -1,
	'tax_query' => array($taxQuery),
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

		<?php if ( $archive_query->have_posts() ) : ?>
	  <!-- the loop -->
			<section class="beer-container archive" id="archive-container">
				<button class="button" id="archive-button">Explore The<br>Archives</button>
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

		<section class="entry-content">
			<?php echo do_shortcode( '[metaslider id="6789"]' ); ?>
		</section>
		<?php wp_reset_postdata(); ?>

	</main><!-- #primary -->

	<script>
		if ( 'loading' === document.readyState ) {
			// The DOM has not yet been loaded.
			document.addEventListener( 'DOMContentLoaded', init );
		} else {
			// The DOM has already been loaded.
			init();
		}

		function init() {
			BeerList('list-container', 'filter-controls');
			BeerList('archive-container');

			const archiveListEl = document.getElementById('archive-list');
			const archiveButton = document.getElementById('archive-button');
			addClickToggle(archiveButton, archiveListEl);
		}


		function BeerList(listId, filterId=''){
			const listEl = document.getElementById(listId);
			const beerEls = [...listEl.querySelectorAll('.beer')];
			const filterEl = document.getElementById(filterId);
			const filterNameEl = document.getElementById('filter-name');

			if(filterEl) {
				initFilters();
			}

			initBeers();

			function initBeers() {
				beerEls.forEach(beer => {
					addClickToggle( beer.getElementsByClassName('beer-header')[0], beer );
				});
			}

			function initFilters() {
				addClickToggle(filterEl.getElementsByClassName("filter-header")[0], filterEl);
				const filterEls = [...document.getElementsByClassName('filter-button')];
				filterEls.forEach(button => {
					button.addEventListener('click', e => {
						filterEls.forEach(button => {
							button.classList.remove("active");
						})
						button.classList.add("active");
						updateFilter(button.dataset.filterslug, button.dataset.filtername);
					})
				});
			}

			function updateFilter(newFilter, newFilterName) {
				// Update filter name
				if ( newFilter ) {
					filterNameEl.innerHTML = newFilterName;
				} else {
					filterNameEl.innerHTML = '';
				}

				beerEls.forEach( beer => {
					if (!newFilter){
						beer.classList.remove('hidden');
					} else {
						if(!beer.classList.contains('beer-series-' + newFilter)) {
							beer.classList.add('hidden');
						} else {
							beer.classList.remove('hidden');
						}
					}

				});
				//Close the filter menu after switching
				filterEl.classList.remove('open');
			}
		}

		function addClickToggle(el, target) {
			el.addEventListener('click', e => {
				if (!target.classList.contains("open")) {
					target.classList.add("open");
				} else {
					target.classList.remove("open");
				}
			});
		}
	</script>
<?php
get_footer();
