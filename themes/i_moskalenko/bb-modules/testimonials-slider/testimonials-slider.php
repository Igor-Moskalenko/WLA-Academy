<?php

class FLTestimonialsSliderModule extends FLBuilderModule {
    public function __construct() {
        parent::__construct(array(
            'name'            => __('Testimonials Slider', 'fl-builder'),
            'description'     => __('A slider to display testimonials.', 'fl-builder'),
            'group'           => __('Custom Modules', 'fl-builder'),
            'category'        => __('Custom', 'fl-builder'),
            'dir'             => BB_MODULE_DIR . 'testimonials-slider/',
            'url'             => BB_MODULE_URL . 'testimonials-slider/',
            'icon'            => 'slides.svg',
            'partial_refresh' => true,
        ));

        // Register frontend CSS and JS
        $this->add_css('custom-css', $this->url . 'assets/css/custom.css');
        $this->add_js('slick-js', $this->url . 'assets/js/slick.min.js', array(), '', true);
        $this->add_js('testimonials-slider', $this->url . 'assets/js/testimonials-slider.js', array('slick-js'), '', true);
    }
}

// Register the module
FLBuilder::register_module('FLTestimonialsSliderModule', array(
    'general' => array(
        'title' => __('General', 'fl-builder'),
        'sections' => array(
            'number_of_testimonials_section' => array(
                'title' => __('Testimonials Settings', 'fl-builder'),
                'fields' => array(
                    'number_of_testimonials' => array(
                        'type' => 'unit',
                        'label' => __('Number of Testimonials', 'fl-builder'),
                        'default' => '3',
                        'description' => __('Enter the number of testimonials to display.', 'fl-builder'),
                    ),
                ),
            ),
            'my_loop_settings' => array(
                'title' => __('Loop Settings', 'fl-builder'),
                'file'  => FL_BUILDER_DIR . 'includes/ui-loop-settings.php',
            ),
        ),
    ),
));
