# Elementor Pro Unique Email Validator
# Elementor Unique Email Validator

[![PHP Version](https://img.shields.io/badge/PHP-%3E%3D7.4-brightgreen)](https://www.php.net/)
[![WordPress Tested](https://img.shields.io/badge/WordPress-Tested-blue)](https://wordpress.org/)
[![License](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)

A lightweight WordPress plugin that prevents duplicate email submissions in Elementor forms. Ideal for membership sites, event registrations, and any form where you need to ensure every email address is unique.

---

## Key Features

- Prevents duplicate emails on Elementor form submissions
- Lightweight and easy to install
- Works out-of-the-box with standard Elementor forms
- Clean and minimal code for easy maintenance

## Why use this

Duplicate email submissions can lead to multiple unwanted registrations, spam entries, or data integrity issues. This plugin ensures each email address is only accepted once, improving data quality and user experience.

## Installation

1. Download or clone this repository.
2. Copy the plugin folder to your WordPress `wp-content/plugins/` directory.
3. Activate the plugin from the WordPress admin Plugins screen.
4. Use your Elementor form as usual — the plugin will automatically validate email uniqueness on submission.

## Usage

- No additional configuration is required for basic usage.
- If you need customization (for example: whitelist domains or integrate with external user DBs), edit `elementor-email-restriction.php` or extend the plugin via hooks.

Example: Show a custom message when an email already exists

```php
// Hook into plugin filter/action (if available) to customize messages
add_filter('elementor_unique_email_validator_message', function($message){
      return 'This email is already registered. If you forgot your password, use the reset option.';
});
```

## Screenshots

1. Elementor form with validation message (placeholder)

> Tip: Add a screenshot named `screenshot-1.png` to the plugin root to show on WordPress.org.

## Frequently Asked Questions

- **Will this block existing WordPress users?**
   No — by default the plugin checks submissions against previously recorded form entries. If you want it to check against WP users, we can add an option for that.

- **Does it support custom form fields?**
   The plugin checks the email field in Elementor forms by default; custom integrations are possible.

## Development

Contributions are welcome. To run locally:

1. Install a local WordPress environment (LocalWP, XAMPP, MAMP).
2. Activate the plugin in `wp-admin`.
3. Modify `elementor-email-restriction.php` and test with an Elementor form.

## Support

Open an issue on GitHub with details and steps to reproduce and we'll help as soon as possible.

## License

This project is licensed under the MIT License. See the `LICENSE` file for details.

---

Made with ❤️ — If you'd like, I can add a screenshot, badges, or a short demo GIF next.

A lightweight PHP and CSS solution to prevent users from submitting the same email address multiple times in specific Elementor Pro forms. 

## Features
* **Database Verification:** Checks the native Elementor submissions database (`e_submissions_values`) to see if the email already exists for a specific form.
* **Case-Insensitive:** Prevents bypasses by converting all inputs (e.g., `User@email.com` vs `user@email.com`) to lowercase before checking.
* **Dynamic Field Support:** Automatically fetches the correct Field ID dynamically, rather than relying on hardcoded keys.
* **Layout Shift Prevention:** Includes custom CSS to absolutely position the inline validation error, preventing the form container from stretching or breaking its layout.

## How to Use

### 1. PHP Installation
1. Copy the code from `elementor-email-restriction.php`.
2. Paste it into your WordPress child theme's `functions.php` file, or use a plugin like *Code Snippets*.
3. At the bottom of the script, change `'newsletter'` to the exact **Form Name** of your Elementor form.
   ```php
   $email_restriction_handler = new EmailRestrictionHandler( array( 'your_form_name_here' ) );
2. Elementor Form Settings
For this script to work, ensure the following settings are configured in your Elementor Form widget:

The field you are checking must have its Type set to Email.

Under Actions After Submit, you must have Collect Submissions turned ON.

3. CSS Layout Fix (Optional but Recommended)
If the custom error message breaks your form's layout by pushing elements around:

Copy the code from style.css.

Go to your Elementor Form widget > Advanced > Custom CSS and paste the code.

This will absolute-position the error message so it floats perfectly beneath the input field.

Requirements
WordPress

Elementor Pro (Requires the native Submissions feature enabled)


---

### How to upload this to GitHub quickly:
1. Go to your GitHub account and click **New Repository**.
2. Name it something like `elementor-unique-email-validator`.
3. Check the box that says **"Add a README file"**, then click **Create Repository**.
4. Click the **"Add file"** button > **"Create new file"**.
5. Name the first file `elementor-email-restriction.php`, paste the PHP code, and click **Commit changes**.
6. Repeat step 4 and 5 for the `style.css` file.
7. Finally, click the pencil icon next to your `README.md` file, replace whatever is there with the Markdown code above, and click **Commit changes**.

Would you like me to add comments to the PHP code explaining how a developer could e