<?php

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

// Instantiate

if ( !class_exists( 'WLT_Product_Likes_Account' ) ) {

	class WLT_Product_Likes_Account {

		public function __construct() {

			add_filter( 'woocommerce_account_menu_items', array( $this, 'item' ), 10, 1 );
			add_action( 'woocommerce_account_likes_endpoint', array( $this, 'content' ) );
			add_action( 'init', array( $this, 'endpoint' ) );
			add_filter( 'query_vars', array( $this, 'vars' ), 0 );

		}

		public function item( $items ) {
			$menu_name = 'Favorites Product'; 
			if ( get_option( 'wlt_product_menu_name' ) != '' ) {
				$menu_name = get_option( 'wlt_product_menu_name' );
			}
			unset( $items['customer-logout'] );
			$items['likes'] = esc_html__( $menu_name, 'wlt-product-likes' );
			$items['customer-logout'] = esc_html__( 'Logout', 'woocommerce' ); // Puts the log out menu item below likes
			return $items;

		}

		public function content() {

			global $wpdb;
			$user_id = get_current_user_id(); // Not using get user id function from buttons class as already logged in and don't want the not logged in user ids from that function
			$products_liked = $wpdb->get_results( $wpdb->prepare( "SELECT product_id FROM {$wpdb->prefix}wlt_product_likes WHERE user_id = %s", $user_id ) );
			$products_liked_ids = array();

			if ( !empty( $products_liked ) ) {

				foreach ( $products_liked as $product_liked ) {

					$products_liked_ids[] = $product_liked->product_id;

				} ?>

				<ul class="products">
					<?php
					$args = array(
						'post_type'			=> 'product',
						'posts_per_page'	=> -1,
						'post__in'			=> $products_liked_ids,
					);
					$loop = new WP_Query( $args );
					if ( $loop->have_posts() ) {
						while ( $loop->have_posts() ) {
							$loop->the_post();
							wc_get_template_part( 'content', 'product' );
						}
					}
					wp_reset_postdata();
					?>
				</ul>

				<?php

			} else {

				esc_html_e( 'No products liked yet.', 'wlt-product-likes' );

			}

		}

		public function endpoint() {

			add_rewrite_endpoint( 'likes', EP_PAGES );

			// Only flush rewrites once

			if ( get_option( 'wlt_product_likes_flush_rewrites' ) == 'yes' ) {
				
				flush_rewrite_rules();
				update_option( 'wlt_product_likes_flush_rewrites', 'no' );
			
			}

		}

		public function vars( $vars ) {

			$vars[] = 'likes';
			return $vars;

		}

	}

}
