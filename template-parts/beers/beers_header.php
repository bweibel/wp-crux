<?php
/**
 * Template part for displaying a post's header
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

?>

<header class="beer-header">
	<?php
		$id = get_the_ID();
		$style = get_post_meta( $id, 'wpcf-beer-style', true );

	// get_template_part( 'template-parts/content/entry_title', get_post_type() );

	the_title( '<h3 class="beer-title">', '</h3>' );
	echo '<span class="beer-type">' . $style . '</span>';
	?>
</header><!-- .entry-header -->
