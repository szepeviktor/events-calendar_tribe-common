<?php
/**
 * Class Tribe__Admin__Views
 *
 * @since TBD
 */
class Tribe__Admin__Views extends Tribe__Template {
	/**
	 * Building of the Class template configuration
	 *
	 * @since TBD
	 */
	public function __construct() {
		$this->set_template_origin( Tribe__Main::instance() );
		$this->set_template_folder( 'src/admin-views' );

		// Configures this templating class extract variables
		$this->set_template_context_extract( true );
	}
}