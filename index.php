<?php get_header(); ?>
				
		<div id="main">
			<div class="container">
				<div class="inner">

					<div id="primary" role="main">

						<?php
							if(have_posts()) {

								do_action('content_nav', 'content-nav-above');

								while(have_posts()) {
									the_post();
									get_template_part('content', get_post_type());
								}

								do_action('content_nav', 'content-nav-below');

								if(is_single() && (comments_open() || '0' != get_comments_number())) comments_template();
								
							} else {
						?>

							<article id="post-0" class="post no-results not-found">
								<header class="entry-header">
									<h1 class="entry-title">Nothing Found</h1>
								</header><!-- .entry-header -->
								<div class="entry-content">
									<p>Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.</p>
									<?php get_search_form(); ?>
								</div><!-- .entry-content -->
							</article><!-- #post-0 -->

						<?php } ?>

					</div><!-- #primary -->

					<?php get_sidebar(); ?>

				</div><!-- .inner -->
			</div><!-- .container -->
		</div><!-- #main -->

<?php get_footer(); ?>