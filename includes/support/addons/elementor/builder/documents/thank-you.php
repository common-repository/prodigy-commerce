<?php
namespace Prodigy\Includes\Support\Addons\Elementor\Builder\Documents;

use ElementorPro\Modules\ThemeBuilder\Documents\Archive;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class ThankYou extends Archive {

    public function get_name() {
        return 'thank-prodigy';
    }

    public static function get_type() {
        return 'thank-prodigy';
    }

    public static function get_class_full_name() {
        return get_called_class();
    }

    public static function get_properties() {
        $properties = parent::get_properties();

        $properties['location']       = 'thank';
        $properties['condition_type'] = 'prodigy_thank';

        return $properties;
    }

    protected static function get_site_editor_type() {
        return 'thank-prodigy';
    }

    public static function get_title() {
        return __( 'Prodigy Thank You' );
    }

    public static function get_plural_title() {
        return __( 'Prodigy Thank You' );
    }

    protected static function get_site_editor_icon() {
        return 'eicon-products';
    }

    /**
     * Fix for thumbnail name that is different from editor type.
     *
     * @return string
     */
    protected static function get_site_editor_thumbnail_url() {
        return ELEMENTOR_ASSETS_URL . 'images/app/site-editor/products.svg';
    }

    protected static function get_site_editor_tooltip_data() {
        return array(

        );
    }

    public function get_container_attributes() {
        $attributes           = parent::get_container_attributes();
        $attributes['class'] .= ' thank';

        return $attributes;
    }


    public function __construct( array $data = array() ) {
        parent::__construct( $data );
    }

    protected function register_controls() {
        parent::register_controls();

        $this->update_control(
            'preview_type',
            array(
                'default' => 'post_type_thank/product',
            )
        );
    }

    protected function get_remote_library_config() {
        $config             = parent::get_remote_library_config();
        $config['category'] = 'prodigy thank';

        return $config;
    }



    protected static function get_editor_panel_categories() {
        $categories = array(
            'prodigy-elements-archive' => array(
                'title' => __( 'Prodigy Thank You' ),
            ),
            // Move to top as active.
            'prodigy-elements'         => array(
                'title'  => __( 'Prodigy' ),
                'active' => true,
            ),
        );

        $categories += parent::get_editor_panel_categories();

        unset( $categories['theme-elements-thank'] );

        return $categories;
    }

}
