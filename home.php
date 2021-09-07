<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

get_header();

wp_rig()->print_styles( 'wp-rig-content' );

$theme = get_template_directory_uri();


?>

	<main id="primary" class="site-main page">
		<header class="entry-header yellow">
			<div class="post-thumbnail">
				<img src="<?php echo $theme . '/assets/images/Crux-Blog-header.jpg'?>" class="skip-lazy wp-post-image" alt="Beer Blog" loading="lazy" sizes="100vw" width="1920" height="1000">
			</div><!-- .post-thumbnail -->
			<section class="entry-title-container">
				<h1 class="entry-title entry-title-singular">Beer Blog</h1>
				<img src="<?php echo $theme . '/assets/images/yellow_down_arrow.png'; ?>" alt="Down Arrow" class="down-arrow">
			</section>
		</header>
		<?php
		if ( have_posts() ) {

			// get_template_part( 'template-parts/content/page_header' );

			while ( have_posts() ) {
				the_post();

				get_template_part( 'template-parts/content/entry', get_post_type() );
			}

			if ( ! is_singular() ) {
				get_template_part( 'template-parts/content/pagination' );
			}
		} else {
			get_template_part( 'template-parts/content/error' );
		}
		?>
	</main><!-- #primary -->
<?php
get_sidebar();
get_footer();
