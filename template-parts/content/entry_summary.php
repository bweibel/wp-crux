<?php
/**
 * Template part for displaying a post's summary
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

?>

<div class="entry-summary">
	<?php the_excerpt(); ?>
	<a class="read-more button" href="<?php the_permalink(); ?>" >Read More</a>
</div><!-- .entry-summary -->
