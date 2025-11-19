# Villa Booking with Midtrans Payment Integration

## Overview

This implementation provides a complete villa booking flow with Midtrans payment integration. When users book a villa, the system:

1. Captures booking details from the WPBS (WP Booking System) form
2. Creates a WooCommerce order
3. Redirects to Midtrans payment gateway
4. Processes payment confirmation
5. Shows a thank you message upon successful payment

## Prerequisites

Before this system will work, you need:

1. **WooCommerce Plugin** - Must be installed and activated
2. **Midtrans Payment Plugin** - Install one of the following:
   - [Midtrans WooCommerce Payment Gateway](https://wordpress.org/plugins/midtrans-woocommerce/)
   - [WooCommerce Midtrans Snap](https://github.com/Midtrans/midtrans-woocommerce)
3. **WP Booking System Plugin** - Already in use for calendar management
4. **Midtrans Account** - Sign up at [https://midtrans.com](https://midtrans.com)

## Installation Steps

### 1. Install Midtrans Plugin

```bash
# Option A: Via WordPress Admin
# Go to Plugins > Add New
# Search for "Midtrans WooCommerce"
# Install and Activate

# Option B: Manual Installation
# Download plugin from: https://wordpress.org/plugins/midtrans-woocommerce/
# Upload to wp-content/plugins/
# Activate via WordPress admin
```

### 2. Configure Midtrans Plugin

1. Go to **WooCommerce > Settings > Payments**
2. Enable **Midtrans Snap** payment method
3. Click **Manage** to configure settings:

   ```
   Server Key:     [Your Midtrans Server Key]
   Client Key:     [Your Midtrans Client Key]
   Environment:    Sandbox (for testing) or Production
   ```

4. Get your API keys from Midtrans Dashboard:
   - Sandbox: https://dashboard.sandbox.midtrans.com/
   - Production: https://dashboard.midtrans.com/

5. Configure Payment Notification URL in Midtrans Dashboard:
   ```
   https://your-site.com/wp-admin/admin-ajax.php?action=midtrans_payment_notification
   ```

### 3. Configure WP Booking System

For each villa, ensure you have:

1. Go to **Villas > Edit Villa**
2. Set the **Calendar ID** and **Form ID** in the WP Booking System meta box
3. Configure the WPBS form to include these fields:
   - Check-in date
   - Check-out date
   - Number of guests
   - Customer name
   - Customer email (required)
   - Customer phone
   - Total price (calculated by WPBS)

### 4. Test the Integration

#### Sandbox Testing

1. Set Midtrans to **Sandbox Mode**
2. Use Midtrans test cards:
   ```
   Card Number:     4811 1111 1111 1114
   CVV:             123
   Expiry Date:     Any future date
   ```

3. Test the complete flow:
   - Open a villa page
   - Click "BOOK YOUR STAY"
   - Select dates and fill form
   - Click submit
   - Complete payment on Midtrans
   - Verify redirect back to villa
   - Confirm thank you modal appears

## How It Works

### 1. Form Submission Flow

```
User fills booking form
        ↓
JavaScript intercepts form submission
        ↓
AJAX call to: process_villa_booking_payment
        ↓
PHP creates WooCommerce order
        ↓
Returns Midtrans payment URL
        ↓
User redirected to Midtrans
        ↓
User completes payment
        ↓
Midtrans redirects back to villa page
        ↓
Thank you modal displayed
```

### 2. Key Files Modified

**functions.php** (lines 12611-12884):
- `nirup_process_villa_booking_payment()` - Creates WooCommerce order
- `nirup_get_or_create_villa_product()` - Creates/retrieves villa product
- `nirup_generate_midtrans_payment_url()` - Generates payment URL
- `nirup_handle_midtrans_payment_notification()` - Processes webhooks
- `nirup_handle_midtrans_return()` - Handles payment returns
- `nirup_configure_midtrans_return_urls()` - Sets return URLs

**assets/js/villa-booking-calendar.js**:
- Intercepts WPBS form submission
- Extracts booking data
- Sends AJAX request to create order
- Redirects to Midtrans
- Detects payment return
- Shows thank you modal

### 3. Data Flow

#### Booking Data Structure

```javascript
{
    villa_id: 123,
    booking_data: {
        check_in: "2025-01-15",
        check_out: "2025-01-20",
        guests: 2,
        total_price: 5000000,
        name: "John Doe",
        email: "john@example.com",
        phone: "+62812345678",
        raw_form_data: { /* all WPBS form fields */ }
    }
}
```

#### Order Meta Data

Each WooCommerce order stores:
- `_villa_id` - Villa post ID
- `_villa_name` - Villa title
- `_check_in_date` - Check-in date
- `_check_out_date` - Check-out date
- `_number_of_guests` - Guest count
- `_booking_type` - Always "villa"

## Configuration Options

### Customize Thank You Message

Edit `/assets/js/villa-booking-calendar.js` line 204:

```javascript
var message = 'Your custom thank you message here!';
```

### Customize Return URL

By default, users return to the villa page. To change this, edit `nirup_configure_midtrans_return_urls()` in functions.php.

### Payment Gateway Selection

The system checks for these Midtrans gateway IDs in order:
1. `midtrans_snap` (recommended)
2. `midtrans` (legacy)

If neither is found, it falls back to WooCommerce checkout URL.

## Troubleshooting

### White Screen Issue

**Symptom**: Clicking submit shows white screen

**Causes**:
1. JavaScript not loading
2. WPBS form not found
3. AJAX endpoint not responding

**Solution**:
1. Check browser console for errors
2. Verify jQuery is loaded
3. Check WordPress debug log
4. Ensure nonce is being passed correctly

### Payment URL Not Generated

**Symptom**: Error "Failed to generate payment URL"

**Causes**:
1. Midtrans plugin not active
2. Midtrans not configured
3. WooCommerce not active

**Solution**:
1. Verify Midtrans plugin is installed and activated
2. Check WooCommerce > Settings > Payments
3. Ensure Midtrans gateway is enabled
4. Verify API keys are correct

### Payment Not Completing

**Symptom**: Payment successful but order not updated

**Causes**:
1. Webhook not configured
2. Incorrect notification URL
3. Server blocking webhooks

**Solution**:
1. Configure Midtrans webhook URL
2. Check Midtrans dashboard for notification logs
3. Verify server allows incoming webhooks
4. Check WordPress error logs

### Thank You Modal Not Showing

**Symptom**: Payment successful but no confirmation

**Causes**:
1. Session storage not working
2. Return URL parameters missing
3. JavaScript not detecting return

**Solution**:
1. Check browser console for errors
2. Verify URL has payment status parameters
3. Test with different browser
4. Clear browser cache and cookies

## Security Considerations

1. **Nonce Verification**: All AJAX requests verify WordPress nonces
2. **Data Sanitization**: All input is sanitized before processing
3. **Order Validation**: Orders are verified before payment processing
4. **Webhook Authentication**: Midtrans webhooks should verify signatures

## Testing Checklist

- [ ] Villa booking form loads correctly
- [ ] Date selection works
- [ ] Form validation works (email required)
- [ ] Submit button shows "Processing..." state
- [ ] WooCommerce order is created
- [ ] Redirect to Midtrans occurs
- [ ] Payment page displays correctly
- [ ] Test payment completes
- [ ] Return to villa page works
- [ ] Thank you modal displays
- [ ] Order status updates to "Processing"
- [ ] Admin receives order notification email
- [ ] Customer receives confirmation email

## Production Deployment

1. Switch Midtrans to **Production Mode**
2. Update API keys to production keys
3. Test with real payment method
4. Monitor first few bookings closely
5. Set up order notification emails
6. Configure Midtrans webhook to production URL

## Support & Resources

- **Midtrans Documentation**: https://docs.midtrans.com
- **WooCommerce Docs**: https://woocommerce.com/documentation/
- **WPBS Documentation**: Check plugin documentation
- **WordPress AJAX**: https://codex.wordpress.org/AJAX_in_Plugins

## Future Enhancements

Potential improvements:
1. Add loading spinner during order creation
2. Store more booking details in order notes
3. Send custom confirmation emails with booking details
4. Add booking management dashboard
5. Implement booking cancellation
6. Add payment receipt download
7. Integrate with calendar blocking system

## License & Credits

- Implementation by Claude AI Assistant
- Uses WooCommerce, Midtrans, and WP Booking System
- Built for Nurip Island Resort website
