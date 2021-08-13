<?php
/**
 * Template part for displaying a post's content
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

$abv = get_post_meta( $id, 'wpcf-beer-abv', true );
$ibu = get_post_meta( $id, 'wpcf-beer-ibu', true );

$info = $abv . ' | ' . $ibu . ' IBU';

?>

<div class="entry-content">
  <span class="beer-info"><?php echo $info; ?></span>
  <p class="untappd"><a href="#">Untappd Check-in</a></p>
	<?php
  get_template_part( 'template-parts/content/entry_thumbnail', get_post_type() );
	the_content(
		sprintf(
			wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
				__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'wp-rig' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			get_the_title()
		)
	);

	wp_link_pages(
		array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'wp-rig' ),
			'after'  => '</div>',
		)
	);
	?>
</div><!-- .entry-content -->
