var tribe = tribe || {};
tribe.admin = tribe.admin || {};
tribe.admin.header = tribe.admin.header || {};

// @TODO: We need to move anything notification related to admin/notifications.js

( function ( $, obj ) {
	'use strict';

	var $document = $( document );


	/**
	 * Object containing the relevant selectors
	 *
	 * @since TBD
	 *
	 * @return {Object}
	 */
	obj.selectors = {
		container: '.tribe-admin__layout',
		notificationContainer: '.tribe-admin__header-sidebar-notification',
		markReadButton: '.tribe-admin__header-sidebar-notification-mark-as-read',
	};

	/**
	 * Binds
	 *
	 * @since TBD
	 *
	 * @param {jQuery}  $container jQuery object of object of the container.
	 *
	 * @return {void}
	 */
	obj.bindMarkReadButton = function( $container ) {
		const $markReadButton = $container.find( obj.selectors.markReadButton );

		$markReadButton.each( function( index, button ) {
			$( button ).on( 'click', function() {
				const data = {
					action: 'tribe_admin_manager',
					//ticket_id: rsvpId,
					request: 'tribe_admin_notification_mark_read',
					notification_id: $( this ).data( 'notification-id' ),
				};

				tribe.admin.manager.request(
					data,
					$( this ).parent( obj.selectors.notificationContainer )
				);
			} );
		} );

	};

	/**
	 * Binds events for container.
	 *
	 * @since TBD
	 *
	 * @param {jQuery}  $container jQuery object of object of the container.
	 *
	 * @return {void}
	 */
	obj.bindEvents = function( $container ) {
		obj.bindMarkReadButton( $container );
	};

	/**
	 * Saves all the containers in the page into the object.
	 *
	 * @since 5.0.0
	 *
	 * @return {void}
	 */
	obj.selectContainers = function() {
		obj.$containers = $( obj.selectors.container );
	};

	/**
	 *
	 * @since TBD
	 *
	 * @return {void}
	 */
	obj.setup = function( index, container ) {
		const $container = $( container );

		$('.tooltip').tooltipster();
		obj.bindEvents( $container );
	};

	/**
	 * Handles the initialization of the manager when Document is ready.
	 *
	 * @since 5.0.0
	 *
	 * @return {void}
	 */
	obj.ready = function() {
		obj.selectContainers();
		obj.$containers.each( obj.setup );
	};

	$( obj.ready );

} )( jQuery, tribe.admin.header );
