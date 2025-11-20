<?php
/**
 * Custom Nirup Checkout Template
 *
 * Based on WooCommerce form-checkout.php
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
    echo esc_html(
        apply_filters(
            'woocommerce_checkout_must_be_logged_in_message',
            __( 'You must be logged in to checkout.', 'woocommerce' )
        )
    );
    return;
}
?>

<main class="nirup-checkout-main">

    <div class="nirup-checkout-wrapper">

        <header class="nirup-checkout-header">
            <p class="nirup-checkout-eyebrow">
                Your stay at Nirup Island
            </p>
            <h1 class="nirup-checkout-title">
                Complete your booking
            </h1>
            <p class="nirup-checkout-subtitle">
                Please review your details and confirm your reservation. Payment is processed securely via Midtrans.
            </p>
        </header>

        <!-- IMPORTANT: the form now wraps BOTH columns -->
        <form name="checkout"
              method="post"
              class="checkout woocommerce-checkout nirup-checkout-layout"
              action="<?php echo esc_url( wc_get_checkout_url() ); ?>"
              enctype="multipart/form-data">

            <!-- LEFT COLUMN – GUEST DETAILS -->
            <div class="nirup-checkout-col nirup-checkout-col--details">

                <div class="nirup-checkout-card">

                    <?php if ( $checkout->get_checkout_fields() ) : ?>

                        <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

                        <div id="customer_details" class="nirup-checkout-customer-details">
                            <div class="nirup-checkout-section">
                                <?php do_action( 'woocommerce_checkout_billing' ); ?>
                            </div>

                            <div class="nirup-checkout-section nirup-checkout-section--secondary">
                                <?php
                                // Keep the default shipping hook so Woo stays happy,
                                // even if you don't actually show shipping fields.
                                do_action( 'woocommerce_checkout_shipping' );
                                ?>
                            </div>
                        </div>

                        <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

                    <?php endif; ?>

                </div><!-- .nirup-checkout-card -->

            </div><!-- .nirup-checkout-col--details -->


            <!-- RIGHT COLUMN – ORDER SUMMARY & PAYMENT -->
            <div class="nirup-checkout-col nirup-checkout-col--order">

                <div class="nirup-checkout-card nirup-checkout-card--order">

                    <?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>

                    <h2 id="order_review_heading" class="nirup-checkout-section-title">
                        Your stay summary
                    </h2>

                    <?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

                    <div id="order_review" class="woocommerce-checkout-review-order nirup-checkout-order-review">
                        <?php
                        // This outputs the order table + payment methods + Midtrans "Place order" button.
                        do_action( 'woocommerce_checkout_order_review' );
                        ?>
                    </div>

                    <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

                    <p class="nirup-checkout-security-note">
                        Payments are encrypted and processed securely via Midtrans.
                    </p>

                </div><!-- .nirup-checkout-card--order -->

            </div><!-- .nirup-checkout-col--order -->

        </form><!-- .checkout -->

    </div><!-- .nirup-checkout-wrapper -->

</main><!-- .nirup-checkout-main -->

<?php
do_action( 'woocommerce_after_checkout_form', $checkout );
