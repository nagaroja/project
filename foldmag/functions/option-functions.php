<?php
/*--------------------------------------------
Description: add body font style
---------------------------------------------*/
function frkw_add_body_font_style() {
$bodyfont = get_theme_mod('body_font');
$bodyfontweight = get_theme_mod('body_font_weight');
if( $bodyfont == 'Choose a font' || $bodyfont == '') { ?>
body {font-family: 'Roboto',arial; font-weight:400; }
<?php } else { ?>
body {font-family:<?php echo $bodyfont; ?>;font-weight:<?php echo $bodyfontweight; ?>;}
<?php
}
}
add_action('frkw_custom_css','frkw_add_body_font_style');


/*--------------------------------------------
Description: add headline font style
---------------------------------------------*/
function frkw_add_headline_font_style() {
$headlinefont = get_theme_mod('headline_font');
$headlinefontweight = get_theme_mod('headline_font_weight');
if( $headlinefont == 'Choose a font' || $headlinefont == '') { ?>
h1,h2,h3,h4,h5,h6,#siteinfo h1, #siteinfo h2, #siteinfo div,.activity-header { font-family: 'Roboto',arial;  font-weight:700 !important; }
<?php } else { ?>
h1,h2,h3,h4,h5,h6,#siteinfo h1, #siteinfo h2, #siteinfo div,.activity-header { font-family: <?php echo $headlinefont; ?>; font-weight: <?php echo $headlinefontweight; ?>; }
<?php
}
}
add_action('frkw_custom_css','frkw_add_headline_font_style');

/*--------------------------------------------
Description: add navigation font style
---------------------------------------------*/
function frkw_add_navigation_font_style() {
$navfont = get_theme_mod('navigation_font');
$navfontweight = get_theme_mod('navigation_font_weight');
if( $navfont == 'Choose a font' || $navfont == '') { ?>
.sf-menu a {font-family: 'Roboto',arial;  font-weight:900;}
<?php } else { ?>
.sf-menu a {font-family: <?php echo $navfont; ?>; font-weight:<?php echo $navfontweight; ?>; }
<?php
}
}
add_action('frkw_custom_css','frkw_add_navigation_font_style');



/*----------------------------------------------------
Description: add theme header text style
----------------------------------------------------*/
function frkw_add_header_textcolor() {
$header_text = get_theme_mod('header_text');
$header_textcolor = get_theme_mod('header_textcolor');
if( $header_textcolor == 'blank' ) { ?>
#custom #siteinfo h1, #custom #siteinfo p,#custom .site-title-wrap {display:none;}
<?php } else {
if( $header_textcolor ) { ?>
#custom #siteinfo a {color: #<?php echo $header_textcolor; ?> !important;text-decoration: none;}
#custom #siteinfo p#site-description {color: #<?php echo $header_textcolor; ?> !important;text-decoration: none;}
<?php
}
}
}
add_action('frkw_custom_css','frkw_add_header_textcolor');


/*----------------------------------------------------
Description: add main color css
----------------------------------------------------*/
function frkw_add_main_color() {
$main_color = get_theme_mod('main_color');
if( $main_color ) { ?>

#header {background-color:<?php echo $main_color; ?>;}
#mobile-nav .mobile-open a {background-color: <?php echo $main_color; ?>;}
#main-navigation .sf-menu li li a:hover {background-color:<?php echo $main_color; ?>;}
.post-paging .page-navigation span.current {background-color:<?php echo $main_color; ?>;border:1px solid <?php echo $main_color; ?>;}
.post-paging .page-navigation a:hover {color:<?php echo $main_color; ?>;border:1px solid <?php echo $main_color; ?>;}
.content a,#right-sidebar .widget a:hover, aside.widget #calendar_wrap a, #custom aside.widget .textwidget a,.content-area article span.entry-tag a,#related-posts .related-post a {color:<?php echo $main_color; ?>;}

.content-area article h2.entry-title a {color: <?php echo $main_color; ?>;}
#right-sidebar aside.widget a {color: <?php echo $main_color; ?>;}
#right-sidebar aside.widget h3.widget-title {background-color: <?php echo $main_color; ?>;border-color:<?php echo $main_color; ?>;}

#custom .content-area article h2.entry-title a:hover {color: <?php echo dehex($main_color,-10); ?>;}

footer.footer-top {background-color: <?php echo $main_color; ?>;}

footer.footer-bottom {background-color: <?php echo dehex($main_color,-20); ?>;}

footer aside.widget ul.featured-cat-posts li,footer aside.widget ul.item-list li {
border-bottom: 1px solid <?php echo dehex($main_color,-10); ?>;
}
footer .ftop aside.widget a:hover  {color:<?php echo dehex($main_color,80); ?>;}

<?php }
}
add_action('frkw_custom_css','frkw_add_main_color');


/*----------------------------------------------------
Description: add footer background image
----------------------------------------------------*/
function frkw_add_footer_bg_image() {
$footer_bg = get_theme_mod('footer_bg_image');
if( $footer_bg ) { ?>
footer.footer-top {background: #000 url(<?php echo $footer_bg; ?>) no-repeat center center;-webkit-background-size: cover;
-moz-background-size: cover;-o-background-size: cover;background-size: cover;}
<?php }
}
//add_action('frkw_custom_css','frkw_add_footer_bg_image');


/*----------------------------------------------------
Description: add theme custom css
----------------------------------------------------*/
function frkw_add_theme_custom_css() {
$customcss = get_theme_mod('custom_css');
if( $customcss ) { echo $customcss; }
}
add_action('frkw_custom_css','frkw_add_theme_custom_css');


/*----------------------------------------------------
Description: let's finalize all it wp_head
----------------------------------------------------*/
function frkw_init_theme_custom_style() {
print '<style id="theme-custom-css" type="text/css" media="all">' . "\n";
do_action( 'frkw_custom_css' );
print '</style>' . "\n";
}
add_action('wp_head','frkw_init_theme_custom_style',99);

?>