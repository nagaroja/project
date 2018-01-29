<?php get_header(); ?>
<?php do_action( 'mp_before_container' ); ?>
<main id="container">
<?php do_action( 'mp_inside_container' ); ?>
<div id="single-content" class="content full-width-content error-content">
<?php do_action( 'mp_before_content_inner' ); ?>
<div class="content-inner">
<?php do_action( 'mp_before_content_area' ); ?>
<div id="entries" class="content-area">
<?php do_action( 'mp_before_content_area_inner' ); ?>
<div class="content-area-inner">
<?php do_action( 'mp_inside_content_area_inner' ); ?>

<article class="post-single page-single 404-page">
<h1 class="post-title entry-title"><?php _e('Error 404', 'foldmag'); ?></h1>
<div class="post-content">
<div class="entry-content">
<h3><?php _e('The page you requested cannot be found!', 'foldmag'); ?></h3>
<p><?php _e('Perhaps you are here because:', 'foldmag'); ?></p>
<ul>
<li><?php _e('The page has moved', 'foldmag'); ?></li>
<li><?php _e('The page url has been change', 'foldmag'); ?></li>
<li><?php _e('The page no longer exist', 'foldmag'); ?></li>
</ul>
<p><strong><?php printf(__('Don\'t worry, we are still here, just <a href="%s">click here</a> to go back to civilization.', 'foldmag'), home_url() ); ?></strong></p>
</div>  </div>
<!-- POST CONTENT END -->
</article>

</div>
<?php do_action( 'mp_after_content_area_inner' ); ?>
</div>
<?php do_action( 'mp_after_content_area' ); ?>
</div>
<?php do_action( 'mp_after_content_inner' ); ?>
</div>
<?php do_action( 'mp_after_content' ); ?>
</main>
<?php do_action( 'mp_after_container' ); ?>