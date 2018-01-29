<?php $ads_right_sidebar = get_theme_mod('right_sidebar_ad_code'); if($ads_right_sidebar) { ?>
<aside class="widget ads-widget">
<div class="textwidget"><?php echo stripcslashes(do_shortcode($ads_right_sidebar)); ?></div>
</aside>
<?php } ?>

<aside class="widget">
<h3 class="widget-title"><?php _e('Stay Up Date', 'foldmag'); ?></h3>
<?php echo frkw_add_social_box(); ?>
</aside>

<aside class="widget">
<h3 class="widget-title"><?php _e('Search','foldmag'); ?></h3>
<?php get_search_form(); ?>
</aside>

<aside class="widget">
<h3 class="widget-title"><?php _e('Categories', 'foldmag'); ?></h3>
<ul><?php wp_list_categories('orderby=name&show_count=1&title_li='); ?></ul>
</aside>

<aside class="widget widget_recent_entries">
<h3 class="widget-title"><?php _e('Recent Posts', 'foldmag'); ?></h3>
<ul><?php wp_get_archives('type=postbypost&limit=5'); ?></ul>
</aside>

<aside class="widget widget_recent_entries">
<h3 class="widget-title"><?php _e('Popular Posts','foldmag'); ?></h3>
<?php frkw_get_popular_posts('thumbnail','enable','5'); ?>
</aside>


<aside class="widget widget_recent_entries">
<h3 class="widget-title"><?php _e('Archived Posts','foldmag'); ?></h3>
<?php frkw_get_recent_posts('thumbnail','enable','5','5'); ?>
</aside>