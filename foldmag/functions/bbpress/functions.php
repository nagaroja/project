<?php
/*------------------------------------------------
Description: check if in bbpress page
------------------------------------------------*/
function frkw_in_bbpress() {
global $in_bbpress;
$forum_root_slug = get_option('_bbp_forum_slug');
$topic_root_slug = get_option('_bbp_topic_slug');
$reply_root_slug = get_option('_bbp_reply_slug');
$tag_root_slug = get_option('_bbp_tag_slug');
if( get_post_type() == 'forum' || is_page('forums') || is_page('support') || get_post_type() == $forum_root_slug ||
get_post_type() == $topic_root_slug || get_post_type() == $reply_root_slug || get_post_type() == $tag_root_slug ) {
$in_bbpress = 'true';
}
//echo $in_bbpress;
}
add_action('wp_head','frkw_in_bbpress');


/*------------------------------------------------
Description: load bbpress styles
------------------------------------------------*/
function frkw_bbpress_load_styles() {
global $theme_version;
wp_enqueue_style( 'bbpress-custom-style', get_template_directory_uri(). '/functions/bbpress/custom.css', array(), $theme_version );
}
add_action( 'wp_enqueue_scripts', 'frkw_bbpress_load_styles' );


/*------------------------------------------------
Description: load bbpress widgets location
------------------------------------------------*/
function frkw_bbpress_widgets_init() {
register_sidebar(array(
    'name'=>__('Forum Sidebar', 'foldmag'),
   	'id' => 'forum-sidebar',
   	'description' => __( 'Forum sidebar widget area', 'foldmag' ),
	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	'after_widget' => '</aside>',
	'before_title' => '<h3 class="widget-title">',
	'after_title' => '</h3>',
));
}
add_action( 'widgets_init', 'frkw_bbpress_widgets_init', 20 );


?>