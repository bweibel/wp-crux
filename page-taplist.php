<?php

/**
 * Template Name: Taplist Template
 * The template for displaying CurrentTaplist
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

get_header();

wp_rig()->print_styles('wp-rig-content', 'wp-rig-taplist' );

?>
<main id="primary" class="site-main">
	<?php

	while (have_posts()) {
		the_post();

		get_template_part('template-parts/content/entry', 'page');
	}
	?>
	<section class="beer-container">
		<ul id="tap-list" class="tap-list"></ul>
	</section>

	<?php
	// Additional Page Content (ACF).
	get_template_part( 'template-parts/acf/flexible', get_post_type(), array( 'row_group' => 'page_blocks') );
	?>

	<script>
		if ('loading' === document.readyState) {
			// The DOM has not yet been loaded.
			document.addEventListener('DOMContentLoaded', initTapList);
		} else {
			// The DOM has already been loaded.
			initTapList();
		}

		function initTapList() {
			const ul = document.getElementById('tap-list');
			const url = 'https://crux.smartz.com/api/ontap/tapfeed';

			fetchBeers(url, ul);
		}

		function createNode(element) {
			return document.createElement(element);
		}

		function append(parent, el) {
			return parent.appendChild(el);
		}

		function formatBeer(beer) {
			const beerEl = createNode('li');

			const title = beer.name;
			// const details = beer.description;

			const headerEl = createNode('header');
			const titleEl = createNode('h3');
			const styleEl = createNode('span');
			const seperatorEl = createNode('span');
			const contentEl = createNode('section');
			const untappdEl = createNode('span')
			const detailsEl = createNode('span');
			const storyEl = createNode('p');

			titleEl.innerHTML = title;
			styleEl.innerHTML = `${beer.style}`
			storyEl.innerHTML = `${beer.properties.storyText}`;
			if( beer.properties.untappdId ){
				untappdEl.innerHTML = `<a href="https://untappd.com/beer/${beer.properties.untappdId}" target="_blank">Untappd Check-in</a>`;
			}

			let details = '';
			if( beer.ibus && beer.abv ){
				details = `${beer.abv}% ABV | ${beer.ibus} IBU`;
			} else if( beer.ibus && ! beer.abv ) {
				details = `${beer.ibus} IBU`;
			} else if ( ! beer.ibus && beer.abv ){
				details = `${beer.abv}% ABV`;
			}

			detailsEl.innerHTML = details;

			append(beerEl, headerEl);
			append(headerEl, titleEl);
			append(headerEl, styleEl);
			append(beerEl, contentEl);
			append(contentEl, detailsEl);
			append(contentEl, storyEl);
			append(contentEl, untappdEl);


			headerEl.addEventListener('click', e => {
				if (!beerEl.classList.contains("open")) {
					beerEl.classList.add("open");
				} else {
					beerEl.classList.remove("open");
				}
			});

			beerEl.classList.add("beer");
			headerEl.classList.add("beer-header");
			styleEl.classList.add("beer-type");
			titleEl.classList.add("title");
			seperatorEl.classList.add("seperator");
			contentEl.classList.add("content");
			untappdEl.classList.add("untappd");

			return beerEl;
		}

		function fetchBeers(url, el) {
			fetch(url)
				//Success
				.then(response => response.json())
				.then(response => {
					let beers = response;
					console.log(beers);
					beers.forEach( beer => {

						append(el, formatBeer(beer.onTap.beer) );
						console.log(beer.onTap.beer.name);
					})
				})
				// Error
				.catch(error => console.log(error));
		}
	</script>
</main><!-- #primary -->
<?php
// get_sidebar();
get_footer();
