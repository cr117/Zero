<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if(has_post_thumbnail() && !(is_search() || is_archive())) { ?>
		<div class="entry-featured-image">
			<?php if(is_singular()) { ?>
				<?php the_post_thumbnail('featured'); ?>
			<?php } else { ?>
				<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('featured'); ?></a>
			<?php } ?>
		</div>
	<?php } ?>

	<header class="entry-header">
		
		<?php if(is_singular()) { ?>
			<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php } else { ?>
			<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="Permalink to <?php echo the_title_attribute('echo=0'); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		<?php } ?>

		<?php if(get_post_type() == 'post') { ?>
			<div class="entry-meta">
				<p class="entry-date"><?php the_time('l, F jS, Y'); ?></p>
			</div><!-- .entry-meta -->
		<?php } ?>

	</header><!-- .entry-header -->

	<?php if(is_search() || is_archive()) { ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
	<?php } else { ?>
		<div class="entry-content">
			<?php the_content('Continue reading <span class="meta-nav">&rarr;</span>'); ?>
			<?php wp_link_pages(array('before' => '<nav class="page-links" role="navigation"><span>Pages:</span>', 'after' => '</nav>')); ?>
		</div><!-- .entry-content -->
	<?php } ?>

	<footer class="entry-meta">
		<?php
			if(get_post_type() == 'post') {

				$footer_meta = array();
				
				$categories_list = get_the_category_list(', ');
				if($categories_list) $footer_meta[] = '<span class="entry-cat-links"><span class="entry-utility-prep entry-utility-prep-cat-links">Posted in</span> '.$categories_list.'</span>';

				$tags_list = get_the_tag_list('', ', ');
				if($tags_list) $footer_meta[] = '<span class="entry-tag-links"><span class="entry-utility-prep entry-utility-prep-tag-links">Tagged</span> '.$tags_list.'</span>';

				if(comments_open()) {
					$comment_count = get_comments_number();
					$label = 'Leave a comment';
					if($comment_count > 0) $label = $comment_count.' Comment'.($comment_count > 1 ? 's' : '');
					$footer_meta[] = '<span class="entry-comments-link"><a href="'.get_permalink().'#comments">'.$label.'</a></span>';
				}

				if(!empty($footer_meta)) echo '<p class="inline-meta">'.implode(' <span class="sep">|</span> ', $footer_meta).'</p>';

			}
		?>
	</footer><!-- .entry-meta -->

</article><!-- #post-<?php the_ID(); ?> -->