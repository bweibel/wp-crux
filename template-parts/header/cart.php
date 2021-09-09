<?php
/**
 * Template part for displaying the header branding
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

$theme = get_template_directory_uri();
?>

<a class="cart-button" href="<?php echo wc_get_cart_url(); ?>">
	<img src="<?php echo $theme; ?>/assets/images/cart.png" alt="Cart">
</a><!-- .site-branding -->
