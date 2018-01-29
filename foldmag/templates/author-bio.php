<?php if ( get_the_author_meta( 'description' ) ) : ?>
<div id="author-bio">
<div class="author-avatar"><?php echo get_avatar( get_the_author_meta( 'user_email' ), 68 ); ?></div>
<div class="author-description">
<h2><?php printf( __( 'About %s', 'foldmag' ), get_the_author() ); ?></h2>
<?php the_author_meta( 'description' ); ?>
<div class="author-link">
<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
<?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'foldmag' ), get_the_author() ); ?>
</a>
</div>
</div>
</div>
<?php endif; ?>