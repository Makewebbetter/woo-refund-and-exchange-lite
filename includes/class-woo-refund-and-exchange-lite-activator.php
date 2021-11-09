<?php
/**
 * Fired during plugin activation
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    woo-refund-and-exchange-lite
 * @subpackage woo-refund-and-exchange-lite/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    woo-refund-and-exchange-lite
 * @subpackage woo-refund-and-exchange-lite/includes
 */
class Woo_Refund_And_Exchange_Lite_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @param array $network_wide .
	 * @since    1.0.0
	 */
	public static function woo_refund_and_exchange_lite_activate( $network_wide ) {
		global $wpdb;
		// Check if the plugin has been activated on the network.
		if ( is_multisite() && $network_wide ) {
			// Get all blogs in the network and activate plugins on each one.
			$blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
			foreach ( $blog_ids as $blog_id ) {
				switch_to_blog( $blog_id );
				self::mwb_rma_create_pages();
				// Schedule event to send data to makewebbetter.
				wp_clear_scheduled_hook( 'makewebbetter_tracker_send_event' );
				wp_schedule_event( time() + 10, apply_filters( 'makewebbetter_tracker_event_recurrence', 'daily' ), 'makewebbetter_tracker_send_event' );
				restore_current_blog();
			}
		} else {
			// Activated on a single site, in a multi-site or on a single site.
			self::mwb_rma_create_pages();
			// Schedule event to send data to makewebbetter.
			wp_clear_scheduled_hook( 'makewebbetter_tracker_send_event' );
			wp_schedule_event( time() + 10, apply_filters( 'makewebbetter_tracker_event_recurrence', 'daily' ), 'makewebbetter_tracker_send_event' );
		}
	}

	/**
	 * Creates a translation of a post (to be used with WPML) && pages
	 **/
	public static function mwb_rma_create_pages() {
		$timestamp = get_option( 'mwb_rma_activated_timestamp', 'not_set' );

		if ( 'not_set' === $timestamp ) {

			$current_time = current_time( 'timestamp' );

			$thirty_days = strtotime( '+30 days', $current_time );

			update_option( 'mwb_rma_activated_timestamp', $thirty_days );
		}

		// Pages will create.
		$email                       = get_option( 'admin_email', false );
		$admin                       = get_user_by( 'email', $email );
		$admin_id                    = $admin->ID;
		$mwb_rma_return_request_form = array(
			'post_author' => $admin_id,
			'post_name'   => 'refund-request-form',
			'post_title'  => 'Refund Request Form',
			'post_type'   => 'page',
			'post_status' => 'publish',

		);

		$page_id = wp_insert_post( $mwb_rma_return_request_form );

		if ( $page_id ) {
			update_option( 'mwb_rma_return_request_form_page_id', $page_id );
			self::mwb_rma_wpml_translate_post( $page_id ); // Insert Translated Pages.
		}

		$mwb_rma_view_order_msg_form = array(
			'post_author' => $admin_id,
			'post_name'   => 'view-order-msg',
			'post_title'  => 'View Order Messages',
			'post_type'   => 'page',
			'post_status' => 'publish',

		);

		$page_id = wp_insert_post( $mwb_rma_view_order_msg_form );

		if ( $page_id ) {
			update_option( 'mwb_rma_view_order_msg_page_id', $page_id );
			self::mwb_rma_wpml_translate_post( $page_id ); // Insert Translated Pages.
		}
	}

	/**
	 * Creates a translation of a post (to be used with WPML)
	 *
	 * @param int $page_id The ID of the post to be translated.
	 **/
	public static function mwb_rma_wpml_translate_post( $page_id ) {
		if ( has_filter( 'wpml_object_id' ) ) {
			// If the translated page doesn't exist, now create it.
			do_action( 'wpml_admin_make_post_duplicates', $page_id );
		}
	}
}
