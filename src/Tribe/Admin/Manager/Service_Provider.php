<?php
namespace Tribe\Admin\Manager;

use tad_DI52_ServiceProvider;

/**
 * Class Manager
 *
 * @package Tribe\Admin\Manager
 *
 * @since   TBD
 */
class Service_Provider extends tad_DI52_ServiceProvider {
	/**
	 * Register the provider singletons.
	 *
	 * @since TBD
	 */
	public function register() {
		$this->container->singleton( 'admin.manager', self::class );

		$this->hooks();
	}

	/**
	 * Add actions and filters.
	 *
	 * @since TBD
	 */
	protected function hooks() {
		if ( ! is_admin() ) {
			return;
		}

		// Assets.
		add_action( 'tribe_common_loaded', [ $this, 'assets' ] );

		// Handle AJAX.
		add_action( 'wp_ajax_nopriv_tribe_admin_manager', [ $this, 'ajax_handle_admin_manager' ] );
		add_action( 'wp_ajax_tribe_admin_manager', [ $this, 'ajax_handle_admin_manager' ] );
	}

	/**
	 * Register assets associated with tooltip
	 *
	 * @since TBD
	 */
	public function assets() {
		$main = \Tribe__Main::instance();

		$admin_manager_js_data = [
			'tribeAdminManagerNonce' => wp_create_nonce( 'tribe_admin_manager_nonce' ),
			'ajaxurl'                => admin_url( 'admin-ajax.php', ( is_ssl() ? 'https' : 'http' ) ),
		];

		tribe_asset(
			$main,
			'tribe-admin-manager',
			'admin/manager.js',
			[
				'jquery',
				'tribe-common',
			],
			null,
			[
				'localize' => [
					[
						'name' => 'TribeAdminManager',
						'data' => $admin_manager_js_data,
					],
				],
				'groups'   => [
					'tribe-admin',
				],
			]
		);

	}

	/**
	 * Handle AJAX response.
	 *
	 * @since TBD
	 */
	public function ajax_handle_admin_manager() {
		// @todo Look at adding capability checks of some sort based on a filter that provides capability context for the specific request.
		$response = [
			'html' => '',
		];

		if ( ! check_ajax_referer( 'tribe_admin_manager_nonce', 'nonce', false ) ) {
			$response['html'] = $this->render_error( __( 'Insecure request.', 'tribe-common' ) );

			wp_send_json_error( $response );
		}

		/*
		 * Get the request vars.
		 *
		 * Note to future developers: Using tribe_get_request_vars() here was removing non-string values (like arrays).
		 */
		$vars = $_REQUEST;

		/**
		 * Filter the admin manager request.
		 *
		 * @since TBD
		 *
		 * @param string|\WP_Error $render_response The render response HTML content or WP_Error with list of errors.
		 * @param array            $vars            The request variables.
		 */
		$render_response = apply_filters( 'tribe_admin_manager_request', '', $vars );

		if ( is_string( $render_response ) && '' !== $render_response ) {
			// Return the HTML if it's a string.
			$response['html'] = $render_response;

			wp_send_json_success( $response );
		} elseif ( is_wp_error( $render_response ) ) {
			$response['html'] = $this->render_error( $render_response->get_error_messages() );

			wp_send_json_error( $response );
		}

		$response['html'] = $this->render_error( __( 'Something happened here.', 'tribe-common' ) );

		wp_send_json_error( $response );
	}

	/**
	 * Handle error rendering.
	 *
	 * @since TBD
	 *
	 * @param string|array $error_message The error message(s).
	 *
	 * @return string The error template HTML.
	 */
	public function render_error( $error_message ) {
		if ( is_array( $error_message ) ) {
			$error_message = implode( '<br>', $error_message );
		}

		return $error_message;
	}
}
