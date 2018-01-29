<?php

if (is_single()) { ?>

<div class="post-paging" id="post-navigator-single">
<div class="alignleft"><?php next_post_link('<span>&larr; Newer Post</span><br />%link') ?></div>
<div class="alignright"><?php previous_post_link('<span>Older Post &rarr;</span><br />%link') ?></div>
</div>

<?php } else { ?>

<div class="post-paging" id="post-navigator">

<?php if( function_exists('paginate_links') ) : ?>
<?php
global $wp_query;
$big = 999999999; // need an unlikely integer
echo '<div class="page-navigation">';
echo paginate_links( array(
    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
    'format' => '?paged=%#%',
    'current' => max( 1, get_query_var('paged') ),
    'total' => $wp_query->max_num_pages,
    'prev_text'  => __('&laquo;','foldmag'),
    'next_text'  => __('&raquo;','foldmag'),
    'before_page_number' => ''
) );
echo '</div>';
?>
<?php else: ?>

<div class="alignright"><?php next_posts_link(__('Older Entries &raquo;', 'foldmag') ); ?></div>
<div class="alignleft"><?php previous_posts_link(__('&laquo; Newer Entries', 'foldmag') ); ?></div>

<?php endif; ?>

</div>

<?php } ?>