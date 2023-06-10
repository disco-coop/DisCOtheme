<?php
// enqueue styles from parent theme
function my_theme_enqueue_styles() {
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_script('disco_app', get_stylesheet_directory_uri() . '/app.js', array('jquery'), null, true);
}

add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles');
add_filter('upload_mimes', 'allow_svgimg_types');
add_filter('body_class', 'number_body_class');
add_filter('body_class', 'title_body_class');

// enable SVG images
function allow_svgimg_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}

function number_body_class($classes) {
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

function title_body_class($classes) {
    $add = array();
    $title = the_title_attribute(array('echo' => false));
    $slug = preg_replace('/[^0-9a-z]/i', '', strtolower($title));
    array_push($add, "page-$slug");
    return array_merge($classes, $add);
}
