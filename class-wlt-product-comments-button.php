<?php

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

// Instantiate

if ( !class_exists( 'WLT_Product_Comments_Button' ) ) {

	class WLT_Product_Comments_Button {

		public function __construct() {

			//add_action( 'woocommerce_before_shop_loop_item', array( $this, 'product_page_display_comments' ), 22 );
			//add_action( 'woocommerce_before_single_product_summary', array( $this, 'product_page_display_comments') );

		}

		public function product_page_display_comments() {

			if ( get_option( 'wlt_product_comments_enable' ) == 'yes' && get_option( 'woocommerce_enable_reviews' ) == 'yes' ) {

				$this->comments_button();

			}

		}

		public function comments_button() {
			global $post, $wpdb;
			$product_id = $post->ID;
			$count_args = array(
			                'post_id' => $product_id,
			                'type' => 'review',
			                'status' => "approve", // Status you can also use 'hold', 'spam', 'trash', 
			                'order' => 'DESC',
			            );
			$total_comments = count(get_comments($count_args));

			echo '<div class="wlt-comments-product" ><span class="wlt-product-comments-button"></span>'.$total_comments.'</div>';

		}

	}

}