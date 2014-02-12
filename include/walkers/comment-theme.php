<?php

if(!class_exists('Walker_Comment_Theme')) {

	/*
		Comment walker class for theme.
	*/
	class Walker_Comment_Theme extends Walker_Comment {

		protected function ping( $comment, $depth, $args ) {
			$tag = $args['style'] === 'div' ? 'div' : 'li';
			?>

				<<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
				<div class="comment-body">
					Pingback: <?php comment_author_link(); ?> <?php edit_comment_link('Edit', '<span class="edit-link">', '</span>'); ?>
				</div>

			<?php
		}

		protected function comment($comment, $depth, $args) {
			$this->html5_comment($comment, $depth, $args);
		}

		protected function html5_comment($comment, $depth, $args) {

			$tag = array( // defaults
				'comment' => $args['style'] === 'div' ? 'div' : 'li',
				'article' => 'article',
				'footer' => 'footer',
				'time' => 'time'
			);
			if($args['format'] !== 'html5') {
				$tag = array_merge($tag, array_fill_keys(array('article', 'footer'), 'div')); // block elements
				$tag = array_merge($tag, array_fill_keys(array('time'), 'span')); // inline elements
			}

			?>

				<<?php echo $tag['comment']; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class(empty($args['has_children']) ? '' : 'parent'); ?>>
				<<?php echo $tag['article']; ?> id="div-comment-<?php comment_ID(); ?>" class="comment-body">

					<<?php echo $tag['footer']; ?> class="comment-meta">

						<div class="comment-author vcard">
							<?php if(0 != $args['avatar_size']) echo get_avatar($comment, ($comment->comment_parent != '0' ? 40 : 50)); ?>
							<strong class="fn"><?php echo comment_author_link() ?></strong> <span class="says">says:</span>
						</div><!-- .comment-author -->

						<div class="comment-metadata">
							<a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>">
								<<?php echo $tag['time']; ?> datetime="<?php comment_time('c'); ?>">
									<?php echo get_comment_date('F j, Y \a\t g:ia'); ?>
								</<?php echo $tag['time']; ?>>
							</a>
							<?php edit_comment_link('Edit', '<span class="edit-link">', '</span>'); ?>
						</div><!-- .comment-metadata -->

						<?php if($comment->comment_approved == '0') { ?>
							<p class="comment-awaiting-moderation">Your comment is awaiting moderation.</p>
						<?php } ?>

					</<?php echo $tag['footer']; ?>><!-- .comment-meta -->

					<div class="comment-content">
						<?php comment_text(); ?>
					</div><!-- .comment-content -->

					<div class="reply">
						<?php comment_reply_link(array_merge($args, array('add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
					</div><!-- .reply -->

				</<?php echo $tag['article']; ?>><!-- .comment-body -->

			<?php
		}

	}
}