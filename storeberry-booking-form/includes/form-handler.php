<?php
/**
 * Storeberry Booking Form – AJAX handler.
 *
 * @package Storeberry_Booking_Form
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handles booking form AJAX submissions.
 */
class Storeberry_Booking_Form_Handler {

	const AJAX_ACTION  = 'storeberry_booking_form_submit';
	const NONCE_ACTION = 'storeberry_booking_form_nonce';

	/**
	 * Register AJAX hooks.
	 */
	public static function init() {
		add_action( 'wp_ajax_' . self::AJAX_ACTION, array( __CLASS__, 'handle_submit' ) );
		add_action( 'wp_ajax_nopriv_' . self::AJAX_ACTION, array( __CLASS__, 'handle_submit' ) );
	}

	/**
	 * Process form submission.
	 */
	public static function handle_submit() {
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), self::NONCE_ACTION ) ) {
			wp_send_json_error(
				array(
					'message' => esc_html__( 'Security check failed. Please refresh and try again.', 'storeberry-booking-form' ),
				),
				403
			);
		}

		$name         = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
		$email        = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
		$country_code = isset( $_POST['country_code'] ) ? sanitize_text_field( wp_unslash( $_POST['country_code'] ) ) : '';
		$phone        = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
		$page_url     = isset( $_POST['page_url'] ) ? esc_url_raw( wp_unslash( $_POST['page_url'] ) ) : '';

		$recipient         = isset( $_POST['recipient'] ) ? sanitize_email( wp_unslash( $_POST['recipient'] ) ) : '';
		$subject           = isset( $_POST['subject'] ) ? sanitize_text_field( wp_unslash( $_POST['subject'] ) ) : '';
		$success_message   = isset( $_POST['success_message'] ) ? sanitize_text_field( wp_unslash( $_POST['success_message'] ) ) : '';
		$error_message     = isset( $_POST['error_message'] ) ? sanitize_text_field( wp_unslash( $_POST['error_message'] ) ) : '';
		$required_message  = isset( $_POST['required_message'] ) ? sanitize_text_field( wp_unslash( $_POST['required_message'] ) ) : '';

		$name_required  = ! empty( $_POST['name_required'] ) && '1' === $_POST['name_required'];
		$email_required = ! empty( $_POST['email_required'] ) && '1' === $_POST['email_required'];
		$phone_required = ! empty( $_POST['phone_required'] ) && '1' === $_POST['phone_required'];

		if ( empty( $required_message ) ) {
			$required_message = esc_html__( 'Please fill in all required fields.', 'storeberry-booking-form' );
		}

		if ( empty( $error_message ) ) {
			$error_message = esc_html__( 'Something went wrong. Please try again.', 'storeberry-booking-form' );
		}

		if ( empty( $success_message ) ) {
			$success_message = esc_html__( 'Thank you. Your submission has been sent.', 'storeberry-booking-form' );
		}

		if ( $name_required && '' === $name ) {
			wp_send_json_error( array( 'message' => $required_message ), 400 );
		}

		if ( $email_required && ( '' === $email || ! is_email( $email ) ) ) {
			wp_send_json_error( array( 'message' => $required_message ), 400 );
		}

		if ( '' !== $email && ! is_email( $email ) ) {
			wp_send_json_error( array( 'message' => $required_message ), 400 );
		}

		if ( $phone_required && '' === $phone ) {
			wp_send_json_error( array( 'message' => $required_message ), 400 );
		}

		if ( empty( $recipient ) || ! is_email( $recipient ) ) {
			$recipient = get_option( 'admin_email' );
		}

		if ( empty( $subject ) ) {
			$subject = esc_html__( 'New Storeberry Booking Form Submission', 'storeberry-booking-form' );
		}

		$country_code = self::sanitize_country_code( $country_code );

		$submitted_at = wp_date( 'Y-m-d H:i:s' );

		$body_lines = array(
			__( 'Name:', 'storeberry-booking-form' ) . ' ' . $name,
			__( 'Email:', 'storeberry-booking-form' ) . ' ' . $email,
			__( 'Country Code:', 'storeberry-booking-form' ) . ' ' . $country_code,
			__( 'Phone Number:', 'storeberry-booking-form' ) . ' ' . $phone,
			__( 'Page URL:', 'storeberry-booking-form' ) . ' ' . $page_url,
			__( 'Submission Date:', 'storeberry-booking-form' ) . ' ' . $submitted_at,
		);

		$headers = array( 'Content-Type: text/plain; charset=UTF-8' );

		if ( is_email( $email ) ) {
			$headers[] = 'Reply-To: ' . $name . ' <' . $email . '>';
		}

		$sent = wp_mail(
			$recipient,
			$subject,
			implode( "\n", $body_lines ),
			$headers
		);

		if ( ! $sent ) {
			wp_send_json_error( array( 'message' => $error_message ), 500 );
		}

		wp_send_json_success( array( 'message' => $success_message ) );
	}

	/**
	 * Sanitize country code value.
	 *
	 * @param string $code Raw country code.
	 * @return string
	 */
	private static function sanitize_country_code( $code ) {
		$code = trim( $code );
		if ( preg_match( '/^\+[0-9]{1,4}$/', $code ) ) {
			return $code;
		}
		return '';
	}
}
