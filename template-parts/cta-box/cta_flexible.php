<?php
/**
 * Template part for displaying Columns
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

?>


<?php

// Check value exists.
if ( have_rows( 'cta_blocks' ) ) :

	// Loop through rows.
	while ( have_rows('cta_blocks') ) : the_row();
		?>
			<?php
			// Case: Generic WYSIWYG Content
			if ( get_row_layout() == 'generic_content' ) :
				the_sub_field( 'content' );
			endif;

			// Case: Generic WYSIWYG Content
			if ( get_row_layout() == 'button' ) :
				$button = get_sub_field( 'button' );
				$args = array(
					'text' => $button['button_text'],
					'link'=> $button['button_link'],
					'color' => $button['button_color']
				);
				get_template_part( '/template-parts/content/button', '', $args );
			endif;

			?>

		<?php
		// End loop.
	endwhile;

	// No value.
else :
	// Do something...
endif;
?>

