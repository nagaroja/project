<?php
$home_feat_post = get_theme_mod('home_feat_post');
$home_feat_cat = get_theme_mod('home_feat_cat');
$home_feat_cat_count = get_theme_mod('home_feat_cat_count');

if(!$home_feat_post && !$home_feat_cat) {
} else {
if( frkw_is_in_home() ) {

if( $home_feat_cat ) { ?>

<div class="feat-post-box">
<?php
$post_count = 1;
$query = new WP_Query( "cat=$home_feat_cat&posts_per_page=$home_feat_cat_count&orderby=date" );
while ( $query->have_posts() ) : $query->the_post();
$thepostlink =  '<a href="'. get_permalink() . '" title="' . the_title_attribute('echo=0') . '">';
$post_alt = 'featpostgrid-'.$post_count;
if($post_count == 1) {
$imgsize = 'large';
} else {
$imgsize = 'medium';
}
?>
<article style="background-image: url('<?php echo frkw_get_featured_image_src($imgsize); ?>');" <?php post_class('feat-post ' . $post_alt); ?>>
<div class="dark-cover"></div>
<div class="feat-post-wrapper">


<h2 class="post-title entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

<footer class="entry-meta">
<span class="entry-date"><i class="fa fa-clock-o"></i><?php echo the_time( get_option( 'date_format' ) ); ?></span>
<?php
if( has_category() ) { ?>
<span class="entry-category"><i class="fa fa-file-o"></i><?php echo frkw_get_singular_cat(); ?></span>
<?php } else { ?>
<span class="entry-category"><i class="fa fa-file-o"></i><?php echo frkw_get_singular_term(); ?></span>
<?php }
?>
</footer>


</div>
</article>
<?php $post_count++; endwhile; wp_reset_query(); ?>
</div>

<?php } elseif( !$home_feat_cat && $home_feat_post ) {
?>
<div class="feat-post-box">
<?php
$post_count = 1;
$allposttype = frkw_get_all_posttype();

query_posts( array( 'post_type'=> $allposttype, 'post__in' => explode(',', $home_feat_post), 'posts_per_page' => -1, 'ignore_sticky_posts' => 1, 'orderby' => 'post__in' ) );

if (have_posts()) : while ( have_posts() ) : the_post();
$thepostlink =  '<a href="'. get_permalink() . '" title="' . the_title_attribute('echo=0') . '">';
$post_alt = 'featpostgrid-'.$post_count;

$cat_name = frkw_get_singular_cat_name();
$cat_id = get_cat_ID($cat_name);

if($post_count == 1) {
$imgsize = 'large';
} else {
$imgsize = 'medium';
}
?>
<article style="background-image: url('<?php echo frkw_get_featured_image_src($imgsize); ?>');" <?php post_class('feat-post ' . $post_alt); ?>>
<div class="dark-cover"></div>
<div class="feat-post-wrapper">


<h2 class="post-title entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

<footer class="entry-meta">
<span class="entry-date"><i class="fa fa-clock-o"></i><?php echo the_time( get_option( 'date_format' ) ); ?></span>
<?php
if( has_category() ) { ?>
<span class="entry-category"><i class="fa fa-file-o"></i><?php echo frkw_get_singular_cat(); ?></span>
<?php } else { ?>
<span class="entry-category"><i class="fa fa-file-o"></i><?php echo frkw_get_singular_term(); ?></span>
<?php }
?>
</footer>


</div>
</article>
<?php $post_count++; endwhile; wp_reset_query(); endif; ?>
</div>

<?php } } } ?>