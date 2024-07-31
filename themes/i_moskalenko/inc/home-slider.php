<?php

// Register Post Type Slider
function post_type_slider()
{
    $post_type_slider_labels = array(
        'name' => _x('Slider', 'post type general name', 'default'),
        'singular_name' => _x('Slide', 'post type singular name', 'default'),
        'add_new' => _x('Add New', 'slide', 'default'),
        'add_new_item' => __('Add New Slide', 'default'),
        'edit_item' => __('Edit Slide', 'default'),
        'new_item' => __('New Slide', 'default'),
        'all_items' => __('All Slides', 'default'),
        'view_item' => __('View Slide', 'default'),
        'search_items' => __('Search Slides', 'default'),
        'not_found' => __('No slides found.', 'default'),
        'not_found_in_trash' => __('No slides found in Trash.', 'default'),
        'parent_item_colon' => '',
        'menu_name' => 'Slider'
    );
    $post_type_slider_args = array(
        'labels' => $post_type_slider_labels,
        'description' => 'Display Slider',
        'public' => false,
        'show_ui' => true,
        'menu_icon' => 'dashicons-format-gallery',
        'menu_position' => 5,
        'supports' => array(
            'title',
            'thumbnail',
            'page-attributes',
            'editor',
            'post-formats'
        ),
        'has_archive' => false,
        'hierarchical' => true
    );
    register_post_type('slider', $post_type_slider_args);
    add_theme_support('post-formats', array('video'));
    remove_post_type_support('post', 'post-formats');
}

add_action('init', 'post_type_slider');

// Add Video background Metabox to slider post type
add_action('add_meta_boxes', 'slide_background_metabox');

function slide_background_metabox()
{
    $screens = array('slider');
    add_meta_box('slide_background', __('Slide background', 'default'), 'slider_background_callback', $screens);
}

function slider_background_callback($post, $meta)
{
    wp_nonce_field('save_video_bg', 'project_nonce');
    ?>
    <style>
        .fields-list {
            margin-left: -12px;
            margin-right: -12px;
        }

        .fields-list::after {
            content: '';
            display: table;
            clear: both;
        }

        .field-wrap {
            float: left;
            padding-left: 12px;
            padding-right: 12px;
            box-sizing: border-box;
        }
    </style>
    <div class="fields-list">
        <div class="field-wrap" style="width: 70%">
            <p class="label-wrapper"><label for="slide_video"
                    style="display: block;"><b><?php _e('Video background', 'default'); ?></b></label><em><?php _e('Enter here link to video from Media Library or YouTube', 'default'); ?></em>
            </p>
            <input type="text" id="slide_video" name="slide_video_bg"
                value="<?php echo get_post_meta($post->ID, 'slide_video_bg', true); ?>" style="width: 100%;" />
        </div>
        <div class="field-wrap" style="width: 30%">
            <p class="label-wrapper"><label for="video_aspect_ratio"
                    style="display: block;"><b><?php _e('Video aspect ratio', 'default'); ?></b></label>
            </p>
            <?php
            $aspect_ratio = get_post_meta($post->ID, 'video_aspect_ratio', true) ?: '16:9';
            $ratio_list = array('16:9', '4:3', '2.39:1');
            ?>
            <select name="video_aspect_ratio" id="video_aspect_ratio" style="width: 100%;">
                <?php foreach ($ratio_list as $item): ?>
                    <option value="<?php echo $item; ?>" <?php selected($aspect_ratio, $item); ?>><?php echo $item; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="clearfix" style="clear:both"></div>
    </div>
    <?php
}

/**
 * Update slide background on slide save
 */

add_action('save_post', 'save_slide_background');

function save_slide_background($post_id)
{

    if (!isset($_POST['slide_video_bg']) && !isset($_POST['video_aspect_ratio'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['project_nonce'], 'save_video_bg')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    update_post_meta($post_id, 'video_aspect_ratio', $_POST['video_aspect_ratio']);
    update_post_meta($post_id, 'slide_video_bg', $_POST['slide_video_bg']);

}

/**
 * Print script to hande appearance of metabox
 */
//add_action('admin_enqueue_scripts','display_metaboxes');
add_action('admin_footer', 'display_metaboxes');

function display_metaboxes()
{

    if (get_post_type() == "slider"):
        ?>
        <script type="text/javascript">// <![CDATA[
            $ = jQuery;

            function displayMetaboxes() {
                $('#slide_background').hide();
                var selectedFormat = $('input[name=\'post_format\']:checked').val();
                if (selectedFormat == 'video') {
                    $('#slide_background').show();
                }
            }

            $(function () {
                displayMetaboxes();
                $('input[name=\'post_format\']').change(function () {
                    displayMetaboxes();
                });
            });
            // ]]></script>
        <?php
    endif;
}

// Create HOME Slider
function home_slider_template()
{ ?>

    <script type="text/javascript">

        // Send command to iframe youtube player
        function postMessageToPlayer(player, command) {
            if (player == null || command == null) return;
            player.contentWindow.postMessage(JSON.stringify(command), '*');
        }

        jQuery(document).ready(function () {
            var $homeSlider = jQuery('#home-slider');
            $homeSlider
                .on('init', function (event, slick) {
                    slick.$slides.not(':eq(0)').find('.video--local').each(function () {
                        this.pause();
                    });

                    if (slick.$slides.eq(0).find('.video--local').length) {
                        slick.$slides.eq(0).find('.video--local')[0].play();
                    }
                    if (slick.$slides.eq(0).find('.video--embed').length) {
                        var playerId = slick.$slides.eq(0).find('iframe').attr('id');
                        var player = jQuery('#' + playerId).get(0);
                        postMessageToPlayer(player, {
                            'event': 'command',
                            'func': 'playVideo'
                        });
                    }
                })
                .on('beforeChange', function (event, slick, currentSlide, nextSlide) {
                    // Pause youtube video on slide change
                    if (slick.$slides.eq(currentSlide).find('.video--embed').length) {
                        var playerId = slick.$slides.eq(currentSlide).find('iframe').attr('id');
                        var player = jQuery('#' + playerId).get(0);
                        postMessageToPlayer(player, {
                            'event': 'command',
                            'func': 'pauseVideo'
                        });
                    }
                    // Pause local video on slide change
                    if (slick.$slides.eq(currentSlide).find('.video--local').length) {
                        slick.$slides.eq(currentSlide).find('.video--local')[0].pause();
                    }

                })
                .on('afterChange', function (event, slick, currentSlide) {
                    // Start playing local video on current slide
                    if (slick.$slides.eq(currentSlide).find('.video--local').length) {
                        slick.$slides.eq(currentSlide).find('.video--local')[0].play();
                    }

                    // Start playing youtube video on current slide
                    if (slick.$slides.eq(currentSlide).find('.video--embed').length) {
                        var playerId = slick.$slides.eq(currentSlide).find('iframe').attr('id');
                        var player = jQuery('#' + playerId).get(0);
                        postMessageToPlayer(player, {
                            'event': 'command',
                            'func': 'playVideo'
                        });
                    }

                });

            $homeSlider.slick({
                cssEase: 'ease',
                fade: true,  // Cause trouble if used slidesToShow: more than one
                // arrows: false,
                dots: true,
                infinite: true,
                speed: 500,
                autoplay: true,
                autoplaySpeed: 5000,
                slidesToShow: 1,
                slidesToScroll: 1,
                rows: 0, // Prevent generating extra markup
                slide: '.slick-slide', // Cause trouble with responsive settings
            });
        });
    </script>

    <?php

    $related_products = get_field('related_products');

    if ($related_products && is_array($related_products)):
        $arg = array(
            'post_type' => 'product',
            'post__in' => $related_products,
            'orderby' => 'post__in',
            'posts_per_page' => -1
        );
        $slider = new WP_Query($arg);

        if ($slider->have_posts()): ?>
            <div id="home-slider" class="slick-slider home-slider">
                <div class="grid-container">
                    <div class="grid-x grid-margin-x">
                        <div class="cell medium-3">
                            <div class="home-slider__sidebars">

                                <div class="cart">
                                    <div class="cart__login grid-x">
                                        <?php
                                        $account_page_url = get_permalink(get_option('woocommerce_myaccount_page_id'));
                                        if ($account_page_url) {
                                            echo '<a href="' . esc_url($account_page_url) . '">' . __('LOG IN', 'moskalenko') . '</a>';
                                        }
                                        ?>
                                        <?php echo do_shortcode('[yith_wcwl_items_count]'); ?>
                                    </div>
                                    <div class="cart__info">
                                        <div class="cart__icon"></div>
                                        <div>
                                            <a class="cart__price" href="<?php echo wc_get_cart_url(); ?>">
                                                <?php echo WC()->cart->get_cart_total(); ?>
                                            </a>
                                            <a class="cart__items" href="<?php echo wc_get_cart_url(); ?>">
                                                <?php printf(_n('%d item', '%d items', WC()->cart->get_cart_contents_count(), 'your-text-domain'), WC()->cart->get_cart_contents_count()); ?>
                                            </a>
                                        </div>
                                        <div class="cart__column">
                                            <a id="clear-cart-button" class="cart__clear" href="#"><i
                                                    class="fa-solid fa-xmark"></i></a>
                                            <a href="<?php echo esc_url(wc_get_cart_url()); ?>"
                                                class="cart__edit"><?php _e('EDIT', 'moskalenko'); ?></a>
                                        </div>
                                    </div>
                                    <div class="cart__quick-access grid-x">
                                        <a href="<?php echo esc_url(wc_get_cart_url()); ?>"
                                            class="cart__link cart__link-view"><?php _e('VIEW CART', 'moskalenko'); ?></a>
                                        <a href="<?php echo esc_url(wc_get_checkout_url()); ?>"
                                            class="cart__link cart__link-checkout"><?php _e('CHECKOUT', 'moskalenko'); ?></a>
                                    </div>
                                    <?php get_search_form(); ?>
                                </div>
                                <div class="info-box">
                                    <?php if ($box_title = get_field('box_title')): ?>
                                        <h4 class="info-box__title"><?php echo esc_html($box_title); ?></h4>
                                    <?php endif; ?>
                                    <?php if ($box_description = get_field('box_description')): ?>
                                        <p class="info-box__description"><?php echo esc_html($box_description); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php while ($slider->have_posts()):
                    $slider->the_post(); ?>
                    <div class="slick-slide home-slide">
                        <div class="home-slide__inner rel-wrap">

                            <?php
                            $image = get_field('image_brands', get_the_ID());
                            if ($image): ?>
                                <img class="stretched-img home-slide__bg" src="<?php echo esc_url($image['url']); ?>"
                                    alt="<?php echo esc_attr($image['alt']); ?>" />
                            <?php else: ?>
                                <?php echo wp_get_attachment_image(get_post_thumbnail_id(), 'full_hd', false, array('class' => 'stretched-img home-slide__bg')); ?>
                            <?php endif; ?>

                            <div class="grid-x grid-margin-x align-right items-center home-slide__caption">
                                <div class="cell medium-7 large-5 slider-container">
                                    <?php
                                    echo '<h5 class="hero-product-title">' . esc_html(get_the_title()) . '</h5>';
                                    $description = get_the_excerpt();
                                    echo '<p class="hero-product-description">' . wp_trim_words($description, 20, '...') . '</p>';
                                    echo '<a href="' . esc_url(get_permalink()) . '" class="buy-now button">' . __('BUY NOW', 'moskalenko') . '</a>';
                                    ?>
                                </div>
                            </div>

                        </div>
                    </div>
                <?php endwhile; ?>
            </div><!-- END of  #home-slider-->

        <?php endif;
        wp_reset_query(); ?>
    <?php endif; ?>

<?php }

// HOME Slider Shortcode

function home_slider_shortcode()
{
    ob_start();
    home_slider_template();
    $slider = ob_get_clean();

    return $slider;
}

add_shortcode('slider', 'home_slider_shortcode');
