<?php
/**
 * Template part for displaying social links
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

$theme = get_template_directory_uri();

?>

<div class="social">
  <a href="https://www.facebook.com/cruxfermentationproject/" target="_blank" rel="nofollow">
	<img src="<?php echo $theme; ?>/assets/images/crux_facebook.svg" alt="Facebook" width="50px">
  </a>
  <a href="https://www.instagram.com/cruxfermentationproject/" target="_blank" rel="nofollow">
	<img src="<?php echo $theme; ?>/assets/images/crux_instagram.svg" alt="Instagram" width="50px">
  </a>
  <a href="https://twitter.com/cruxbrew" target="_blank" rel="nofollow">
	<img src="<?php echo $theme; ?>/assets/images/crux_twitter.svg" alt="Twitter" width="50px">
  </a>

</div><!-- .site-info -->
