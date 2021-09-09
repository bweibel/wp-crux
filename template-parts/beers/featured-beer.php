<?php
/**
 * Template part for displaying a career
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

$className = 'beer';

?>

<li class="featured-beer" data-id="<?php echo get_post_field( 'post_name') ?>">
<?php
	the_post_thumbnail('post-thumbnail' );
	the_title( '<h3 class="flex-caption text-centered">', '</h3>' );
?>
</li><!-- #post-<?php the_ID(); ?> -->

<?php
