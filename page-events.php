<?php

/**
 * Template Name: Events Template
 * The template for displaying Events
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

get_header();

wp_rig()->print_styles('wp-rig-content', 'wp-rig-events');

?>
<main id="primary" class="site-main">
	<?php

	while (have_posts()) {
		the_post();

		get_template_part('template-parts/content/entry', 'page');
	}
	?>
	<ul id="event-list" class="event-list"></ul>

	<?php
	// Additional Page Content (ACF).
	get_template_part( 'template-parts/acf/flexible', get_post_type(), array( 'row_group' => 'page_blocks') );
	?>

	<script>
		if ('loading' === document.readyState) {
			// The DOM has not yet been loaded.
			document.addEventListener('DOMContentLoaded', initEvents);
		} else {
			// The DOM has already been loaded.
			initEvents();
		}

		const DAYS_OF_WEEK = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

		function initEvents() {
			const ul = document.getElementById('event-list');
			const url = 'https://eventmanager.smartz.com/api/feed/events/crux/crux%20fermentation%20project/';

			fetchEvents(url, ul);
			// const eventsList = [...document.getElementsByClassName("szem-description")];
			// console.log(eventsList);
			// eventsList.forEach(event => console.log(event));
		}

		function createNode(element) {
			return document.createElement(element);
		}

		function append(parent, el) {
			return parent.appendChild(el);
		}

		function formatTimes(date) {
			let hour = date.getHours();
			if (hour > 12) {
				hour -= 12;
				return hour + 'pm';
			} else if (hour == 12) {
				return hour + 'pm';
			} else {
				return hour + 'am';
			}
			return hour;
		}

		function formatEvent(event) {
			const eventEl = createNode('li');

			const title = event.name;
			const details = event.description;
			const startDate = new Date(event.start_time);
			const endDate = new Date(event.end_time);

			const headerEl = createNode('header');
			const titleEl = createNode('h3');
			const dateEl = createNode('span');
			const seperatorEl = createNode('span');
			const detailsEl = createNode('section');

			titleEl.innerHTML = title;
			dateEl.innerHTML = `${startDate.getMonth()+1}/${startDate.getDate()}`;

			seperatorEl.innerHTML = ' | ';
			detailsEl.innerHTML = `<span class="time">${DAYS_OF_WEEK[startDate.getDay()]} | ${formatTimes(startDate)} - ${ formatTimes(endDate)}</span><p>${details}</p>`;

			append(eventEl, headerEl);
			append(headerEl, dateEl);
			append(headerEl, seperatorEl);
			append(headerEl, titleEl);
			append(eventEl, detailsEl);

			headerEl.addEventListener('click', e => {
				if (!eventEl.classList.contains("open")) {
					eventEl.classList.add("open");
				} else {
					eventEl.classList.remove("open");
				}
			});

			eventEl.classList.add("event");
			titleEl.classList.add("title");
			seperatorEl.classList.add("seperator");
			dateEl.classList.add("date");
			detailsEl.classList.add("details");
			return eventEl;
		}

		function fetchEvents(url, el) {
			fetch(url)
				//Success
				.then(response => response.json())
				.then(response => {
					let events = response.data;
					events.reverse();
					console.log(events);
					return events.map(event => {
						const startDate = new Date(event.start_time);
						if (startDate > Date.now()) {
							append(el, formatEvent(event));
						} else {
							// Event has already passed
						}

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
