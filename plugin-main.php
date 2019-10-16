<?php 
/*
Plugin Name: AZ Product Slider For WooCommerce
Plugin URI: http://demo.azplugins.com/product-slider/
Description: 
Author: turje24
Author URI: https://azplugins.com
Version: 1.0
*/


/*Some Set-up*/
define('AZPSFORWC_PL_ROOT_URL', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );
define('AZPSFORWC_PL_VERSION', '0.0.1');

/* Enqueue scripts */
function azpsforwc_scripts() {
    wp_enqueue_style( 'fontawesome', AZPSFORWC_PL_ROOT_URL.'assets/libs/fontawesome-5/css/fontawesome.min.css');
    wp_enqueue_style( 'fontawesome-solid', AZPSFORWC_PL_ROOT_URL.'assets/libs/fontawesome-5/css/solid.min.css');
	wp_enqueue_style( 'slick', AZPSFORWC_PL_ROOT_URL.'assets/libs/slick/slick.min.css');
	wp_enqueue_style( 'slick-theme', AZPSFORWC_PL_ROOT_URL.'assets/libs/slick/slick-theme.css');
	wp_enqueue_style( 'azp-grid', AZPSFORWC_PL_ROOT_URL.'assets/azp-grid.min.css');
	wp_enqueue_style( 'azpsforwc-main', AZPSFORWC_PL_ROOT_URL.'assets/main.css');

	wp_enqueue_script('jquery');
	wp_enqueue_script( 'slick', AZPSFORWC_PL_ROOT_URL.'assets/libs/slick/slick.min.js', array( 'jquery' ), '1.8.1', true );
	wp_enqueue_script( 'azpsforwc-main', AZPSFORWC_PL_ROOT_URL.'assets/main.js', array( 'jquery', 'slick' ), AZPSFORWC_PL_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'azpsforwc_scripts', 15 );


add_shortcode( 'az_product_slider', 'azp_product_slider_sc' );
function azp_product_slider_sc(){

    // product query build
    $args = array(
         'post_type'             => 'product',
         'post_status'           => 'publish',
         'ignore_sticky_posts'   => 1,
         // 'posts_per_page'        => ( $settings['per_page'] == 0 ) ? -1 : $settings['per_page'],
         'cache_results'          => false,
         'update_post_meta_cache' => false,
         'update_post_term_cache' => false,
    );
    $wp_query = new WP_Query($args);

	ob_start();
	?>

	<div class="azp-container">
	    <!-- <div class="azp-row">
	        <div class="azp-col-md-4 azp-product-grid style--2">
                <div class="azp-product-image-wrapper">
					<div class="azp-product-image">
	                	<a href="#">
	                		<img src="http://bestjquery.com/tutorial/product-grid/demo79/images/img-1.jpg">
	                	</a>
                	</div>
                	<a href="/wordpress/shop/?add-to-cart=105" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart" data-product_id="105" data-product_sku="" aria-label="Add “Gallery” to your cart" rel="nofollow">Add to cart</a>
                </div>
                <div class="azp-product-content">
                	<a href="">
                		<h2 class="woocommerce-loop-product__title">Gallery</h2>
                	</a>
                	<span class="price">
                		<span class="woocommerce-Price-amount amount">
                			<span class="woocommerce-Price-currencySymbol">£</span>
                			18.00
                		</span>
                	</span>
                </div>
	        </div>
	        <div class="azp-col-md-4 azp-product-grid style--2">
                <div class="azp-product-image-wrapper">
					<div class="azp-product-image">
	                	<a href="#">
	                		<span class="onsale">Sale!</span>
	                		<img src="http://bestjquery.com/tutorial/product-grid/demo79/images/img-1.jpg">
	                	</a>
                	</div>
                	<a href="/wordpress/shop/?add-to-cart=105" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart" data-product_id="105" data-product_sku="" aria-label="Add “Gallery” to your cart" rel="nofollow">Add to cart</a>
                </div>
                <div class="azp-product-content azp-center-xs">
                	<a href="">
                		<h2 class="woocommerce-loop-product__title">Gallery</h2>
                	</a>
                	<div class="star-rating" role="img" aria-label="Rated 4.00 out of 5">
                		<span style="width:80%">Rated <strong class="rating">5.00</strong> out of 5</span>
                	</div>
                	<span class="price">
                		<span class="woocommerce-Price-amount amount">
                			<span class="woocommerce-Price-currencySymbol">£</span>
                			18.00
                		</span>
                	</span>
                </div>
	        </div>
	        <div class="azp-col-md-4 azp-product-grid style--2">
                <div class="azp-product-image-wrapper">
					<div class="azp-product-image">
	                	<a href="#">
	                		<img src="http://bestjquery.com/tutorial/product-grid/demo79/images/img-1.jpg">
	                	</a>
                	</div>
                	<a href="/wordpress/shop/?add-to-cart=105" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart" data-product_id="105" data-product_sku="" aria-label="Add “Gallery” to your cart" rel="nofollow">Add to cart</a>
                </div>
                <div class="azp-product-content">
                	<a href="">
                		<h2 class="woocommerce-loop-product__title">Gallery</h2>
                	</a>
                	<span class="price">
                		<del>
                			<span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">£</span>15.00</span>
                		</del>
                		<ins>
                			<span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">£</span>12.00</span>
                		</ins>
                	</span>
                </div>
	        </div>
	    </div> -->

        <ul>
            <li><i class="fas fa-angle-right"></i></li>
            <li><i class="fas fa-angle-left"></i></li>
        </ul>
	    <div class="azp-row azp-slick-active">
            <?php
                while ( $wp_query->have_posts() ) : $wp_query->the_post();
                    $image_size = 'woocommerce_thumbnail';
            ?>
    	        <div <?php wc_product_class('azp-col-md-4 azp-product-grid mb--25') ?>>
                    <div class="azp-product-image-wrapper">
    					<div class="azp-product-image">
    	                	<a href="<?php the_permalink(); ?>">
    	                		<?php woocommerce_show_product_loop_sale_flash(); ?>
    	                		<?php echo woocommerce_get_product_thumbnail( $image_size ); ?>
    	                	</a>
                    	</div>
                    </div>
                    <div class="azp-product-content azp-center-xs">
                    	<div class="azp-product-title">
                    		<a href="<?php the_permalink(); ?>">
                    			<h2 class="woocommerce-loop-product__title"><?php the_title(); ?></h2>
                    		</a>
                    	</div>
                    	<?php woocommerce_template_loop_rating(); ?>
                    	<div class="azp-product-price">
                    		<?php woocommerce_template_loop_price(); ?>
                    	</div>
                    	<div class="azp-cart-button">
                    		<?php woocommerce_template_loop_add_to_cart(); ?>
                    	</div>
                    </div>
    	        </div>
            <?php endwhile; wp_reset_query(); wp_reset_postdata(); ?>
	    </div>

                <ul>
                    <li><i class="fas fa-angle-right"></i></li>
                    <li><i class="fas fa-angle-left"></i></li>
                </ul>
                <div class="azp-row azp-slick-active">
                    <?php
                        while ( $wp_query->have_posts() ) : $wp_query->the_post();
                            $image_size = 'woocommerce_thumbnail';
                    ?>
                        <div <?php wc_product_class('azp-col-md-4 azp-product-grid mb--25') ?>>
                            <div class="azp-product-image-wrapper">
                                <div class="azp-product-image">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php woocommerce_show_product_loop_sale_flash(); ?>
                                        <?php echo woocommerce_get_product_thumbnail( $image_size ); ?>
                                    </a>
                                </div>
                            </div>
                            <div class="azp-product-content azp-center-xs">
                                <div class="azp-product-title">
                                    <a href="<?php the_permalink(); ?>">
                                        <h2 class="woocommerce-loop-product__title"><?php the_title(); ?></h2>
                                    </a>
                                </div>
                                <?php woocommerce_template_loop_rating(); ?>
                                <div class="azp-product-price">
                                    <?php woocommerce_template_loop_price(); ?>
                                </div>
                                <div class="azp-cart-button">
                                    <?php woocommerce_template_loop_add_to_cart(); ?>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; wp_reset_query(); wp_reset_postdata(); ?>
                </div>
	</div>

	<?php
	echo do_shortcode('[woo_product_slider id="311"]');
	return ob_get_clean();
}