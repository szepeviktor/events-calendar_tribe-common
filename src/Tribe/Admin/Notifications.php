<?php
namespace Tribe\Admin;

use Tribe__Utils__Array as Arr;
use WP_Error;

/**
 * Class
 *
 * @since TBD
 */
class Notifications {

	protected $option_name = 'tec_admin_notifications';

	/**
	 *** Must have
	 * - ID
	 * - Sender (core, plugin, theme, user)
	 * - Destination (sites, roles, users)
	 * - Timestamp
	 * - Read status (read/unread)
	 * - Page (where it should be displayed)
	 * - Message body
	 * - Links in the message body
	 * - Dropdown to contain the feed
	 *
	 *** Should have
	 * - Notification type/category icon/color
	 * - Settings page
	 * - Multiple channels (email, push, slack etc)
	 * - Sent status for all different delivery methods
	 * - Multisite support
	 *
	 *** Could have
	 * - Basic markup (bold, italic etc)
	 * - Expiry date
	 * - Filters for specific topics
	 * - Settings to hide certain notification (types) away from certain user roles (don’t bother clients with upgrade notices and whatnot)
	 * - Ability to group notifications per day
	 * - Dedicated action buttons
	 *
	 * TODO
	 *
	 * - order by date
	 */

	/**
	 * Get notifications.
	 *
	 * @since TBD
	 *
	 * @return array The notifications.
	 */
	public function get_notifications() {
		// @todo: maybe add filter.
		$notifications = tribe_get_option( $this->option_name, [] );
		//return $notifications;
		//usort( $notifications, [ $this, 'sort_by_time_asc' ] );
		return $notifications;
	}

	/**
	 * Add notification.
	 *
	 * @since TBD
	 *
	 * @param array $notification The array with the notification information.
	 * @return void
	 */
	public function add_notification( $notification = [], $notifications = [] ) {
		// Bail if empty.
		if ( empty( $notification ) || empty( $notification['id'] ) ) {
			return;
		}

		if ( empty( $notifications ) ) {
			$notifications = $this->get_notifications();
		}

		// Bail if it exists already. Or update? :thinking:
		if ( $this->notification_exist( $notifications, $notification['id'] ) ) {
			return;
		}

		$notification = wp_parse_args( $notification, $this->get_notification_defaults() );

		// Add it to the notifications.
		$notifications[ $notification['id'] ] = $notification;

		tribe_update_option( $this->option_name, $notifications );

		return $notification;
	}

	/**
	 * Check if the notification exists
	 *
	 * @since TBD
	 *
	 * @param array  $notifications The array with the notifications.
	 * @param string $notification_id The notification ID we want to check.
	 * @return void
	 */
	public function notification_exist( $notifications = [], $notification_id = '' ) {
		if ( empty( $notifications ) || empty( $notification_id ) ) {
			return;
		}

		return isset( $notifications[ $notification_id ] );
	}

	/**
	 * Remove notification.
	 *
	 * @since TBD
	 *
	 * @param string $notification_id The notification ID.
	 */
	public function remove_notification( $notification_id = '', $notifications = [] ) {
		// Bail if empty.
		if ( empty( $notification_id ) ) {
			return;
		}

		if ( empty( $notifications ) ) {
			$notifications = $this->get_notifications();
		}

		// Bail if it doesn't exist.
		if ( ! $this->notification_exist( $notifications, $notification_id ) ) {
			return;
		}

		// Remove it from the notifications.
		unset( $notifications[ $notification_id ] );

		$this->save_notifications( $notifications );

		return $notification;
	}

	/**
	 * Get a specific notification.
	 *
	 * @since TBD
	 *
	 * @param string $notification_id The notification ID we want to get.
	 *
	 * @return bool|array False if it doesn't exist. The notification array with the info.
	 */
	public function get_notification( $notification_id = '', $notifications = [] ) {
		// Get the notifications.
		if ( empty( $notifications ) ) {
			$notifications = $this->get_notifications();
		}

		// Bail if it doesn't exist.
		if ( ! $this->notification_exist( $notifications, $notification_id ) ) {
			return;
		}

		return $notifications[ $notification_id ];
	}

	private function save_notifications( $notifications = [] ) {
		tribe_update_option( $this->option_name, $notifications );
	}

	/**
	 * Get the default notification values.
	 *
	 * @since TBD
	 *
	 * @return array The default notification values.
	 */
	public function get_notifications_ordered( $order = 'asc' ) {
		$notifications = $this->get_notifications();

		//usort( $notifications, [ $this, "sort_by_time_{ $order }"] );

		usort( $notifications, function( $a, $b ) {
			return ( $a['date'] > $b['date'] ) ? -1 : 1;
		} );

		return $notifications;
	}

	/**
	 * Sort the notifications by time.
	 *
	 * @since TBD
	 *
	 * @param array $a The first notification.
	 * @param array $b The second notification.
	 *
	 * @return int
	 */
	public function sort_by_time_asc( $a = [], $b = [] ) {
		if ( empty( $a['date'] ) || empty( $b['date'] ) ) {
			return 0;
		}

		return $a['date'] - $b['date'];
	}

	/**
	 * Sort the notifications by time descending.
	 *
	 * @return int
	 */
	public function sort_by_time_desc( $a = [], $b = [] ) {
		if ( empty( $a['date'] ) || empty( $b['date'] ) ) {
			return 0;
		}

		return $b['date'] - $a['date'];
	}

	/**
	 * The notification defaults.
	 *
	 * @since TBD
	 *
	 * @return array The notification defaults.
	 */
	private function get_notification_defaults() {
		$defaults = [
			'title'     => '',
			'content'   => '',
			'read'      => false,
			'expire'    => false,
			'date'      => time(),
			'page'      => '',
			'link'      => [
				'url'      => '',
				'readmore' => __( 'Read more', 'tribe-common' ),
				'target'   => '',
			],
			'category'  => [],
		];

		/**
		 * The notification defaults.
		 *
		 * @since TBD
		 *
		 * @param array $defaults Array with the notification defaults.
		 */
		return apply_filters( 'tec_admin_notification_defaults', $defaults );
	}

	/**
	 * Get an array of unread notifications
	 *
	 * @return array $unread The array of unread notifications.
	 */
	public function get_notifications_unread( $notifications = [] ) {

		if ( empty( $notifications ) ) {
			$notifications = $this->get_notifications();
		}

		$unread = [];
		foreach ( $notifications as $id => $n ) {

			if ( empty( $n['read'] ) ) {
				$unread[ $id ] = $n;
			}
		}

		return $unread;
	}

	/**
	 * Mark a notification as read.
	 *
	 * @since TBD.
	 *
	 * @param string $notification_id The notification ID.
	 * @param array $notifications The array of notifications, optional.
	 *
	 * @return void
	 */
	public function mark_as_read( $notification_id = '', $notifications = [] ) {

		if ( empty( $notification_id ) ) {
			return;
		}

		if ( empty( $notifications ) ) {
			$notifications = $this->get_notifications();
		}

		// Bail if it doesn't exist.
		if ( ! $this->notification_exist( $notifications, $notification_id ) ) {
			return;
		}

		$notifications[ $notification_id ]['read'] = true;

		$this->save_notifications( $notifications );
	}

	public function mark_all_as_read() {
		// get_notifications()
		// mark_as_read()
	}

	/**
	 * Filters the admin manager request to handle notification actions.
	 *
	 * @since TBD
	 *
	 * @param string|\WP_Error $render_response The render response HTML content or WP_Error with list of errors.
	 * @param array            $vars            The request variables.
	 *
	 * @return string $html The response with the HTML of the form, depending on the call.
	 */
	public function filter_admin_manager_request( $render_response, $vars ) {
		$html = '';


		if ( 'tribe_admin_notification_mark_read' === Arr::get( $vars, 'request', '' ) ) {

			$notification_id = Arr::get( $vars, 'notification_id', '' );
			$view            = tribe( 'admin.views' );
			$notification    = $this->get_notification( $notification_id );

			$this->mark_as_read( $notification_id );

			$html = $view->template(
				'admin-header/sidebar/notifications/notification',
				[ 'notification' => $notification ],
				false
			);
		}

		return $html;
	}
}