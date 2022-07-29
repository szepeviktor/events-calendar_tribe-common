<?php

namespace Tribe\Admin;

/**
 * Admin Settings class.
 * 
 * @since TBD
 */

class Settings {

    /**
     * Loaded image field assets if not already loaded.
     * 
     * @since TBD
     *
     * @return void
     */
    public function maybe_load_image_field_assets() {
        if ( has_filter( 'tribe_admin_load_image_fields_assets', '__return_true' ) ) {
            return;
        }
        add_filter( 'tribe_admin_load_image_fields_assets', '__return_true' );
    }

    /**
     * Logic to load image field assets.
     * 
     * @since TBD
     *
     * @return bool
     */
    public function should_load_image_field_assets() {
        $load_assets = apply_filters( 'tribe_admin_load_image_fields_assets', false );
        if ( $load_assets ) {
            wp_enqueue_media();
        }
        return $load_assets;
    }
    
}