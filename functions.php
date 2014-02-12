<?php

if(!function_exists('zero_autoload')) {

	/*
		Autoloader function for classes used by theme.
		Define additional classes by adding to $file_map array.
	*/

	function zero_autoload($class) {
		$file_map = array(

			'Walker_Nav_Menu_No_Follow' => 'include/walkers/nav-menu-no-follow.php',
			'Walker_Category_Count_Badges' => 'include/walkers/category-count-badges.php',
			'Walker_Comment_Theme' => 'include/walkers/comment-theme.php'

		);
		if(array_key_exists($class, $file_map)) {
			require_once(get_template_directory().'/'.$file_map[$class]);
		}
	}

}

// register autoloader function
spl_autoload_register('zero_autoload');



if(!class_exists('Zero_Loader')) {

	/*
		Class with methods to perform generic theme functionality.
		Register action/filter hooks in constructor, passing in class methods for execution.
	*/
	class Zero_Loader {


		public function __construct() {

			// Actions
			add_action('after_setup_theme', array(&$this, 'action_setup'));
			add_action('wp_enqueue_scripts', array(&$this, 'action_enqueue_scripts'));
			add_action('wp_enqueue_scripts', array(&$this, 'action_enqueue_styles'));
			add_action('widgets_init', array(&$this, 'action_init_sidebars'));
			add_action('pre_get_posts', array(&$this, 'action_pre_get_posts'));
			add_action('content_nav', array(&$this, 'action_content_nav'));

			// Filters
			add_filter('excerpt_length', array(&$this, 'filter_excerpt_length'));
			add_filter('excerpt_more', array(&$this, 'filter_excerpt_more'));
			add_filter('get_the_excerpt', array(&$this, 'filter_get_the_excerpt'));
			add_filter('body_class', array(&$this, 'filter_body_class'));
			add_filter('img_caption_shortcode_width', array(&$this, 'filter_img_caption_shortcode_width'), 10, 3);
			add_filter('get_search_form', array(&$this, 'filter_get_search_form'));

			// Gravity Forms
			add_filter('gform_field_content', array(&$this, 'filter_gform_field_content'), 10, 5);
			add_filter('gform_submit_button', array(&$this, 'filter_gform_submit_button'), 10, 2);

		}


		/*
			Define theme settings.
		*/
		public function action_setup() {

			// import theme's styles into admin content editor
			add_editor_style(get_template_directory_uri().'/css/editor-style.css');

			// define theme support
			add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'));
			add_theme_support('post-thumbnails');
			add_theme_support('automatic-feed-links');
			add_theme_support('html5', array('comment-list', 'comment-form', 'search-form'));

			// register navigation menu locations
			register_nav_menu('header', 'Header Navigation');
			register_nav_menu('footer', 'Footer Navigation');

			// set image sizes
			set_post_thumbnail_size(200, 200, true);
			add_image_size('featured', 1000, 450, true);

		}


		/*
			Register and enqueue JS files.
			Localize theme scripts if necessary.
		*/
		public function action_enqueue_scripts() {

			wp_enqueue_script('jquery-mobile', get_template_directory_uri().'/library/jquery/jquery.mobile.custom.min.js', array('jquery')); // jQuery Mobile touchscreen events
			if(is_singular() && get_option('thread_comments')) wp_enqueue_script('comment-reply'); // threaded comment interface
			wp_enqueue_script('bootstrap', get_template_directory_uri().'/library/bootstrap/js/bootstrap.min.js', array('jquery')); // Bootstrap framework

			// custom theme scripts
			wp_enqueue_script('theme-plugins', get_template_directory_uri().'/js/plugins.js', array());
			wp_enqueue_script('theme-main', get_template_directory_uri().'/js/main.js', array('jquery-effects-core', 'jquery-mobile', 'bootstrap', 'theme-plugins'));
			wp_localize_script('theme-main', 'theme_data', array(
				'base_url' => get_home_url(),
				'theme_url' => get_template_directory_uri(),
				'ajax_url' => admin_url('admin-ajax.php')
			));

		}


		/*
			Register and enqueue CSS files.
		*/
		public function action_enqueue_styles() {

			// custom theme stylesheet
			wp_enqueue_style('theme-style', get_template_directory_uri().'/css/style.css', array(), '1.0.0', 'all');

		}


		/*
			Register theme's dynamic sidebars available in admin.
			Add custom sidebars to $sidebars array, overriding parameters in $default_sidebar_settings.
		*/
		public function action_init_sidebars() {

			// global sidebar settings
			$default_sidebar_settings = array(
				'id' => '',
				'name' => '',
				'description' => '',
				'class' => '',
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget' => '</aside>',
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>'
			);

			// define dynamic sidebars
			$sidebars = array(
				array('id' => 'blog', 'name' => 'Blog Sidebar'),
				array('id' => 'page', 'name' => 'Page Sidebar')
			);

			// register sidebars
			foreach($sidebars as $sidebar_settings) {
				if(!empty($sidebar_settings['id'])) register_sidebar(array_merge($default_sidebar_settings, $sidebar_settings));
			}

		}


		/*
			Modify global wp_query parameters before fetched.
			Additional parameters can be set using the query object's set() method.

			@param WP_Query &$query Gobal wp_query object.
		*/
		public function action_pre_get_posts($query) {
			if(is_admin() || !$query->is_main_query()) return false;

			// place modifications to $query here

		}


		/*
			Output pagination for archive pages.

			@param string $nav_id Optional. Content nav ID.
		*/
		public function action_content_nav($nav_id = '') {
			global $wp_query;
			if($wp_query->max_num_pages <= 1 ) return false;
			?>
				<nav id="<?php echo $nav_id; ?>" class="content-navigation" role="navigation">
					<h4 class="screen-reader-text">Content Navigation</h4>
					<ul>
						<li class="nav-previous"><?php next_posts_link('&larr; Older Posts'); ?></li>
						<li class="nav-next"><?php previous_posts_link('Newer Posts &rarr;'); ?></li>
					</ul>
				</nav><!-- #<?php echo $nav_id; ?> -->
			<?php
		}


		/*
			Modify the excerpt word count.
			Default exerpt length is 55 words.

			@param int $length Excerpt word count.
			@return int Excerpt word count.
		*/
		public function filter_excerpt_length($length) {
			return 55;
		}


		/*
			Modify the excerpt more string.
			Default excerpt more string is '[...]'.

			@param string $more Excerpt more string.
			@return string Excerpt more string.
		*/
		public function filter_excerpt_more($more) {
			return '&hellip; '.$this->get_continue_reading_link();
		}


		/*
			Filter the excerpt of the post.
			Applied after excerpt is retrieved from the database and before it is returned from the get_the_filter() function.

			@param string $output Post excerpt.
			@return string Post excerpt.
		*/
		public function filter_get_the_excerpt($output) {
			if(has_excerpt() && !is_attachment()) {
				$output .= ' '.$this->get_continue_reading_link();
			}
			return $output;
		}


		/*
			Get the continue reading post link.
			Automatically appended to post excerpts.

			@return string Continue reading link.
		*/
		private function get_continue_reading_link() {
			return '<a href="'.esc_url(get_permalink()).'">Continue reading <span class="meta-nav">&raquo;</span></a>';
		}


		/*
			Add or modify HTML body classes.
			
			@param array $classes Body classes.
			@return array Body classes.
		*/
		public function filter_body_class($classes) {
			
			// add, remove, modify body classes here

			return $classes;
		}


		/*
			Modify the inline caption shortcode width.
			Default is the width attribute value plus 10px.
			
			@param string $caption_width Caption width.
			@param array $atts Attributes of the caption shortcode.
			@param string $content Caption text.
			@return string Caption width.
		*/
		public function filter_img_caption_shortcode_width($caption_width, $atts, $content) {
			return $atts['width'];
		}


		/*
			Modify the default search form.
			Can also be used to replace search form HTML.
			
			@param string $form Search form HTML.
			@return string Search form HTML.
		*/
		public function filter_get_search_form($form) {
			ob_start();
			?>
				<form role="search" method="get" class="search-form" action="<?php echo home_url('/'); ?>">
					<label>
						<span class="screen-reader-text">Search for:</span>
						<input type="text" name="s" value="<?php echo esc_attr(get_search_query()); ?>" placeholder="Search&hellip;">
					</label>
					<button type="submit">Search</button>
				</form>
			<?php
			return ob_get_clean();
		}


		/*
			Modify the Gravity Forms' field HTML.
			
			@param string $content Field content HTML.
			@param array $field Curent form field object.
			@param string $value Default/initial value that the field should be pre-populated with.
			@param int $lead_id Current entry ID.
			@param int $form_id Current form ID.
			@return string Field content HTML.
		*/
		public function filter_gform_field_content($content, $field, $value, $lead_id, $form_id) {
			if(IS_ADMIN) return $content; // only modify HTML on the front end
			
			// multi-column form functionality
			if($field['type'] == 'section') {
				$form = RGFormsModel::get_form_meta($form_id, true);

				// check for the presence of multi-column form classes
				$form_class = explode(' ', $form['cssClass']);
				$form_class_matches = array_intersect($form_class, array('two-column', 'three-column'));

				// check for the presence of section break column classes
				$field_class = explode(' ', $field['cssClass']);
				$field_class_matches = array_intersect($field_class, array('gform_column'));

				// if field is a column break in a multi-column form, perform the list split
				if(!empty($form_class_matches) && !empty($field_class_matches)) { // make sure to target only multi-column forms

					// retrieve the form's field list classes for consistency
					$form = RGFormsModel::add_default_properties($form);
					$description_class = rgar($form, 'descriptionPlacement') == 'above' ? 'description_above' : 'description_below';

					// close current field's li and ul and begin a new list with the same form field list classes
					return '</li></ul><ul class="gform_fields '.$form['labelPlacement'].' '.$description_class.' '.$field['cssClass'].'"><li class="gfield gsection empty">';

				}
			}

			// add HTML5 placeholder attribute for fields with .placeholder-label class
			if($field['cssClass'] == 'placeholder-label') {
				$input_name = 'input_'.$field['id'];
				$content = preg_replace('/name=["\']'.$input_name.'["\']/', 'name="'.esc_attr($input_name).'" placeholder="'.esc_attr($field['label']).'"', $content);
			}

			return $content;
		}


		/*
			Set the Gravity Forms' submit button HTML.
			
			@param string $button Submit button HTML.
			@param array $form Current form object.
			@return string Submit button HTML.
		*/
		public function filter_gform_submit_button($button, $form) {
			$button_class = array();
			$button_label = $form['button']['text'];
			$button = '<button type="submit" id="gform_submit_button_'.$form['id'].'" class="'.implode(' ', $button_class).'">'.$button_label.'</button>';
			return $button;
		}


	}
}

// initialize loader class
$zero_loader = new Zero_Loader();