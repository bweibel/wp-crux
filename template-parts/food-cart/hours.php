<?php
/**
 * Template part for displaying a career
 * Template Name: Food Menu Template
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

wp_rig()->print_styles( 'wp-rig-content');

// use WP_Query;

$site_url = get_post_meta( $id, 'wpcf-cart-url', true );
$hours['monday'] = get_post_meta( $id, 'wpcf-cart-monday-hours', true );
$hours['tuesday'] = get_post_meta( $id, 'wpcf-cart-tuesday-hours', true );
$hours['wednesday'] = get_post_meta( $id, 'wpcf-cart-wednesday-hours', true );
$hours['thursday'] = get_post_meta( $id, 'wpcf-cart-thursday-hours', true );
$hours['friday'] = get_post_meta( $id, 'wpcf-cart-friday-hours', true );
$hours['saturday'] = get_post_meta( $id, 'wpcf-cart-saturday-hours', true );
$hours['sunday'] = get_post_meta( $id, 'wpcf-cart-sunday-hours', true );

get_post_meta( $id, 'wpcf-job-type', true );

?>

<table class="hours">
	<tbody>
	<?php
		foreach ( $hours as $day => $hour ) {
			echo '<tr><td class="day">' . ucfirst( $day ) . '</td> <td class="hour">' . $hour . '</td></tr>';
		}
	?>
	</tbody>
</table>
<?php
