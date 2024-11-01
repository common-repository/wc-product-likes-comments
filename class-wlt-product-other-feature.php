<?php

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

// Instantiate

if ( !class_exists( 'WLT_Product_Other_Feature' ) ) {

	class WLT_Product_Other_Feature {

		public function __construct() {

			if ( get_option( 'wlt_product_redirect_checkout' ) == 'yes' ) {
				add_filter( 'woocommerce_add_to_cart_redirect',  array( $this,'skip_cart_redirect_checkout') );
				add_filter( 'add_to_cart_redirect',  array( $this,'skip_cart_redirect_checkout') );
			}
			if ( get_option( 'wlt_product_update_cart_btn_name' ) != '' ) {
				add_filter( 'woocommerce_product_single_add_to_cart_text',  array( $this,'btntext_cart') );
				add_filter( 'woocommerce_product_add_to_cart_text',  array( $this,'btntext_cart') );
			}
			if ( get_option( 'wlt_product_update_checkout_btn_name' ) != '' ) {
				add_filter( 'woocommerce_order_button_text', array( $this,'change_checkout_button_text' ) );
			}

			if ( get_option( 'wlt_product_hide_pride' ) == 'yes') {

				add_action( 'init', array( $this,'wlt_hide_price_add_cart_not_logged_in' ) );
			}


			if ( get_option( 'wlt_product_remove_cart_feature' ) == 'yes' ) {
				add_action( 'init', array( $this,'wlt_hide_price_add_cart_for_store' ) );
			}

			if ( get_option( 'wlt_product_disable_fragmentation' ) == 'yes' ) {
				add_action( 'wp_enqueue_scripts', array( $this,'disable_fragmentation_checkout_script' ) );
			}

			
		}


		public function btntext_cart() {
			$cart_btn_name = get_option( 'wlt_product_update_cart_btn_name' );
			$cart_btn_name = __( $cart_btn_name, 'wlt-product-likes' );
		    return $cart_btn_name; 
		}
		
 
		public function skip_cart_redirect_checkout() {
		    global $woocommerce;
		    $checkout_url = $woocommerce->cart->get_checkout_url();
		    return $checkout_url;
		}
		 
		function change_checkout_button_text( $button_text ) {
			
		   	$cart_btn_name = get_option( 'wlt_product_update_checkout_btn_name' );
			$cart_btn_name = __( $cart_btn_name, 'wlt-product-likes' );
		    return $cart_btn_name; 
		   
		}


		/**

		 * Hide Price & Add to Cart for Logged Out Users

		*/

		public function wlt_hide_price_add_cart_not_logged_in() {  

		   if ( ! is_user_logged_in() ) {     

		      remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

		      remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );

		      remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );

		      remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );  

		      add_action( 'woocommerce_single_product_summary', array( $this,'wlt_print_login_to_see'), 31 );

		      add_action( 'woocommerce_after_shop_loop_item', array( $this,'wlt_print_login_to_see'), 11 );
		      add_action( 'woocommerce_login_form_end', array( $this,'wlt_actual_referrer' ) );

		   }

		}

		/**

		 * Hide Price & Add to Cart for store

		*/

		public function wlt_hide_price_add_cart_for_store() {  


		      remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

		      remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );

		      remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );

		      remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );  
		}




		public function wlt_print_login_to_see() {
		  $wlt_product_text_for_login = get_option( 'wlt_product_text_for_login' );
		  if($wlt_product_text_for_login == '' ){
		  	$wlt_product_text_for_login = 'Login to see prices';
		  }
		   echo '<a class="wlt_product_login_text button wp-element-button" href="' . get_permalink(wc_get_page_id('myaccount')) . '">' . __($wlt_product_text_for_login, 'wlt-product-likes') . '</a>';

		}

		public function disable_fragmentation_checkout_script(){
		    wp_dequeue_script( 'wc-checkout' );
		}
		 
		public function wlt_actual_referrer() {
		   if ( ! wc_get_raw_referer() ) return;
		   echo '<input type="hidden" name="redirect" value="' . wp_validate_redirect( wc_get_raw_referer(), wc_get_page_permalink( 'myaccount' ) ) . '" />';
		}

	}

}

		