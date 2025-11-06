# Brevo Newsletter Integration Setup

The theme now integrates with Brevo (formerly Sendinblue) for newsletter subscriptions through the footer form.

## Setup Options

### Option 1: Using wp-config.php (Recommended for Security)

Add these constants to your `wp-config.php` file:

```php
// Brevo API Configuration
define('NIRUP_BREVO_API_KEY', 'your-brevo-api-key-here');
define('NIRUP_BREVO_LIST_ID', 'your-list-id-here');
```

### Option 2: Using WordPress Customizer

1. Go to WordPress Admin → Appearance → Customize
2. Navigate to the "Footer Settings" section
3. Enter your Brevo API Key (starts with `xkeysib-`)
4. Enter your Brevo List ID (e.g., `6`)
5. Click "Publish" to save

## How It Works

When a visitor subscribes to your newsletter:
1. The email is validated
2. The subscriber is added to your Brevo list via API
3. The email is also stored locally in WordPress as a backup
4. The user receives a confirmation message

## Troubleshooting

If subscriptions aren't working:
1. Check that your API key is correct
2. Verify the List ID exists in your Brevo account
3. Check WordPress error logs for API errors
4. Test the API key in your Brevo dashboard

## Where to Find Your Credentials

- **API Key**: Brevo Dashboard → Settings → SMTP & API → API Keys
- **List ID**: Brevo Dashboard → Contacts → Lists (the number in the URL or list details)
