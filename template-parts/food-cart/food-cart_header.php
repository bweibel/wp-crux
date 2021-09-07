<?php
/**
 * Template part for displaying a post's header
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

$theme = get_template_directory_uri();
$siteUrl = get_post_meta( get_the_ID(), 'wpcf-cart-url', true );
// $gallery = get_post_meta( get_the_ID(), 'wpcf-page-gallery', true );

?>

<header class="food-cart-header">
	<?php
	if ( has_post_thumbnail() ) {
		get_template_part( 'template-parts/content/entry_thumbnail', get_post_type() );
	}

	the_title( '<h2 class="food-cart-title">', '</h2>' );
	if ( ! empty( $siteUrl ) ) {
		echo '<a href="' . $siteUrl . '" class="website button" target="_blank">visit website</a>';
	}
	?>
</header><!-- .entry-header -->
