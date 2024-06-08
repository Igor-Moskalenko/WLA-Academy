<?php

/**
 * Class Foundation_Navigation
 */

// class Foundation_Navigation extends Walker_Nav_Menu {
//
// 	/**
// 	 * Adds custom class to dropdown menu for foundation dropdown script
// 	 */
// 	function start_lvl( &$output, $depth = 0, $args = array() ) {
// 		$indent = str_repeat( "\t", $depth );
// 		$output .= "\n$indent<ul class=\"menu submenu\">\n";
// 	}
//
// 	/**
// 	 * Adds custom class to parent item with dropdown menu
// 	 */
// 	function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {
// 		$id_field = $this->db_fields['id'];
// 		if ( ! empty( $children_elements[ $element->$id_field ] ) ) {
// 			$element->classes[] = 'has-dropdown';
// 		}
// 		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
// 	}
// }


class Foundation_Navigation extends Walker_Nav_Menu
{

    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        // Get classes and output them
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        // Get ID and output it
        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';

        // Prepare output
        $output .= $indent . '<li' . $id . $class_names . '>';

        // Get attributes
        $atts = array();
        $atts['title'] = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target) ? $item->target : '';
        $atts['rel'] = !empty($item->xfn) ? $item->xfn : '';
        $atts['href'] = !empty($item->url) ? $item->url : '';
        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args);
        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        // Get item title
        $title = apply_filters('the_title', $item->title, $item->ID);

        // Append image if it exists
        $overlay_color = get_field('overlay_color', $item);
        $overlay_style = $overlay_color ? ' style="background-color:' . esc_attr($overlay_color) . ';"' : '';

        // Get overlay color from ACF field
        $image = '';
        if ($image_field = get_field('image', 'category_portfolio_' . $item->object_id)) {
            $image = '<div class="menu-item__image-wrapper">';
            $image .= '<img src="' . esc_url($image_field['url']) . '" alt="' . esc_attr($image_field['alt']) . '">';
            $image .= '<span class="menu-item-overlay"' . $overlay_style . '></span>';
            $image .= '</div>';
        } else {
            error_log('No image found for item: ' . $item->ID);
        }

        // Get description if it exists
        $description = '';
        if (!empty($item->description)) {
            $description = '<p class="menu-item-description">' . esc_html($item->description) . '</p>';
        }

        // Prepare item output
        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $image;
        $item_output .= '<div class="menu-item-content">';
        $item_output .= $args->link_before . '<span class="menu-item-title">' . $title . '</span>' . $args->link_after;
        $item_output .= $description;
        $item_output .= '</div>';
        $item_output .= '</a>';

        $item_output .= $args->after;

        // Output the item
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}












