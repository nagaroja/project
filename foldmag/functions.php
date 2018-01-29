<?php
/*------------------------------------------------
load theme global variable
------------------------------------------------*/
$theme_data = wp_get_theme();
$theme_version = $theme_data['Version'];
$theme_name = $theme_data['Name'];
$choose_count = array("Select a number","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20");
$choose_weight = array("Select font weight",'light','lighter','normal','bold','100','200','300','400','500','600','700','800','900');
if ( !isset( $content_width ) ) { $content_width = 660; }
//define('SUPER_STYLE', 'yes');
/*------------------------------------------------
load theme setup
------------------------------------------------*/
function frkw_init_setup() {
load_theme_textdomain( 'foldmag', get_template_directory() . '/languages' );
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'title-tag' );
add_theme_support( 'post-thumbnails' );
add_theme_support( 'customize-selective-refresh-widgets' );
add_theme_support( 'custom-logo', array(
    'height'      => 100,
    'width'       => 400,
    'flex-height' => true,
    'flex-width'  => true,
    'header-text' => array( 'site-title', 'site-description' ),
) );
register_nav_menus( array(
'primary' => __( 'Primary Menu', 'foldmag' ),
'footer'  => __( 'Footer Menu', 'foldmag' ),
'mobile'  => __( 'Mobile Menu', 'foldmag' )
));
add_theme_support('html5');
add_editor_style();
if( class_exists('woocommerce') ) { add_theme_support( 'woocommerce' ); }

$custom_background_support = array(
	'default-color'          => '',
	'default-image'          => '',
    'wp-head-callback'       => '_custom_background_cb',
	'admin-head-callback'    => '',
	'admin-preview-callback' => ''
);
add_theme_support( 'custom-background', $custom_background_support );

$custom_header_support = array(
    'default-image'          => '',
	'random-default'         => false,
	'width'                  => 1920,
	'height'                 => 500,
	'flex-height'            => true,
	'flex-width'             => true,
	'default-text-color'     => '',
	'header-text'            => true,
	'uploads'                => true,
	'wp-head-callback'       => '',
	'admin-head-callback'    => '',
	'admin-preview-callback' => '',
);
add_theme_support( 'custom-header', $custom_header_support );
}
add_action('after_setup_theme','frkw_init_setup');

/*------------------------------------------------
load theme stylesheet css
------------------------------------------------*/
function frkw_theme_load_styles() {
global $theme_version;
wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css', array(), $theme_version );

if ( is_rtl() ) {
wp_enqueue_style( 'rtl-style', get_template_directory_uri() . '/rtl.css', array(), $theme_version );
}

wp_enqueue_style( 'superfish-style', get_template_directory_uri(). '/scripts/superfish/superfish.css', array(), $theme_version );

wp_enqueue_style( 'font-awesome-style', get_template_directory_uri(). '/scripts/font-awesome/css/font-awesome.css', array(), $theme_version );

}
add_action('wp_enqueue_scripts','frkw_theme_load_styles');

/*------------------------------------------------
load theme scripts
------------------------------------------------*/
function frkw_theme_load_scripts() {
global $wp_customize,$theme_version, $is_IE;
wp_enqueue_script("jquery");
wp_enqueue_script('hoverIntent');

if ( isset($wp_customize) && $wp_customize->is_preview() && !is_admin() ) {
wp_enqueue_script('theme-customizer-js', get_template_directory_uri() . '/functions/theme-customizer/theme-customizer.js', false, $theme_version, true );
}

wp_enqueue_script('modernizr-js', get_template_directory_uri() . '/scripts/modernizr/modernizr.js', false, $theme_version, true );

if($is_IE) {
wp_enqueue_script('html5shim-js', get_template_directory_uri() . '/scripts/html5shiv.js', false,$theme_version, false );
}

wp_enqueue_script('superfish-js', get_template_directory_uri() . '/scripts/superfish/superfish.js', false, $theme_version, true );
wp_enqueue_script('supersub-js', get_template_directory_uri() . '/scripts/superfish/supersubs.js', false, $theme_version, true );

wp_enqueue_script('custom-js', get_template_directory_uri() . '/scripts/custom.js', false,$theme_version, true );

if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
wp_enqueue_script( 'comment-reply' );
}

}
add_action('wp_enqueue_scripts','frkw_theme_load_scripts');


/*------------------------------------------------
load default Google web fonts
------------------------------------------------*/
function frkw_load_gwf_styles() {
if( get_theme_mod('body_font') == 'Choose a font' || get_theme_mod('body_font') == '') {
wp_register_style('body_gwf', '//fonts.googleapis.com/css?family=Roboto:400,400i,700,700i,900,900i');
wp_enqueue_style( 'body_gwf');
}

if( get_theme_mod('headline_font') == 'Choose a font' || get_theme_mod('headline_font') == '') {
//wp_register_style('headline_gwf', '//fonts.googleapis.com/css?family=Oswald:300,400,700');
//wp_enqueue_style( 'headline_gwf');
}

if( get_theme_mod('navigation_font') == 'Choose a font' || get_theme_mod('navigation_font') == '') {
//wp_register_style('navigation_gwf', '//fonts.googleapis.com/css?family=Noto+Sans:400,400i,700,700i');
//wp_enqueue_style( 'navigation_gwf');
}

}
add_action('wp_enqueue_scripts', 'frkw_load_gwf_styles');

/*------------------------------------------------
load theme functions
------------------------------------------------*/
include( get_template_directory() . '/functions/theme-functions.php' );
include( get_template_directory() . '/functions/option-functions.php' );
include( get_template_directory() . '/functions/widget-functions.php' );
include( get_template_directory() . '/functions/fonts-functions.php' );
include( get_template_directory() . '/functions/customizer-functions.php' );
include( get_template_directory() . '/functions/hook-functions.php' );
include( get_template_directory() . '/functions/theme-customizer/sanitization-callbacks.php' );

/*-------------------------------------------------------
load theme buddypress, woocommerce and bbpress functions
-------------------------------------------------------*/
if ( class_exists('woocommerce') && file_exists( get_template_directory() . '/functions/woocommerce/functions.php' ) ) { include_once( get_template_directory() . '/functions/woocommerce/functions.php' ); }
if ( class_exists('buddypress') && file_exists( get_template_directory() . '/functions/buddypress/functions.php' ) ) { include_once( get_template_directory() . '/functions/buddypress/functions.php' ); }
if ( class_exists('bbpress') && file_exists( get_template_directory() . '/functions/bbpress/functions.php' ) ) { include_once( get_template_directory() . '/functions/bbpress/functions.php' ); }

?>