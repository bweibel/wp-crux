<?php
/**
 * WP_Rig\WP_Rig\Accessibility\Component class
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig\Woocommerce;

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
 * Class for Flexslider.
 */
class Component implements Component_Interface {

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug() : string {
		return 'woocommerce';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize() {
		// add_action( 'wp_enqueue_scripts', array( $this, 'action_require_flexslider_script' ) );
		add_action( 'after_setup_theme', array( $this, 'action_add_woocommerce_support' ));

		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
		remove_action( 'woocommerce_after_main_content', array( $this, 'woocommerce_output_content_wrapper_end' ), 10 );
		add_action('woocommerce_before_main_content', array( $this, 'crux_woocommerce_theme_wrapper_start' ), 10 );
		add_action('woocommerce_after_main_content', array( $this, 'crux_woocommerce_theme_wrapper_end' ), 10 );

		add_action('woocommerce_before_shop_loop', array( $this, 'crux_woocommerce_content_wrapper_start' ), 10 );
		add_action('woocommerce_after_shop_loop', array( $this, 'crux_woocommerce_content_wrapper_end' ), 10 );

		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

		// add_action( 'woocommerce_before_main_content', array( $this, 'woocommerce_category_image' ), 2  );

		add_filter('woocommerce_subcategory_count_html', array( $this, 'crux_woocommerce_category_count' ) );
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

		remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
		remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );

		// add_action('woocommerce_single_product_summary', array( $this, 'crux_woocommerce_single_product_content' ), 20 );
		add_action( 'after_setup_theme', array( $this, 'remove_product_result_count' ), 99 );
		add_filter( 'woocommerce_product_tabs',  array( $this, 'remove_product_tabs' ), 98 );

		add_action('woocommerce_proceed_to_checkout', array( $this, 'back_to_store' ) );
		add_action( 'init',  array( $this, 'woo_remove_wc_breadcrumbs' ) );

		remove_action('woocommerce_archive_description', 'woocommerce_taxonomy_archive_description' );
		add_action('woocommerce_before_shop_loop', 'woocommerce_taxonomy_archive_description' );
		add_action('woocommerce_archive_description', array( $this, 'crux_woocommerce_header'), 10 );
		add_filter( 'woocommerce_show_page_title', '__return_false' );

		add_filter( 'woocommerce_checkout_fields', array( $this, 'crux_woocommerce_hide_country' ) );

		add_action('woocommerce_after_order_notes', array( $this, 'crux_woocommerce_add_checkout_age_check' ) );
		add_action('woocommerce_checkout_process', array( $this, 'crux_woocommerce_age_checkout_field_process' ) );
		add_action('woocommerce_checkout_update_order_meta', array( $this, 'crux_woocommerce_age_checkout_field_update_order_meta' ) );
		add_action( 'woocommerce_admin_order_data_after_billing_address', array( $this, 'crux_woocommerce_age_checkout_field_display_admin_order_meta' ), 10, 1 );
		add_filter('woocommerce_email_order_meta_keys', array( $this, 'crux_woocommerce_custom_order_meta_keys' ) );
		add_filter( 'woocommerce_package_rates', array( $this, 'crux_show_shipping_based_on_beer' ), 100 );
		if ( !is_admin() ) {
			add_filter( 'woocommerce_states', array( $this, 'crux_woocommerce_limit_state_for_beer' ) );
		}

	}

	/**
	 * Declares Woocommerce Support for the theme.
	 */
	public function action_add_woocommerce_support() {
		add_theme_support( 'woocommerce' );
	}

	public function crux_woocommerce_theme_wrapper_start() {
		wp_rig()->print_styles( 'wp-rig-content' );
		echo '<main id="primary" class="site-main">';
		echo '<article id="post-';
		the_ID();
		echo '"';
		post_class( 'entry' );
		echo '>';
		if( ! is_product_category() ) {
			$this->crux_woocommerce_content_wrapper_start();
		}
	}

	public function crux_woocommerce_theme_wrapper_end() {
		if( ! is_product_category() ) {
			$this->crux_woocommerce_content_wrapper_end();
		}
		echo '</article>';
		echo '</main>';
	}

	public function crux_woocommerce_content_wrapper_start() {
		echo '<div class="entry-content">';
	}

	public function crux_woocommerce_content_wrapper_end() {
		echo '</div>';
	}

	public function crux_woocommerce_header() {
		if ( is_product_category() || is_shop()){
			$this->woocommerce_category_image();
		}

	}

	public function woocommerce_category_image() {
		$theme = get_template_directory_uri();

			$color = 'yellow';
			global $wp_query;
			$cat = $wp_query->get_queried_object();
			$thumbnail_id = get_term_meta( $cat->term_id, 'header_image', true );
			$image = wp_get_attachment_url( $thumbnail_id );

			echo '<div class="post-thumbnail">';
			if ( $image ) {
				echo '<img src="' . $image . '" alt="' . $cat->name . '" />';
			} else {
				$image = $theme . '/assets/images/Crux_Shop.jpg';
				echo '<img src="' . $image . '" alt="' . $cat->name . '" />';
			}
			echo '</div><!-- .post-thumbnail -->';
			echo  '<section class="entry-title-container">';
			?><h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
			<?php
			echo '<img src="' . $theme . '/assets/images/' . $color . '_down_arrow.png" alt="Down Arrow" class="down-arrow">';
			echo '</section>';


	}

	public function crux_woocommerce_category_count( $content, $category = null ) {
		return '';
	}

	public function remove_product_result_count() {
		remove_action( 'woocommerce_before_shop_loop' , 'woocommerce_result_count', 20 );
		remove_action( 'woocommerce_after_shop_loop' , 'woocommerce_result_count', 20 );
	}

	public function remove_product_tabs( $tabs ) {
		unset( $tabs['additional_information'] ); // To remove the additional information tab
		return $tabs;
	}

	function back_to_store() {
		?>
			<a class="button button-navy wc-backward" href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"> <?php _e( 'Return to shop', 'woocommerce' ) ?> </a>
		<?php
	}

	public function woo_remove_wc_breadcrumbs() {
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
	}

	// Hide country field from checkout, it's U.S. only.
	public function crux_woocommerce_hide_country( $fields ) {
		unset( $fields['billing']['billing_country'] );
		unset( $fields['shipping']['shipping_country'] );
		return $fields;
	}

	public function crux_woocommerce_check_is_beer() {
		$is_beer = false;
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			//$product = $cart_item['data'];
			//if ( has_term( 'beer', 'product_cat', $product->id ) ) {
			$product = wc_get_product( $cart_item['product_id'] );
			if ( $product->get_shipping_class() == 'beer' ) {
				$is_beer = true;
				break;
			}
		}
		return $is_beer;
	}

	public function crux_woocommerce_check_is_na_beer() {
		$is_na_beer = false;
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$product = wc_get_product( $cart_item['product_id'] );
			if ( $product->get_shipping_class() == 'na-beer' ) {
				$is_na_beer = true;
				break;
			}
		}
		return $is_na_beer;
	}

	/**
	 * Add age-check checkbox to checkout.
	 */
	public function crux_woocommerce_add_checkout_age_check( $checkout ) {
		if ( $this->crux_woocommerce_check_is_beer() ) {
			woocommerce_form_field(
				'crux_age_checkbox',
				array(
					'type'          => 'checkbox',
					'class'         => array('input-checkbox'),
					'label'         => __('By clicking this box, I certify that I am over 21+ years of age. <strong>ID will be checked upon delivery.</strong>'),
					'required'  => true,
				),
			$checkout->get_value( 'crux_age_checkbox' ) );

		}
	}

	/**
	 * Process the checkout
	 */
	public function crux_woocommerce_age_checkout_field_process() {
		global $woocommerce;

		if ( $this->crux_woocommerce_check_is_beer() ) {
			// Check if set, if its not set add an error.
			if (!$_POST['crux_age_checkbox'])
				$woocommerce->add_error( __('You must certify that you are over 21 years of age.' ) );
		}
	}

	public function crux_woocommerce_age_checkout_field_update_order_meta( $order_id ) {
		if ( $this->crux_woocommerce_check_is_beer() ) {
			if ($_POST['crux_age_checkbox']) {
				update_post_meta( $order_id, 'Age Certification', 'I am over 21' );
			}
		}
	}

	/**
	 * Display field value on the order edit page
	 */
	public function crux_woocommerce_age_checkout_field_display_admin_order_meta( $order ) {
		$over21 = get_post_meta( $order->id, 'Age Certification', true );
		if ( ! $over21 ) {
			$over21 = 'No';
		}
		echo '<p><strong>' . __( 'Over 21+ years of age' ) . ':</strong> ' . $over21 . '</p>';
	}

	/**
	 * Add custom "crux_age_checkbox" field to emails
	 *  1. Add this snippet to your theme's functions.php file
	 *  2. Change the meta key names in the snippet
	 *  3. Create a custom field in the order post - e.g. key = "Tracking Code" value = abcdefg
	 *  4. When next updating the status, or during any other event which emails the user, they will see this field in their email
	 */
	public function crux_woocommerce_custom_order_meta_keys( $keys ) {
		$keys[] = 'crux_age_checkbox';
		$keys[] = 'Age Certification';
		return $keys;
	}

	// Only allow shipping in Oregon if they have beer in their carts.
	public function crux_woocommerce_limit_state_for_beer( $states ) {
		if ( $this->crux_woocommerce_check_is_beer() ) {
			/*
			$states['US'] = array(
				'OR' => __( 'Oregon', 'woocommerce' )
			);
			*/
		} elseif ( $this->crux_woocommerce_check_is_na_beer() ) {
			$states['US'] = array(
				'AZ' => __( 'Arizona', 'woocommerce' ),
				'CA' => __( 'California', 'woocommerce' ),
				'OR' => __( 'Oregon', 'woocommerce' ),
				'NV' => __( 'Nevada', 'woocommerce' ),
				'WA' => __( 'Washington', 'woocommerce' ),
			);
		}
		return $states;
	}

	/**
	 * Hide shipping rates when free shipping is available.
	 * Updated to support WooCommerce 2.6 Shipping Zones.
	 *
	 * @param array $rates Array of rates found for the package.
	 * @return array
	 */
	public function crux_show_shipping_based_on_beer( $rates ) {
		$is_beer = $this->crux_woocommerce_check_is_beer();
		$is_na_beer = $this->crux_woocommerce_check_is_na_beer();

		$subtotal = WC()->cart->get_subtotal();

		$min_free_shipping = 75;

		$new_rates = array();
		foreach ( $rates as $rate_id => $rate ) {
			if ( $subtotal >= $min_free_shipping ) {
				if ( 'Free shipping' == $rate->label ) {
					$new_rates[ $rate_id ] = $rate;
					//break;
				}
			} else {
				if ( 'Beer (Flat Rate)' == $rate->label ) {
					if ( $is_beer || $is_na_beer ) {
						$new_rates[ $rate_id ] = $rate;
					}
					//break;
				} elseif ( ! $is_beer && ! $is_na_beer ) {
					$new_rates[ $rate_id ] = $rate;
				}
			}
		}
		return $new_rates;
		//return ! empty( $new_rates ) ? $new_rates : $rates;
	}
}

