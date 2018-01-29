<article class="post-single page-single 404-page">
<h1 class="post-title entry-title"><?php _e('Error 404', 'foldmag'); ?></h1>
<div class="post-content">
<div class="entry-content">
<h3><?php _e('The page you requested cannot be found!', 'foldmag'); ?></h3>
<p><?php _e('Perhaps you are here because:', 'foldmag'); ?></p>
<ul>
<li><?php _e('The search keyword you searching cannot be found', 'foldmag'); ?></li>
<li><?php _e('The page has moved', 'foldmag'); ?></li>
<li><?php _e('The page url has been change', 'foldmag'); ?></li>
<li><?php _e('The page no longer exist', 'foldmag'); ?></li>
</ul>
<p><strong><?php printf(__('Don\'t worry, we are still here, just <a href="%s">click here</a> to go back to civilization or use the search form below.', 'foldmag'), home_url() ); ?></strong></p>
<?php get_search_form(); ?>
</div>  </div>
<!-- POST CONTENT END -->
</article>