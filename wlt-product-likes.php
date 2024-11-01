<?php
/**
 * Plugin Name: Woo Helper
 * Plugin URI: https://wordpress.org/plugins/wc-product-likes-comments/
 * Description: Extend Woocoomerce feature easily with this plugin. Users can like products WooCommerce store.support system and lot's of things on this plugin.
 * Version: 2.0.2
 * Author: WP Lovers
 * Author URI: https://wordpress.org/five-for-the-future/pledge/wordpress-lovers-team/
 * Developer: sumitsingh
 * Developer URI: https://profiles.wordpress.org/sumitsingh
 * Text Domain: product-likes-comments
 * Domain Path: /languages
 *
 * WC requires at least: 4.0.0
 * WC tested up to: 6.2.2
 *
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
  * @author    IIH Global <info@iihglobal.com>
 * @license   GPLv2 or later
 * @package   WP Disable Block Editor
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

// Instantiate

if ( !class_exists( 'WLT_Product_Likes' ) ) {

	class WLT_Product_Likes {

		public function __construct() {

			require_once( __DIR__ . '/class-wlt-product-likes-activation.php' );
			new WLT_Product_Likes_Activation();
			
			// WooCommerce Active Check

			if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

				require_once( __DIR__ . '/class-wlt-product-likes-account.php' );
				require_once( __DIR__ . '/class-wlt-product-likes-button.php' );
				require_once( __DIR__ . '/class-wlt-product-other-feature.php' );
				require_once( __DIR__ . '/class-wlt-product-comments-button.php' );
				require_once( __DIR__ . '/class-wlt-product-likes-settings.php' );

				new WLT_Product_Likes_Settings();

				if ( get_option('wlt_product_likes_enable') == 'yes' ) {

						new WLT_Product_Other_Feature();

					if ( get_option('wlt_product_likes_account') == 'yes' ) {

						new WLT_Product_Likes_Account();

					}
					
					new WLT_Product_Likes_Button();
					new WLT_Product_Comments_Button();
				}

			}

		}

	}
	
	new WLT_Product_Likes();

}