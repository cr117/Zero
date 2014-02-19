<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title>
		<?php wp_title(''); ?>
	</title>

	<link rel="shortcut icon" type="image/x-icon" href="<?php echo home_url('/favicon.ico'); ?>">
	<link rel="icon" type="image/x-icon" href="<?php echo home_url('/favicon.ico'); ?>">

	<meta name="HandheldFriendly" content="True">
	<meta name="MobileOptimized" content="320">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<?php wp_head(); ?>

	<!--[if lt IE 9]>
		<script src="<?php echo get_template_directory_uri(); ?>/library/html5shiv/html5shiv-printshiv.js" type="text/javascript"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/library/respond.min.js" type="text/javascript"></script>
	<![endif]-->

</head>

<body <?php body_class(); ?>>

	<div id="page">
			
		<header id="header" role="banner">
			<div class="container">

				<hgroup id="site-branding">
					<h1 id="site-title"><a href="<?php echo home_url('/'); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
					<h2 id="site-description"><?php bloginfo('description'); ?></h2>
				</hgroup><!-- #site-branding -->

				<?php get_search_form(); ?>
				
				<nav id="header-navigation" role="navigation">
					<a class="skip-link screen-reader-text" href="#content">Skip to content</a>
					<?php wp_nav_menu(array('theme_location' => 'header')); ?>
				</nav><!-- #header-navigation -->

			</div><!-- .container -->
		</header><!-- #header -->