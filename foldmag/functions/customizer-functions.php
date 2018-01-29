<?php
if( !function_exists('frkw_check_theme_valid') ) { wp_die(); }
global $theme_version;
if ( ! isset( $wp_customize ) ) { return; }

/*--------------------------------------------
Description: load customizer css
---------------------------------------------*/
function frkw_add_customizer_custom_css() {
wp_enqueue_style('theme-customizer-css', get_template_directory_uri() . '/functions/theme-customizer/theme-customizer.css', array(), $theme_version);
}
add_action( 'customize_controls_print_styles', 'frkw_add_customizer_custom_css', 999 );


/*--------------------------------------------
Description: customizer google web font live preview
---------------------------------------------*/
function frkw_add_google_webfont_preview() { ?>
<link id="google_body" rel="stylesheet" href="">
<link id="google_headline" rel="stylesheet" href="">
<link id="google_nav" rel="stylesheet" href="">
<?php }
add_action('wp_head','frkw_add_google_webfont_preview');


/*--------------------------------------------
Description: customizer fonts list
---------------------------------------------*/
class FRKW_Fonts_Family_Option_Control extends WP_Customize_Control {
public $type = 'select';
public function render_content() {
global $font_family_group;
?>
<label>
<span class="customize-control-title"><?php echo esc_html( $this->description ); ?></span>
<select data-customize-setting-link="<?php echo $this->id; ?>">
<?php foreach($font_family_group as $font): ?>
<option<?php $fontsave = get_theme_mod($this->id); if( $fontsave == $font ) { ?> selected="selected"<?php } ?> value="<?php echo $font; ?>"><?php echo ucfirst($font); ?></option>
<?php endforeach; ?>
</select>
</label>
<?php
}
}


/*--------------------------------------------
Description: customizer font weight
---------------------------------------------*/
class FRKW_Fonts_Weight_Option_Control extends WP_Customize_Control {
public $type = 'select';
public function render_content() {
global $choose_weight;
?>
<label>
<span class="customize-control-title"><?php echo esc_html( $this->description ); ?></span>
<select data-customize-setting-link="<?php echo $this->id; ?>">
<?php foreach($choose_weight as $weight): ?>
<option<?php $fontweightsave = get_theme_mod($this->id); if( $fontweightsave == $weight ) { ?> selected="selected"<?php } ?> value="<?php echo $weight; ?>"><?php echo ucfirst($weight); ?></option>
<?php endforeach; ?>
</select>
</label>
<?php
}
}


/*--------------------------------------------
Description: customizer count selection
---------------------------------------------*/
class FRKW_Choose_Count_Option_Control extends WP_Customize_Control {
public $type = 'select';
public function render_content() {
global $choose_count;
?>
<label>
<span class="customize-control-title"><?php echo esc_html( $this->description ); ?></span>
<select data-customize-setting-link="<?php echo $this->id; ?>">
<?php foreach($choose_count as $count): ?>
<option<?php $choosecountsave = get_theme_mod($this->id); if( $choosecountsave == $count ) { ?> selected="selected"<?php } ?> value="<?php echo $count; ?>"><?php echo $count; ?></option>
<?php endforeach; ?>
</select>
</label>
<?php
}
}


/*--------------------------------------------
Description: customizer category selection
---------------------------------------------*/
class FRKW_Category_Dropdown_Control extends WP_Customize_Control {
public $type = 'select';
private $cats = false;
public function __construct($manager, $id, $args = array(), $options = array()) {
$this->cats = get_categories($options);
parent::__construct( $manager, $id, $args );
}
public function render_content() {
if(!empty($this->cats)) { ?>
<label>
<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
<select data-customize-setting-link="<?php echo $this->id; ?>">
<option<?php $catsave = get_theme_mod($this->id); if( $catsave == '' && $catsave == 'Choose a category' ) { ?> selected="selected"<?php } ?> value="Choose a category"><?php _e('Choose a category', 'foldmag'); ?></option>
<?php foreach ( $this->cats as $cat ) {
printf('<option value="%s" %s>%s</option>', $cat->term_id, selected($this->value(), $cat->term_id, false), $cat->name);
}
?>
</select>
</label>
<?php
}
}
}


/*--------------------------------------------
Description: customizer register panels
---------------------------------------------*/
add_action( 'customize_register', 'frkw_customizer_add_panels' );
function frkw_customizer_add_panels($wp_customize) {

$wp_customize->add_panel('frkw_posts_option_panel', array(
'priority' 			=> 30,
'capability' 		=> 'edit_theme_options',
'theme_supports'	=> '',
'title' 			=> __( 'Theme Options', 'foldmag' ),
'description' 		=> __( 'Customize this theme', 'foldmag' ),
)
);

}




/*--------------------------------------------
Description: customizer register sections
---------------------------------------------*/
add_action( 'customize_register', 'frkw_customizer_add_sections' );
function frkw_customizer_add_sections($wp_customize) {

// font sections
$wp_customize->add_section( 'custom_font_section', array (
'title'			=> __( 'Fonts', 'foldmag' ),
'description'	=> __( 'Theme fonts settings', 'foldmag' ),
'priority'	=> 30,
'panel'	=> 'frkw_posts_option_panel'
)
);


// post sections
$wp_customize->add_section( 'custom_post_section', array (
'title'			=> __( 'Posts', 'foldmag' ),
'description'	=> __( 'Theme posts settings', 'foldmag' ),
'priority'	=> 35,
'panel'	=> 'frkw_posts_option_panel'
)
);

// post sections
$wp_customize->add_section( 'custom_home_section', array (
'title'			=> __( 'Home', 'foldmag' ),
'description'	=> __( 'Home settings', 'foldmag' ),
'priority'	=> 32,
'panel'	=> 'frkw_posts_option_panel'
)
);


// ads sections
$wp_customize->add_section( 'custom_ads_section', array (
'title'			=> __( 'Advertisement', 'foldmag' ),
'description'	=> __( 'Advertisement location settings', 'foldmag' ),
'priority'	=> 30,
'panel'	=> 'frkw_posts_option_panel'  
)
);

// misc sections
$wp_customize->add_section( 'custom_misc_section', array (
'title'			=> __( 'Miscellaneous', 'foldmag' ),
'description'	=> __( 'Miscellaneous settings', 'foldmag' ),
'priority'	=> 40,
'panel'	=> 'frkw_posts_option_panel'
)
);

// css sections
$wp_customize->add_section( 'custom_css_section', array (
'title'			=> __( 'Custom CSS', 'foldmag' ),
'description'	=> __( 'Custom css and style settings', 'foldmag' ),
'priority'	=> 50,
'panel'	=> 'frkw_posts_option_panel'
)
);
}



/*--------------------------------------------
Description: customizer register settings
---------------------------------------------*/
add_action( 'customize_register', 'frkw_customizer_add_settings' );
function frkw_customizer_add_settings($wp_customize) {

$wp_customize->add_setting('footer_bg_image' , array('default' => '','type' => 'theme_mod','sanitize_callback'=> 'frkw_sanitize_image','capability' => 'edit_theme_options'));

$wp_customize->add_setting('body_font' , array('default' => '','type' => 'theme_mod','capability' => 'edit_theme_options','transport' => 'postMessage','sanitize_callback' => 'frkw_sanitize_nohtml'));

$wp_customize->add_setting('body_font_weight' , array('default' => '','type' => 'theme_mod','capability' => 'edit_theme_options','transport' => 'postMessage','sanitize_callback' => 'frkw_sanitize_nohtml'));

$wp_customize->add_setting('headline_font' , array('default' => '','type' => 'theme_mod','capability' => 'edit_theme_options','transport' => 'postMessage','sanitize_callback' => 'frkw_sanitize_nohtml'));

$wp_customize->add_setting('headline_font_weight' , array('default' => '','type' => 'theme_mod','capability' => 'edit_theme_options','transport' => 'postMessage','sanitize_callback' => 'frkw_sanitize_nohtml')
);

$wp_customize->add_setting('navigation_font' , array('default' => '','type' => 'theme_mod','capability' => 'edit_theme_options','transport' => 'postMessage','sanitize_callback' => 'frkw_sanitize_nohtml'));

$wp_customize->add_setting('navigation_font_weight' , array('default' => '','type' => 'theme_mod','capability' => 'edit_theme_options','transport' => 'postMessage','sanitize_callback' => 'frkw_sanitize_nohtml'));

$wp_customize->add_setting('main_color',array('type' => 'theme_mod','capability' => 'edit_theme_options','default' => '','sanitize_callback' => 'frkw_sanitize_css'));

$wp_customize->add_setting('first_feat_img',array('type' => 'theme_mod','capability' => 'edit_theme_options','default' => 'disable','sanitize_callback' => 'frkw_sanitize_select'));

$wp_customize->add_setting('related_on',array('type' => 'theme_mod','capability' => 'edit_theme_options','default' => 'disable','sanitize_callback' => 'frkw_sanitize_select'));

$wp_customize->add_setting('related_count',array('type' => 'theme_mod','capability' => 'edit_theme_options','default' => 3,'sanitize_callback' => 'frkw_sanitize_number_absint'));

$wp_customize->add_setting('author_bio_on',array('type' => 'theme_mod','capability' => 'edit_theme_options','default' => 'disable','sanitize_callback' => 'frkw_sanitize_select'));

$wp_customize->add_setting('breadcrumbs_on',array('type' => 'theme_mod','capability' => 'edit_theme_options','default' => 'disable','sanitize_callback' => 'frkw_sanitize_select'));

$wp_customize->add_setting('social_on',array('type' => 'theme_mod','capability' => 'edit_theme_options','default' => 'disable','sanitize_callback' => 'frkw_sanitize_select'));

$wp_customize->add_setting('home_feat_cat',array('type' => 'theme_mod','capability' => 'edit_theme_options','default' => '','sanitize_callback' => 'frkw_sanitize_nohtml'));

$wp_customize->add_setting('home_feat_cat_count',array('type' => 'theme_mod','capability' => 'edit_theme_options','default' => '','sanitize_callback' => 'frkw_sanitize_select'));

$wp_customize->add_setting('home_feat_post',array('type' => 'theme_mod','capability' => 'edit_theme_options','default' => '','sanitize_callback' => 'frkw_sanitize_nohtml'));

$wp_customize->add_setting( 'header_ad_code', array('type' => 'theme_mod','capability' => 'edit_theme_options','default' => '','sanitize_callback' => apply_filters('frkw_textarea_settings_filter','frkw_sanitize_textarea')) );

$wp_customize->add_setting( 'post_loop_ad_code_one', array('type' => 'theme_mod','capability' => 'edit_theme_options',
'default' => '','sanitize_callback' => apply_filters('frkw_textarea_settings_filter','frkw_sanitize_textarea')) );

$wp_customize->add_setting( 'post_loop_ad_code_two', array('type' => 'theme_mod','capability' => 'edit_theme_options',
'default' => '','sanitize_callback' => apply_filters('frkw_textarea_settings_filter','frkw_sanitize_textarea')) );

$wp_customize->add_setting( 'post_single_ad_code_top', array('type' => 'theme_mod','capability' => 'edit_theme_options','default' => '','sanitize_callback' => apply_filters('frkw_textarea_settings_filter','frkw_sanitize_textarea')) );

$wp_customize->add_setting( 'post_single_ad_code_bottom', array('type' => 'theme_mod','capability' => 'edit_theme_options','default' => '','sanitize_callback' => apply_filters('frkw_textarea_settings_filter','frkw_sanitize_textarea')) );

$wp_customize->add_setting( 'right_sidebar_ad_code', array('type' => 'theme_mod','capability' => 'edit_theme_options',
'default' => '','sanitize_callback' => apply_filters('frkw_textarea_settings_filter','frkw_sanitize_textarea')) );

$wp_customize->add_setting( 'schema_article', array('type' => 'theme_mod','capability' => 'edit_theme_options','default' => 'disable','sanitize_callback' => 'frkw_sanitize_select') );

$wp_customize->add_setting( 'schema_breadcrumb', array('type' => 'theme_mod','capability' => 'edit_theme_options','default' => 'disable','sanitize_callback' => 'frkw_sanitize_select') );

$wp_customize->add_setting( 'schema_comment', array('type' => 'theme_mod','capability' => 'edit_theme_options','default' => 'disable','sanitize_callback' => 'frkw_sanitize_select') );

$wp_customize->add_setting('facebook_url',array('type' => 'theme_mod','capability' => 'edit_theme_options','default' => '','sanitize_callback' => 'frkw_sanitize_nohtml'));

$wp_customize->add_setting('twitter_url',array('type' => 'theme_mod','capability' => 'edit_theme_options','default' => '','sanitize_callback' => 'frkw_sanitize_nohtml'));

$wp_customize->add_setting('google_plus_url',array('type' => 'theme_mod','capability' => 'edit_theme_options','default' => '','sanitize_callback' => 'frkw_sanitize_nohtml'));

$wp_customize->add_setting('pinterest_url',array('type' => 'theme_mod','capability' => 'edit_theme_options','default' => '','sanitize_callback' => 'frkw_sanitize_nohtml'));

$wp_customize->add_setting('rss_feed_url',array('type' => 'theme_mod','capability' => 'edit_theme_options','default' => '','sanitize_callback' => 'frkw_sanitize_nohtml'));

$wp_customize->add_setting( 'custom_css', array('type' => 'theme_mod','capability' => 'edit_theme_options','default' => '','sanitize_callback' => 'frkw_sanitize_css') );

}


/*--------------------------------------------
Description: customizer register controls
---------------------------------------------*/
add_action( 'customize_register', 'frkw_customizer_add_control' );
function frkw_customizer_add_control($wp_customize) {
global $choose_count;

$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'footer_bg_image', array(
'label'   => 'Footer Background Image',
'section' => 'background_image',
'settings'   => 'footer_bg_image'
) ) );

$wp_customize->add_control(
new FRKW_Fonts_Family_Option_Control (
$wp_customize,'body_font',array('label' => 'Body Font','section' => 'custom_font_section','description'	=> __( 'Body', 'foldmag' ),'settings' => 'body_font')));

$wp_customize->add_control(
new FRKW_Fonts_Weight_Option_Control (
$wp_customize,'body_font_weight',array('label' => 'Body Font Weight','section' => 'custom_font_section','description'	=> __( 'font weight', 'foldmag' ),'settings' => 'body_font_weight')));


$wp_customize->add_control(
    new FRKW_Fonts_Family_Option_Control (
        $wp_customize,
        'headline_font',
        array(
            'label'   => 'Headline Font',
            'section' => 'custom_font_section',
            'description'	=> __( 'Headline', 'foldmag' ),
            'settings' => 'headline_font'
        )
    )
);


$wp_customize->add_control(
     new FRKW_Fonts_Weight_Option_Control (
        $wp_customize,
        'headline_font_weight',
        array(
            'label'   => 'Headline Font Weight',
            'section' => 'custom_font_section',
            'description'	=> __( 'font weight', 'foldmag' ),
            'settings' => 'headline_font_weight'
        )
    )
);


$wp_customize->add_control(
    new FRKW_Fonts_Family_Option_Control (
        $wp_customize,
        'navigation_font',
        array(
            'label'   => 'Navigation Font',
            'section' => 'custom_font_section',
            'description'	=> __( 'Navigation', 'foldmag' ),
            'settings' => 'navigation_font'
        )
    )
);


$wp_customize->add_control(
     new FRKW_Fonts_Weight_Option_Control (
        $wp_customize,
        'navigation_font_weight',
        array(
            'label'   => 'Navigation Font Weight',
            'section' => 'custom_font_section',
            'description'	=> __( 'font weight', 'foldmag' ),
            'settings' => 'navigation_font_weight'
        )
    )
);

$wp_customize->add_control( new WP_Customize_Color_Control(
$wp_customize,'main_color',
        array(
            'label' => __("Main Color", 'foldmag'),
            'section' => 'colors',
            'settings' => 'main_color',
        )));


$wp_customize->add_control( 'first_feat_img', array(
'label'   =>  __("Enable First Image Grab for Featured Thumbnails", 'foldmag'),
'section' => 'custom_post_section',
'settings'   => 'first_feat_img',
'type'     => 'radio',
'choices'  => array(
'disable'  => 'Disable',
'enable' => 'Enable',
),
)
);



$wp_customize->add_control( 'related_on', array(
'label'   =>  __("Enable Related Posts", 'foldmag'),
'section' => 'custom_post_section',
'settings'   => 'related_on',
'type'     => 'radio',
'choices'  => array(
'disable'  => 'Disable',
'enable' => 'Enable',
),
)
);


$wp_customize->add_control(
     new frkw_Choose_Count_Option_Control (
        $wp_customize,
        'related_count',
        array(
            'label'   => 'Related Count',
            'section' => 'custom_post_section',
            'description'	=> __( 'Choose related count', 'foldmag' ),
            'settings' => 'related_count'
        )
    )
);




$wp_customize->add_control( 'author_bio_on', array(
'label'   => __("Enable Author Bio", 'foldmag'),
'section' => 'custom_post_section',
'settings'   => 'author_bio_on',
'type'     => 'radio',
'choices'  => array(
'disable'  => 'Disable',
'enable' => 'Enable',
),
)
);


$wp_customize->add_control( 'breadcrumbs_on', array(
'label'   => __("Enable Breadcrumbs", 'foldmag'),
'section' => 'custom_post_section',
'settings'   => 'breadcrumbs_on',
'type'     => 'radio',
'choices'  => array(
'disable'  => 'Disable',
'enable' => 'Enable',
),
)
);


$wp_customize->add_control( 'social_on', array(
'label'   => __("Enable Social Share", 'foldmag'),
'section' => 'custom_post_section',
'settings'   => 'social_on',
'type'     => 'radio',
'choices'  => array(
'disable'  => 'Disable',
'enable' => 'Enable',
),
)
);


$wp_customize->add_control( 'home_feat_cat', array(
'label'   => __( 'Choose Featured Category for Homepage', 'foldmag' ),
'description' => __( 'Add a single or list of cat ids to featured in homepage<br /><small>example: 7,16,33</small>', 'foldmag' ),
'section' => 'custom_home_section',
'settings'   => 'home_feat_cat',
'type'     => 'text'
)
);


$wp_customize->add_control( 'home_feat_cat_count', array(
'label'   => __( 'How many to show?', 'foldmag' ),
'description' => __( 'Choose how many posts from the choosen category to show', 'foldmag' ),
'section' => 'custom_home_section',
'settings'   => 'home_feat_cat_count',
'type'     => 'select',
'choices'  => $choose_count
)
);


$desc_string = sprintf( __("Add a list of post ids to featured in homepage, max 10. Post type: %s Supported.<br /><small>example: 136,928,925,80,77,55,49</small>", 'foldmag'), get_transient('frkw_supported_posttype') );
$wp_customize->add_control( 'home_feat_post', array(
'label'   => __( 'OR Choose Featured Posts for Homepage', 'foldmag' ),
'description' => $desc_string,
'section' => 'custom_home_section',
'settings'   => 'home_feat_post',
'type'     => 'text'
)
);


$wp_customize->add_control( 'header_ad_code', array(
'label' => __("Top Header", 'foldmag'),
'description' => __("Add script code or image banner here", 'foldmag'),
'section' => 'custom_ads_section',
'settings'   => 'header_ad_code',
'type'     => 'textarea'
) );


$wp_customize->add_control( 'post_loop_ad_code_one', array(
'label' => __("First Post Loop", 'foldmag'),
'description' => __("Add script code or image banner here.", 'foldmag'),
'section' => 'custom_ads_section',
'settings'   => 'post_loop_ad_code_one',
'type'     => 'textarea'
) );

$wp_customize->add_control( 'post_loop_ad_code_two', array(
'label' => __("Second Post Loop", 'foldmag'),
'description' => __("Add script code or image banner here", 'foldmag'),
'section' => 'custom_ads_section',
'settings'   => 'post_loop_ad_code_two',
'type'     => 'textarea'
) );


$wp_customize->add_control( 'post_single_ad_code_top', array(
'label' => __("Single Post Top", 'foldmag'),
'description' => __("Add script code or image banner here", 'foldmag'),
'section' => 'custom_ads_section',
'settings'   => 'post_single_ad_code_top',
'type'     => 'textarea'
) );


$wp_customize->add_control( 'post_single_ad_code_bottom', array(
'label' => __("Single Post Bottom", 'foldmag'),
'description' => __("Add script code or image banner here", 'foldmag'),
'section' => 'custom_ads_section',
'settings'   => 'post_single_ad_code_bottom',
'type'     => 'textarea'
) );

$wp_customize->add_control( 'right_sidebar_ad_code', array(
'label' => __("Right Sidebar", 'foldmag'),
'description' => __("Add script code or image banner here.", 'foldmag'),
'section' => 'custom_ads_section',
'settings'   => 'right_sidebar_ad_code',
'type'     => 'textarea'
) );



$wp_customize->add_control( 'schema_article', array(
'label' => __("Schema.org Markup for Posts", 'foldmag'),
'description' => __("Choose to disable or enable schema markup for posts", 'foldmag'),
'section' => 'custom_misc_section',
'settings'   => 'schema_article',
'type'     => 'radio', 'choices'  => array('disable'  => 'Disable', 'enable' => 'Enable',)
));


$wp_customize->add_control( 'schema_breadcrumb', array(
'label' => __("Schema.org Markup for Breadcrumb", 'foldmag'),
'description' => __("Choose to disable or enable schema markup for site breadcrumb", 'foldmag'),
'section' => 'custom_misc_section',
'settings'   => 'schema_breadcrumb',
'type'     => 'radio', 'choices'  => array('disable'  => 'Disable', 'enable' => 'Enable',)
));

$wp_customize->add_control( 'schema_comment', array(
'label' => __("Schema.org Markup for Comments", 'foldmag'),
'description' => __("Choose to disable or enable schema markup for comments", 'foldmag'),
'section' => 'custom_misc_section',
'settings'   => 'schema_comment',
'type'     => 'radio', 'choices'  => array('disable'  => 'Disable', 'enable' => 'Enable',)
));


 $wp_customize->add_control( 'facebook_url', array(
'label'   => __( 'Facebook Link', 'foldmag' ),
'description' => __( 'Enter full url include http for your Facebook link', 'foldmag' ),
'section' => 'custom_misc_section',
'settings'   => 'facebook_url',
'type'     => 'text'
)
);

 $wp_customize->add_control( 'twitter_url', array(
'label'   => __( 'Twitter Link', 'foldmag' ),
'description' => __( 'Enter full url with http for your Twitter link', 'foldmag' ),
'section' => 'custom_misc_section',
'settings'   => 'twitter_url',
'type'     => 'text'
)
);

 $wp_customize->add_control( 'google_plus_url', array(
'label'   => __( 'Google Plus Link', 'foldmag' ),
'description' => __( 'Enter full url with http for your Google Plus link', 'foldmag' ),
'section' => 'custom_misc_section',
'settings'   => 'google_plus_url',
'type'     => 'text'
)
);

 $wp_customize->add_control( 'pinterest_url', array(
'label'   => __( 'Pinterest Link', 'foldmag' ),
'description' => __( 'Enter full url with http for your Pinterest link', 'foldmag' ),
'section' => 'custom_misc_section',
'settings'   => 'pinterest_url',
'type'     => 'text'
)
);

 $wp_customize->add_control( 'rss_feed_url', array(
'label'   => __( 'RSS Feed Link', 'foldmag' ),
'description' => __( 'Enter full url with http for your RSS feed link', 'foldmag' ),
'section' => 'custom_misc_section',
'settings'   => 'rss_feed_url',
'type'     => 'text'
)
);

$wp_customize->add_control( 'custom_css', array(
'label' => __("Custom CSS", 'foldmag'),
'description' => __("Insert your custom css here.", 'foldmag'),
'section' => 'custom_css_section',
'settings'   => 'custom_css',
'type'     => 'textarea'
) );

}


/*--------------------------------------------
Description: customizer reset core functions
Original Code from: http://wordpress.org/plugins/customizer-reset/
---------------------------------------------*/
if ( ! class_exists( 'FRKW_Customizer_Reset' ) ) {
final class FRKW_Customizer_Reset {
private static $instance = null;
private $wp_customize;
public static function get_instance() {
if ( null === self::$instance ) {
self::$instance = new self();
}
return self::$instance;
}
private function __construct() {
add_action( 'customize_controls_print_scripts', array( $this, 'customize_controls_print_scripts' ) );
add_action( 'wp_ajax_customizer_reset', array( $this, 'ajax_customizer_reset' ) );
add_action( 'customize_register', array( $this, 'customize_register' ) );
}

public function customize_controls_print_scripts() {
wp_enqueue_script( 'frkw-customizer-reset', get_template_directory_uri() . '/functions/theme-customizer/customizer-reset.js', array( 'jquery' ), $theme_version );
wp_localize_script( 'frkw-customizer-reset', '_FRKWCustomizerReset', array(
'reset'   => __( 'Reset', 'foldmag' ),
'confirm' => __( "Attention! This will remove all customizations ever made via customizer to this theme!\n\nThis action is irreversible!", 'foldmag' ),
'nonce'   => array(
'reset' => wp_create_nonce( 'customizer-reset' ),
)
) );
}

/*--------------------------------------------
Description: customizer init
---------------------------------------------*/
public function customize_register( $wp_customize ) {
$this->wp_customize = $wp_customize;
}
public function ajax_customizer_reset() {
if ( ! $this->wp_customize->is_preview() ) {
wp_send_json_error( 'not_preview' );
}
if ( ! check_ajax_referer( 'customizer-reset', 'nonce', false ) ) {
wp_send_json_error( 'invalid_nonce' );
}
$this->reset_customizer();
wp_send_json_success();
}
public function reset_customizer() {
$settings = $this->wp_customize->settings();
// remove theme_mod settings registered in customizer
foreach ( $settings as $setting ) {
if ( 'theme_mod' == $setting->type ) {
// only remove theme mod by customizer
if ($setting->id == 'active_theme' || $setting->id == 'nav_menu_locations[top]' || $setting->id == 'nav_menu_locations[primary]' || $setting->id == 'nav_menu_locations[footer]' || $setting->id == 'nav_menu_locations[mobile]' || $setting->id == 'header_text'):
continue;
endif;
remove_theme_mod( $setting->id );
}
}
}
}
}
FRKW_Customizer_Reset::get_instance();
?>