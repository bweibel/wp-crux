<?php
/**
 * WP_Rig\WP_Rig\Accessibility\Component class
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig\Beerlist;

use WP_Rig\WP_Rig\Component_Interface;
use function WP_Rig\WP_Rig\wp_rig;
use WP_Post;
use function add_action;
use function add_filter;
use function wp_enqueue_script;
use function get_theme_file_uri;
use function get_theme_file_path;
use function wp_script_add_data;
use function wp_localize_script;

/**
 * Class for improving accessibility among various core features.
 */
class Component implements Component_Interface {

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug() : string {
		return 'beerlist';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize() {
		add_action( 'wp_enqueue_scripts', array( $this, 'action_register_beerlist_script' ) );

	}

	/**
	 * Enqueues a script that improves navigation menu accessibility.
	 */
	public function action_register_beerlist_script() {

		// If the AMP plugin is active, return early.
		if ( wp_rig()->is_amp() ) {
			return;
		}

		// Enqueue the navigation script.
		wp_register_script(
			'wp-rig-beerlist',
			get_theme_file_uri( '/assets/js/beerlist.min.js' ),
			array('wp-rig-flexslider'),
			wp_rig()->get_asset_version( get_theme_file_path( '/assets/js/beerlist.min.js' ) ),
			false
		);
		wp_script_add_data( 'wp-rig-beerlist', 'async', true );
		wp_script_add_data( 'wp-rig-beerlist', 'precache', true );

	}

}
