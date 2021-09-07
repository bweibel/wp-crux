<?php

/**
 * Template Name: Food Cart Template
 * The template for food menu
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

use WP_Query;

$args = array(
	'post_type' => 'crux_food-cart',
	'orderby' => 'date',
);
$cart_query = new WP_Query($args);

get_header();

wp_rig()->print_styles('wp-rig-content', 'wp-rig-food-cart' );

?>
<main id="primary" class="site-main">
	<?php

	while (have_posts()) {
		the_post();
		get_template_part('template-parts/content/entry', 'page');
	}

	?>

	<section id="carts-list" class="cart-list entry-content">
		<?php if ($cart_query->have_posts()) : ?>
			<!-- the loop -->
			<?php
			while ($cart_query->have_posts()) :
				$cart_query->the_post();
				get_template_part('template-parts/food-cart/food-cart');
			endwhile;
			?>
			<!-- end of the loop -->

			<?php wp_reset_postdata(); ?>
		<?php endif; ?>
	</section>

	<?php
	// Additional Page Content (ACF).
	get_template_part( 'template-parts/acf/flexible', get_post_type(), array( 'row_group' => 'page_blocks') );
	?>
</main><!-- #primary -->

<?php
// get_sidebar();
get_footer();
