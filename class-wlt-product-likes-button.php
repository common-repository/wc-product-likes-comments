<?php

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

// Instantiate

if ( !class_exists( 'WLT_Product_Likes_Button' ) ) {

	class WLT_Product_Likes_Button {

		public function __construct() {

			add_action( 'init', array( $this, 'cookie' ) );
			add_action( 'wp_footer', array( $this, 'scripts_styles' ) );
			add_action( 'woocommerce_before_single_product_summary', array( $this, 'product_page_display' ) );
			add_action( 'woocommerce_before_shop_loop_item', array( $this, 'archive_page_display' ), 20 );
			add_action( 'wp_ajax_wlt_product_likes_update', array( $this, 'update_likes' ) );
			add_action( 'wp_ajax_nopriv_wlt_product_likes_update', array( $this, 'update_likes' ) );
		}

		public function cookie() {

			if ( !isset( $_COOKIE['wlt_product_likes'] ) ) {

				setcookie( 'wlt_product_likes', wp_generate_uuid4(), time() + ( 86400 * 30 ), '/' );

			}

		}

		public function scripts_styles() {

			$user_id = $this->user_id();

			if ( $this->user_logged_in() == true ) { ?>

				<script>
					jQuery( document ).ready( function($) {

						$( 'body' ).on( 'click', '.wlt-product-likes-button', function(e) {

							e.preventDefault();

							var data = {
								'action': 'wlt_product_likes_update',
								'product_id': $(this).parent().attr('data-product-id'),
								'type': $(this).attr('data-type'),
								'nonce': '<?php echo esc_html( wp_create_nonce('wlt-product-likes-update') ); ?>',
							};

							jQuery.post( '<?php echo esc_html( admin_url( 'admin-ajax.php' ) ); ?>', data, function( response ) {

								console.log( response );

								response = response.split('_');
								likedTotal = parseInt( $('.wlt-product-likes-product[data-product-id="' + response[1] + '"] .wlt-product-likes-liked-total').text() );

								if ( response[0] == 'liked' ) {

									likedTotalNew = likedTotal + 1;
									$('.wlt-product-likes-product[data-product-id="' + response[1] + '"] .wlt-product-likes-button').attr( 'data-type', 'unlike' );
									$('.wlt-product-likes-product[data-product-id="' + response[1] + '"] .wlt-product-likes-button').removeClass('like');
									$('.wlt-product-likes-product[data-product-id="' + response[1] + '"] .wlt-product-likes-button').addClass('unlike');
									$('.wlt-product-likes-product[data-product-id="' + response[1] + '"] .wlt-product-likes-liked-total').text( likedTotalNew );

									if ( likedTotalNew > 0 ) {
										$('.wlt-product-likes-product[data-product-id="' + response[1] + '"] .wlt-product-likes-liked').show();
									}

								} else {

									likedTotalNew = likedTotal - 1;
									$('.wlt-product-likes-product[data-product-id="' + response[1] + '"] .wlt-product-likes-button').attr( 'data-type', 'like' );
									$('.wlt-product-likes-product[data-product-id="' + response[1] + '"] .wlt-product-likes-button').removeClass('unlike');
									$('.wlt-product-likes-product[data-product-id="' + response[1] + '"] .wlt-product-likes-button').addClass('like');

									$('.wlt-product-likes-product[data-product-id="' + response[1] + '"] .wlt-product-likes-liked-total').text( likedTotalNew );

									if ( likedTotalNew == 0 ) {
										$('.wlt-product-likes-product[data-product-id="' + response[1] + '"] .wlt-product-likes-liked').hide();
									}

								}

							});


						});

					});
				</script>
			<?php } ?>
				<style>
					body.single-product .wlt-product-likes-button svg._wcpl_heart {
					    cursor: pointer;
					    width: 26px;
					    height: 26px;
					    border-radius: 50%;
					    border: 1px solid #f0f0f0;
					    box-shadow: 0 1px 4px 0 rgb(0 0 0 / 10%);
					    background: #fff;
					    padding: 5px;
					}
					body.single-product .wlt-product-likes-product {
						left: 2px;
					}
					.wlt-product-likes-product {
						font-size: 1em;
						margin: 0.1em;
						position: absolute;
						z-index: 9;
						display: inline-block;
					    right: 5px;
					    cursor: pointer;
					}
					.wlt-product-likes-product .wlt-product-likes-button {
						margin-right: 0.1em;
						cursor: pointer;
						display: inline-block;
						vertical-align: middle
					}
					.wlt-product-likes-product .wlt-product-likes-button:hover {
						opacity: 0.75;
					}
					.wlt-product-likes-product .wlt-product-likes-liked {
						font-size: 0.7em;
						display: inline-block;
						vertical-align: middle
					}
					.wlt-product-likes-product.guest span.wlt-product-likes-button.like,span.wlt-product-comments-button {
					    cursor: auto;
					}
					/*.wlt-comments-product {
					    position: absolute;
					    left: 40px;
					    width: 50px;
					    font-size: 1em;
					    margin: 0.3em;
					    z-index: 9;
					}
					.single-product .wlt-comments-product{
						left: 5%;
					}
					span.wlt-product-comments-button::before {
					    content: '';
					    background: url('<?php echo esc_html( plugin_dir_url( __FILE__ ) ); ?>assets/comments.png') no-repeat;
					    background-size: 100% 100%;
					    padding-right: 1em;
					    margin-right: 0.3em;
					}
					.wlt-product-likes-product .wlt-product-likes-button.like::before {
						content: '';
						background: url('<?php echo esc_html( plugin_dir_url( __FILE__ ) ); ?>assets/unlike.png') no-repeat;
						background-size: 100% 100%;
						padding-right: 1em;
						margin-right: 0.3em;
					}
					.wlt-product-likes-product .wlt-product-likes-button.unlike::before {
					    content: '';
					    background: url('<?php echo esc_html( plugin_dir_url( __FILE__ ) ); ?>assets/heart.png') no-repeat;
					    background-size: 100% 100%;
					    padding-right: 1em;
					    margin-right: 0.3em;
					}*/
					span.wlt-product-likes-button.unlike path.wcpl_heart {
					    fill: red;
					}
				</style>
		<?php

		}

		public function product_page_display() {

			if ( get_option( 'wlt_product_likes_products' ) == 'yes' ) {

				$this->like_button();

			}

		}

		public function archive_page_display() {

			if ( get_option( 'wlt_product_likes_archives' ) == 'yes' ) {

				$this->like_button();

			}

		}

		public function like_button() {

			global $post, $wpdb;
			$user_id = $this->user_id();
			$icon = '<svg xmlns="http://www.w3.org/2000/svg" class="_wcpl_heart" width="16" height="16" viewBox="0 0 20 16"><path d="M8.695 16.682C4.06 12.382 1 9.536 1 6.065 1 3.219 3.178 1 5.95 1c1.566 0 3.069.746 4.05 1.915C10.981 1.745 12.484 1 14.05 1 16.822 1 19 3.22 19 6.065c0 3.471-3.06 6.316-7.695 10.617L10 17.897l-1.305-1.215z" fill="#c2c2c2" class="wcpl_heart" stroke="#FFF" fill-rule="evenodd" opacity=".9"></path></svg>';
			if ( $this->user_logged_in() == true || ( $this->user_logged_in() == false && get_option( 'wlt_product_likes_not_logged_in' ) == 'yes' ) ) {

				$product_id = $post->ID;
				$product_likes = $wpdb->get_results( $wpdb->prepare( "SELECT COUNT(*) AS likes FROM {$wpdb->prefix}wlt_product_likes WHERE product_id = %d", $product_id ) );
				$product_likes = ( isset( $product_likes[0] ) ? (int) $product_likes[0]->likes : 0 );
				$product_liked = $wpdb->get_results( $wpdb->prepare( "SELECT COUNT(*) AS liked FROM {$wpdb->prefix}wlt_product_likes WHERE product_id = %d AND user_id = %s", array( $product_id, $user_id ) ) );
				$product_liked = ( isset( $product_liked[0] ) ? (int) $product_liked[0]->liked : 0 );

				echo '<div class="wlt-product-likes-product" data-product-id="' . esc_html( $product_id ) . '">';

				if ( 1 == $product_liked ) {

					echo '<span class="wlt-product-likes-button unlike" data-type="unlike">' .$icon. esc_html__( '', 'wcpl-product-likes' ) . '</span>';

				} else {

					echo '<span class="wlt-product-likes-button like" data-type="like">' .$icon. esc_html__( '', 'wcpl-product-likes' ) . '</span>';

				}

				if ( 'yes' == get_option( 'wlt_product_likes_total' ) ) {

					echo '<span class="wlt-product-likes-liked"' . ( 0 == $product_likes ? ' style="display: none;"' : '' ) . '>' . esc_html__( '', 'wlt-product-likes' ) . ' <span class="wlt-product-likes-liked-total">' . esc_html( $product_likes ) . '</span> ' . esc_html__( '', 'wlt-product-likes' ) . '</span>';

				}

				echo '</div>';

			}

			if ( $this->user_logged_in() == false ) {

				$product_id = $post->ID;
				$product_likes = $wpdb->get_results( $wpdb->prepare( "SELECT COUNT(*) AS likes FROM {$wpdb->prefix}wlt_product_likes WHERE product_id = %d", $product_id ) );
				$product_likes = ( isset( $product_likes[0] ) ? (int) $product_likes[0]->likes : 0 );
				$product_liked = $wpdb->get_results( $wpdb->prepare( "SELECT COUNT(*) AS liked FROM {$wpdb->prefix}wlt_product_likes WHERE product_id = %d AND user_id = %s", array( $product_id, $user_id ) ) );
				$product_liked = ( isset( $product_liked[0] ) ? (int) $product_liked[0]->liked : 0 );

				echo '<div class="wlt-product-likes-product guest" data-product-id="' . esc_html( $product_id ) . '">';

				if ( 1 == $product_liked ) {

					echo '<span class="wlt-product-likes-button unlike">' .$icon. esc_html__( '', 'wcpl-product-likes' ) . '</span>';

				} else {

					echo '<span class="wlt-product-likes-button like">' .$icon. esc_html__( '', 'wcpl-product-likes' ) . '</span>';

				}

				if ( 'yes' == get_option( 'wlt_product_likes_total' ) ) {

					echo '<span class="wlt-product-likes-liked"' . ( 0 == $product_likes ? ' style="display: none;"' : '' ) . '>' . esc_html__( '', 'wlt-product-likes' ) . ' <span class="wlt-product-likes-liked-total">' . esc_html( $product_likes ) . '</span> ' . esc_html__( '', 'wlt-product-likes' ) . '</span>';

				}

				echo '</div>';

			}

		}

		public function update_likes() {

			$response = '';

			if ( isset( $_POST['nonce'] ) ) {

				if ( wp_verify_nonce( sanitize_text_field( $_POST['nonce'] ), 'wlt-product-likes-update' ) ) {

					global $wpdb;
					$user_id = $this->user_id();
					$product_id = ( isset( $_POST['product_id'] ) ? sanitize_text_field( $_POST['product_id'] ) : '' );
					$type = ( isset( $_POST['type'] ) ? sanitize_text_field( $_POST['type'] ) : '' );

					if ( !empty( $user_id ) ) {

						$existing_like = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wlt_product_likes WHERE product_id = %d AND user_id = %s", array( $product_id, $user_id ) ) );

						if ( 'like' == $type ) {

							// Check for existing like incase someone tries changing the type to like on the link to try to inflate likes

							if ( empty( $existing_like ) ) {

								$like = $wpdb->query( $wpdb->prepare( "INSERT INTO {$wpdb->prefix}wlt_product_likes VALUES ('', %d, %s)", array( $product_id, $user_id ) ) );

								if ( $like > 0 ) {

									$response = 'liked_' . $product_id;

								}

							}
							do_action('like_product',$product_id);
						} elseif ( 'unlike' == $type ) {
							do_action('unlike_product',$product_id);
							// Check for existing like incase someone tries changing the type to unlike on the link to try to deflate likes

							if ( !empty( $existing_like ) ) {

								$unlike = $wpdb->query( $wpdb->prepare( "DELETE FROM {$wpdb->prefix}wlt_product_likes WHERE product_id = %d AND user_id = %s", array( $product_id, $user_id ) ) );

								if ( $unlike > 0 ) {

									$response = 'unliked_' . $product_id;
									
								}
								do_action('unlike_product',$product_id);
							}

						}

					}

				}

			}

			echo esc_html( $response );
			exit;

		}

		public function user_id() {

			$user_id = get_current_user_id();

			if ( 0 == $user_id ) { // Not logged in

				if ( isset( $_COOKIE['wlt_product_likes'] ) ) {

					$user_id = sanitize_text_field( $_COOKIE['wlt_product_likes'] );

				}

			}

			return $user_id;

		}

		public function user_logged_in() {

			$user_id = $this->user_id();
			$user_logged_in = true;

			if ( !empty( $user_id ) ) {

				if ( substr_count( $user_id, '-' ) > 0 ) {

					$user_logged_in = false;

				}

			}

			return $user_logged_in;

		}

	}

}
