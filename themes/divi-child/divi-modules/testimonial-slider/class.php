<?php

if (!class_exists('\ET_Builder_Module')) {
    return;
}

class TestimonialsSlider extends \ET_Builder_Module
{
    public function init()
    {
        $this->name = esc_html__('Testimonials Slider', 'default');
        $this->slug = 'testimonials_slider';
        $this->vb_support = 'partial';
        $this->settings_modal_toggles = [
            'general' => [
                'toggles' => [
                    'slides' => __('Slides', 'default'),
                ],
            ]
        ];
    }

    public function get_fields()
    {
        $terms = get_terms([
            'taxonomy' => 'testimonial_category',
            'hide_empty' => true,
        ]);
        $terms_options = [];
        foreach ($terms as $term) {
            $terms_options[$term->slug] = $term->name;
        }

        $fields = [
            'amount' => [
                'label' => esc_html__('Number of testimonials', 'default'),
                'type' => 'input',
                'option_category' => 'configuration',
                'default_on_front' => -1,
                'toggle_slug' => 'slides',
            ],
            'terms' => [
                'label' => esc_html__('Post Categories', 'default'),
                'type' => 'select',
                'options' => $terms_options,
                'option_category' => 'configuration',
                'default_on_front' => '',
                'toggle_slug' => 'slides',
            ],
        ];
        return $fields;
    }

    public function render($unprocessed_props, $content, $render_slug)
    {
        $args = [
            'content' => $this->content,
            'amount' => $this->props['amount'],
            'terms' => $this->props['terms']
        ];
        ob_start();
        get_template_part(
            str_replace(get_stylesheet_directory() . DIRECTORY_SEPARATOR, '', __DIR__) . '/template',
            null,
            $args
        );
        return ob_get_clean();
    }
}
new TestimonialsSlider;