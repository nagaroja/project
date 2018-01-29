<?php
/*
Template Name: Blog
*/
?>
<?php get_header(); ?>
<?php do_action( 'mp_before_container' ); ?>
<main id="container">
<?php do_action( 'mp_inside_container' ); ?>
<div class="content">
<?php do_action( 'mp_before_content_inner' ); ?>
<div class="content-inner">
<?php do_action( 'mp_before_content_area' ); ?>
<div id="entries" class="content-area">
<?php do_action( 'mp_before_content_area_inner' ); ?>
<div class="content-area-inner masonry-grid">   
<?php do_action( 'mp_inside_content_area_inner' ); ?>

<?php
global $more; $more = 0;
$postcount = 1;
$oddpost = '';
$max_num_post = get_option('posts_per_page');
if('page' == get_option( 'show_on_front' )) {
$page = (get_query_var('page')) ? get_query_var('page') : 1;
} else {
$page = (get_query_var('paged')) ? get_query_var('paged') : 1;
}
query_posts("posts_per_page=$max_num_post&paged=$page");

if ( have_posts() ) : while ( have_posts() ) : the_post();
get_template_part( 'content', get_post_format() );
($oddpost == "alt-post") ? $oddpost="" : $oddpost="alt-post"; $postcount++;
endwhile;
else :
get_template_part( 'content', 'none' );
endif;
?>
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