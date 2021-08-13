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
		<?php

		while ( have_posts() ) {
			the_post();

			// get_template_part( 'template-parts/content/entry', get_post_type() );
		}

		?>

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

		<section class="home-grid">
			<section class="home-box our-story">
				<div class="content">
					<h2>Welcome to Crux</h2>
					<p>A brewer-owned and operated community, where passion for the craft intersects with uncompromising quality. </p>
					<a href="/our-story/" class="button button-yellow">Our Story</a>
				</div>
			
			</section>
			<section class="home-box tasting-room">
				<div class="content">
					<h2>Tasting Room</h2>
						<a href="/on-tap/" class="button button-yellow">Tap List</a>
						<a href="/menu/" class="button button-gold">Food Menu</a>

						<p class="red has-large-font-size">Sunday - Thursday 12 - 8pm | Friday - Saturday 12 - 9pm</p>

						<p class="yellow has-large-font-size">Today's Sunset: 8pm</p>
						<p>50 SW Division Street, Bend, Oregon 97702</p>
				</div>
			</section>
			<section class="home-box beers">
				<div class="content">
					<p>From hoppy pilsners to crisp IPAs, bold sours to barrel-aged stouts and every experimental ale in-between. This is our wild pursuit of perfection.</p>
					<a href="/beer/" class="button button-gold">Learn More <br> about our beers</a>
				</div>
			</section>
			<section class="home-box shop">
				<a href="/shop/" class="button button-yellow">Shop Crux<br> Beer + Gear</a>				
			</section>

		</section>

	</main><!-- #primary -->
<?php
get_footer();
