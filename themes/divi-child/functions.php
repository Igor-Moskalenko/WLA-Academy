<?php

function starter_theme_enqueue_styles() {
 
    $parent_style = 'divi-style';
 
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );

    // Enqueue Slick Slider CSS
    wp_enqueue_style( 'slick-slider-css', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css', array(), '1.8.1' );

    // Enqueue Slick Slider JS
    wp_enqueue_script( 'slick-slider-js', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js', array('jquery'), '1.8.1', true );

    wp_enqueue_script( 'font-awesome', 'https://kit.fontawesome.com/3893c73c07.js');
}
add_action( 'wp_enqueue_scripts', 'starter_theme_enqueue_styles' );


register_nav_menus( [
    'divi-header-menu' => __( 'Divi Header Menu' ),
    'divi-footer-menu' => __( 'Divi Footer Menu' ),
] );

add_action('et_builder_ready', function () {
    $modules_path = __DIR__ . '/divi-modules/*/index.php';
    foreach (glob($modules_path) as $module_file) {
        require $module_file;
    }
});

add_filter( 'use_block_editor_for_post_type', '__return_false' );