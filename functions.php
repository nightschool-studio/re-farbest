<?php 
add_action('init' , 'remove_actions' , 15 );
add_action('init' , 'add_actions' , 16 );
add_action('init' , 'add_filters' , 16 );
add_theme_support('woocommerce');

function remove_actions() {

    remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
    remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
    remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
    remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
    remove_action('wp_head', 'index_rel_link'); // Index link
    remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
    remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
    remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
    remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
    remove_action('wp_head', 'rel_canonical');
    remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

    //remove_action( 'woocommerce_before_main_content', 'storefront_before_content', 10 );
    //remove_action( 'woocommerce_after_main_content', 'storefront_after_content', 10 );

	remove_action( 'storefront_header', 'storefront_header_cart', 60 ); //Disable the cart icon in Storefront header
    remove_action( 'homepage', 'storefront_product_categories', 20 );
    remove_action( 'homepage', 'storefront_recent_products', 30 );
    remove_action( 'homepage', 'storefront_featured_products', 40 );
    remove_action( 'homepage', 'storefront_popular_products', 50 );
    remove_action( 'homepage', 'storefront_on_sale_products', 60 );
    remove_action( 'homepage', 'storefront_homepage_content', 10 );
    remove_action( 'homepage', 'storefront_best_selling_products', 70 );
    remove_action( 'homepage', 'woocommerce_catalog_ordering', 10 );
    remove_action( 'woocommerce_after_shop_loop', 'storefront_sorting_wrapper', 9 );
    remove_action( 'woocommerce_after_shop_loop', 'woocommerce_catalog_ordering', 10 );
    //remove_action( 'woocommerce_after_shop_loop', 'woocommerce_result_count', 20 );
    remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 30 );
    remove_action( 'woocommerce_after_shop_loop', 'storefront_sorting_wrapper_close', 31 );

    remove_action( 'woocommerce_before_shop_loop', 'storefront_sorting_wrapper', 9 );
    remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 10 );
    //remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
    remove_action( 'woocommerce_before_shop_loop', 'storefront_woocommerce_pagination', 30 );
    remove_action( 'woocommerce_before_shop_loop', 'storefront_sorting_wrapper_close', 31 );
    remove_action( 'woocommerce_before_shop_loop', 'woocommerce_template_loop_product_thumbnail', 31 );
    //remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
    remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
    //remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
    remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
    remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10  );
    remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );

    // single product
    remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
    //remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
    //remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
    //remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
    remove_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30 );
    remove_action( 'woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30 );
    remove_action( 'woocommerce_variable_add_to_cart', 'woocommerce_variable_add_to_cart', 30 );
    remove_action( 'woocommerce_external_add_to_cart', 'woocommerce_external_add_to_cart', 30 );
    remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation', 10 );
    remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
}

function add_actions() {
   // add_action( 'storefront_sidebar', 'storefront_get_sidebar', 10 );
}

function add_filters() {
   
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