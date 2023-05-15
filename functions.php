<?php
@include('/inc/woo-functions.php');
// Custom Color Palette

add_action('after_setup_theme' , 'remove_actions' , 1 );
add_action('after_setup_theme' , 'add_actions' , 16 );
add_action('after_setup_theme' , 'add_filters' , 16 );


function remove_actions() {
    // WP ACTIONS
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

    // WOO ACTIONS
    // removes images from archive pages
    remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
    // removes images from single product page
    remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
    remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
    remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
    // remove_action( 'woocommerce_product_additional_information', 'wc_display_product_attributes', 10 );

}

function add_actions() {
    add_action( 'wp_enqueue_scripts', 'farbest_child_theme_enqueue_style' );
	add_action( 'woocommerce_single_product_summary', 'ta_the_content', 28 );
    add_action( 'woocommerce_after_shop_loop_item_title', 'wc_add_long_description', 40 );
}

function add_filters() {
    add_filter('excerpt_more', 'new_excerpt_more');
    add_filter('body_class', 'sidebar_template_class');
    add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );
    // add_filter( 'woocommerce_attribute', 'replace_comma_by_pipe' );

}


// Replaces the excerpt "more" text by a link
function new_excerpt_more($more) {
    global $post;
	return '<div style="text-align:center"><a class="moretag" style="color:#5f9732;" href="'. get_permalink($post->ID) . '"> [... more]</a></div>';
}

function wc_add_long_description() {
	global $product;
	?>
        <div itemprop="description">
            <?php
            $content = get_the_content();
			if (strlen($content) > 200) {echo substr( apply_filters( 'the_content', $product->post->post_content ), 0,190 ) . '...';} else {echo apply_filters('the_content', $content);} ?>
        </div>
        <a class="product-read-more" style="color:#6d6d6d;" href="<?php echo get_permalink($product->ID); ?>"><i class="fas fa-arrow-circle-right" style="color:#6a8c3d;"></i> product details</a>
        <?php

}

/*  Enqueue the parent and child theme stylesheets in this order. */
function farbest_child_theme_enqueue_style() {

    // enqueue the child stylesheet after the parent theme stylesheet
    wp_enqueue_style( 'farbest-parent', get_template_directory_uri() . '/style.css');
    wp_enqueue_style( 'farbest-child', get_stylesheet_directory_uri() . '/style.css', array( 'farbest-parent') );
    wp_enqueue_style( 'farbest-og', get_stylesheet_directory_uri() . '/assets/css/style-original.css' );
}

/**
* Removes the left sidebar class from the body tag
* @param Array $classes  a WordPress specific class
* @return Array a list of classes
*/
function sidebar_template_class($classes){
    $key ='left-sidebar';
    if (($key = array_search($key, $classes)) !== false) {
        unset($classes[$key]);
    }
    return $classes;
}

//Remove WooCommerce Tabs - this code removes all 3 tabs - to be more specific just remove actual unset lines //
function woo_remove_product_tabs( $tabs ) {
    unset( $tabs['description'] );          // Remove the description tab
    unset( $tabs['reviews'] );          // Remove the reviews tab
    // unset( $tabs['additional_information'] );  	// Remove the additional information tab
    $tabs['additional_information']['title'] = __( 'Product Details' );
    return $tabs;
}
// Woocommerce move description on single product page to below excerpt //

function ta_the_content() {
        echo the_content();
}



// replace comma with pipe
function replace_comma_by_pipe() {
    global $product;
    $values = array_filter( $product->get_attributes(), 'wc_attributes_array_filter_visible' );
    return wpautop( wptexturize( implode( '| ', $values ) ) );
}
/***
 * ACF CUSTOMIZATION
 */

function my_acf_json_save_point($path)
{
	// update path
	$path = get_stylesheet_directory() . '/acf-json';

	// return
	return $path;
}

add_filter('acf/settings/save_json', 'my_acf_json_save_point');
