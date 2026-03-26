<?php
/**
 * Class EmailRestrictionHandler
 * Prevent duplicate email submissions in Elementor Pro forms.
 */
class EmailRestrictionHandler {

	private $wpdb;
	private $table_prefix;
	private $target_form_names;
	private $submissions_table;
	private $values_table;

	public function __construct( $target_form_names ) {
		global $wpdb;

		$this->wpdb              = $wpdb;
		$this->table_prefix      = $wpdb->prefix;
		// Convert target form names to lowercase to prevent case-mismatch bugs
		$this->target_form_names = array_map( 'strtolower', $target_form_names );
		$this->submissions_table = $this->table_prefix . 'e_submissions';
		$this->values_table      = $this->table_prefix . 'e_submissions_values';

		// Register the validate_email method.
		add_action( 'elementor_pro/forms/validation/email', array( $this, 'validate_email' ), 10, 3 );
	}

	private function get_submitted_emails( $form_name, $field_id ) {
		// 1. Get all submission IDs for this specific form
		$form_submission_ids = $this->wpdb->get_col(
			$this->wpdb->prepare(
				"SELECT id FROM {$this->submissions_table} WHERE form_name = %s",
				$form_name
			)
		);

		if ( empty( $form_submission_ids ) ) {
			return array();
		}

		// 2. Build placeholders dynamically for the IN() clause
		$placeholders = implode( ',', array_fill( 0, count( $form_submission_ids ), '%d' ) );

		// 3. Prepare the array of arguments: the exact field_id first, followed by all submission IDs
		$query_args = array_merge( array( $field_id ), $form_submission_ids );

		// 4. Retrieve all previous values tied to this specific field ID
		$emails = $this->wpdb->get_col(
			$this->wpdb->prepare(
				"SELECT value FROM {$this->values_table} WHERE `key` = %s AND submission_id IN ($placeholders)",
				$query_args
			)
		);

		// Convert all historical emails to lowercase for comparison
		return array_map( 'strtolower', $emails );
	}

	public function validate_email( $field, $record, $ajax_handler ) {
		$form_name = $record->get_form_settings( 'form_name' );

		// Ensure the form name matches (case-insensitive)
		if ( ! in_array( strtolower( $form_name ), $this->target_form_names ) ) {
			return;
		}

		// Pass the exact Field ID into our DB query instead of a hardcoded string
		$invalid_emails = $this->get_submitted_emails( $form_name, $field['id'] );

		// Make the current submission lowercase
		$current_email = strtolower( $field['value'] );

		// Check if it already exists in the database
		if ( in_array( $current_email, $invalid_emails ) ) {
			$ajax_handler->add_error( $field['id'], 'You have already submitted with this email!' );
		}
	}
}

// ==================== USAGE ====================
// Replace 'newsletter' with the exact Form Name from your Elementor Editor.
// You can add this code to your child theme's functions.php or a custom snippets plugin.
$email_restriction_handler = new EmailRestrictionHandler( array( 'newsletter' ) );