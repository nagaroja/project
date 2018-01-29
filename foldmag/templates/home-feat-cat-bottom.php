<?php
$home_feat = get_theme_mod('home_feat_post');
if($home_feat) {
if( frkw_is_in_home() ) { ?>
<div class="feat-post-box">
<?php
$post_count = 1;


$allposttype = frkw_get_all_posttype();

query_posts( array( 'post_type'=> $allposttype, 'post__in' => explode(',', $home_feat), 'posts_per_page' => 40, 'ignore_sticky_posts' => 1, 'orderby' => 'post__in', 'offset' => 5 ) );

if (have_posts()) : while ( have_posts() ) : the_post();
$thepostlink =  '<a href="'. get_permalink() . '" title="' . the_title_attribute('echo=0') . '">';
$post_alt = 'featpostgrid-'.$post_count;

if($post_count == 1) {
$imgsize = 'large';
} else {
$imgsize = 'medium';
}
?>
<article style="background-image: url('<?php echo frkw_get_featured_image_src($imgsize); ?>');" <?php post_class('feat-post ' . $post_alt); ?> id="post-<?php the_ID(); ?>">
<div class="dark-cover"></div>
<div class="feat-post-wrapper">

<?php if( has_category() ) { ?>
<span class="entry-category home-entry-category"><?php the_category(', ',''); ?></span>
<?php } else { ?>
<?php echo frkw_get_post_taxonomy(', ','<span class="entry-category home-entry-category">', '</span>'); ?>
<?php } ?>

<h2 class="post-title entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
</div>
</article>
<?php $post_count++; endwhile; wp_reset_query(); endif; ?>
</div>

<?php } } ?>