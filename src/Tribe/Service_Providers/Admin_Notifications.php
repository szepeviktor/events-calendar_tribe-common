<?php

namespace Tribe\Service_Providers;

/**
 * Class Tribe\Service_Providers\Admin_Notifications
 *
 * @since TBD
 *
 * Handles the registration and creation of our async process handlers.
 */
class Admin_Notifications extends \tad_DI52_ServiceProvider {

	/**
	 * Binds and sets up implementations.
	 *
	 * @since TBD
	 */
	public function register() {
		if ( ! is_admin() ) {
			return;
		}

		tribe_singleton( 'admin.notifications', '\Tribe\Admin\Notifications' );

		$this->hooks();
	}

	/**
	 * Setup hooks for classes.
	 *
	 * @since TBD
	 */
	private function hooks() {
		//add_action( 'tribe_common_loaded', [ $this, 'add_admin_bar_assets' ] );
		//add_action( 'in_admin_header', [ $this, 'embed_page_header' ] );
	}

}
