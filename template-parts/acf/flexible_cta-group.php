<?php
/**
 * Template part for displaying a post's content
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

?>

<div class="cta-grid">
	<?php
	// Check value exists.
	if ( have_rows( 'cta_boxes' ) ) :
		// Loop through rows.
		while ( have_rows('cta_boxes') ) : the_row();
			// Case: CTA Box
			if ( get_row_layout() == 'cta_box' ) :
				get_template_part( '/template-parts/cta-box/cta-box' );
		endif;

		// End loop.
	endwhile;
		// No value.
	else :
		// Do something...
	endif;
	?>
</div><!-- .entry-content -->
