var tribe = tribe || {};
tribe.admin = tribe.admin || {};
tribe.admin.header = tribe.admin.header || {};

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
	obj.selectors = {};

	/**
	 *
	 * @since TBD
	 *
	 * @return {void}
	 */
	obj.setup = function () {
		$('.tooltip').tooltipster();
	};



	$( obj.setup );

} )( jQuery, tribe.admin.header );
