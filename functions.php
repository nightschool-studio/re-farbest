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
    remove_action( 'woocommerce_product_additional_information', 'wc_display_product_attributes', 10 );

    // KADENCE ACTIONS
    if ( class_exists( 'Kadence\Theme' ) ) {
        $kadence_theme_class = Kadence\Theme::instance();
        remove_action( 'woocommerce_before_shop_loop_item_title', array( $kadence_theme_class->components['woocommerce'], 'archive_loop_second_image' ), 30 );
        remove_action( 'woocommerce_after_shop_loop_item_title', array( $kadence_theme_class->components['woocommerce'], 'archive_excerpt' ), 20 );
    }

}

function add_actions() {
    add_action( 'wp_enqueue_scripts', 'farbest_child_theme_enqueue_style' );
    add_action( 'woocommerce_after_shop_loop_item_title', 'farbest_product_read_more', 20 );
	add_action( 'woocommerce_single_product_summary', 'ta_the_content', 28 );
    add_action( 'woocommerce_product_additional_information', 'wc_display_product_attributes_with_pipe', 10 );
}

function add_filters() {
    add_filter('body_class', 'sidebar_template_class');
    add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );
}

// farbest_goto_single_product
function farbest_product_read_more() {
    if ( is_main_query() && is_archive() ) {
    $columns = wc_get_loop_prop( 'columns' );
    if ( 1 === $columns || kadence()->option( 'product_archive_toggle' ) ) {
        global $post;
        echo '<div class="product-excerpt" itemprop="description">';
        if ( $post->post_excerpt ) {
			$content = get_the_content();
            echo wp_kses_post( apply_filters( 'archive_woocommerce_short_description', $post->post_excerpt ) ); // phpcs:ignore WPThemeReview.CoreFunctionality.PrefixAllGlobals.NonPrefixedHooknameFound
			if (strlen($content) > 200) {
				echo substr( apply_filters( 'the_content', $post->post_content ), 0,190 ) . '...';
			}
			else {
				echo apply_filters('the_content', $content);
			}
        } ?>
            <a style="color:#6d6d6d; display: block;" href="<?php the_permalink(); ?>" class="farbest-btn"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Free 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2023 Fonticons, Inc. --><path d="M0 256a256 256 0 1 0 512 0A256 256 0 1 0 0 256zM294.6 135.1l99.9 107.1c3.5 3.8 5.5 8.7 5.5 13.8s-2 10.1-5.5 13.8L294.6 376.9c-4.2 4.5-10.1 7.1-16.3 7.1C266 384 256 374 256 361.7l0-57.7-96 0c-17.7 0-32-14.3-32-32l0-32c0-17.7 14.3-32 32-32l96 0 0-57.7c0-12.3 10-22.3 22.3-22.3c6.2 0 12.1 2.6 16.3 7.1z"/></svg></i>Product Details</a></div>
        <?php }
    }
}

function wc_add_long_description() {
	global $product;
	?>
        <div itemprop="description">
            <?php
            $content = get_the_content();
			if (strlen($content) > 200) {echo substr( apply_filters( 'the_content', $product->post->post_content ), 0,190 ) . '...';} else {echo apply_filters('the_content', $content);} ?>
			<p style="color:#6d6d6d;"><i class="fas fa-arrow-circle-right" style="color:#6a8c3d;"></i> product details</p>
        </div> <?php

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
    //unset( $tabs['additional_information'] );     // Remove the additional information tab
    return $tabs;
}
// Woocommerce move description on single product page to below excerpt //

function ta_the_content() {
        echo the_content();
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
