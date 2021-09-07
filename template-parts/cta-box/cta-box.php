<?php
/**
 * Template part for displaying a CTA Box
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

$image = get_sub_field( 'background' );
?>

<section class="cta-box" style="background-image: url(<?php echo $image['url'] ?>)">
	<?php
		get_template_part( '/template-parts/cta-box/cta_flexible' );
	?>
</section>

<?php
