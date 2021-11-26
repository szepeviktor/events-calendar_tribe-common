<?php

namespace Tribe\Service_Providers;

/**
 * Class Tribe\Service_Providers\Admin_Header
 *
 * @since TBD
 *
 * Handles the registration and creation of our async process handlers.
 */
class Admin_Header extends \tad_DI52_ServiceProvider {

	/**
	 * Binds and sets up implementations.
	 *
	 * @since TBD
	 */
	public function register() {
		// tribe_singleton( 'admin_bar.view', '\Tribe\Tooltip\View' );

		$this->hooks();
	}

	/**
	 * Setup hooks for classes.
	 *
	 * @since TBD
	 */
	private function hooks() {
		add_action( 'tribe_common_loaded', [ $this, 'add_admin_bar_assets' ] );
		add_action( 'in_admin_header', [ $this, 'embed_page_header' ] );
		//add_action( 'all_admin_notices', [ $this, 'embed_page_header' ] );
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function embed_page_header() {

		$admin_helpers = tribe( 'admin.helpers' );

		// Only display custom text on Tribe Admin Pages.
		if ( ! $admin_helpers->is_screen() || ! $admin_helpers->is_post_type_screen() ) {
			return;
		}

		/** @var \Tribe__Admin__Views $view */
		$view = tribe( 'admin.views' );

		$context = [
			'notifications' => tribe( 'admin.notifications' )->get_notifications_ordered(),
		];

		// Enqueue assets.
		tribe_asset_enqueue_group( 'tribe-tooltip' );
		tribe_asset_enqueue_group( 'tribe-admin-header' );
		tribe_asset_enqueue_group( 'tribe-admin' );

		$view->template( 'admin-header', $context );
	}

	/**
	 * Register assets associated with tooltip
	 *
	 * @since TBD
	 */
	public function add_admin_bar_assets() {

		$main = \Tribe__Main::instance();

		tribe_asset(
			$main,
			'tribe-admin-header',
			'admin/header.js',
			[
				'jquery',
				'tribe-common',
				'tribe-tooltipster',
				'tribe-admin-manager',
			],
			'wp_enqueue_scripts',
			[
				'groups' => 'tribe-admin-header',
			]
		);

		return;

		tribe_asset(
			$main,
			'tribe-tooltip',
			'tooltip.css',
			[ 'tribe-common-skeleton-style' ],
			[ 'wp_register_style', 'admin_enqueue_scripts' ],
			[ 'groups' => 'tribe-tooltip' ]
		);

		tribe_asset(
			$main,
			'tribe-tooltip-js',
			'tooltip.js',
			[
				'jquery',
				'tribe-common'
			],
			[
				'wp_register_script',
				'admin_enqueue_scripts',
			],
			[
				'groups' => 'tribe-tooltip'
			]
		);
	}
}
