<?php get_header(); ?>
<?php do_action( 'mp_before_container' ); ?>
<main id="container">
<?php do_action( 'mp_inside_container' ); ?>
<div id="single-content" class="content full-width-content">
<?php do_action( 'mp_before_content_inner' ); ?>
<div class="content-inner">
<?php do_action( 'mp_before_content_area' ); ?>
<div id="entries" class="content-area">
<?php do_action( 'mp_before_content_area_inner' ); ?>
<div class="content-area-inner">
<?php do_action( 'mp_inside_content_area_inner' ); ?>
<?php
$postcount = 1;
$oddpost = '';
if ( have_posts() ) : while ( have_posts() ) : the_post();
get_template_part( 'content', 'image' );
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
<?php if ( comments_open() ) { comments_template(); } ?>
<?php do_action( 'mp_after_comment_template' ); ?>
</div>
<?php do_action( 'mp_after_content_inner' ); ?>
</div>
<?php do_action( 'mp_after_content' ); ?>
</main>
<?php do_action( 'mp_after_container' ); ?>