<?php
/**
 * Nirup – Custom Thank You (Order received) template
 *
 * Based on WooCommerce thankyou.php
 *
 * @var WC_Order $order
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="woocommerce-order nirup-thankyou">

    <?php
    if ( $order ) :

        do_action( 'woocommerce_before_thankyou', $order->get_id() );
        ?>

        <?php if ( $order->has_status( 'failed' ) ) : ?>

            <main class="nirup-thankyou-main">
                <div class="nirup-thankyou-wrapper">
                    <div class="nirup-thankyou-card nirup-thankyou-card--failed">
                        <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed">
                            <?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?>
                        </p>

                        <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
                            <a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay">
                                <?php esc_html_e( 'Pay', 'woocommerce' ); ?>
                            </a>

                            <?php if ( is_user_logged_in() ) : ?>
                                <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay">
                                    <?php esc_html_e( 'My account', 'woocommerce' ); ?>
                                </a>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            </main>

        <?php else : ?>

            <main class="nirup-thankyou-main">
                <div class="nirup-thankyou-wrapper">

                    <header class="nirup-thankyou-header">
                        <p class="nirup-thankyou-eyebrow">
                            Order received
                        </p>

                        <h1 class="nirup-thankyou-title">
                            <?php
                            $first_name = $order->get_billing_first_name();
                            if ( $first_name ) {
                                printf(
                                    /* translators: %s: customer first name */
                                    esc_html__( 'Thank you, %s.', 'nirup' ),
                                    esc_html( $first_name )
                                );
                            } else {
                                esc_html_e( 'Thank you for your booking.', 'nirup' );
                            }
                            ?>
                        </h1>

                        <?php
                        // Default Woo success text (“Thank you. Your order has been received.”)
                        wc_get_template( 'checkout/order-received.php', array( 'order' => $order ) );
                        ?>
                    </header>

                    <section class="nirup-thankyou-summary-card">

                        <h2 class="nirup-thankyou-section-title">
                            <?php esc_html_e( 'Your stay summary', 'nirup' ); ?>
                        </h2>

                        <ul class="nirup-thankyou-overview">
                            <li class="nirup-thankyou-overview-item">
                                <span class="nirup-thankyou-overview-label">
                                    <?php esc_html_e( 'Order number', 'woocommerce' ); ?>
                                </span>
                                <span class="nirup-thankyou-overview-value">
                                    <?php echo $order->get_order_number(); // phpcs:ignore ?>
                                </span>
                            </li>

                            <li class="nirup-thankyou-overview-item">
                                <span class="nirup-thankyou-overview-label">
                                    <?php esc_html_e( 'Date', 'woocommerce' ); ?>
                                </span>
                                <span class="nirup-thankyou-overview-value">
                                    <?php echo wc_format_datetime( $order->get_date_created() ); // phpcs:ignore ?>
                                </span>
                            </li>

                            <?php if ( $order->get_billing_email() ) : ?>
                                <li class="nirup-thankyou-overview-item">
                                    <span class="nirup-thankyou-overview-label">
                                        <?php esc_html_e( 'Email', 'woocommerce' ); ?>
                                    </span>
                                    <span class="nirup-thankyou-overview-value">
                                        <?php echo esc_html( $order->get_billing_email() ); ?>
                                    </span>
                                </li>
                            <?php endif; ?>

                            <li class="nirup-thankyou-overview-item">
                                <span class="nirup-thankyou-overview-label">
                                    <?php esc_html_e( 'Total', 'woocommerce' ); ?>
                                </span>
                                <span class="nirup-thankyou-overview-value">
                                    <?php echo $order->get_formatted_order_total(); // phpcs:ignore ?>
                                </span>
                            </li>

                            <?php if ( $order->get_payment_method_title() ) : ?>
                                <li class="nirup-thankyou-overview-item">
                                    <span class="nirup-thankyou-overview-label">
                                        <?php esc_html_e( 'Payment method', 'woocommerce' ); ?>
                                    </span>
                                    <span class="nirup-thankyou-overview-value">
                                        <?php echo wp_kses_post( $order->get_payment_method_title() ); ?>
                                    </span>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </section>

                    <section class="nirup-thankyou-extra">
                        <?php
                        // Midtrans, booking details etc. still hook in here.
                        do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() );
                        do_action( 'woocommerce_thankyou', $order->get_id() );
                        ?>
                    </section>

                </div>
            </main>

        <?php endif; ?>

    <?php else : ?>

        <main class="nirup-thankyou-main">
            <div class="nirup-thankyou-wrapper">
                <?php
                // Fallback when no order object is available.
                wc_get_template( 'checkout/order-received.php', array( 'order' => false ) );
                ?>
            </div>
        </main>

    <?php endif; ?>

</div>
