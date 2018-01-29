<?php do_action('mp_before_post_article'); ?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>"<?php do_action('mp_article_start'); ?>>

<?php do_action('mp_before_post_wrapper'); ?>

<div class="post-wrapper">

<?php do_action('mp_before_post_title'); ?>

<header class="post-title">
<h1 class="entry-title"><?php the_title(); ?></h1>
</header>

<?php //do_action('mp_before_post_content'); ?>

<div class="post-content">
<?php do_action('mp_before_entry_content'); ?>
<div class="entry-content"<?php do_action('mp_article_post_content'); ?>>

<?php
echo '<div class="entry-meta">';
$metadata = wp_get_attachment_metadata();
printf( __( '<span class="entry-date"><time class="entry-date" datetime="%1$s">%2$s</time></span> at <a href="%3$s" title="Link to full-size image">%4$s &times; %5$s</a> in <a href="%6$s" title="Return to %7$s" rel="gallery">%8$s</a>.', 'foldmag' ),
									esc_attr( get_the_date( 'c' ) ),
									esc_html( get_the_date() ),
									esc_url( wp_get_attachment_url() ),
									$metadata['width'],
									$metadata['height'],
									esc_url( get_permalink( $post->post_parent ) ),
									esc_attr( strip_tags( get_the_title( $post->post_parent ) ) ),
									get_the_title( $post->post_parent )
								);
							echo '</div>'; ?>



<?php
/**
 * Grab the IDs of all the image attachments in a gallery so we can get the URL of the next adjacent image in a gallery,
 * or the first image (if we're looking at the last image in a gallery), or, in a gallery of one, just the link to that image file
 */
$attachments = array_values( get_children( array( 'post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) ) );
foreach ( $attachments as $k => $attachment ) :
	if ( $attachment->ID == $post->ID )
		break;
endforeach;

$k++;
// If there is more than 1 attachment in a gallery
if ( count( $attachments ) > 1 ) :
	if ( isset( $attachments[ $k ] ) ) :
		// get the URL of the next image attachment
		$next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
	else :
		// or get the URL of the first image attachment
		$next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
	endif;
else :
	// or, if there's only 1 image, get the URL of the image
	$next_attachment_url = wp_get_attachment_url();
endif;
?>
								<a href="<?php echo esc_url( $next_attachment_url ); ?>" title="<?php the_title_attribute(); ?>" rel="attachment"><?php
								$attachment_size = apply_filters( 'theme_attachment_size', array( 960, 960 ) );
								echo wp_get_attachment_image( $post->ID, 'full' );
								?></a>

								<?php if ( ! empty( $post->post_excerpt ) ) : ?>
								<div class="entry-caption">
									<?php the_excerpt(); ?>
								</div>
								<?php endif; ?>



<div class="post-paging" id="post-navigator-single">
<div class="alignleft"><?php previous_image_link( false, __( '&larr; Previous Image', 'foldmag' ) ); ?></div>
<div class="alignright"><?php next_image_link( false, __( 'Next Image &rarr;', 'foldmag' ) ); ?></div>
</div>

</div>


<?php do_action('mp_after_entry_content'); ?>
</div>

<?php do_action('mp_after_post_content'); ?>

</div>

<?php do_action('mp_after_post_wrapper'); ?>

</article>

<?php do_action('mp_after_post_article'); ?>