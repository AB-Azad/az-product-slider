<?php 
/*
Plugin Name: AZ Product Slider For WooCommerce
Plugin URI: http://demo.azplugins.com/product-slider/
Description: This plugin will allow you to show your WooCommerce store's product as a slider anywhere of your website. You can change color & other settings from <a href="options-general.php?page=azpswc_options">Option Panel</a>
Author: turje24
Author URI: https://azplugins.com
Version: 1.0.0
*/

/*Some Set-up*/
define('AZPSWC_PL_ROOT_URL', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );
define('AZPSWC_PL_ROOT_DIR', dirname( __FILE__ ) );
define('AZPSWC_PL_VERSION', '0.0.1');

/* Include all files */
require_once( AZPSWC_PL_ROOT_DIR. '/includes/helper-functions.php');
require_once( AZPSWC_PL_ROOT_DIR. '/admin/class.settings-api.php');
require_once( AZPSWC_PL_ROOT_DIR. '/admin/plugin-options.php');

/* WooCommerce active/install notice */
function azpswc_plugin_install_active_notice(){
    if(class_exists('woocommerce')){
        return;
    }

    $woocommerce = 'woocommerce/woocommerce.php';
    if( azpswc_is_plugins_active( $woocommerce ) ) {
        if( ! current_user_can( 'activate_plugins' ) ) {
            return;
        }
        $activation_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $woocommerce . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $woocommerce );
        $button_text = '<p><a href="' . $activation_url . '" class="button-primary">' . esc_html__( 'Activate WooCommerce', 'azpswc' ) . '</a></p>';
    } else {
        if( ! current_user_can( 'activate_plugins' ) ) {
            return;
        }
        $activation_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=woocommerce' ), 'install-plugin_woocommerce' );
        $button_text = '<p><a href="' . $activation_url . '" class="button-primary">' . esc_html__( 'Install WooCommerce', 'azpswc' ) . '</a></p>';
    }

    $message = sprintf(
        /* translators: 1: Plugin name 2: WooCommerce */
        esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'azpswc' ),
        '<strong>' . esc_html__( 'AZ Product Slider', 'azpswc' ) . '</strong>',
        '<strong>' . esc_html__( 'WooCommerce', 'azpswc' ) . '</strong>'
    );
    printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p>%2$s</div>', $message, $button_text );
}
add_action( 'admin_notices', 'azpswc_plugin_install_active_notice' );

/* Enqueue scripts */
function azpswc_scripts() {
    //Latest jQuery from WordPress
    wp_enqueue_script('jquery');

    // Load fontawesome icons
    wp_enqueue_style( 'fontawesome', AZPSWC_PL_ROOT_URL.'assets/libs/fontawesome-5/css/fontawesome.min.css');
    wp_enqueue_style( 'fontawesome-solid', AZPSWC_PL_ROOT_URL.'assets/libs/fontawesome-5/css/solid.min.css');

    // Load Slick slider files
    wp_enqueue_style( 'slick', AZPSWC_PL_ROOT_URL.'assets/libs/slick/slick.min.css');
    wp_enqueue_script( 'slick', AZPSWC_PL_ROOT_URL.'assets/libs/slick/slick.min.js', array( 'jquery' ), '1.8.1', true );

    // Load custom grid css
    wp_enqueue_style( 'azpswc-grid', AZPSWC_PL_ROOT_URL.'assets/azpswc-grid.min.css');

    // load main css
    wp_enqueue_style( 'azpswc-main', AZPSWC_PL_ROOT_URL.'assets/main.css');

    // load main js
    wp_enqueue_script( 'azpswc-main', AZPSWC_PL_ROOT_URL.'assets/main.js', array( 'jquery', 'slick' ), AZPSWC_PL_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'azpswc_scripts', 15 );

/* Admin enqueue scripts */
function azpswc_admin_scripts(){
    wp_enqueue_style( 'azpswc-admin', AZPSWC_PL_ROOT_URL.'assets/admin.css');
}
add_action( 'admin_enqueue_scripts', 'azpswc_admin_scripts');

/* Dynamic Style */
function azpswc_inline_css() {
    $custom_css = array();

    $custom_css[] = azpswc_add_inline_css('margin',
        'item_margin',
        array(
            '.azpswc-product-grid'
        )
    );

    $custom_css[] = azpswc_add_inline_css('background-color',
        'onsale_bg_color',
        array(
            '.azpswc-product-grid .onsale'
        )
    );
    $custom_css[] = azpswc_add_inline_css('color',
        'onsale_text_color',
        array(
            '.azpswc-product-grid .onsale'
        )
    );

    $custom_css[] = azpswc_add_inline_css('color',
        'title_text_color',
        array(
            '.azpswc-product-grid .woocommerce-loop-product__title'
        )
    );
    $custom_css[] = azpswc_add_inline_css('font-size',
        'title_font_size',
        array(
            '.azpswc-product-grid .woocommerce-loop-product__title'
        )
    );
    $custom_css[] = azpswc_add_inline_css('color',
        'rating_color',
        array(
            '.azpswc-product-grid .star-rating span:before'
        )
    );
    $custom_css[] = azpswc_add_inline_css('color',
        'rating_empty_color',
        array(
            '.azpswc-product-grid .star-rating:before'
        )
    );
    $custom_css[] = azpswc_add_inline_css('margin',
        'rating_margin',
        array(
            '.azpswc-product-grid .star-rating'
        )
    );

    $custom_css[] = azpswc_add_inline_css('color',
        'price_prev_text_color',
        array(
            '.azpswc-product-grid del'
        )
    );
    $custom_css[] = azpswc_add_inline_css('font-size',
        'price_prev_font_size',
        array(
            '.azpswc-product-grid del'
        )
    );
    $custom_css[] = azpswc_add_inline_css('color',
        'price_current_text_color',
        array(
            '.azpswc-product-grid ins'
        )
    );
    $custom_css[] = azpswc_add_inline_css('font-size',
        'price_current_font_size',
        array(
            '.azpswc-product-grid ins'
        )
    );
    $custom_css[] = azpswc_add_inline_css('margin',
        'price_margin',
        array(
            '.azpswc-product-grid .azpswc-product-price'
        )
    );

    $custom_css[] = azpswc_add_inline_css('background-color',
        'button_bg_color',
        array(
            '.azpswc-product-grid .add_to_cart_button'
        )
    );
    $custom_css[] = azpswc_add_inline_css('color',
        'button_text_color',
        array(
            '.azpswc-product-grid .add_to_cart_button'
        )
    );

    $custom_css[] = azpswc_add_inline_css('border-color',
        'button_border_color',
        array(
            '.azpswc-product-grid .add_to_cart_button'
        )
    );
    $custom_css[] = azpswc_add_inline_css('background-color',
        'button_hover_bg_color',
        array(
            '.azpswc-product-grid .add_to_cart_button:hover'
        )
    );
    $custom_css[] = azpswc_add_inline_css('color',
        'button_hover_text_color',
        array(
            '.azpswc-product-grid .add_to_cart_button:hover'
        )
    );
    $custom_css[] = azpswc_add_inline_css('border-color',
        'button_hover_border_color',
        array(
            '.azpswc-product-grid .add_to_cart_button:hover'
        )
    );
    $custom_css[] = azpswc_add_inline_css('margin',
        'button_margin',
        array(
            '.azpswc-product-grid .add_to_cart_button'
        )
    );

    $custom_css[] = azpswc_add_inline_css('background-color',
        'arrow_bg_color',
        array(
            '.azpswc-slick-arrow'
        )
    );
    $custom_css[] = azpswc_add_inline_css('color',
        'arrow_icon_color',
        array(
            '.azpswc-slick-arrow i'
        )
    );
    $custom_css[] = azpswc_add_inline_css('border-color',
        'arrow_border_color',
        array(
            '.azpswc-slick-arrow',
            '.azpswc-slick-arrow:hover'
        )
    );
    $custom_css[] = azpswc_add_inline_css('background-color',
        'arrow_hover_bg_color',
        array(
            '.azpswc-slick-arrow:hover'
        )
    );
    $custom_css[] = azpswc_add_inline_css('color',
        'arrow_hover_icon_color',
        array(
            '.azpswc-slick-arrow:hover i'
        )
    );

    $custom_css[] = azpswc_add_inline_css('background-color',
        'dots_bg_color',
        array(
            '.azpswc-product-slider-area .slick-dots li button',
        )
    );
    $custom_css[] = azpswc_add_inline_css('border-color',
        'dots_border_color',
        array(
            '.azpswc-product-slider-area .slick-dots li button',
        )
    );
    $custom_css[] = azpswc_add_inline_css('background-color',
        'dots_active_bg_color',
        array(
            '.azpswc-product-slider-area .slick-dots li:hover button',
            '.azpswc-product-slider-area .slick-dots li.slick-active button'
        )
    );
    $custom_css[] = azpswc_add_inline_css('border-color',
        'dots_active_border_color',
        array(
            '.azpswc-product-slider-area .slick-dots li:hover button',
            '.azpswc-product-slider-area .slick-dots li.slick-active button'
        )
    );
    $custom_css[] = azpswc_add_inline_css('margin',
        'dots_margin',
        array(
            '.azpswc-product-slider-area .slick-dots li',
        )
    );

    wp_add_inline_style( 'azpswc-main', implode('', $custom_css) );
}
add_action( 'wp_enqueue_scripts', 'azpswc_inline_css', 15 );

/* Product slider shortcode */
function azpswc_shortcodes_init(){
    add_shortcode( 'azpswc_product_slider', 'azpswc_product_slider_sc' );
}
add_action('init', 'azpswc_shortcodes_init');

function azpswc_product_slider_sc( $attributes ){
    $shortcode_att_defaults = array(
         'class'        => '',
         'style'        => '1',
         'limit'        => 10,
         'type'        => 'recent',
         'visibility'        => '',
         'categories'        => '',
         'tags'        => '',
         'ids'        => '',
         'orderby'        => '',
         'order'        => '',
         'image_size'        => '',
    );
    extract(shortcode_atts($shortcode_att_defaults, $attributes));

    // product query build
    $query_args = array(
         'post_type'             => 'product',
         'post_status'           => 'publish',
         'ignore_sticky_posts'   => 1,
         'posts_per_page'        => $limit,
    );

    // type
    switch ( $type ) {
        case 'best_selling':
            $query_args['meta_key']   = 'total_sales';
            $query_args['orderby']    = 'meta_value_num';
            $query_args['order']      = 'DESC';
            break;

        case 'top_rated':
            $query_args['meta_key']   = '_wc_average_rating';
            $query_args['orderby']    = 'meta_value_num';
            $query_args['order']      = 'DESC';
            break;

        case 'on_sale':
            $query_args['meta_query'][] = array(
                'key'           => '_sale_price',
                'value'        =>  0,
                'compare'      => '>',
                'type'         => 'NUMERIC'
            );
            break;

        case 'featured':
            $query_args['tax_query'][] = array(
                'taxonomy' => 'product_visibility',
                'field'    => 'name',
                'terms'    => 'featured',
                'operator' => 'IN',
                'include_children' => false,
            );
            break;

        default:
            $query_args['orderby']    = 'title';
            $query_args['order']      = 'ASC';
            break;
    }

    // visibility
    $product_visibility_term_ids = wc_get_product_visibility_term_ids();
    switch ( $visibility ) {
        case 'visible':
            $query_args['tax_query'][] = array(
                'taxonomy' => 'product_visibility',
                'field'    => 'term_taxonomy_id',
                'terms'    => array($product_visibility_term_ids['exclude-from-catalog']),
                'operator' => 'NOT IN',
            );
            break;

        case 'shop_only':  // exclude-from-search,
            $query_args['tax_query'][] = array(
                'taxonomy' => 'product_visibility',
                'field'    => 'name',
                'terms'    => 'exclude-from-search',
                'operator' => 'IN',
                'include_children' => false,
            );
            $query_args['tax_query'][] = array(
                'taxonomy' => 'product_visibility',
                'field'    => 'name',
                'terms'    => 'exclude-from-catalog',
                'operator' => 'NOT IN',
                'include_children' => false,
            );
            break;

        case 'search_only': // exclude-from-catalog
            $query_args['tax_query'][] = array(
                'taxonomy' => 'product_visibility',
                'field'    => 'name',
                'terms'    => 'exclude-from-search',
                'operator' => 'NOT IN',
                'include_children' => false,
            );
            $query_args['tax_query'][] = array(
                'taxonomy' => 'product_visibility',
                'field'    => 'name',
                'terms'    => 'exclude-from-catalog',
                'operator' => 'IN',
                'include_children' => false,
            );
            break;

        case 'hidden_only':  // exclude-from-search, exclude-from-catalog
            $query_args['tax_query'][] = array(
                'taxonomy' => 'product_visibility',
                'field'    => 'name',
                'terms'    => array('exclude-from-search', 'exclude-from-catalog'),
                'operator' => 'AND',
                'include_children' => false,
            );
            break;
    }

    // categories query
    if( $categories ){
        $categories = explode(',', $categories);
        $query_args['tax_query'][] = array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => $categories,
            ),
        );
    }

    // tags query
    if( $tags ){
        $tags = explode(',', $tags);
        $query_args['tax_query'][] = array(
            array(
                'taxonomy' => 'product_tag',
                'field'    => 'slug',
                'terms'    => $tags,
            ),
        );
    }

    // ids query
    if( $ids ){
        $ids = array_map( 'trim', explode( ',', $ids ) );

        if ( 1 === count( $ids ) ) {
            $query_args['p'] = $ids[0];
        } else {
            $query_args['post__in'] = $ids;
        }
    }

    // orderby
    if( $orderby ){
        $query_args['orderby']    = $orderby;
    }

    // order
    if( $order ){
        $query_args['order']    = $order;
    }

    $wp_query = new WP_Query($query_args);

    // slick settings
    $arrow_prev_class = azpswc_get_option('arrow_prev_class', 'azpswc_settings_styling') ? azpswc_get_option('arrow_prev_class', 'azpswc_settings_styling') : 'fas fa-angle-left';
    $arrow_next_class = azpswc_get_option('arrow_next_class', 'azpswc_settings_styling') ? azpswc_get_option('arrow_next_class', 'azpswc_settings_styling') : 'fas fa-angle-right';

    $slick_setting_defaults = array(
        'autoplay' => 'false',
        'autoplay_speed' => 3000,
        'pause_on_focus' => 'true',
        'pause_on_hover' => 'true',
        'pause_on_dots_hover' => 'true',
        'arrows' => 'true',
        'prev_arrow_class' =>  $arrow_prev_class,
        'next_arrow_class' => $arrow_next_class,
        'dots'  => 'true',
        'draggable'  => 'true',
        'infinite'  => 'false',
        'initial_slide'  => 0,
        'rows'  => 1,
        'slides_to_show'  => 3,
        'slides_to_scroll'  => 1,
        'speed'  => 700,
        'swipe' => 'true',
        'slides_to_show_xs_mobile' => 1, 
        'slides_to_show_mobile' => 1, 
        'slides_to_show_tablet' => 3, 
        'slides_to_show_md_desktop' => 3,
        'xs_mobile_breakpoint'  => 575,
        'mobile_breakpoint'  => 767,
        'tablet_breakpoint'  => 991,
        'md_desktop_breakpoint'  => 1199,
    );

    $slick_settings = shortcode_atts($slick_setting_defaults, $attributes);
    $slick_settings = wp_json_encode($slick_settings);
    ob_start();
    ?>

    <div class="azpswc-area">
        <div class="<?php echo esc_attr($class); ?> azpswc-row azpswc-slick-active azpswc-product-slider-area" data-slick-settings='<?php echo $slick_settings; ?>'>
            <?php
            if($wp_query->have_posts()):
                while ( $wp_query->have_posts() ) : $wp_query->the_post();
                    if(!$image_size){
                        $image_size = apply_filters('azpswc_image_size', 'woocommerce_thumbnail');
                    }
                   
            ?>
                <div <?php wc_product_class('azpswc-col-md-4 azpswc-product-grid style--'. $style) ?>>
                    <div class="azpswc-product-image-wrapper">
                        <div class="azpswc-product-image">
                            <a href="<?php the_permalink(); ?>">
                                <?php woocommerce_show_product_loop_sale_flash(); ?>
                                <?php echo woocommerce_get_product_thumbnail( $image_size ); ?>
                            </a>
                        </div>
                        <?php if($style == '2'): ?>
                            <div class="azpswc-cart-button">
                                <?php woocommerce_template_loop_add_to_cart(); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="azpswc-product-content azpswc-center-xs">
                        <div class="azpswc-product-title">
                            <a href="<?php the_permalink(); ?>">
                                <h2 class="woocommerce-loop-product__title"><?php the_title(); ?></h2>
                            </a>
                        </div>
                        <?php woocommerce_template_loop_rating(); ?>
                        <div class="azpswc-product-price">
                            <?php woocommerce_template_loop_price(); ?>
                        </div>

                        <?php if($style == '1'): ?>
                        <div class="azpswc-cart-button">
                            <?php woocommerce_template_loop_add_to_cart(); ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; wp_reset_query(); wp_reset_postdata(); ?>
            <?php else: ?>
                <div class="azpswc-col-xs-12 azpswc-center-xs">
                    <?php echo esc_html__( 'No Products found!', 'azpswc' ); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php
    return ob_get_clean();
}