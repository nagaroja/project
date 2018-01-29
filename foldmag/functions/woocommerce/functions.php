<?php
/*------------------------------------------------
Description: check if is in woocommerce page
------------------------------------------------*/
function frkw_is_woocommerce_page() {
return ( is_shop() || is_product_category() || is_product_tag() || is_product() || is_cart() || is_checkout() || is_account_page() ) ? true : false;
}

///////////////////////////////////////////////////////////////////////////////
// woocommerce - add before and after container class
///////////////////////////////////////////////////////////////////////////////

function frkw_woocommerce_theme_before_content() {
echo '<main id="container"><div id="single-content" class="content shop-content"><div class="content-inner">
<div id="entries" class="content-area">';
}


function frkw_woocommerce_theme_after_content() {
echo '</div></div></div></main>';
}

//remove default open and close wrapper for woocommerce
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
//add new open and close wrapper for woocommerce
add_action('woocommerce_before_main_content', 'frkw_woocommerce_theme_before_content', 10);
add_action('woocommerce_after_main_content', 'frkw_woocommerce_theme_after_content', 20);


/*------------------------------------------------
Description: load woocommerce style
------------------------------------------------*/
function frkw_woocommerce_load_styles() {
global $theme_version;
wp_enqueue_style( 'custom-woocommerce-style', get_template_directory_uri(). '/functions/woocommerce/style.css', array(), $theme_version );
}
add_action( 'wp_enqueue_scripts', 'frkw_woocommerce_load_styles' );


/*------------------------------------------------
Description: add woocommerce widgets location
------------------------------------------------*/
function frkw_woocommerce_widgets_init() {
register_sidebar(array(
    'name'=>__('Shop Sidebar', 'foldmag'),
   	'id' => 'shop-sidebar',
   	'description' => __( 'Shop sidebar widget area', 'foldmag'),
	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	'after_widget' => '</aside>',
	'before_title' => '<h3 class="widget-title">',
	'after_title' => '</h3>',
));
}
add_action( 'widgets_init', 'frkw_woocommerce_widgets_init', 20 );

?>