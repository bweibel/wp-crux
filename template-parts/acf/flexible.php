<?php

/**
 * Template part for displaying flexible content
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

?>


<?php

if ( ! $args['row_group'] ){
	$row_group = 'page_blocks';
}


// Check value exists.
if ( have_rows( $args['row_group'] ) ) :

	// Loop through rows.
	while (have_rows('page_blocks')) : the_row();

		// Case: Generic WYSIWYG Content
		if ( get_row_layout() == 'generic_content' ) :
			get_template_part( '/template-parts/acf/flexible_generic' );
		endif;

		// Case: Generic WYSIWYG Content
		if ( get_row_layout() == 'column_layout' ) :
			get_template_part( '/template-parts/acf/flexible_columns' );
		endif;

		// Case: Generic WYSIWYG Content
		if ( get_row_layout() == 'cta_box_group' ) :
				get_template_part( '/template-parts/acf/flexible_cta-group' );
		endif;
		// End loop.
	endwhile;

	// No value.
else :
	// Do something...
endif;
?>
