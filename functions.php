<?php
// enqueue styles from parent theme
function my_theme_enqueue_styles()
{
	wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
	wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/dist/bundle.css');
	wp_enqueue_script('disco_app', get_stylesheet_directory_uri() . '/dist/bundle.js', array('jquery'), null, true);
}

add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles');
add_filter('upload_mimes', 'allow_svgimg_types');
add_filter('body_class', 'number_body_class');
add_filter('body_class', 'title_body_class');
add_shortcode('widget', 'widget_shortcode');
add_shortcode('menu', 'menu_shortcode');

// enable SVG images
function allow_svgimg_types($mimes)
{
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}

function number_body_class($classes)
{
	$add = array();
	$title = the_title_attribute(array('echo' => false));
	if (preg_match('/^([0-9\.]+)\s(.*)$/', $title, $matches)) {
		$number = $matches[1];
		if ($number) {
			array_push($add, "page-number");
			$stack = array();
			foreach (explode('.', $number) as $comp) {
				array_push($stack, $comp);
				array_push($add, "page-number-" . implode(".", $stack));
			}
		}
	}
	return array_merge($classes, $add);
}

function title_body_class($classes)
{
	$add = array();
	$title = the_title_attribute(array('echo' => false));
	$slug = preg_replace('/[^0-9a-z]/i', '', strtolower($title));
	array_push($add, "page-$slug");
	return array_merge($classes, $add);
}

// https://digwp.com/2010/04/call-widget-with-shortcode/
function widget_shortcode($atts)
{

	global $wp_widget_factory;

	extract(shortcode_atts(array(
		'widget_name' => FALSE
	), $atts));

	$widget_name = wp_specialchars($widget_name);

	if (!is_a($wp_widget_factory->widgets[$widget_name], 'WP_Widget')):
		$wp_class = 'WP_Widget_' . ucwords(strtolower($class));

		if (!is_a($wp_widget_factory->widgets[$wp_class], 'WP_Widget')):
			return '<p>' . sprintf(__("%s: Widget class not found. Make sure this widget exists and the class name is correct"), '<strong>' . $class . '</strong>') . '</p>';
		else:
			$class = $wp_class;
		endif;
	endif;

	ob_start();
	the_widget($widget_name, $instance, array('widget_id' => 'arbitrary-instance-' . $id,
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => ''
	));
	$output = ob_get_contents();
	ob_end_clean();
	return $output;

}

// https://wordpress.stackexchange.com/questions/292877/shortcode-to-insert-menu-in-page-body
function menu_shortcode($atts=[], $content = null) {
	$shortcode_atts = shortcode_atts([ 'name' => '', 'class' => '' ], $atts);
	$name   = $shortcode_atts['name'];
	$class  = $shortcode_atts['class'];
	return wp_nav_menu( array( 'menu' => $name, 'menu_class' => $class, 'echo' => false ) );
}
