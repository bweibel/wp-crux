<?php
/**
 * Template part for displaying Columns
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

?>

<div class="entry-content">
	<div class="column-container">
		<?php

		// Check value exists.
		if ( have_rows( 'column_content' ) ) :

			// Loop through rows.
			while ( have_rows('column_content') ) : the_row();
				?>
				<div class="column">
					<?php
					// Case: Generic WYSIWYG Content
					if ( get_row_layout() == 'generic_content' ) :
						the_sub_field( 'content' );
					endif;
					?>
				</div>
				<?php
				// End loop.
			endwhile;

			// No value.
		else :
			// Do something...
		endif;
		?>
	</div>
</div><!-- .entry-content -->
