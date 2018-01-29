<?php $ads_left_sidebar = get_theme_mod('left_sidebar_ad_code'); if($ads_left_sidebar) { ?>
<aside class="widget ads-widget">
<div class="textwidget"><?php echo stripcslashes(do_shortcode($ads_left_sidebar)); ?></div>
</aside>
<?php } ?>
<aside class="widget">
<h3 class="widget-title"><?php _e('Categories', 'foldmag'); ?></h3>
<ul><?php wp_list_categories('orderby=name&show_count=1&title_li='); ?></ul>
</aside>

<?php
/*
<aside class="widget">
<h3 class="widget-title"><?php _e('Pages', 'foldmag'); ?></h3>
<ul><?php wp_list_pages('title_li='); ?></ul>
</aside>
*/
?>
