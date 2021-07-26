<?php
/**
 * Template part for displaying a post's header
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

$theme = get_template_directory_uri();

?>

<header class="entry-header">
	<?php
    get_template_part( 'template-parts/content/entry_thumbnail', get_post_type() );
    echo '<section class="entry-title-container">';
        get_template_part( 'template-parts/content/entry_title', get_post_type() );
        echo file_get_contents($theme . '/assets/images/down_arrow.svg');
    echo '</section>';
    ?>
</header><!-- .entry-header -->
