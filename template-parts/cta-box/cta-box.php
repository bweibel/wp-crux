<?php
/**
 * Template part for displaying a CTA Box
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

$image = get_sub_field( 'background' );
if ( is_front_page() ) {
	$size = 'wp-rig-large';
} else {
	$size = 'wp-rig-featured';
}
?>

<section class="cta-box" style="background-image: url(<?php echo $image['sizes'][$size] ?>)">
	<?php
		get_template_part( '/template-parts/cta-box/cta_flexible' );
	?>
</section>

<?php
