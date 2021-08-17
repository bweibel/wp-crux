<?php
/**
 * Template part for displaying a post's header
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

?>

<header class="career-header">
	<?php
		$id = get_the_ID();
		$type = get_post_meta( $id, 'wpcf-job-type', true );
	// get_template_part( 'template-parts/content/entry_title', get_post_type() );

	the_title( '<h3 class="career-title">', '</h3>' );
	echo '<span class="career-type">' . $type . '</span>';
	?>
</header><!-- .entry-header -->
