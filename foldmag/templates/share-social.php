<?php
$social_on = get_theme_mod('social_on');
if($social_on == 'enable') {
global $post;
$post_aioseo_title = get_post_meta($post->ID, '_aioseop_title', true);
$post_aioseo_desc = get_post_meta($post->ID, '_aioseop_description', true);
$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "thumbnail" );
if($post_aioseo_title) {
$ptitle =  str_replace(' ','+',$post_aioseo_title);
$the_title = str_replace(' ', '%20', $post_aioseo_title);
} else {
$thep_title = strip_tags(the_title_attribute('echo=0'));
$ptitle =  str_replace(' ','+',$thep_title);
$the_title = str_replace(' ', '%20', $ptitle);
}
?>
<div class="sharebox-wrap">
<div class="share_box">

<p class="fb"><a class="fa fa-facebook" rel="nofollow" target="_blank" title="<?php _e('Share in Facebook', 'foldmag'); ?>" href="//www.facebook.com/sharer.php?s=100&amp;p%5Btitle%5D=<?php echo urlencode($ptitle); ?>&amp;p%5Bsummary%5D=<?php if($post_aioseo_desc) { echo urlencode($post_aioseo_desc); } else { echo urlencode(esc_attr( get_the_excerpt() )); } ?>&amp;p%5Burl%5D=<?php echo urlencode( get_permalink() ); ?>&amp;p%5Bimages%5D%5B0%5D=<?php echo $thumbnail_src[0];?>"><span><?php _e('Share', 'foldmag'); ?></span></a></p>

<p class="tw"><a class="fa fa-twitter" rel="nofollow" target="_blank" title="<?php _e('Share in Twitter', 'foldmag'); ?>" href="//twitter.com/share?text=<?php echo $the_title; ?>&amp;url=<?php echo urlencode(get_permalink()); ?>"><span>Tweet</span></a></p>

<p class="gp"><a class="fa fa-google-plus" rel="nofollow" target="_blank" title="<?php _e('Share in Google+', 'foldmag'); ?>" href="//plus.google.com/share?url=<?php echo urlencode(get_permalink()); ?>"><span>Google+</span></a></p>

<p class="pin"><a class="fa fa-pinterest" rel="nofollow" target="_blank" title="<?php _e('Share in Pinterest', 'foldmag'); ?>" href="//www.pinterest.com/pin/create/button/?url=<?php echo urlencode( get_permalink()); ?>&media=<?php $image_id = get_post_thumbnail_id($post->ID);$image_url = wp_get_attachment_image_src($image_id,'full', true);echo $image_url[0];  ?>&description=<?php if($post_aioseo_desc) { echo urlencode($post_aioseo_desc); } else { echo $the_title; } ?>"><span>Pin It</span></a></p>

</div></div>
<?php } ?>










