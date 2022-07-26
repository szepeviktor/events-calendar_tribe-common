<?php

namespace Tribe\Admin;

/**
 * Admin Settings class.
 * 
 * @since TBD
 */

class Settings {

    static $image_field_assets_loaded = false;

    /**
     * Loaded image field assets if not already loaded.
     *
     * @return void
     */
    public function maybe_load_image_field_assets() {
        if ( $this->image_field_assets_loaded ) {
            return;
        }

        tribe_asset_enqueue( 'tribe-admin-image-field' );
        wp_enqueue_media();

        $this->image_field_assets_loaded = true;
    }
    
}