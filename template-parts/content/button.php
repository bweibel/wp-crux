<?php
/**
 * Template part for displaying social links
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

$button_text = $args['text'];
$button_link = $args['link'];
$button_color = $args['color'];

$button_class = 'button';
if ( $button_color ) {

	$button_class = $button_class . ' button-' . $button_color;
}
?>

<a href="<?php echo $button_link ?>" class="<?php echo $button_class ?>"><?php echo $button_text; ?></a>
