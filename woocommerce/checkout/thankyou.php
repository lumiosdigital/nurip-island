<?php
/**
 * Custom Nirup Thank You / Order Received template
 *
 * Overrides WooCommerce checkout/thankyou.php
 *
 * Layout:
 * - Same wrapper + cards as checkout (.nirup-checkout-main, etc.)
 * - Left: Order details table (+ any booking details hooked into woocommerce_thankyou)
 * - Right: Stay summary + billing address
 *
 * @var WC_Order $order
 */

defined( 'ABSPATH' ) || exit;
?>

<?php if ( isset( $order ) && $order ) : ?>

	<?php do_action( 'woocommerce_before_thankyou', $order->get_id() ); ?>

	<?php
	$has_failed    = $order->has_status( 'failed' );
	$first_name    = $order->get_billing_first_name();
	$display_name  = $first_name ? $first_name : '';
	$thankyou_text = apply_filters(
		'woocommerce_thankyou_order_received_text',
		esc_html__( 'Thank you. Your order has been received.', 'woocommerce' ),
		$order
	);
	?>

	<?php if ( $has_failed ) : ?>

		<main class="nirup-checkout-main nirup-thankyou-main">
			<div class="nirup-checkout-wrapper">
				<header class="nirup-checkout-header nirup-thankyou-header">
					<p class="nirup-checkout-eyebrow"><?php esc_html_e( 'Order problem', 'woocommerce' ); ?></p>
					<h1 class="nirup-checkout-title">
						<?php esc_html_e( 'Unfortunately your order cannot be processed.', 'woocommerce' ); ?>
					</h1>
					<p class="nirup-checkout-subtitle">
						<?php esc_html_e( 'The originating bank or payment provider declined the transaction. Please try again or use a different method.', 'woocommerce' ); ?>
					</p>
				</header>

				<div class="nirup-checkout-layout nirup-thankyou-layout">
					<div class="nirup-checkout-col">
						<div class="nirup-checkout-card nirup-thankyou-card nirup-thankyou-card--failed">
							<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed">
								<?php esc_html_e( 'Please attempt your purchase again.', 'woocommerce' ); ?>
							</p>
							<p class="nirup-thankyou-failed-actions">
								<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay">
									<?php esc_html_e( 'Try again', 'woocommerce' ); ?>
								</a>
								<?php if ( is_user_logged_in() ) : ?>
									<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay nirup-thankyou-secondary-button">
										<?php esc_html_e( 'My account', 'woocommerce' ); ?>
									</a>
								<?php endif; ?>
							</p>
						</div>
					</div>
				</div>

				<?php
				// Let gateways / plugins still run their thankyou hooks.
				do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() );
				do_action( 'woocommerce_thankyou', $order->get_id() );
				?>
			</div>
		</main>

	<?php else : ?>

		<?php
		// We are rendering the order details table manually in our card,
		// so prevent WooCommerce from outputting it again through the hook.
		remove_action( 'woocommerce_thankyou', 'woocommerce_order_details_table', 10 );
		?>

		<main class="nirup-checkout-main nirup-thankyou-main">
			<div class="nirup-checkout-wrapper">

				<header class="nirup-checkout-header nirup-thankyou-header">
					<p class="nirup-checkout-eyebrow">
						<?php esc_html_e( 'Order received', 'woocommerce' ); ?>
					</p>
					<h1 class="nirup-checkout-title">
						<?php
						if ( $display_name ) {
							printf(
								/* translators: 1: Customer first name. */
								esc_html__( 'Thank you, %s.', 'woocommerce' ),
								esc_html( $display_name )
							);
						} else {
							esc_html_e( 'Thank you for your booking.', 'woocommerce' );
						}
						?>
					</h1>
					<p class="nirup-checkout-subtitle nirup-thankyou-subtitle">
						<?php echo esc_html( wp_strip_all_tags( $thankyou_text ) ); ?>
					</p>
				</header>

				<div class="nirup-checkout-layout nirup-thankyou-layout">
					<!-- LEFT COLUMN: ORDER DETAILS + BOOKING DETAILS -->
					<div class="nirup-checkout-col nirup-thankyou-col nirup-thankyou-col--main">

						<section class="nirup-checkout-card nirup-thankyou-card nirup-thankyou-card--order">
							<h2 class="nirup-checkout-section-title">
								<?php esc_html_e( 'Order details', 'woocommerce' ); ?>
							</h2>

							<?php
							// Properly render the order details table so all expected vars (incl. $show_downloads) are passed.
							if ( function_exists( 'woocommerce_order_details_table' ) ) {
								woocommerce_order_details_table( $order->get_id() );
							} else {
								// Fallback for very old WooCommerce versions.
								wc_get_template(
									'order/order-details.php',
									array(
										'order_id'       => $order->get_id(),
										'show_downloads' => apply_filters(
											'woocommerce_order_downloads_table_show_downloads',
											( $order->has_downloadable_item() && $order->is_download_permitted() ),
											$order
										),
									)
								);
							}
							?>
						</section>

						<section class="nirup-checkout-card nirup-thankyou-card nirup-thankyou-card--extra">
							<?php
							// Payment-specific + generic thankyou content (e.g. booking details from plugins).
							do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() );
							do_action( 'woocommerce_thankyou', $order->get_id() );
							?>
						</section>

					</div>

					<!-- RIGHT COLUMN: STAY SUMMARY + BILLING -->
					<aside class="nirup-checkout-col nirup-thankyou-col nirup-thankyou-col--sidebar">

						<section class="nirup-checkout-card nirup-thankyou-card nirup-thankyou-card--summary">
							<h2 class="nirup-checkout-section-title">
								<?php esc_html_e( 'Your stay summary', 'woocommerce' ); ?>
							</h2>

							<ul class="nirup-thankyou-summary-list">
								<li>
									<span class="nirup-thankyou-summary-label">
										<?php esc_html_e( 'Order number', 'woocommerce' ); ?>
									</span>
									<span class="nirup-thankyou-summary-value">
										<?php echo esc_html( $order->get_order_number() ); ?>
									</span>
								</li>
								<li>
									<span class="nirup-thankyou-summary-label">
										<?php esc_html_e( 'Date', 'woocommerce' ); ?>
									</span>
									<span class="nirup-thankyou-summary-value">
										<?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?>
									</span>
								</li>
								<?php if ( $order->get_billing_email() ) : ?>
									<li>
										<span class="nirup-thankyou-summary-label">
											<?php esc_html_e( 'Email', 'woocommerce' ); ?>
										</span>
										<span class="nirup-thankyou-summary-value">
											<?php echo esc_html( $order->get_billing_email() ); ?>
										</span>
									</li>
								<?php endif; ?>
								<li>
									<span class="nirup-thankyou-summary-label">
										<?php esc_html_e( 'Total', 'woocommerce' ); ?>
									</span>
									<span class="nirup-thankyou-summary-value">
										<?php echo wp_kses_post( $order->get_formatted_order_total() ); ?>
									</span>
								</li>
								<!-- Intentionally skip "Payment method" here to avoid repeating it under the order table -->
							</ul>
						</section>

						<section class="nirup-checkout-card nirup-thankyou-card nirup-thankyou-card--billing">
							<h2 class="nirup-checkout-section-title">
								<?php esc_html_e( 'Billing address', 'woocommerce' ); ?>
							</h2>

							<div class="nirup-thankyou-billing">
								<?php
								$billing_address = $order->get_formatted_billing_address( esc_html__( 'N/A', 'woocommerce' ) );
								echo wp_kses_post( wpautop( $billing_address ) );

								if ( $order->get_billing_phone() ) :
									?>
									<p class="nirup-thankyou-billing-line nirup-thankyou-billing-phone">
										<span class="nirup-thankyou-summary-label">
											<?php esc_html_e( 'Phone', 'woocommerce' ); ?>
										</span>
										<br>
										<span class="nirup-thankyou-summary-value">
											<?php echo esc_html( $order->get_billing_phone() ); ?>
										</span>
									</p>
								<?php endif; ?>
							</div>
						</section>

					</aside>
				</div><!-- .nirup-checkout-layout -->

			</div><!-- .nirup-checkout-wrapper -->
		</main><!-- .nirup-checkout-main -->

	<?php endif; // ! failed ?>

<?php else : ?>

	<!-- Fallback when there is no order object (very rare) -->
	<main class="nirup-checkout-main nirup-thankyou-main">
		<div class="nirup-checkout-wrapper">
			<header class="nirup-checkout-header nirup-thankyou-header">
				<p class="nirup-checkout-eyebrow"><?php esc_html_e( 'Order received', 'woocommerce' ); ?></p>
				<h1 class="nirup-checkout-title">
					<?php esc_html_e( 'Thank you for your booking.', 'woocommerce' ); ?>
				</h1>
				<p class="nirup-checkout-subtitle nirup-thankyou-subtitle">
					<?php esc_html_e( 'We have received your order. If you have any questions, please contact us.', 'woocommerce' ); ?>
				</p>
			</header>
		</div>
	</main>

<?php endif; ?>
