<?php
/**
 * TODO: Uncomment some action if you need it
 */

//======================================================================
// SHOP / ARCHIVE PAGE
//======================================================================

/**
 * Disable the WooCommerce default page title
 */

add_filter('woocommerce_show_page_title', '__return_false');

/**
 * Remove Result count
 */

remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);

/**
 * Remove Sorting dropdown
 */

remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);

/**
 * Display WooCommerce breadcrumbs
 */
function custom_woocommerce_breadcrumbs()
{
    echo '<div class="woocommerce-breadcrumbs__wrapper">';
    woocommerce_breadcrumb();

    if (wp_get_referer()) {
        $referrer_url = wp_get_referer();
        echo '<a href="' . esc_url($referrer_url) . '" class="button-previous-page">« ' . __('Back to previous page', 'moskalenko') . '</a>';
    }
    echo '</div>';
}
add_action('woocommerce_before_shop_loop', 'custom_woocommerce_breadcrumbs');
add_action('woocommerce_before_single_product', 'custom_woocommerce_breadcrumbs');


/**
 * Set the breadcrumb delimiter to » (HTML entity for »)
 */
function custom_breadcrumb_delimiter($defaults)
{
    $defaults['delimiter'] = ' &raquo; ';
    return $defaults;
}
add_filter('woocommerce_breadcrumb_defaults', 'custom_breadcrumb_delimiter');

/**
 * Rename default Catalog Order
 */
function rename_catalog_orderby($options)
{
    $options['menu_order'] = 'Position';
    $options['price'] = 'Price (to high)';
    $options['price-desc'] = 'Price (to low)';
    $options['date'] = 'Date';
    $options['rating'] = 'Rating';
    $options['popularity'] = 'Popularity';

    return $options;
}
add_filter('woocommerce_catalog_orderby', 'rename_catalog_orderby');

/**
 * Function to wrap sorting and pagination
 */
function add_sort_and_pagination_wrapper()
{
    ob_start();
    ?>
    <div class="shop__filter">
        <div class="shop__filter-sort">
            <span class="shop__filter-text"><?php _e('Sort By', 'moskalenko'); ?></span>
            <?php woocommerce_catalog_ordering(); ?>
        </div>

        <div class="shop__filter-view">
            <span class="shop__filter-text"><?php _e('View As:', 'moskalenko'); ?></span>
            <?php echo do_shortcode('[br_grid_list]'); ?>
        </div>

        <div class="shop__filter-select">
            <?php custom_select(); ?>
        </div>

        <?php if (function_exists('woocommerce_pagination')): ?>
            <?php
            ob_start();
            woocommerce_pagination();
            $pagination = ob_get_clean();
            ?>

            <?php if (!empty($pagination)): ?>
                <div class="shop__filter-pagination">
                    <span class="shop__filter-text"><?php _e('Page:', 'moskalenko'); ?></span>
                    <?php echo $pagination; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>

    </div>
    <?php
    $output = ob_get_clean();
    echo $output;
}

add_action('woocommerce_before_shop_loop', 'add_sort_and_pagination_wrapper', 15);
add_action('woocommerce_after_shop_loop', 'add_sort_and_pagination_wrapper', 15);

/**
 * Function for changing the number of products on the page
 */
function ps_pre_get_products_query($query)
{
    if ($query->is_main_query() && !is_admin() && is_post_type_archive('product')) {
        $per_page = filter_input(INPUT_GET, 'perpage', FILTER_SANITIZE_NUMBER_INT);
        $query->set('posts_per_page', $per_page ?: 12);
    }
}
add_action('pre_get_posts', 'ps_pre_get_products_query');

function custom_select()
{
    $per_page = filter_input(INPUT_GET, 'perpage', FILTER_SANITIZE_NUMBER_INT);

    $options = array(
        '12' => __('Default', 'moskalenko'),
    );

    $args = array('post_type' => 'product', 'post_status' => 'publish', 'posts_per_page' => -1);
    $products = new WP_Query($args);

    for ($i = 1; $i <= $products->found_posts; $i++) {
        $options[$i] = $i;
    }

    ob_start();
    ?>
    <span class="shop__filter-text"><?php _e('Show:', 'moskalenko'); ?></span>
    <div class="shop__filter-select-dropdown">
        <select onchange="if (this.value) window.location.href=this.value">
            <?php foreach ($options as $value => $label): ?>
                <option value="?perpage=<?php echo esc_attr($value); ?>" <?php selected($per_page, $value); ?>>
                    <?php echo esc_html($label); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <span class="shop__filter-text"><?php _e('Per Page', 'moskalenko'); ?></span>
    <?php
    $output = ob_get_clean();
    echo $output;
}

//add_action( 'woocommerce_before_shop_loop', 'woocommerce_pagination', 10 );
remove_action('woocommerce_after_shop_loop', 'woocommerce_pagination', 10);

//======================================================================
// SINGLE PRODUCT PAGE
//======================================================================

/**
 * Replace excerpt with full content
 */

//remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
//add_action( 'woocommerce_single_product_summary', 'single_product_content_replace', 20 );

function single_product_content_replace()
{
    the_content();
}

/**
 * Remove info tabs under products info (Description / Reviews / ...)
 */

//remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );


/**
 * Add SKU code
 */
function add_product_code_to_single_product()
{
    global $product;

    $product_sku = $product->get_sku();

    if (!empty($product_sku)) {
        echo '<p class="product-code">Product Code: ' . esc_html($product_sku) . '</p>';
    }
}

add_action('woocommerce_single_product_summary', 'add_product_code_to_single_product', 5);

/**
 * Display custom availability text on the single product page
 */
function custom_add_availability_to_single_product()
{
    global $product;

    if (!is_a($product, 'WC_Product')) {
        return;
    }

    $availability = $product->get_availability();
    $stock_status = $availability['class'];
    $stock_text = $availability['availability'];

    if ($stock_status == 'in-stock') {
        echo '<p class="stock in-stock">' . esc_html__('Availability: ', 'woocommerce') . '<span>' . esc_html__('In Stock', 'woocommerce') . '</span></p>';
    } elseif ($stock_status == 'out-of-stock') {
        echo '<p class="stock out-of-stock">' . esc_html__('Availability: ', 'woocommerce') . '<span>' . esc_html__('Out of Stock', 'woocommerce') . '</span></p>';
    } else {
        echo '<p class="stock">' . esc_html__('Availability: ', 'woocommerce') . '<span>' . esc_html($stock_text) . '</span></p>';
    }
}

add_action('woocommerce_single_product_summary', 'custom_add_availability_to_single_product', 10);

/**
 * Add Custom Heading for woocommerce product details
 */
function action_woocommerce_single_product_sum()
{

    echo '<h4 class="woocommerce-product-details__heading">' . __('Quick Overview:', 'moskalenko') . '</h4>';
}

add_action('woocommerce_single_product_summary', 'action_woocommerce_single_product_sum', 10, 0);

/**
 * Add a filter to modify the variable product price
 */
function custom_variation_price($price, $product)
{
    $prices = $product->get_variation_prices(true);
    $max_price = current($prices['price']);

    return wc_price($max_price);
}

add_filter('woocommerce_variable_price_html', 'custom_variation_price', 10, 2);

/**
 * Add custom attribute buttons to simple products
 */
function custom_simple_product_attributes_buttons()
{
    global $product;

    if ($product->is_type('simple')) {

        $attributes = $product->get_attributes();

        if ($attributes) {
            echo '<div class="product-attributes-buttons">';
            foreach ($attributes as $attribute) {
                if ($attribute->is_taxonomy()) {
                    $terms = wp_get_post_terms($product->get_id(), $attribute->get_name(), array('fields' => 'names'));
                    $attribute_values = $terms;
                } else {
                    $attribute_values = $attribute->get_options();
                }

                echo '<div class="product-attribute">';
                echo '<span class="product-attribute__title">' . wc_attribute_label($attribute->get_name()) . ':</span> ';
                echo '<div class="attribute-buttons-container">';
                foreach ($attribute_values as $value) {
                    $input_id = esc_attr($attribute->get_name() . '_' . $value);
                    echo '<button type="button" class="attribute-button" data-attribute="' . esc_attr($attribute->get_name()) . '" data-value="' . esc_attr($value) . '">' . esc_html($value) . '</button>';
                }
                echo '</div>';

                echo '</div>';
            }
            echo '</div>';
        }
    }
}

add_action('woocommerce_single_product_summary', 'custom_simple_product_attributes_buttons', 20);

/**
 * Heading to the quantity input
 */
function quantity_title()
{
    echo '<p>' . __('Quantity', 'woocommerce') . '</p>';
}

add_action('woocommerce_before_quantity_input_field', 'quantity_title');

/**
 * Add block with button:
 * -wishlists
 * -compare
 * -email for friends
 *
 */
function block_wishlists_compare()
{
    global $post;
    echo '<div class="block__buttons">';
    echo do_shortcode("[yith_wcwl_add_to_wishlist]");
    echo do_shortcode("[yith_compare_button]");
    echo '<a class="email__link" href="mailto:?subject=I share with you information about the product. Name: ' . get_the_title() . '  ' . 'Link: ' . get_permalink() . '">' . __(' Email to a Friend', 'moskalenko') . '</a>';
    echo '</div>';
}

add_action('woocommerce_after_add_to_cart_button', 'block_wishlists_compare');

/**
 * Remove "RECENTLY VIEWED"
 */
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

/**
 * Remove default SKUs and add
 */
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);


/**
 * Add a custom product data tab "Product Tags"
 */
function woo_new_product_tab($tabs)
{
    // Adds the new tab
    $tabs['test_tab'] = array(
        'title' => __('Product tags', 'woocommerce'),
        'priority' => 50,
        'callback' => 'woo_new_product_tab_content'
    );

    return $tabs;
}

add_filter('woocommerce_product_tabs', 'woo_new_product_tab');

function woo_new_product_tab_content()
{
    global $products;
    $product_tags = get_the_term_list($products, 'product_tag', '', ',');
    echo '<p class="single-product-tags">' . __("Tags: ", "moskalenko") . $product_tags . '<p>';
}

/**
 * Rename tab Reviews()
 *
 */
function woo_rename_reviews_tab($tabs)
{
    $tabs['reviews']['title'] = 'Reviews';

    return $tabs;
}

add_filter('woocommerce_product_tabs', 'woo_rename_reviews_tab', 20);

/**
 * Add "Recently Product"
 */
function woocommerce_recently_viewed_products()
{
    if (!is_singular('product')) {
        return;
    }

    global $product;
    $product_id = $product->get_id();
    $viewed_products = array();

    if (isset($_COOKIE['woocommerce_recently_viewed'])) {
        $viewed_products = array_filter(explode('|', $_COOKIE['woocommerce_recently_viewed']));
    }

    if (!in_array($product_id, $viewed_products)) {
        array_unshift($viewed_products, $product_id);
    }

    if (count($viewed_products) > 6) {
        array_pop($viewed_products);
    }

    setcookie('woocommerce_recently_viewed', implode('|', $viewed_products), time() + 3600 * 24, '/');

    if (empty($viewed_products)) {
        return;
    }

    $output = '<div class="recently-added">';
    $output .= '<h2>' . __('Recently Viewed', 'woocommerce') . '</h2>';
    $output .= '<ul class="recently-viewed">';

    foreach ($viewed_products as $viewed_product_id) {
        $viewed_product = wc_get_product($viewed_product_id);
        if (!$viewed_product) {
            continue;
        }
        $output .= '<a class="recently-viewed__item" href="' . esc_url(get_permalink($viewed_product_id)) . '">';
        $output .= $viewed_product->get_image('medium');
        $output .= '<h4 class="recently-viewed__title">' . get_the_title($viewed_product_id) . '</h4>' . $viewed_product->get_price_html() . '</a>';
    }

    $output .= '</ul>';
    $output .= '</div>';

    echo $output;
}

add_action('woocommerce_after_single_product_summary', 'woocommerce_recently_viewed_products', 25);


//======================================================================
// CART PAGE
//======================================================================



//======================================================================
// CHECKOUT PAGE
//======================================================================



//======================================================================
// MY ACCOUNT PAGE
//======================================================================



//======================================================================
// DASHBOARD TWEAKS
//======================================================================