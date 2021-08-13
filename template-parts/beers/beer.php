<?php
/**
 * Template part for displaying a career
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

$className = 'beer';

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $className ); ?>>
	<?php
	get_template_part( 'template-parts/beers/beers_header', get_post_type() );
	get_template_part( 'template-parts/beers/beer_content', get_post_type() );

	?>
</article><!-- #post-<?php the_ID(); ?> -->

<?php
