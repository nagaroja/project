<footer class="entry-meta meta-top<?php if( is_page() ) { echo ' meta-no-display'; } ?>">

<?php do_action('mp_inside_post_meta_start'); ?>

<span class="entry-author vcard"><i class="fa fa-user"></i><?php the_author_posts_link(); ?></span>

<span class="entry-date"><i class="fa fa-clock-o"></i><?php echo the_time( get_option( 'date_format' ) ); ?></span>

<?php if( is_single() ) { ?>
<?php if( get_post_type() == 'post' ) { ?>
<span class="entry-category"><i class="fa fa-file-o"></i><?php if(is_single() ) { the_category(', '); } else { echo frkw_get_singular_cat(); } ?></span>
<?php } else { ?>
<?php frkw_get_post_taxonomy(', ','<span class="entry-category"><i class="fa fa-file-o"></i>','</span>'); ?>
<?php } } ?>


<?php if ( comments_open() ) { ?>
<span class="entry-comment"><i class="fa fa-comments-o"></i><?php comments_popup_link(__('No Comment','foldmag'), __('1 Comment','foldmag'), __('% Comments','foldmag') ); ?></span>
 <?php } ?>


<?php do_action('mp_inside_post_meta_end'); ?>

</footer>