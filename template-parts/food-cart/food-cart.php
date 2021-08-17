<?php
/**
 * Template part for displaying a career
 * Template Name: Food Menu Template
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

wp_rig()->print_styles( 'wp-rig-content');


?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'food-cart' ); ?>>
	<?php
	get_template_part( 'template-parts/food-cart/food-cart_header', get_post_type() );
	get_template_part( 'template-parts/content/entry_content', get_post_type() );
	get_template_part( 'template-parts/food-cart/hours', get_post_type() );
	?>
</article><!-- #post-<?php the_ID(); ?> -->

<?php
