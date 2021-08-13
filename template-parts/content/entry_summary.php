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
	<a class="read-more" href="<?php the_permalink(); ?>" aria-hidden="true">Read More</a>
</div><!-- .entry-summary -->
