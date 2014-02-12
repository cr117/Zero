<?php if(post_password_required()) return; ?>

<div id="comments" class="comments-area">

	<?php if(have_comments()) { ?>

		<h3 class="comments-title">
			<?php
				$comment_count = get_comments_number();
				echo ($comment_count == 1 ? 'One' : $comment_count).' Comment'.($comment_count > 1 ? 's' : '');
			?>
		</h3>

		<?php if(get_option('page_comments') && get_comment_pages_count() > 1) { ?>
			<nav id="comment-nav-above" class="comment-navigation" role="navigation">
				<h4 class="screen-reader-text">Comment Navigation</h4>
				<ul>
					<li class="nav-previous"><?php previous_comments_link('&larr; Older Comments'); ?></li>
					<li class="nav-next"><?php next_comments_link('Newer Comments &rarr;'); ?></li>
				</ul>
			</nav><!-- #comment-nav-above -->
		<?php } ?>

		<ol class="comment-list">
			<?php wp_list_comments(array('style' => 'ul', 'walker' => new Walker_Comment_Theme())); ?>
		</ol><!-- .comment-list -->

		<?php if(get_option('page_comments') && get_comment_pages_count() > 1) { ?>
			<nav id="comment-nav-below" class="comment-navigation" role="navigation">
				<h4 class="screen-reader-text">Comment Navigation</h4>
				<ul>
					<li class="nav-previous"><?php previous_comments_link('&larr; Older Comments'); ?></li>
					<li class="nav-next"><?php next_comments_link('Newer Comments &rarr;'); ?></li>
				</ul>
			</nav><!-- #comment-nav-above -->
		<?php } ?>

	<?php } ?>

	<?php if(!comments_open() && get_comments_number() != '0' && post_type_supports(get_post_type(), 'comments')) { ?>
		<p class="no-comments">Comments are closed.</p>
	<?php } ?>

	<?php comment_form(); ?>

</div><!-- #comments -->