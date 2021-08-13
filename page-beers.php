<?php
/**
 ** Template Name: Beers Template
 * The template for displaying all pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;
use WP_Query;

get_header();

wp_rig()->print_styles( 'wp-rig-content', 'wp-rig-beers' );


?>
	<main id="primary" class="site-main">
		<?php

		while ( have_posts() ) {
			the_post();
			get_template_part( 'template-parts/content/entry', 'page' );
		}
		?>

		<?php 
		// Make our taxonomy array
			$taxQuery = array();

			if( $seriesArgs ) {
				array_push($taxQuery, array(
					'taxonomy'  => 'beer-series',
					'field'     => 'slug',
					'terms'     => $seriesArgs
				));
			}

			$series = get_terms(  array(
				'taxonomy' => 'beer-series',
				'hide_empty' => true,
			) );

			$seriesSortOrder = array('year-round' => 0, 'seasonal' => 1, 'limited-release' => 2, 'banished' => 3, 'archive' => 4 );
			
			foreach ( $series as $theSeries ) {
				$theSeries->order = $seriesSortOrder[$theSeries->slug];
			}

			usort($series, function($a, $b)
			{
					return $a->order - $b->order;
			});


			$sorting = 'ASC';
			$args = array( 
				'post_type' => 'crux_beer',
				'orderby' => 'menu_order',
				'order'	=> $sorting,
				'posts_per_page'  => -1,
				'tax_query'      => $taxQuery
			);
			$beer_query = new WP_Query( $args ); 
		?>

		<?php if ( $beer_query->have_posts() ) : ?>
      <!-- the loop -->
			<section class="beer-container">
				<section class="filter-controls" id="filter-controls">
					<header class="filter-header">
						<h3>Filter</h3>
					</header>
					<ul class="filter-buttons">
						<?php 
						if ( $seriesArgs == '' ) {
							$className = "active";
						} else {
							$className = "";
						}
						echo '<li class=""><a class="filter-button data-filtername=""'. $className .'">All Beers</a></li>';

					foreach($series as $theSeries) {
							if ( $seriesArgs == $theSeries->slug ) {
								$className = "active";
							} else {
								$className = "";
							}

							if($theSeries->slug != 'archive' ) {
								echo '<li><a class="filter-button "' . $className . '" data-filtername="' . $theSeries->slug . '">' . $theSeries->name . '</a></li>';
							}
						} 

						?>
					</ul>
				</section>
				<ul id="beer-list" class="beer-list">
					<?php while ( $beer_query->have_posts() ) : $beer_query->the_post(); 
							get_template_part( 'template-parts/beers/beer' );  
							endwhile; 
					?>
      <!-- end of the loop -->
				</ul>
				<!-- <a style="text-align: center" href="" class="button">
					Explore the<br>archives
				</a> -->
			</section>

			<section class="entry-content">
			<?php echo do_shortcode('[metaslider id="6789"]'); ?>
			</section>
      <?php wp_reset_postdata(); ?>
    <?php endif; ?>

	</main><!-- #primary -->

	<script>
		if ( 'loading' === document.readyState ) {
        // The DOM has not yet been loaded.
        document.addEventListener( 'DOMContentLoaded', initBeers );
      } else {
        // The DOM has already been loaded.
        initBeers();
				
      }

			function initBeers() {
				let filter = '';
				updateFilter(filter);
				initFilters();
				const listEl = document.getElementById('beers-list');
				const beerEls = [...document.getElementsByClassName('beer')];
				const filterEl = document.getElementById('filter-controls');

				addClickToggle(filterEl.getElementsByClassName("filter-header")[0], filterEl);

				beerEls.forEach(beer => {
					addClickToggle( beer.getElementsByClassName('beer-header')[0], beer );
				});

			}

			function initFilters() {
				const filterEls = [...document.getElementsByClassName('filter-button')];
				filterEls.forEach(button => {
					button.addEventListener('click', e => {
						filterEls.forEach(button => {
							button.classList.remove("active");
						})
						button.classList.add("active");
						updateFilter(button.dataset.filtername);
					})
				});
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

			function updateFilter(newFilter) {
				console.log("new filter is: " + newFilter);
				let beers = [...document.getElementsByClassName("beer")];
				beers.forEach(beer => {
					if (!newFilter){
						beer.classList.remove('hidden');
					} else {
						if(!beer.classList.contains('beer-series-' + newFilter)) {
							beer.classList.add('hidden');
						} else {
							beer.classList.remove('hidden');
						}
					}
					
				})
			}


	</script>
<?php
// get_sidebar();
get_footer();
