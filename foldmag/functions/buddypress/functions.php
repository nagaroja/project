<?php
/*------------------------------------------------
Description: check if is in buddypress page
------------------------------------------------*/
if ( function_exists( 'bp_is_active' ) ) {
global $blog_id, $current_blog;
if ( is_multisite() ) {
//check if multiblog
if ( defined( 'BP_ENABLE_MULTIBLOG' ) && BP_ENABLE_MULTIBLOG ) {
$bp_active = 'true';
} else if ( defined( 'BP_ROOT_BLOG' ) && BP_ROOT_BLOG == $current_blog->blog_id ) {
$bp_active = 'true';
}
else if ( defined( 'BP_ROOT_BLOG' ) && ( $blog_id != 1 ) ) {
$bp_active = 'false';
}
} else {
$bp_active = 'true';
}
}
else {
$bp_active = 'false';
}


/*------------------------------------------------
Description: load buddypress styles
------------------------------------------------*/
function frkw_buddypress_load_styles() {
global $theme_version;
wp_enqueue_style( 'buddypress-default-style', get_template_directory_uri(). '/functions/buddypress/style.css', array(), $theme_version );
wp_enqueue_style( 'buddypress-custom-style', get_template_directory_uri(). '/functions/buddypress/custom.css', array(), $theme_version );
}
add_action( 'wp_enqueue_scripts', 'frkw_buddypress_load_styles' );


/*------------------------------------------------
Description: load buddypress widgets location
------------------------------------------------*/
function frkw_buddypress_widgets_init() {
register_sidebar(array(
    'name'=>__('BuddyPress Sidebar', 'foldmag'),
   	'id' => 'buddypress-sidebar',
   	'description' => __( 'BuddyPress sidebar widget area', 'foldmag'),
	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	'after_widget' => '</aside>',
	'before_title' => '<h3 class="widget-title">',
	'after_title' => '</h3>',
));
}
add_action( 'widgets_init', 'frkw_buddypress_widgets_init', 20 );


?>