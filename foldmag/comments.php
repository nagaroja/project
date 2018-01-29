<?php if ( post_password_required() ) { return; } ?>

<?php if ( !comments_open() && !get_comments_number() ) :
$loose_border = ' comment-no-border';
endif; ?>

<div id="comments" class="comments-area<?php echo $loose_border; ?>">

<?php if ( !comments_open() && get_comments_number() ) : ?>
<h2 class="comments-title"><?php printf( _nx( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'foldmag' ), number_format_i18n( get_comments_number() ), get_the_title() ); ?></h2>
<?php elseif ( !comments_open() && !get_comments_number() ) : ?>
<?php else: ?>
<h2 class="comments-title"><?php printf( _nx( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'foldmag' ), number_format_i18n( get_comments_number() ), get_the_title() ); ?></h2>
<?php endif; ?>

<?php if ( have_comments() ) : ?>
<?php do_action('mp_before_comment_list'); ?>
<ol class="comment-list">
<?php wp_list_comments( 'type=comment&callback=frkw_html5_comment' ); ?>
</ol>
<?php do_action('mp_after_comment_list'); ?>
<?php endif; ?>




<?php
$ping_count = frkw_get_pings_count();
if( $ping_count ) {
echo '<h2 class="comments-title">' . $ping_count . __(' Pingbacks','foldmag') . '</h2>';
do_action('mp_before_pings_list'); ?>
<ol class="comment-list ping-list">
<?php wp_list_comments( 'type=pings&callback=frkw_html5_ping' ); ?>
</ol>
<?php do_action('mp_after_pings_list');
}
?>



<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
<div class="post-paging" id="post-navigator"><?php paginate_comments_links(); ?></div>
<?php endif; ?>

<?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
<p class="no-comments"><?php _e( 'Comments are closed.', 'foldmag' ); ?></p>
<?php endif; ?>

<?php do_action('mp_before_comment_form'); ?>
<?php
$comments_args = array(
        // change the title of send button
        'label_submit'=> __('Submit Comment','foldmag'),
        // change the title of the reply section
        'title_reply'=> __('Write a Reply or Comment','foldmag'),
        'comment_field' => '<p class="comment-form-comment"><label for="comment">' . __( 'Comment', 'foldmag' ) . '</label><textarea id="comment" name="comment" aria-required="true"></textarea></p>',
);
comment_form($comments_args);
?>
<?php do_action('mp_after_comment_form'); ?>

</div>