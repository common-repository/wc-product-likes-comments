<?php

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

// Instantiate

if ( !class_exists( 'WLT_Product_Likes_Activation' ) ) {

	class WLT_Product_Likes_Activation {

		public function __construct() {

			register_activation_hook( plugin_dir_path( __FILE__ ) . 'wlt-product-likes.php', array( $this, 'create_database_table' ) );
			register_activation_hook( plugin_dir_path( __FILE__ ) . 'wlt-product-likes.php', array( $this, 'set_defaults' ) );

		}

		public function create_database_table() {

			global $wpdb;

			// Likes Table

			$table_name = $wpdb->prefix . 'wlt_product_likes';
			$charset_collate = $wpdb->get_charset_collate();

			$sql = "CREATE TABLE IF NOT EXISTS $table_name (
				like_id bigint(20) AUTO_INCREMENT,
				product_id bigint(20) NOT NULL,
				user_id text NOT NULL,
				PRIMARY KEY (like_id)
			) $charset_collate;";

			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );

		}

		public function set_defaults() {
			
			// Updates to any of the option names below should be accounted for in settings class
			// === to check if option exists

			// Account

			if ( get_option( 'wlt_product_likes_flush_rewrites' ) === false ) {

				update_option( 'wlt_product_likes_flush_rewrites', 'yes' );

			}

			// General

			if ( get_option( 'wlt_product_likes_enable' ) === false ) {

				update_option( 'wlt_product_likes_enable', 'yes' );

			}

			if ( get_option( 'wlt_product_comments_enable' ) === false ) {

				update_option( 'wlt_product_comments_enable', 'yes' );

			}
			

			if ( get_option( 'wlt_product_likes_not_logged_in' ) === false ) {

				update_option( 'wlt_product_likes_not_logged_in', 'yes' );

			}

			if ( get_option( 'wlt_product_likes_account' ) === false ) {

				update_option( 'wlt_product_likes_account', 'yes' );

			}

			// Display

			if ( get_option( 'wlt_product_likes_products' ) === false ) {

				update_option( 'wlt_product_likes_products', 'yes' );

			}

			if ( get_option( 'wlt_product_likes_archives' ) === false ) {

				update_option( 'wlt_product_likes_archives', 'yes' );

			}

			if ( get_option( 'wlt_product_likes_total' ) === false ) {

				update_option( 'wlt_product_likes_total', 'yes' );

			}

			// Icon

			if ( get_option( 'wlt_product_likes_icon' ) === false ) {

				update_option( 'wlt_product_likes_icon', 'heart' );

			}

			// Styles

			if ( get_option( 'wlt_product_likes_styles' ) === false ) {

				update_option( 'wlt_product_likes_styles', 'yes' );

			}

		}

	}

}
