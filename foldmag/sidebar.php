<?php
global $in_bbpress, $bp_active;
if( $bp_active == 'true' && function_exists('bp_is_blog_page') && !bp_is_blog_page() ) {
$dynamic_sidebar = 'buddypress-sidebar';
} elseif( function_exists('frkw_is_woocommerce_page') && frkw_is_woocommerce_page() ) {
$dynamic_sidebar = 'shop-sidebar';
} elseif( $in_bbpress == 'true' ) {
$dynamic_sidebar = 'forum-sidebar';
} else {
$dynamic_sidebar = 'right-sidebar';
}
?>

<div id="right-sidebar" class="sidebar">
<div class="sidebar-inner">
<div class="widget-area">
<?php do_action('mp_before_right_sidebar'); ?>

<?php if ( is_active_sidebar( $dynamic_sidebar ) ) : ?>
<?php dynamic_sidebar( $dynamic_sidebar ); ?>
<?php else: ?>

<?php if($dynamic_sidebar == 'right-sidebar') {
get_template_part('templates/right-widget-default');
} else { ?>
<aside class="widget">
<h3 class="widget-title"><span><?php echo strtoupper($dynamic_sidebar); ?> <?php _e('Widget', 'foldmag'); ?></span></h3>
<div class="textwidget">
<?php printf( __( 'This is a widget area for %1$s. You need to setup your widget item in <a href="%2$s">here</a>', 'foldmag' ), $dynamic_sidebar,admin_url('widgets.php') ); ?>
</div>
</aside>
<?php } ?>

<?php endif; ?>

 <?php do_action('mp_after_right_sidebar'); ?>
</div>
</div>
</div>