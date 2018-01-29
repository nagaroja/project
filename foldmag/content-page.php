<?php do_action('mp_before_post_article'); ?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>"<?php do_action('mp_article_start'); ?>>

<?php do_action('mp_before_post_wrapper'); ?>

<div class="post-wrapper">

<?php do_action('mp_before_post_title'); ?>

<header class="post-title">
<h1 class="entry-title"><?php the_title(); ?></h1>
</header>

<?php do_action('mp_before_post_content'); ?>

<div class="post-content">
<?php do_action('mp_before_entry_content'); ?>
<div class="entry-content"<?php do_action('mp_article_post_content'); ?>>
<?php do_action('mp_before_the_content'); ?>
<?php the_content(); ?>
<?php do_action('mp_after_the_content'); ?>
<?php wp_link_pages('before=<div id="page-links">&after=</div>'); ?>
</div>
<?php do_action('mp_after_entry_content'); ?>
</div>

<?php do_action('mp_after_post_content'); ?>

</div>

<?php do_action('mp_after_post_wrapper'); ?>

</article>

<?php do_action('mp_after_post_article'); ?>