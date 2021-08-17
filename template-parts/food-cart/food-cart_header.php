<?php
/**
 * Template part for displaying a post's header
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

?>

<header class="food-cart-header">
	<?php
		$id = get_the_ID();
	// get_template_part( 'template-parts/content/entry_title', get_post_type() );

	the_title( '<h3 class="food-cart-title">', '</h3>' );
	?>
</header><!-- .entry-header -->
