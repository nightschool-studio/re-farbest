<?php 

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

    // KADENCE ACTIONS 
    if ( class_exists( 'Kadence\Theme' ) ) {
        $kadence_theme_class = Kadence\Theme::instance(); 
        remove_action( 'woocommerce_before_shop_loop_item_title', array( $kadence_theme_class->components['woocommerce'], 'archive_loop_image_link_open' ), 5 );
        remove_action( 'woocommerce_before_shop_loop_item_title', array( $kadence_theme_class->components['woocommerce'], 'archive_loop_second_image' ), 30 );
        remove_action( 'woocommerce_before_shop_loop_item_title', array( $kadence_theme_class->components['woocommerce'], 'archive_loop_image_link_close' ), 50 );
        remove_action( 'woocommerce_after_shop_loop_item_title', array( $kadence_theme_class->components['woocommerce'], 'archive_excerpt' ), 20 );
    }
    
}

function add_actions() {
    if ( class_exists( 'Kadence\Theme' ) ) {
        $kadence_theme_class = Kadence\Theme::instance(); 
        add_action( 'wp_enqueue_scripts', 'farbest_child_theme_enqueue_style' );
        add_action( 'woocommerce_after_shop_loop_item_title', 'farbest_goto_single_product', 20 );
    }
}

function add_filters() {
    add_filter('body_class', 'sidebar_template_class');
    add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );
}


// farbest_goto_single_product
function farbest_goto_single_product() {
    if ( is_main_query() && is_archive() ) {
    $columns = wc_get_loop_prop( 'columns' );
    if ( 1 === $columns || kadence()->option( 'product_archive_toggle' ) ) {
        global $post;
        echo '<div class="product-excerpt">';
        if ( $post->post_excerpt ) {
            echo wp_kses_post( apply_filters( 'archive_woocommerce_short_description', $post->post_excerpt ) ); // phpcs:ignore WPThemeReview.CoreFunctionality.PrefixAllGlobals.NonPrefixedHooknameFound
        } else {
            the_excerpt();
        } ?>
            <a href="<?php the_permalink(); ?>" class="farbest-btn">Read More</a></div>
        <?php }
    }
}

/*  Enqueue the parent and child theme stylesheets in this order. */

function farbest_child_theme_enqueue_style() {

    // enqueue the child stylesheet after the parent theme stylesheet
    wp_enqueue_style( 'farbest-parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style( 'farbest-child-style', get_stylesheet_directory_uri() . '/style.css', array( 'farbest-parent-style') );

}
// WooCommerce, Add Short Description & Long Description to Products on Shop Page with Character limit

function wc_add_short_description() {
	global $product;

	?>
        <div itemprop="description" class="custom-short-description">
            <?php echo apply_filters( 'woocommerce_short_description', $product->post-> post_excerpt ) ?>
        </div>
	<?php
}


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
// Woocommerce add long description on shop page and clip length //


// Change add to cart text //
add_filter( 'woocommerce_product_add_to_cart_text', function( $text ) {
    if ( 'Read more' == $text ) {
        $text = __( 'Product details', 'woocommerce' );
    }
    return $text; 
} );
