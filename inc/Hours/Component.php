<?php
/**
 * WP_Rig\WP_Rig\Hours\Component class
 *
 *  @package wp_rig
 */

namespace WP_Rig\WP_Rig\Hours;

use WP_Rig\WP_Rig\Component_Interface;
use function WP_Rig\WP_Rig\wp_rig;
use function add_action;
use function get_theme_file_uri;
use function get_theme_file_path;

/**
 * Class for adding the sundowner Hour calculation script
 */
class Component implements Component_Interface {

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug() : string {
		return 'hours';
	}

	public function initialize() {
		add_action( 'wp_loaded', array( $this, 'action_register_hours_script' ) );
		add_shortcode( 'hours', array( $this, 'handle_shortcode' ) );
	}

	public function action_register_hours_script() {

		// Enqueue the hours script
		wp_register_script(
			'wp-rig-hours',
			get_theme_file_uri( '/assets/js/hours.min.js' ),
			array(),
			wp_rig()->get_asset_version( get_theme_file_path( '/assets/js/hours.min.js' ) ),
			false
		);
		wp_script_add_data( 'wp-rig-hours', 'async', true );
		wp_script_add_data( 'wp-rig-hours', 'precache', true );


	}

	public function handle_shortcode( $atts ) {
		wp_enqueue_script('wp-rig-hours');
		$color = $atts['color'];
		ob_start();
		?>
		<p class="has-large-font-size" style="text-align:center" id="sundowner">
			<strong class="<?php echo $color ?>">Sundowner Hour: <span id="sundowner-hour"></span>
			<br>Today’s Sunset: <span id="sunset"></span></strong>
		</p>
		<?php

		return ob_get_clean();
	}

}

