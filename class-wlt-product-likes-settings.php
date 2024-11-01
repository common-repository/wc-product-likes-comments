<?php

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

// Instantiate

if ( !class_exists( 'WLT_Product_Likes_Settings' ) ) {

	class WLT_Product_Likes_Settings {

		public function __construct() {

			add_filter( 'woocommerce_get_settings_products', array( $this, 'add' ), 10, 2 );

		}

		public function add( $settings, $current_section ) {

			// Products > General

			if ( '' == $current_section ) {

				// Section Start

				$product_likes_settings[] = array(
					'name' => esc_html__( 'Setting for WC Product ', 'wlt-product-likes' ),
					'type' => 'title',
					'id' => 'wlt-product-likes'
				);

				// Updates to any of the ids (option names) below should be accounted for in activation class default settings

				// General

				$product_likes_settings[] = array(
					'name'     => esc_html__( 'General', 'wlt-product-likes' ),
					'id'       => 'wlt_product_likes_enable',
					'type'     => 'checkbox',
					'css'      => 'min-width:300px;',
					'desc'     => esc_html__( 'Enable', 'wlt-product-likes' ),
					'desc_tip' => esc_html__( 'Enables product likes across your store, ensure you also enable at least one of the display options below to see the buttons.', 'wlt-product-likes' ),
					'checkboxgroup' => 'start',
				);

				/*$product_likes_settings[] = array(
					'id'       => 'wlt_product_likes_not_logged_in',
					'type'     => 'checkbox',
					'css'      => 'min-width:300px;',
					'desc'     => esc_html__( 'Enable If Not Logged In', 'wlt-product-likes' ),
					'desc_tip' => esc_html__( 'Allows users without an account to like products, user will see their likes on products for 30 days or until cookies cleared. After this period likes by a not logged in user will still count towards the total number of product likes.', 'wlt-product-likes' ),
					'checkboxgroup' => '',
				);*/

				$product_likes_settings[] = array(
					'id'       => 'wlt_product_likes_account',
					'type'     => 'checkbox',
					'css'      => 'min-width:300px;',
					'desc'     => esc_html__( 'Enable In Account', 'wlt-product-likes' ),
					'desc_tip' => esc_html__( 'Adds a section within the user\'s account listing the products the customer has previously liked.', 'wlt-product-likes' ),
					'checkboxgroup' => '',
				);

				$product_likes_settings[] = array(
					'id'       => 'wlt_product_comments_enable',
					'type'     => 'checkbox',
					'css'      => 'min-width:300px;',
					'desc'     => esc_html__( 'Enable Comments', 'wlt-product-likes' ),
					'desc_tip' => esc_html__( 'Enables product on show comment count across your store.ensure you also enabled  "enable product reviews" option in woocommerce', 'wlt-product-likes' ),
					'checkboxgroup' => '',
				);
				

				// Display

				$product_likes_settings[] = array(
					'title'		=> esc_html__( 'Display', 'wlt-product-likes' ),
					'id'       => 'wlt_product_likes_products',
					'type'     => 'checkbox',
					'css'      => 'min-width:300px;',
					'desc'     => esc_html__( 'Show On Product Pages', 'wlt-product-likes' ),
					'desc_tip' => esc_html__( 'Shows a product like button on individual product pages.', 'wlt-product-likes' ),
					'checkboxgroup' => 'start',
				);

				$product_likes_settings[] = array(
					'id'       => 'wlt_product_likes_archives',
					'type'     => 'checkbox',
					'css'      => 'min-width:300px;',
					'desc'     => esc_html__( 'Show On Product Archive Pages', 'wlt-product-likes' ),
					'desc_tip' => esc_html__( 'Shows a product like button on each product in an archive page e.g. shop page, product categories, etc.', 'wlt-product-likes' ),
					'checkboxgroup' => '',
				);

				$product_likes_settings[] = array(
					'id'       => 'wlt_product_likes_total',
					'type'     => 'checkbox',
					'css'      => 'min-width:300px;',
					'desc'     => esc_html__( 'Show Total Likes', 'wlt-product-likes' ),
					'desc_tip' => esc_html__( 'Shows the total number of likes if a product has been liked.', 'wlt-product-likes' ),
					'checkboxgroup' => 'end',
				);


				// Icon

				/*$product_likes_settings[] = array(
					'id'       => 'wlt_product_likes_icon',
					'type'     => 'select',
					'css'      => 'min-width:300px;',
					'class'    => 'wc-enhanced-select',
					'title'     => __( 'Icon', 'wlt-product-likes' ),
					'desc' => esc_html__( 'Icon type used for product likes.', 'wlt-product-likes' ),
					'options'  => array(
						'heart'	=> esc_html__( 'Heart', 'wlt-product-likes' ),
						'thumb'	=> esc_html__( 'Thumb', 'wlt-product-likes' ),
						'none'	=> esc_html__( 'None', 'wlt-product-likes' ),
					),
				);*/
				// Menu name

				$product_likes_settings[] = array(
					'title'		=> esc_html__( 'Change Menu name', 'wlt-product-likes' ),
					'id'       => 'wlt_product_menu_name',
					'type'     => 'text',
					'placeholder' => 'Default - Favorites Product', 
					'css'      => 'min-width:300px;',
					//'desc'     => esc_html__( 'Change Menu name.', 'wlt-product-likes' ),
					'desc_tip' => esc_html__( 'Change My account page in menu name like wishlist ,Like Item etc...  .', 'wlt-product-likes' ),
					'checkboxgroup' => 'start',
				);

				$product_likes_settings[] = array(
					'title'		=> esc_html__( 'Change Add to Cart button text', 'wlt-product-likes' ),
					'id'       => 'wlt_product_update_cart_btn_name',
					'type'     => 'text',
					'placeholder' => 'For example - BUY NOW', 
					'css'      => 'min-width:300px;',
					'desc'     => esc_html__( 'Change cart button text. like Add to cart to Buy now.', 'wlt-product-likes' ),
					'desc_tip' => esc_html__( 'Change cart button text. like Add to cart to Buy now.', 'wlt-product-likes' ),
					'checkboxgroup' => 'start',
				);

				$product_likes_settings[] = array(
					'title'		=> esc_html__( 'Change Checkout Order button text', 'wlt-product-likes' ),
					'id'       => 'wlt_product_update_checkout_btn_name',
					'type'     => 'text',
					'placeholder' => 'For example - Pay Now', 
					'css'      => 'min-width:300px;',
					'desc'     => esc_html__( 'Change Checkout Order button text. like Add to cart to Pay Now.', 'wlt-product-likes' ),
					'desc_tip' => esc_html__( 'Change Checkout Order button text.like Add to cart to Pay Now.', 'wlt-product-likes' ),
					'checkboxgroup' => 'start',
				);


				$product_likes_settings[] = array(
					'title'		=> esc_html__( 'Remove add to cart feature from store?', 'wlt-product-likes' ),
					'id'       => 'wlt_product_remove_cart_feature',
					'type'     => 'checkbox',
					'css'      => 'min-width:300px;',
					'desc'     => esc_html__( 'We will remove cart feature from store. only user can view product', 'wlt-product-likes' ),
					'desc_tip' => esc_html__( 'We will remove cart feature from store. only user can view product', 'wlt-product-likes' ),
					'checkboxgroup' => 'start',
				);

				$product_likes_settings[] = array(
					'title'		=> esc_html__( 'Hide product price for not login user across your store?', 'wlt-product-likes' ),
					'id'       => 'wlt_product_hide_pride',
					'type'     => 'checkbox',
					'css'      => 'min-width:300px;',
					'desc'     => esc_html__( 'Hide Price Until Login', 'wlt-product-likes' ),
					'desc_tip' => esc_html__( 'Hide product price for not login user across your store.', 'wlt-product-likes' ),
					'checkboxgroup' => 'start',
				);


				$product_likes_settings[] = array(
					'title'		=> esc_html__( 'Text for login link', 'wlt-product-likes' ),
					'id'       => 'wlt_product_text_for_login',
					'type'     => 'text',
					'placeholder' => 'For example - Login to see prices', 
					'css'      => 'min-width:300px;',
					'desc'     => esc_html__( 'Change Text for login link.', 'wlt-product-likes' ),
					'desc_tip' => esc_html__( 'Change Text for login link.', 'wlt-product-likes' ),
					'checkboxgroup' => 'start',
				);

				$product_likes_settings[] = array(
					'title'		=> esc_html__( 'Redirect after Add to cart?', 'wlt-product-likes' ),
					'id'       => 'wlt_product_redirect_checkout',
					'type'     => 'checkbox',
					'css'      => 'min-width:300px;',
					'desc'     => esc_html__( 'Redirect to Checkout Page', 'wlt-product-likes' ),
					'desc_tip' => esc_html__( 'Woocommerce add to cart then redirect to checkout page.', 'wlt-product-likes' ),
					'checkboxgroup' => 'start',
				);

				$product_likes_settings[] = array(
					'title'		=> esc_html__( 'Disable Cart Fragmentation?', 'wlt-product-likes' ),
					'id'       => 'wlt_product_disable_fragmentation',
					'type'     => 'checkbox',
					'css'      => 'min-width:300px;',
					'desc'     => esc_html__( 'Disable Cart Fragmentation', 'wlt-product-likes' ),
					//'desc_tip' => esc_html__( 'Disable Cart Fragmentation.', 'wlt-product-likes' ),
					'checkboxgroup' => 'start',
				);
				

				

				// Styles

				/*$product_likes_settings[] = array(
					'name'     => esc_html__( 'Styles', 'wlt-product-likes' ),
					'id'       => 'wlt_product_likes_styles',
					'type'     => 'checkbox',
					'css'      => 'min-width:300px;',
					'desc'     => esc_html__( 'Enable Styles', 'wlt-product-likes' ),
					'desc_tip' => esc_html__( 'Adds styles to product likes, if disabled this will remove all styles from product likes including the icon chosen, this option should only be disabled if you wish to style product likes yourself with CSS.', 'woocommerce' ),
				);*/

				// Section End
				
				$product_likes_settings[] = array(
					'type' => 'sectionend',
					'id' => 'wlt-product-likes'
				);

				return array_merge( $settings, $product_likes_settings );

			} else {

				return $settings;

			}

		}

	}

}
