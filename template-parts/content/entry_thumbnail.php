<?php
/**
 * Template part for displaying a post's featured image
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

// Audio or video attachments can have featured images, so they need to be specifically checked.
$support_slug = get_post_type();
if ( 'attachment' === $support_slug ) {
	if ( wp_attachment_is( 'audio' ) ) {
		$support_slug .= ':audio';
	} elseif ( wp_attachment_is( 'video' ) ) {
		$support_slug .= ':video';
	}
}

$header_image = get_field("header_image");

if ( post_password_required() || ! post_type_supports( $support_slug, 'thumbnail' ) || ! has_post_thumbnail() && ! $header_image ) {
	return;
}
if ( is_singular( get_post_type() ) ) {

	?>
	<div class="post-thumbnail">
		<?php
		$image_url_mobile = get_the_post_thumbnail_url( get_the_ID(), 'wp-rig-mobile' );
		$image_url_medium = get_the_post_thumbnail_url( get_the_ID(), 'wp-rig-featured' );
		$image_url_large = get_the_post_thumbnail_url( get_the_ID(), 'wp-rig-large' );
		the_post_thumbnail( 'wp-rig-large', array(
			'class' => 'skip-lazy',
			'srcset' => $image_url_medium . ' 960w, ' . $image_url_large . ' 1920w',
		) );


		?>


	</div><!-- .post-thumbnail -->
	<?php
} elseif ( is_woocommerce() ){
	?>
	<div class="post-thumbnail">
		<img src="<?php echo $header_image['url']?>" />
	</div><!-- .post-thumbnail -->
	<?php
} else {
	// Blog Posts and Beers
	if ( get_post_type() !== 'crux_beer' ) {
		echo '<a class="post-thumbnail" href="' . get_permalink() . '" aria-hidden="true">';
	}

	global $wp_query;

	if ( 0 === $wp_query->current_post ) {
		the_post_thumbnail(
			'post-thumbnail',
			array(
				'class' => 'skip-lazy',
				'alt'   => the_title_attribute(
					array(
						'echo' => false,
					)
				),
			)
		);
	} else {

		the_post_thumbnail(
			'post-thumbnail',
			array(
				'alt' => the_title_attribute(
					array(
						'echo' => false,
					)
				),
			)
		);
	}

	if ( get_post_type() !== 'crux_beer' ) {
		echo '</a>';
	}
}
