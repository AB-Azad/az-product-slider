<?php

/**
 * Option page for this plugin
 */
if ( !class_exists('AZPSWC_Settings' ) ):
class AZPSWC_Settings {

    private $settings_api;

    function __construct() {
        $this->settings_api = new AZPSWC_Settings_API;

        add_action( 'admin_init', array($this, 'admin_init') );
        add_action( 'admin_menu', array($this, 'admin_menu'), 100 );
    }

    function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    function admin_menu() {
        add_submenu_page( 'options-general.php', esc_html__('AZ Product Options', 'azpswc'), esc_html__('AZ Product Options', 'azpswc'), 'manage_options', 'azpswc_options', array($this, 'plugin_page') );
    }

    function get_settings_sections() {
        $sections = array(
            array(
                'id'    => 'azpswc_settings_styling',
                'title' => esc_html__( 'AZ Product Slider Options', 'azpswc' )
            ),
        );
        return $sections;
    }

    /**
     * Returns all the settings fields
     *
     * @return array settings fields
     */
    function get_settings_fields() {
        $settings_fields = array(
            'azpswc_settings_styling' => array(
                array(
                    'name'    => 'item_',
                    'label'   => esc_html__( 'Product Item', 'azpswc' ),
                    'type'    => 'text',
                    'class' => 'azpswc-separator',
                ),
                array(
                    'name'              => 'item_margin',
                    'label'             => esc_html__( 'Product Item Margin', 'azpswc' ),
                    'desc'              => esc_html__( 'Example: 5px 0px 5px 0px (Indicates: top right bottom left)', 'azpswc' ),
                    'type'              => 'text',
                    'default'           => '',
                    'class' => 'azpswc',
                ),
                array(
                    'name'    => 'onsale_',
                    'label'   => esc_html__( 'OnSale Label', 'azpswc' ),
                    'type'    => 'text',
                    'class' => 'azpswc-separator',
                ),
                array(
                    'name'    => 'onsale_bg_color',
                    'label'   => esc_html__( 'Onsale Label BG Color', 'azpswc' ),
                    'type'    => 'color',
                    'default' => '',
                    'class' => 'azpswc',
                ),
                array(
                    'name'    => 'onsale_text_color',
                    'label'   => esc_html__( 'Onsale Label Text Color', 'azpswc' ),
                    'type'    => 'color',
                    'default' => '',
                    'class' => 'azpswc',
                ),
                array(
                    'name'    => 'title_',
                    'label'   => esc_html__( 'Product Title', 'azpswc' ),
                    'type'    => 'text',
                    'class' => 'azpswc-separator',
                ),
                array(
                    'name'    => 'title_text_color',
                    'label'   => esc_html__( 'Title Text Color', 'azpswc' ),
                    'type'    => 'color',
                    'default' => '',
                    'class' => 'azpswc',
                ),
                array(
                    'name'              => 'title_font_size',
                    'label'             => esc_html__( 'Title Font Size', 'azpswc' ),
                    'desc'             => esc_html__( 'Example: 24px', 'azpswc' ),
                    'type'              => 'text',
                    'default'           => '',
                    'class' => 'azpswc',
                ),
                array(
                    'name'              => 'title_margin',
                    'label'             => esc_html__( 'Title Margin', 'azpswc' ),
                    'desc'             => esc_html__( 'Example: 5px 0px 5px 0px (Indicates: top right bottom left)', 'azpswc' ),
                    'type'              => 'text',
                    'default'           => '',
                    'class' => 'azpswc',
                ),
                array(
                    'name'    => 'rating_',
                    'label'   => esc_html__( 'Product Rating', 'azpswc' ),
                    'type'    => 'text',
                    'class' => 'azpswc-separator',
                ),
                array(
                    'name'    => 'rating_color',
                    'label'   => esc_html__( 'Rating Color', 'azpswc' ),
                    'type'    => 'color',
                    'default' => '',
                    'class' => 'azpswc',
                ),
                array(
                    'name'    => 'rating_empty_color',
                    'label'   => esc_html__( 'Rating Empty Color', 'azpswc' ),
                    'type'    => 'color',
                    'default' => '',
                    'class' => 'azpswc',
                ),
                array(
                    'name'              => 'rating_margin',
                    'label'             => esc_html__( 'Rating Margin', 'azpswc' ),
                    'desc'             => esc_html__( 'Example: 5px 0px 5px 0px (Indicates: top right bottom left)', 'azpswc' ),
                    'type'              => 'text',
                    'default'           => '',
                    'class' => 'azpswc',
                ),
                array(
                    'name'    => 'price_',
                    'label'   => esc_html__( 'Product Price', 'azpswc' ),
                    'type'    => 'text',
                    'class' => 'azpswc-separator',
                ),
                array(
                    'name'    => 'price_prev_text_color',
                    'label'   => esc_html__( 'Previous Price Text Color', 'azpswc' ),
                    'type'    => 'color',
                    'default' => '',
                    'class' => 'azpswc',
                ),
                array(
                    'name'              => 'price_prev_font_size',
                    'label'             => esc_html__( 'Previous Price Font Size', 'azpswc' ),
                    'desc'             => esc_html__( 'Example: 24px', 'azpswc' ),
                    'type'              => 'text',
                    'default'           => '',
                    'class' => 'azpswc',
                ),
                array(
                    'name'    => 'price_current_text_color',
                    'label'   => esc_html__( 'Current Price Text Color', 'azpswc' ),
                    'type'    => 'color',
                    'default' => '',
                    'class' => 'azpswc',
                ),
                array(
                    'name'              => 'price_current_font_size',
                    'label'             => esc_html__( 'Current Price Font Size', 'azpswc' ),
                    'desc'             => esc_html__( 'Example: 24px', 'azpswc' ),
                    'type'              => 'text',
                    'default'           => '',
                    'class' => 'azpswc',
                ),
                array(
                    'name'              => 'price_margin',
                    'label'             => esc_html__( 'Price Margin', 'azpswc' ),
                    'desc'             => esc_html__( 'Example: 5px 0px 5px 0px (Indicates: top right bottom left)', 'azpswc' ),
                    'type'              => 'text',
                    'default'           => '',
                    'class' => 'azpswc',
                ),
                array(
                    'name'    => 'button_',
                    'label'   => esc_html__( 'Add To Cart Button', 'azpswc' ),
                    'type'    => 'text',
                    'class' => 'azpswc-separator',
                ),
                array(
                    'name'    => 'button_bg_color',
                    'label'   => esc_html__( 'Button Background Color', 'azpswc' ),
                    'type'    => 'color',
                    'default' => '',
                    'class' => 'azpswc',
                ),
                array(
                    'name'    => 'button_text_color',
                    'label'   => esc_html__( 'Button Text Color', 'azpswc' ),
                    'type'    => 'color',
                    'default' => '',
                    'class' => 'azpswc',
                ),
                array(
                    'name'    => 'button_border_color',
                    'label'   => esc_html__( 'Button Border Color', 'azpswc' ),
                    'type'    => 'color',
                    'default' => '',
                    'class' => 'azpswc',
                ),
                array(
                    'name'    => 'button_hover_bg_color',
                    'label'   => esc_html__( 'Button Hover Background Color', 'azpswc' ),
                    'type'    => 'color',
                    'default' => '',
                    'class' => 'azpswc',
                ),
                array(
                    'name'    => 'button_hover_text_color',
                    'label'   => esc_html__( 'Button Hover Text Color', 'azpswc' ),
                    'type'    => 'color',
                    'default' => '',
                    'class' => 'azpswc',
                ),
                array(
                    'name'    => 'button_hover_border_color',
                    'label'   => esc_html__( 'Button Hover Border Color', 'azpswc' ),
                    'type'    => 'color',
                    'default' => '',
                    'class' => 'azpswc',
                ),
                array(
                    'name'              => 'button_margin',
                    'label'             => esc_html__( 'Button margin', 'azpswc' ),
                    'desc'             => esc_html__( 'Example: 5px 0px 5px 0px (Indicates: top right bottom left)', 'azpswc' ),
                    'type'              => 'text',
                    'default'           => '',
                    'class' => 'azpswc',
                ),
                array(
                    'name'    => 'arrow_',
                    'label'   => esc_html__( 'Slider Arrow', 'azpswc' ),
                    'type'    => 'text',
                    'class' => 'azpswc-separator',
                ),
                array(
                    'name'    => 'arrow_bg_color',
                    'label'   => esc_html__( 'Arrow Bg Color', 'azpswc' ),
                    'type'    => 'color',
                    'default' => '',
                    'class' => 'azpswc',
                ),
                array(
                    'name'    => 'arrow_icon_color',
                    'label'   => esc_html__( 'Arrow Icon Color', 'azpswc' ),
                    'type'    => 'color',
                    'default' => '',
                    'class' => 'azpswc',
                ),
                array(
                    'name'    => 'arrow_border_color',
                    'label'   => esc_html__( 'Arrow Border Color', 'azpswc' ),
                    'type'    => 'color',
                    'default' => '',
                    'class' => 'azpswc',
                ),
                array(
                    'name'    => 'arrow_hover_bg_color',
                    'label'   => esc_html__( 'Arrow Hover BG Color', 'azpswc' ),
                    'type'    => 'color',
                    'default' => '',
                    'class' => 'azpswc',
                ),
                array(
                    'name'    => 'arrow_hover_icon_color',
                    'label'   => esc_html__( 'Arrow Hover Icon Color', 'azpswc' ),
                    'type'    => 'color',
                    'default' => '',
                    'class' => 'azpswc',
                ),
                array(
                    'name'              => 'arrow_prev_class',
                    'label'             => esc_html__( 'Arrow Prev Class', 'azpswc' ),
                    'desc'              => esc_html__( 'Example: fa fa-angle-left', 'azpswc' ),
                    'type'              => 'text',
                    'default'           => '',
                    'class' => 'azpswc',
                ),
                array(
                    'name'              => 'arrow_next_class',
                    'label'             => esc_html__( 'Arrow Next Class', 'azpswc' ),
                    'desc'              => esc_html__( 'Example: fa fa-angle-right', 'azpswc' ),
                    'type'              => 'text',
                    'default'           => '',
                    'class' => 'azpswc',
                ),
                array(
                    'name'    => 'dots_',
                    'label'   => esc_html__( 'Slider Dots', 'azpswc' ),
                    'type'    => 'text',
                    'class' => 'azpswc-separator',
                ),
                array(
                    'name'    => 'dots_bg_color',
                    'label'   => esc_html__( 'Dots Background Color', 'azpswc' ),
                    'type'    => 'color',
                    'default' => '',
                    'class' => 'azpswc',
                ),
                array(
                    'name'    => 'dots_border_color',
                    'label'   => esc_html__( 'Dots Border Color', 'azpswc' ),
                    'type'    => 'color',
                    'default' => '',
                    'class' => 'azpswc',
                ),
                array(
                    'name'    => 'dots_active_bg_color',
                    'label'   => esc_html__( 'Dots Active Background Color', 'azpswc' ),
                    'type'    => 'color',
                    'default' => '',
                    'class' => 'azpswc',
                ),
                array(
                    'name'    => 'dots_active_border_color',
                    'label'   => esc_html__( 'Dots Active Border Color', 'azpswc' ),
                    'type'    => 'color',
                    'default' => '',
                    'class' => 'azpswc',
                ),
                array(
                    'name'    => 'dots_margin',
                    'label'   => esc_html__( 'Dots Margin', 'azpswc' ),
                    'desc'    => esc_html__( 'Example: 5px 0px 5px 0px (Indicates: top right bottom left)', 'azpswc' ),
                    'type'    => 'text',
                    'default' => '',
                    'class' => 'azpswc',
                ),
            )
        );

        return $settings_fields;
    }

    function plugin_page() {
        echo '<div class="wrap">';

        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();

        echo '</div>';
    }

    /**
     * Get all the pages
     *
     * @return array page names with key value pairs
     */
    function get_pages() {
        $pages = get_pages();
        $pages_options = array();
        if ( $pages ) {
            foreach ($pages as $page) {
                $pages_options[$page->ID] = $page->post_title;
            }
        }

        return $pages_options;
    }

}
endif;

new AZPSWC_Settings();

/**
 * Get plugin option value
 */
function azpswc_get_option($opt_name = '', $section, $default = ''){
    if($section && $opt_name){
        $options = get_option( $section );
        if ( isset( $options[$opt_name] ) ) {
            return $options[$opt_name];
        } else {
            return $default;
        }
    } else {
        return $default;
    }
}