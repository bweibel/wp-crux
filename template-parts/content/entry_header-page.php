<?php
/**
 * Template part for displaying a post's header
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

$theme = get_template_directory_uri();

$colors = array( 'yellow', 'cream' );
$color = $colors[ rand( 0, 1 ) ];

$img_src = wp_get_attachment_image_src(  'wp-rig-large' );
?>

<header class="entry-header <?php echo $color; ?>" >
	<?php
	echo $img_src;
	get_template_part( 'template-parts/content/entry_thumbnail', get_post_type() );
	echo '<section class="entry-title-container">';
		get_template_part( 'template-parts/content/entry_title', get_post_type() );
		echo '<img src="' . $theme . '/assets/images/' . $color . '_down_arrow.png" alt="Down Arrow" class="down-arrow">';
	echo '</section>';
	?>
</header><!-- .entry-header -->
