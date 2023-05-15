<?php

/**
 * Storefront automatically loads the core CSS even if using a child theme as it is more efficient
 * than @importing it in the child theme style.css file.
 *
 * Uncomment the line below if you'd like to disable the Storefront Core CSS.
 *
 * If you don't plan to dequeue the Storefront Core CSS you can remove the subsequent line and as well
 * as the sf_child_theme_dequeue_style() function declaration.
 */
//add_action( 'wp_enqueue_scripts', 'sf_child_theme_dequeue_style', 999 );

/**
 * Dequeue the Storefront Parent theme core CSS
 */
function sf_child_theme_dequeue_style() {
    wp_dequeue_style( 'storefront-style' );
    wp_dequeue_style( 'storefront-woocommerce-style' );
}

/**
 * Note: DO NOT! alter or remove the code above this text and only add your custom PHP functions below this text.
 */
/**
 * Script to enqueue Google fonts
 * @return void
 */
function uc_enqueue_fonts() {
 wp_enqueue_style( 'Open Sans', 'https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet', array(), '1.0' );
} add_action( 'wp_enqueue_scripts', 'uc_enqueue_fonts' );

// Enqueue Assets
require_once(__DIR__ . '/lib/enqueue-assets.php');


//Add Theme Support
require_once(__DIR__ . '/lib/theme-support.php');

/** Woocommerce Custom Settings- UltraChem */
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
function custom_remove_all_quantity_fields( $return, $product ) {return true;}
add_filter( 'woocommerce_is_sold_individually','custom_remove_all_quantity_fields', 10, 2 );
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
//remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
// Remove product images from the shop loop
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

// Remove default sorting drop down
add_action( 'init', 'ultrachem_remove_default_sorting_storefront' );
function ultrachem_remove_default_sorting_storefront() {
   remove_action( 'woocommerce_after_shop_loop', 'woocommerce_catalog_ordering', 10 );
   remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 10 );
}
// Change add to cart text on archives depending on product type
add_filter( 'woocommerce_product_add_to_cart_text' , 'custom_woocommerce_product_add_to_cart_text' );
function custom_woocommerce_product_add_to_cart_text() {
	global $product;
	$product_type = $product->product_type;
	switch ( $product_type ) {
		case 'simple':
			return __( 'Order Sample', 'woocommerce' );
		break;
		case 'variable':
			return __( 'Select Sample', 'woocommerce' );
	}
}
// To change add to cart text on single product page
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woocommerce_custom_single_add_to_cart_text' );
function woocommerce_custom_single_add_to_cart_text() {
    return __( 'Order Sample', 'woocommerce' );
}

add_filter( 'woocommerce_product_tabs', 'woo_rename_tabs', 98 );
function woo_rename_tabs( $tabs ) {

	$tabs['additional_information']['title'] = __( 'Product Details' );	// Rename the additional information tab
	$tabs['description']['title'] = __( 'Product Description' );// Rename the Description Tab
	return $tabs;
}
// ACF add after short description on product page
add_action( 'woocommerce_single_product_summary', 'acf_add_field_above_summary',20 );
function acf_add_field_above_summary() {
	global$product;
	?>
<p class="inci-name" ><span class="inci-name">INCI  // </span>
	<?php echo get_field('product_inci');  ?>
</p>
	<?php
}


add_action( 'woocommerce_before_add_to_cart_form', 'acf_add_field',5 );
function acf_add_field() {
    global$product;
    if( have_rows('safety_data_sheet') ):
    while ( have_rows('safety_data_sheet') ) : the_row(); ?>
    <p><i class="fas fa-file-download" style="color:#6a8c3d;"></i>&nbsp;<?php echo get_sub_field('sds_download'); ?></p>
    <?php endwhile;
    endif; ?>
	<?php if( have_rows('tds_hosted') ):
	while ( have_rows('tds_hosted') ) : the_row(); ?>
	<p><i class="fas fa-file-download" style="color:#6a8c3d;"></i>&nbsp;<?php echo get_sub_field('tds_download'); ?></p>
    <?php endwhile;
	endif; ?>
    <?php if( get_field('technical_data_sheet') ): ?>
    <p><a href="<?php echo get_field('technical_data_sheet'); ?>"><i class="fas fa-file-export" style="color:#6a8c3d;"></i> TDS UL Prospector link</a></p>
<?php endif; ?>
<?php
}

add_action( 'woocommerce_after_single_product', 'acf_add_brand_field',5 );
function acf_add_brand_field() {
	global$product;
	?>
<div id="disclaimer"><img src="<?php echo get_field('brand_logo'); ?>" />
       <p style="font-size: .8rem;"><?php echo get_field('brand_disclaimer'); ?> </p></div>
<?php
}


// WooCommerce, Add Short Description & Long Description to Products on Shop Page with Character limit
add_action( 'woocommerce_after_shop_loop_item_title', 'wc_add_short_description' );
function wc_add_short_description() {
	global $product;

	?>
        <div itemprop="description" class="custom-short-description">
            <?php echo apply_filters( 'woocommerce_short_description', $product->post-> post_excerpt ) ?>
        </div>
	<?php
}

add_action( 'woocommerce_after_shop_loop_item_title', 'wc_add_long_description' );
function wc_add_long_description() {
	global $product;
	?>
        <div itemprop="description">
            <?php
            $content = get_the_content();
			if (strlen($content) > 200) {echo substr( apply_filters( 'the_content', $product->post->post_content ), 0,190 ) . '...';} else {echo apply_filters('the_content', $content);} ?>
			<p style="color:#6d6d6d;"><i class="fas fa-arrow-alt-circle-right" style="color:#6a8c3d;"></i> product details</p>
        </div>
	<?php
}
//Remove "Order Sample" Button on Products Shop page
//remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart');
return WooCommerce::instance();
//Remove Storefront Footer Credit
add_action( 'storefront_footer', 'storefront_credit', 20 );
function storefront_credit() {
remove_action( 'storefront_footer', 'storefront_credit', 20 );
}
// Change title text for Order Recieved page by changing the page
add_action( 'woocommerce_thankyou', 'bbloomer_custom_thank_you_page', 10 );
function bbloomer_custom_thank_you_page() {
   $page_id = 976;
   $page_object = get_post( $page_id );
	echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your sample request has been received.', 'woocommerce' ), null );
   echo $page_object->post_content;
}