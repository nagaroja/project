<?php
/*--------------------------------------------
Description: allow script in options
---------------------------------------------*/
function frkw_customizer_allow_scripts() { return 'frkw_sanitize_null'; }
add_filter('frkw_textarea_settings_filter','frkw_customizer_allow_scripts');

/*--------------------------------------------
Description: set main query post count
---------------------------------------------*/
function frkw_home_query_count( $query ) {
if ( $query->is_home() && $query->is_main_query() ) {
$query->set( 'posts_per_page', 15 );
}
}
//add_action( 'pre_get_posts', 'frkw_home_query_count' );


/*-----------------------------------------
Description: add searchform filter
-----------------------------------------*/
function frkw_searchform_filter( $form ) {
   $form = '<form role="search" method="get" class="search-form" action="' . esc_url( home_url( '/' ) ) . '">
                <label>
                    <span class="screen-reader-text">' . __( 'Search for:', 'foldmag' ) . '</span>
                    <input type="text" class="search-field" placeholder="' . __( 'Search &hellip;', 'foldmag' ) . '" value="' . get_search_query() . '" name="s" />
                </label>
                <input type="submit" class="search-submit" value="'. __( 'Search', 'foldmag' ) .'" />
            </form>';
    return $form;
}
add_filter('get_search_form','frkw_searchform_filter',20);

/*-----------------------------------------
Description: add head meta
-----------------------------------------*/
function frkw_add_head_meta() {
global $is_IE;
$headmeta = '';
$headmeta .= '<meta charset="'. get_bloginfo( 'charset' ) . '" />';
if($is_IE) {
$headmeta .=  '<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">';
}
$headmeta .=  '<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=yes">';
$headmeta .=  '<meta name="HandheldFriendly" content="true">';
$headmeta .=  '<link rel="profile" href="http://gmpg.org/xfn/11">';
$headmeta .=  '<link rel="pingback" href="'. get_bloginfo('pingback_url') . '" />';
echo apply_filters('mp_headmeta',$headmeta);
}
add_action('mp_inside_head_tag','frkw_add_head_meta');

/*-----------------------------------------
Description: add sidebar
-----------------------------------------*/
function frkw_add_sidebars() {
global $in_bbpress, $bp_active;
if(!is_404() && !is_attachment() && !is_page_template( 'templates/full-width.php' )) {
get_sidebar();
}
}
add_action('mp_after_container','frkw_add_sidebars');

/*-----------------------------------------
Description: add footer
-----------------------------------------*/
function frkw_add_footers() {
get_footer();
}
add_action('mp_after_container','frkw_add_footers');


function frkw_add_pagination() {
global $in_bbpress, $bp_active;
if( !is_page() && !is_404() && !is_attachment() && !is_page_template( 'templates/full-width.php' )) {
if( !is_single() ) {
get_template_part('templates/pagination');
}
}
}
add_action('mp_after_content_inner','frkw_add_pagination');


function frkw_add_single_pagination() {
global $in_bbpress, $bp_active;
if( !is_page() && !is_404() && !is_attachment() && !is_page_template( 'templates/full-width.php' )) {
if( is_single() ) {
get_template_part('templates/pagination');
}
}
}
add_action('mp_after_comment_form','frkw_add_single_pagination');

/*--------------------------------------------
Description: add top navigation
---------------------------------------------*/
function frkw_add_top_menu() {
do_action( 'mp_before_top_nav' ); ?>
<nav class="top-nav" id="top-navigation"<?php do_action('mp_section_top_nav'); ?>>
<?php wp_nav_menu( array( 'theme_location' => 'top', 'container' => false, 'menu_class' => 'sf-menu', 'fallback_cb' => 'frkw_filter_menu_page','walker' => new frkw_custom_menu_walker ));
do_action( 'mp_inside_top_nav' ); ?>
</nav>
<?php do_action( 'mp_after_top_nav' );
}
//add_action('mp_inside_wrapper', 'frkw_add_top_menu',10);


/*--------------------------------------------
Description: add social icon in top nav
---------------------------------------------*/
function frkw_add_social_box() {
$facebook_link = get_theme_mod('facebook_url');
$twitter_link = get_theme_mod('twitter_url');
$google_plus_link = get_theme_mod('google_plus_url');
$pinterest_link = get_theme_mod('pinterest_url');
$get_rss_feed_link = get_theme_mod('rss_feed_url');
$rss_feed_link = !empty( $get_rss_feed_link  ) ? $get_rss_feed_link : get_bloginfo('rss2_url');
?>
<div id="social_box">
<?php if($facebook_link) { ?><p><a title="<?php _e('Like us on Facebook', 'foldmag'); ?>" class="fa fa-facebook" target="_blank" href="<?php echo $facebook_link; ?>">&nbsp;</a></p><?php } ?>
<?php if($twitter_link) { ?><p><a title="<?php _e('Follow us on Twitter', 'foldmag'); ?>" class="fa fa-twitter" target="_blank" href="<?php echo $twitter_link; ?>">&nbsp;</a></p><?php } ?>
<?php if($google_plus_link) { ?><p><a target="_blank" title="<?php _e('Follow us on Pinterest', 'foldmag'); ?>" class="fa fa-pinterest" href="<?php echo $google_plus_link; ?>">&nbsp;</a></p><?php } ?>
<?php if($pinterest_link) { ?><p><a target="_blank" title="<?php _e('Join us on Google Page', 'foldmag'); ?>" class="fa fa-google-plus" href="<?php echo $pinterest_link; ?>">&nbsp;</a></p><?php } ?>
<p><a target="_blank" title="<?php _e('Subscribe to our site RSS Feed', 'foldmag'); ?>" class="fa fa-rss" href="<?php echo $rss_feed_link; ?>">&nbsp;</a></p>
<?php do_action( 'mp_inside_social_box' ); ?>
</div>
<?php }
//add_action('mp_inside_top_nav', 'frkw_add_social_box');
//add_action('mp_inside_siteinfo', 'frkw_add_social_box');

/*--------------------------------------------
Description: add header
---------------------------------------------*/
function frkw_add_header() {
$header_logo = get_theme_mod('header_logo');
do_action( 'mp_before_header' ); ?>
<header id="header"><div class="innerwrap">
<div <?php if($header_logo) { echo 'class="header-with-logo" '; } ?>id="siteinfo">
<?php do_action('mp_inside_siteinfo'); ?>
</div>
<?php do_action('mp_inside_header'); ?>
</div></header>
<?php do_action('mp_after_header');
}
add_action('mp_before_wrapper', 'frkw_add_header',5);

/*--------------------------------------------
Description: add site info
---------------------------------------------*/
function frkw_add_siteinfo() {
return frkw_site_header_content();
}
add_action('mp_inside_siteinfo', 'frkw_add_siteinfo');


/*--------------------------------------------
Description: add primary navigation
---------------------------------------------*/
function frkw_add_primary_menu() {
do_action( 'mp_before_main_nav' ); ?>
<nav class="primary-nav" id="main-navigation"<?php do_action('mp_section_main_nav'); ?>><div class="innerwrap">
<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'menu_class' => 'sf-menu', 'fallback_cb' => 'frkw_filter_menu_page','walker' => new frkw_custom_menu_walker ));
do_action( 'mp_inside_main_nav' ); ?>
</div></nav>
<?php do_action( 'mp_after_main_nav' );
}
add_action('mp_before_wrapper', 'frkw_add_primary_menu',10);

/*--------------------------------------------
Description: add mobile menu in navigation
---------------------------------------------*/
function frkw_add_mobile_menu() {
if ( has_nav_menu( 'mobile' ) ) {
frkw_init_mobile_menu('mobile', __('Browse The Site','foldmag') );
} }
add_action('mp_inside_header','frkw_add_mobile_menu', 10);


/*--------------------------------------------
Description: add breadcrumbs
---------------------------------------------*/
function frkw_add_custom_breadcrumbs() {
if( !is_404() && !is_singular() && get_theme_mod('breadcrumbs_on') == 'enable' ) {
echo frkw_schema_breadcrumbs();
}
}
add_action('mp_before_content_area','frkw_add_custom_breadcrumbs',20);

function frkw_add_custom_breadcrumbs_single() {
if( is_singular() && get_theme_mod('breadcrumbs_on') == 'enable' ) {
echo frkw_schema_breadcrumbs();
}
}
add_action('mp_before_post_article','frkw_add_custom_breadcrumbs_single',20);

/*--------------------------------------------
Description: add top header ads
---------------------------------------------*/
function frkw_add_header_ads() {
$header_banner = get_theme_mod('header_ad_code');
if($header_banner) {
echo '<div id="topbanner">' . stripcslashes(do_shortcode($header_banner)) . '</div>';
}
}
add_action('mp_inside_header','frkw_add_header_ads',15);

/*--------------------------------------------
Description: check show avatars
---------------------------------------------*/
function frkw_check_avatars_on() {
$show_avatars = get_option('show_avatars');
if( $show_avatars != '1'  ) { ?>
#custom ol.commentlist li div.vcard {padding-left: 0px;}
#custom #commentpost ol.commentlist li ul li .vcard {padding-left: 0 !important;}
#post-entry #author-bio #author-description {margin: 0;}
#custom ol.commentlist li ul.children li.depth-4 {margin: 0;}
<?php }
}
add_action('frkw_custom_css','frkw_check_avatars_on');


/*--------------------------------------------
Description: add custom image header location
---------------------------------------------*/
function frkw_custom_img_header() {
if( get_header_image()  ) {
echo '<div id="custom-img-header">' . '<img src="'. get_header_image() . '" alt="' . get_bloginfo('name') . '" /></div>';
}
}
add_action('mp_before_wrapper','frkw_custom_img_header',10);

/*--------------------------------------------
Description: add featured slider
---------------------------------------------*/
function frkw_add_featured_slider() {
if('page' == get_option( 'show_on_front' )) {
$paged = get_query_var( 'page' );
} else {
$paged = get_query_var( 'paged' );
}
if( ( is_home() || is_front_page() || is_page_template('templates/blog.php')) && get_theme_mod('slider_on') == 'enable') {
if ( !$paged ) {
get_template_part( '/scripts/smooth-gallery/smooth-gallery' );
}
}
}
//add_action('mp_inside_content_area_inner','frkw_add_featured_slider',10);


/*--------------------------------------------
Description: add author bio
---------------------------------------------*/
function frkw_add_author_bio() {
if(!is_attachment() && !is_page_template( 'templates/full-width.php' )) {
if( is_single() && get_theme_mod('author_bio_on') == 'enable') {
get_template_part( '/templates/author-bio' );
}
}
}
add_action('mp_after_content_area_inner','frkw_add_author_bio');



/*--------------------------------------------
Description: add single post ads top
---------------------------------------------*/
function frkw_add_single_top_ads() {
global $in_bbpress, $bp_active;
$get_ads = get_theme_mod('post_single_ad_code_top');
if( $get_ads && is_single() && $in_bbpress != 'true') {
echo '<div class="ad-single-top">';
echo stripcslashes(do_shortcode($get_ads));
echo '</div>';
}
}
add_action('mp_before_the_content','frkw_add_single_top_ads');


/*--------------------------------------------
Description: add single post ads bottom
---------------------------------------------*/
function frkw_add_single_bottom_ads() {
global $in_bbpress, $bp_active;
$get_ads = get_theme_mod('post_single_ad_code_bottom');
if( $get_ads && is_single() && $in_bbpress != 'true') {
echo '<div class="ad-single-bottom">';
echo stripcslashes(do_shortcode($get_ads));
echo '</div>';
}
}
add_action('mp_after_the_content','frkw_add_single_bottom_ads');


/*--------------------------------------------
Description: add post loop ads
---------------------------------------------*/
function frkw_add_post_loop_ads() {
global $postcount,$in_bbpress, $bp_active;;
$ads_code_one = get_theme_mod('post_loop_ad_code_one');
$ads_code_two = get_theme_mod('post_loop_ad_code_two');
if( !is_singular() && $in_bbpress != 'true' ) {
if( $ads_code_one == '' && $ads_code_two == '') {
} else {
if( 2 == $postcount && $ads_code_one ){
echo '<div class="post-loop-ads">';
echo stripcslashes(do_shortcode($ads_code_one));
echo '</div>';
} elseif( 4 == $postcount && $ads_code_two ){
echo '<div class="post-loop-ads">';
echo stripcslashes(do_shortcode($ads_code_two));
echo '</div>';
}
}
}
}
add_action('mp_after_post_article','frkw_add_post_loop_ads');


/*--------------------------------------------
Description: add related posts
---------------------------------------------*/
function frkw_add_related_posts() {
if( is_single() && get_theme_mod('related_on') == 'enable') {
get_template_part( '/templates/related' );
}
}
add_action('mp_after_content_area_inner','frkw_add_related_posts');


/*-----------------------------------------
Description: add footer top html
-----------------------------------------*/
function frkw_add_footer_top_html() { ?>
<footer class="footer-top"><div class="innerwrap">
<div class="ftop">

<div class="footer-box">
<div class="widget-area">
<?php if ( is_active_sidebar( 'first-footer-widget-area' ) ) : ?>
<?php dynamic_sidebar( 'first-footer-widget-area' ); ?>
<?php else: ?>
<aside class="widget widget_recent_entries">
<h3 class="widget-title"><?php _e('About This Theme', 'foldmag'); ?></h3>
<div class="textwidget">
<?php if( function_exists('frkw_theme_info') ) { echo frkw_theme_info(); } ?>
</div>
</aside>
<?php endif; ?>
</div>
</div>

<div class="footer-box footer-box-center">
<div class="widget-area">
<?php if ( is_active_sidebar( 'second-footer-widget-area' ) ) : ?>
<?php dynamic_sidebar( 'second-footer-widget-area' ); ?>
<?php else: ?>
<aside class="widget widget_recent_entries">
<h3 class="widget-title"><?php _e('Recent Posts', 'foldmag'); ?></h3>
<ul><?php wp_get_archives('type=postbypost&limit=5'); ?></ul>
</aside>
<?php endif; ?>
</div>
</div>


<div class="footer-box">
<div class="widget-area">
<?php if ( is_active_sidebar( 'third-footer-widget-area' ) ) : ?>
<?php dynamic_sidebar( 'third-footer-widget-area' ); ?>
<?php else: ?>
<aside class="widget">
<h3 class="widget-title"><?php _e('Tags','foldmag'); ?></h3>
<div class="tagcloud"><?php wp_tag_cloud('smallest=10&largest=20&number=30&unit=px&format=flat&orderby=name'); ?></div>
</aside>
<?php endif; ?>
</div>
</div>


</div>
<?php do_action('mp_inside_footer_top'); ?>
</div></footer>
<?php }
add_action('mp_after_wrapper','frkw_add_footer_top_html');


/*-----------------------------------------
Description: add footer bottom html
-----------------------------------------*/
function frkw_add_footer_bottom_html() { ?>
<footer class="footer-bottom"><div class="innerwrap">
<div class="fbottom">
<div class="footer-left">
<?php do_action('mp_footer_left'); ?>
</div>
<div class="footer-right">
<?php do_action('mp_footer_right'); ?>
</div>
</div></div></footer>
<?php }
add_action('mp_after_wrapper','frkw_add_footer_bottom_html');


/*--------------------------------------------
Description: Add footer nav
---------------------------------------------*/
function frkw_add_footer_copyright() {
echo __('Copyright &copy;', 'foldmag') . gmdate('Y') . ' ' . get_bloginfo('name');
}
add_action('mp_footer_left','frkw_add_footer_copyright');

/*--------------------------------------------
Description: Add footer nav
---------------------------------------------*/
function frkw_add_footer_menu() {
wp_nav_menu( array('theme_location' => 'footer','container' => false,'depth' => 1,'fallback_cb' => 'none'));
}
add_action('mp_footer_right','frkw_add_footer_menu');


/*--------------------------------------------
Description: Add author link
---------------------------------------------*/
add_filter( 'wp_nav_menu_items', 'frkw_add_author_link', 10, 2 );
function frkw_add_author_link ( $items, $args ) {
if ( $args->theme_location == 'footer') {
$items .= '<li>' . frkw_author_info() . '</li>';
}
return $items;
}

/*--------------------------------------------
Description: Add post tags
---------------------------------------------*/
function frkw_add_post_tags() {
if( has_tag() && is_single() ) { ?>
<footer class="entry-meta meta-bottom">
<span class="entry-tag"><?php _e('Tagged:', 'foldmag'); ?><?php the_tags('',''); ?></span>
</footer>
<?php }
}
add_action('mp_after_post_content','frkw_add_post_tags');


/*--------------------------------------------
Description: Add archive thumbnails
---------------------------------------------*/
function frkw_add_archive_thumbnail() {
global $post,$in_bbpress, $bp_active;
if( !is_single() && !is_page() && $in_bbpress != 'true') {
$thepostlink =  '<a href="'. get_permalink() . '" title="' . the_title_attribute('echo=0') . '">';
echo frkw_get_featured_image("<div class='post-thumb'>", "</div>", 400, 280, "alignnone", 'medium', frkw_get_image_alt_text(),the_title_attribute('echo=0'), true, false);
}
}
add_action('mp_before_post_wrapper','frkw_add_archive_thumbnail',10);


/*--------------------------------------------
Description: Add archive thumbnails full
---------------------------------------------*/
function frkw_add_archive_thumbnail_large() {
global $post;
if ( !is_single() && has_post_thumbnail() ) {
$thepostlink =  '<a href="'. get_permalink() . '" title="' . the_title_attribute('echo=0') . '">';
echo '<div class="post-thumb">'. $thepostlink . get_the_post_thumbnail($post->ID,'large') . '</a></div>';
}
}
//add_action('mp_before_post_wrapper','frkw_add_archive_thumbnail_large');

/*--------------------------------------------
Description: Add post entry meta
---------------------------------------------*/
function frkw_add_entry_meta() {
get_template_part('templates/post-meta');
}
add_action('mp_before_post_content','frkw_add_entry_meta');

/*--------------------------------------------
Description: Add post social share
---------------------------------------------*/
function frkw_add_posts_social_share() {
global $in_bbpress, $bp_active;
if( ($bp_active == 'true' && function_exists('bp_is_blog_page') && !bp_is_blog_page() ) || (function_exists('frkw_is_woocommerce_page') && frkw_is_woocommerce_page() )  || ($in_bbpress == 'true') ) {
} else {
if( !is_single() && !is_page() ) {
get_template_part('templates/share-social');
}
}
}
//add_action('mp_before_post_content','frkw_add_posts_social_share');

function frkw_add_single_post_social_share() {
global $in_bbpress, $bp_active;
if( ($bp_active == 'true' && function_exists('bp_is_blog_page') && !bp_is_blog_page() ) || (function_exists('frkw_is_woocommerce_page') && frkw_is_woocommerce_page() )  || ($in_bbpress == 'true') ) {
} else {
if( is_single() ) {
get_template_part('templates/share-social');
}
}
}
add_action('mp_after_post_content','frkw_add_single_post_social_share');


/*--------------------------------------------
Description: Add category meta before title
---------------------------------------------*/
function frkw_add_entry_category_meta() {
global $in_bbpress, $bp_active;
if( ($bp_active == 'true' && function_exists('bp_is_blog_page') && !bp_is_blog_page() ) || (function_exists('frkw_is_woocommerce_page') && frkw_is_woocommerce_page() )  || ($in_bbpress == 'true') ) {
} else {
if( !is_singular() ) { ?>
<div class="home-category-entry"><span><?php echo frkw_get_singular_cat(); ?></span></div>
<?php } } }
//add_action('mp_before_post_wrapper','frkw_add_entry_category_meta',5);


/*--------------------------------------------
Description: add filter searchform
---------------------------------------------*/
function frkw_custom_search_form( $form ) {
$form = '<form method="get" class="search-form" action="' . esc_url( home_url( '/' ) ) . '"><label><span class="screen-reader-text">' . __( 'Search for:', 'foldmag' ) . '</span><input type="search" class="search-field" placeholder="' . __( 'Search &hellip;', 'foldmag' ) . '" value="' . get_search_query() . '" name="s" title="' . __( 'Search for:', 'foldmag' ) . '" /></label> <input type="submit" class="search-submit" value="'. __( 'Search', 'foldmag' ) .'" /></form>';
return $form;
}
add_filter( 'get_search_form', 'frkw_custom_search_form' );


/*--------------------------------------------
Description: move comment textarea to bottom prior to wp 4.4
---------------------------------------------*/
function frkw_move_comment_field_to_bottom( $fields ) {
$comment_field = $fields['comment'];
unset( $fields['comment'] );
$fields['comment'] = $comment_field;
return $fields;
}
add_filter( 'comment_form_fields', 'frkw_move_comment_field_to_bottom' );

/*****************************************************************************************
Add Color Option to Category
http://wordpress.stackexchange.com/questions/112866/adding-colorpicker-field-to-category
*****************************************************************************************/
$categories2 = get_categories('hide_empty=0&orderby=name');
$wp_cats2 = array();
foreach ($categories2 as $category_list ) {
$wp_cats2[$category_list->cat_ID] = $category_list->cat_name;
}
function frkw_extra_category_fields( $tag ) {
$t_id = $tag->term_id;
$cat_meta = get_option( "category_$t_id" );
?>
<tr class="form-field">
<th scope="row" valign="top"><label for="meta-color"><?php _e('Category Color', 'foldmag'); ?></label></th>
<td>
<div id="colorpicker">
<input type="text" name="cat_meta[catBG]" class="colorpicker" size="10" style="width:50%;" value="<?php echo (isset($cat_meta['catBG'])) ? $cat_meta['catBG'] : ''; ?>" />
</div>
<br />
<span class="description"></span>
<br />
</td>
</tr>
<?php
}


/** Save Category Meta **/
function frkw_save_extra_category_fileds( $term_id ) {
if ( isset( $_POST['cat_meta'] ) ) {
        $t_id = $term_id;
        $cat_meta = get_option( "category_$t_id");
        $cat_keys = array_keys($_POST['cat_meta']);
foreach ($cat_keys as $key){
if (isset($_POST['cat_meta'][$key])){
$cat_meta[$key] = $_POST['cat_meta'][$key];
}
}
//save the option array
update_option( "category_$t_id", $cat_meta );
}
}


/** Enqueue Color Picker **/
function frkw_colorpicker_enqueue() {
wp_enqueue_style( 'wp-color-picker' );
wp_enqueue_script( 'colorpicker-js', get_template_directory_uri() . '/scripts/colorpicker.js', array( 'wp-color-picker' ) );
}

//add_action ('category_add_form_fields', 'frkw_extra_category_fields');
//add_action ('category_edit_form_fields','frkw_extra_category_fields');
//add_action ('edited_category', 'frkw_save_extra_category_fileds');
//add_action ('admin_enqueue_scripts', 'frkw_colorpicker_enqueue' );


/*****************************************************************************************
Add Cat Color Options
*****************************************************************************************/
function frkw_catcolor_style_init() {
global $wp_cats2;
print '<style type="text/css" media="all">' . "\n";
foreach ($wp_cats2 as $cat_value) {
$cat_id = get_cat_ID($cat_value);
$cat_data = get_option("category_$cat_id");
$cat_color = $cat_data['catBG']; if($cat_color) { ?>
#custom #entries article.cat_<?php echo $cat_id; ?> .home-category-entry { border-bottom: 5px solid <?php echo $cat_color; ?>;}
#custom #entries article.cat_<?php echo $cat_id; ?> .home-category-entry a { background-color: <?php echo $cat_color; ?>;}  
<?php } }
print '</style>' . "\n";
}
//add_action('wp_head','frkw_catcolor_style_init',10);

/*--------------------------------------------
Description: add schema breadcrumbs
---------------------------------------------*/
function frkw_schema_breadcrumbs() {
global $post;
$schema_on = '';
$schema_link = '';
$schema_prop_url = '';
$schema_prop_title = '';
$showOnHome = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
$delimiter = ' &raquo; '; // delimiter between crumbs
$home = __('Home', 'foldmag'); // text for the 'Home' link
$showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
$before = '<span class="current">'; // tag before the current crumb
$after = '</span>'; // tag after the current crumb
$schema_breadcrumb_on = get_theme_mod('schema_breadcrumb');
if ( $schema_breadcrumb_on == 'enable' ) {
$schema_link = ' itemprop="breadcrumb"';
$schema_prop_url = ' itemprop="url"';
$schema_prop_title = ' itemprop="name"';
}
$homeLink = home_url();
if ( is_home() || is_front_page()) {
if ( $showOnHome == 1 ) {
echo '<div id="breadcrumbs">';
echo __('You are here: ', 'foldmag');
echo '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . $homeLink . '">' . '<span' . $schema_prop_title . '>' . $home . '</span>' . '</a></span>';
if ( get_query_var('paged')) {
echo ' ' . $delimiter . ' ' . __('Page', 'foldmag') . ' ' . get_query_var('paged');
}
echo '</div>';
}
}
else {
echo '<div id="breadcrumbs">';
if ( !is_single()) {
echo __('You are here: ', 'foldmag');
}
echo '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . $homeLink . '">' . '<span' . $schema_prop_title . '>' . $home . '</span>' . '</a></span>' . $delimiter . ' ';
if ( is_category()) {
$thisCat = get_category(get_query_var('cat'), false);
if ( $thisCat->parent != 0 ) {
$category_link = get_category_link($thisCat->parent);
echo '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . $category_link . '">' . '<span' . $schema_prop_title . '>' . get_cat_name($thisCat->parent) . '</span>' . '</a></span>' . $delimiter . ' ';
}
$category_id = get_cat_ID(single_cat_title('', false));
$category_link = get_category_link($category_id);
echo '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . $category_link . '">' . '<span' . $schema_prop_title . '>' . single_cat_title('', false) . '</span>' . '</a></span>';
}
elseif ( is_search()) {
echo __('Search results for', 'foldmag') . ' "' . get_search_query() . '"';
}
elseif ( is_day()) {
echo '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . get_year_link(get_the_time('Y')) . '">' . '<span' . $schema_prop_title . '>' . get_the_time('Y') . '</span>' . '</a></span>' . $delimiter . ' ';
echo '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . '<span' . $schema_prop_title . '>' . get_the_time('F') . '</span>' . '</a></span>' . $delimiter . ' ';
echo '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . get_day_link(get_the_time('Y'), get_the_time('m'), get_the_time('d')) . '">' . '<span' . $schema_prop_title . '>' . get_the_time('d') . '</span>' . '</a></span>';
}
elseif ( is_month()) {
echo '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . get_year_link(get_the_time('Y')) . '">' . '<span' . $schema_prop_title . '>' . get_the_time('Y') . '</span>' . '</a></span>' . $delimiter . ' ';
echo '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . '<span' . $schema_prop_title . '>' . get_the_time('F') . '</span>' . '</a></span>';
}
elseif ( is_year()) {
echo '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . get_year_link(get_the_time('Y')) . '">' . '<span' . $schema_prop_title . '>' . get_the_time('Y') . '</span>' . '</a></span>';
}
elseif ( is_single() && !is_attachment()) {
if ( get_post_type() != 'post' ) {
$post_type = get_post_type_object(get_post_type());
$slug = $post_type->rewrite;
echo '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . $homeLink . '/' . $slug['slug'] . '">' . '<span' . $schema_prop_title . '>' . $post_type->labels->singular_name . '</span>' . '</a></span>';
// get post type by post
$post_type = $post->post_type;
// get post type taxonomies
$taxonomies = get_object_taxonomies($post_type, 'objects');
if ( $taxonomies ) {
foreach ( $taxonomies as $taxonomy_slug => $taxonomy ) {
// get the terms related to post
$terms = get_the_terms($post->ID, $taxonomy_slug);
if ( !empty ( $terms )) {
foreach ( $terms as $term ) {
$taxlist .= ' ' . $delimiter . ' ' . '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . get_term_link($term->slug, $taxonomy_slug) . '">' . '<span' . $schema_prop_title . '>' . ucfirst($term->name) . '</span>' . '</a></span>';
}
}
}
if ( $taxlist ) {
echo $taxlist;
}
}
echo ' ' . $delimiter . ' ' . __('You are reading &raquo;', 'foldmag');
}
else {
$category = get_the_category();
if ( $category ) {
foreach ( $category as $cat ) {
echo '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . get_category_link($cat->term_id) . '">' . '<span' . $schema_prop_title . '>' . $cat->name . '</span>' . '</a></span>' . $delimiter . ' ';
}
}
echo __('You are reading &raquo;', 'foldmag');
}
}
elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {
$post_type = get_post_type_object(get_post_type());
echo $before . $post_type->labels->singular_name . $after;
}
elseif ( is_attachment()) {
$parent = get_post($post->post_parent);
$cat = get_the_category($parent->ID);
$cat = $cat[0];
if ( $cat ) {
echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
}
echo '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . get_permalink($parent) . '">' . '<span' . $schema_prop_title . '>' . $parent->post_title . '</span>' . '</a></span>';
if ( $showCurrent == 1 )
echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
}
elseif ( is_page() && !$post->post_parent ) {
if ( class_exists('buddypress')) {
global $bp;
if ( bp_is_groups_component()) {
echo '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . home_url() . '/' . bp_get_root_slug('groups') . '">' . '<span' . $schema_prop_title . '>' . bp_get_root_slug('groups') . '</span>' . '</a></span>';
if ( !bp_is_directory()) {
echo $delimiter . '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . home_url() . '/' . bp_get_root_slug('groups') . '/' . bp_current_item() . '">' . '<span' . $schema_prop_title . '>' . bp_current_item() . '</span>' . '</a></span>';
if ( bp_current_action()) {
echo $delimiter . '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . home_url() . '/' . bp_get_root_slug('groups') . '/' . bp_current_item() . '/' . bp_current_action() . '">' . '<span' . $schema_prop_title . '>' . bp_current_action() . '</span>' . '</a></span>';
}
}
}
else
if ( bp_is_members_directory()) {
echo '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . home_url() . '/' . bp_get_root_slug('members') . '">' . '<span' . $schema_prop_title . '>' . bp_get_root_slug('members') . '</span>' . '</a></span>';
}
else
if ( bp_is_user()) {
echo '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . home_url() . '/' . bp_get_root_slug('members') . '">' . '<span' . $schema_prop_title . '>' . bp_get_root_slug('members') . '</span>' . '</a></span>';
echo $delimiter . '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . bp_core_get_user_domain($bp->displayed_user->id) . '">' . '<span' . $schema_prop_title . '>' . bp_get_displayed_user_username() . '</span>' . '</a></span>';
if ( bp_current_action()) {
echo $delimiter . '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . bp_core_get_user_domain($bp->displayed_user->id) . bp_current_component() . '">' . '<span' . $schema_prop_title . '>' . bp_current_component() . '</span>' . '</a></span>';
}
}
else {
if ( bp_is_directory()) {
echo '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . get_permalink() . '">' . '<span' . $schema_prop_title . '>' . bp_current_component() . '</span>' . '</a></span>';
}
else {
echo '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . get_permalink() . '">' . '<span' . $schema_prop_title . '>' . the_title_attribute('echo=0') . '</span>' . '</a></span>';
}
}
}
else {
echo '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . get_permalink() . '">' . '<span' . $schema_prop_title . '>' . the_title_attribute('echo=0') . '</span>' . '</a></span>';
}
}
elseif ( is_page() && $post->post_parent ) {
$parent_id = $post->post_parent;
$breadcrumbs = array( );
while ( $parent_id ) {
$page = get_page($parent_id);
$breadcrumbs[] = '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . get_permalink($page->ID) . '">' . '<span' . $schema_prop_title . '>' . get_the_title($page->ID) . '</span>' . '</a></span>';
$parent_id = $page->post_parent;
}
$breadcrumbs = array_reverse($breadcrumbs);
for ( $i = 0; $i < count($breadcrumbs); $i++ ) {
echo $breadcrumbs[$i];
if ( $i != count($breadcrumbs) - 1 )
echo ' ' . $delimiter . ' ';
}
echo $delimiter . '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . get_permalink() . '">' . '<span' . $schema_prop_title . '>' . the_title_attribute('echo=0') . '</span>' . '</a></span>';
}
elseif ( is_tag()) {
$tag_id = get_term_by('name', single_cat_title('', false), 'post_tag');
if ( $tag_id ) {
$tag_link = get_tag_link($tag_id->term_id);
}
echo '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . $tag_link . '">' . '<span' . $schema_prop_title . '>' . single_cat_title('', false) . '</span>' . '</a></span>';
}
elseif ( is_author()) {
global $author;
$userdata = get_userdata($author);
echo '<span' . $schema_link . '><a' . $schema_prop_url . ' href="' . get_author_posts_url($userdata->ID) . '">' . '<span' . $schema_prop_title . '>' . $userdata->display_name . '</span>' . '</a></span>';
}
elseif ( is_404()) {
echo ' ' . $delimiter . ' ' . __('Error 404', 'foldmag');
}
if ( get_query_var('paged')) {
if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) {
echo ' ' . $delimiter . ' ' . __('Page', 'foldmag') . ' ' . get_query_var('paged');
}
}
echo '</div>';
}
}

/*--------------------------------------------
Description: custom meta excerpt
---------------------------------------------*/
function frkw_custom_meta_excerpt($text,$limit) {
global $post;
$output = strip_tags($text);
$output = strip_shortcodes($output);
$output = preg_replace( '|\[(.+?)\](.+?\[/\\1\])?|s', '', $output );
$output = str_replace( '"', "'", $output);
$output = explode(' ', $output, $limit);
if (count($output)>=$limit) {
array_pop($output);
$output = implode(" ",$output).'...';
} else {
$output = implode(" ",$output);
}
return trim($output);
}


/*--------------------------------------------
Description: get user role
---------------------------------------------*/
function frkw_get_user_role($id) {
$user = new WP_User( $id );
if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
foreach ( $user->roles as $role )
return ucfirst($role);
} else {
return 'User';
}
}

/*--------------------------------------------
Description: add schema for posts
---------------------------------------------*/
function frkw_add_custom_schema($content) {
global $post,$aioseop_options;
if( is_single() ) {
$post_aioseo_title = get_post_meta($post->ID, '_aioseop_title', true);
$author_id = get_the_author_meta('ID');
$author_email = get_the_author_meta('user_email');
$author_displayname = get_the_author_meta('display_name');
$author_nickname = get_the_author_meta('nickname');
$author_firstname = get_the_author_meta('first_name');
$author_lastname = get_the_author_meta('last_name');
$author_url = get_the_author_meta('user_url');
$author_status = get_the_author_meta('user_level');
$author_description = get_the_author_meta('user_description');
$author_role = frkw_get_user_role($author_id);
// get post thumbnail
$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "thumbnail" );
$large_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "large" );

if(function_exists('get_site_icon_url')) {
$favicon = get_site_icon_url();
if( $favicon ) {
$favicon = get_site_icon_url();
} else {
$favicon = get_theme_mod('fav_icon');
}
} else {
$favicon = get_theme_mod('fav_icon');
}

// get user google+ profile
$author_googleplus_profile = get_the_author_meta('wp_user_googleplus');
$author_facebook_profile = get_the_author_meta('wp_user_facebook');
$author_twitter_profile = get_the_author_meta('wp_user_twitter');

$schema = '';
?>
<?php
$schema .=  '<!-- start data:schema --><span class="post-schema">';
$schema .= '<meta itemscope itemprop="mainEntityOfPage"  itemType="https://schema.org/WebPage" itemid="' . get_permalink() . '"/><a itemprop="url" href="'. get_permalink() . '" rel="bookmark" title="' . the_title_attribute('echo=0') . ' ">' . get_permalink() . '</a>';

if($post_aioseo_title):
$schema .= '<span itemprop="alternativeHeadline">' . $post_aioseo_title . '</span>';
endif;

if($large_src):
$schema .= '<span itemprop="image" itemscope itemtype="https://schema.org/ImageObject">' . $large_src[0] . '<meta itemprop="url" content="' . $large_src[0] . '"><meta itemprop="width" content="' . $large_src[1] . '"><meta itemprop="height" content="' . $large_src[2] . '"></span>';
endif;
if($thumbnail_src):
$schema .= '<span itemprop="thumbnailUrl">' . $thumbnail_src[0] . '</span>';
endif;
$getmodtime = get_the_modified_time();
if( $getmodtime > get_the_time() ) {
$modtime = get_the_modified_time('c');
} else {
$modtime = get_the_time('c');
}
$schema .= '<time datetime="'.get_the_time('Y-m-d') . '" itemprop="datePublished"><span class="date updated">'. $modtime . '</span></time><meta itemprop="dateModified" content="'. $modtime . '"/><span class="vcard author"><span class="fn">'.get_the_author().'</span></span>';
$categories = get_the_category();
$separator = ', ';
$output = '';
if($categories){
foreach($categories as $category) {
$schema .= '<span itemprop="articleSection">' . $category->cat_name . '</span>';
}
}
$posttags = get_the_tags();
$post_tags_list = '';
if ($posttags) {
$schema .= '<span itemprop="keywords">';
foreach($posttags as $tag) {
$post_tags_list .= $tag->name . ',';
}
$schema .= substr( $post_tags_list,0,-1 );
$schema .= '</span>';
}
$schema .= '<div itemprop="description">'. frkw_custom_meta_excerpt(get_the_content(),50) .'</div>';
$schema .= '<span itemprop="author" itemscope="" itemtype="http://schema.org/Person">';

$schema .= '<span itemprop="name">'.$author_displayname.'</span><a href="'. $author_googleplus_profile. '?rel=author" itemprop="url">'. $author_googleplus_profile . '</a>';

$schema .= '<span itemprop="givenName">'.$author_firstname.'</span>
<span itemprop="familyName">'.$author_lastname.'</span><span itemprop="email">'.$author_email . '</span><span itemprop="jobTitle">'. $author_role . '</span>';

if($author_description):
$schema .= '<span itemprop="knows">'.stripcslashes($author_description).'</span>';
endif;

$schema .= '<span itemprop="brand">'. get_bloginfo('name').'</span>';
$schema .= '</span>';


$schema .= '<span itemprop="publisher" itemscope itemtype="https://schema.org/Organization"><span itemprop="logo" itemscope itemtype="https://schema.org/ImageObject"><img src="' . $favicon . '"/><meta itemprop="url" content="'.$favicon.'"><meta itemprop="width" content="60"><meta itemprop="height" content="60"></span><meta itemprop="name" content="'. get_bloginfo('name') . '"></span>';


$schema .= '</span><!-- end data:schema -->';
return $content . $schema;
} else {
return $content;
}
}


function frkw_add_meta_schema() {
$schema_article = get_theme_mod('schema_article');
if( $schema_article == 'enable' ) { ?>
<div class="post-schema">
<!-- time published and modified schema -->
<time itemprop="datePublished" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo the_time( get_option( 'date_format' ) ); ?></time><time itemprop='dateModified' datetime='<?php echo esc_attr( the_modified_date( 'c' ) ); ?>' ><?php the_modified_date(get_option( 'date_format' )); ?></time>
<!-- keyword and articleSection schema -->
<span itemprop="keywords"><?php the_tags('', ', '); ?></span>
<span itemprop="articleSection"><?php echo the_category(', ',''); ?></span>
<!-- person schema -->
<div itemscope itemprop="author" itemtype="http://schema.org/Person">
<span itemprop="name"><?php the_author_meta('user_nicename'); ?></span>
 <span itemprop='givenName'><?php the_author_meta('first_name'); ?></span>
<span itemprop='familyName'><?php the_author_meta('last_name'); ?></span>
<span itemprop='jobTitle'><?php $user_id = get_the_author_meta('id'); $user_info = get_userdata($user_id); echo implode(', ', $user_info->roles) . "\n"; ?></span>
</div>
<!-- image figure schema -->
<span itemprop="image" itemscope="" itemtype="https://schema.org/ImageObject">
<?php echo frkw_get_featured_image_src('large'); ?>
<meta itemprop="url"
content="<?php echo frkw_get_featured_image_src('large'); ?>"><meta itemprop="width" content="800"><meta itemprop="height" content="600">
</span>
<span itemprop="thumbnailUrl"><?php echo frkw_get_featured_image_src('thumbnail'); ?></span>
<?php
$favicon = get_site_icon_url();
?>
<!-- organization schema -->
<span itemprop="publisher" itemscope itemtype="https://schema.org/Organization"><span itemprop="logo" itemscope itemtype="https://schema.org/ImageObject"><img alt="<?php echo get_bloginfo('name'); ?>" src="<?php echo $favicon; ?>" /><meta itemprop="url" content="<?php echo $favicon; ?>"><meta itemprop="width" content="60"><meta itemprop="height" content="60"></span><meta itemprop="name" content="<?php echo get_bloginfo('name'); ?>"></span>
<!-- extra schema -->
<span itemprop="commentCount"><?php echo get_comments_number(); ?></span>
<span itemprop="discussionUrl"><?php comments_link(); ?></span>
<div itemprop="wordCount"><?php echo frkw_get_word_count(); ?></div>
</div>
<?php
}
}
add_action('mp_inside_post_meta_end','frkw_add_meta_schema');


//change logo itemprop
add_filter('get_custom_logo','frkw_change_logo_schema');
function frkw_change_logo_schema($html) {
$custom_logo_id = get_theme_mod( 'custom_logo' );
 $html = sprintf( '<a href="%1$s" class="custom-logo-link" rel="home">%2$s</a>',
            esc_url( home_url( '/' ) ),
            wp_get_attachment_image( $custom_logo_id, 'full', false, array(
                'class'    => 'custom-logo',
                'alt' => get_bloginfo('description'),
            ) )
        );
    return $html;
}


function frkw_add_webpage_main_img() {
$schema_on = get_theme_mod('schema_article');
if( is_singular() && $schema_on == 'enable') {
echo '<span class="post-schema" itemprop="primaryImageOfPage">'. frkw_get_featured_image_src('large') . '</span>';
}
}
add_action('mp_after_post_article','frkw_add_webpage_main_img');

/*--------------------------------------------
Description: add schema itemtype
---------------------------------------------*/
function frkw_add_itemtype_article() { echo ' itemscope itemtype="http://schema.org/BlogPosting"'; }
function frkw_add_itemtype_post_title() { echo ' itemprop="headline"'; }
function frkw_add_itemtype_post_content() { if( is_singular() ) { echo ' itemprop="articleBody"'; } else { echo ' itemprop="description"'; } }
function frkw_add_itemtype_body() { echo '<div id="'. frkw_get_current_url() . '" itemscope itemtype="http://schema.org/WebPage">'; }
function frkw_add_itemtype_body_close() { echo '</div>'; }

/*--------------------------------------------
Description: add schema init
---------------------------------------------*/
function frkw_init_post_schema() {
/* check if schema is on */
$schema_on = '';
$schema_on = get_theme_mod('schema_article');
if( $schema_on == 'enable' ) {
add_action('mp_start_webpage_schema','frkw_add_itemtype_body');
add_action('mp_end_webpage_schema','frkw_add_itemtype_body_close');
add_action('mp_article_start','frkw_add_itemtype_article');
add_action('mp_article_post_title','frkw_add_itemtype_post_title');
add_action('mp_article_post_content','frkw_add_itemtype_post_content');
}
}
add_action('wp_head','frkw_init_post_schema');



/*---------------------------------------------------------------
Description: add remove hook when background color or image saved
---------------------------------------------------------------*/
function frkw_if_bg_saved() {
$bg_image = get_background_image();
$bg_color = get_background_color();
if( $bg_image || $bg_color ) {
remove_action('mp_before_wrapper', 'frkw_add_header',5);
add_action('mp_inside_wrapper', 'frkw_add_header',5);
remove_action('mp_before_wrapper','frkw_custom_img_header',10);
add_action('mp_inside_wrapper','frkw_custom_img_header',6);
remove_action('mp_after_wrapper','frkw_add_footer_top_html');
add_action('mp_before_end_wrapper','frkw_add_footer_top_html');

echo '<style id="bg-set">'; ?>
body.custom-background #wrapper-content { background-color:#fff; }
body.custom-background #header,body.custom-background footer.footer-top {width:94%;padding:2em 3%;}
body.custom-background #header .innerwrap,body.custom-background footer.footer-top .innerwrap  { font-size:1em; max-width:100%;}
body.custom-background #container {width:94%;padding:0 3%;}
@media only screen and (min-width:800px) {
body.custom-background .content {margin: 3em 360px 0 0;}
body.custom-background #right-sidebar {margin: 0 0 0 -380px;padding: 3em 35px 0 0;}
}
<?php echo '</style>';
}
}
//add_action('wp_head','frkw_if_bg_saved');



?>