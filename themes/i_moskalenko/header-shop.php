<?php
/**
 * Header Shop
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <!-- Set up Meta -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta charset="<?php bloginfo('charset'); ?>">

    <!-- Set the viewport width to device width for mobile -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5, user-scalable=yes">
    <!-- Remove Microsoft Edge's & Safari phone-email styling -->
    <meta name="format-detection" content="telephone=no,email=no,url=no">

    <!-- Add external fonts below (GoogleFonts / Typekit) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,700;1,400&display=swap"
          rel="stylesheet">

    <?php wp_head(); ?>
</head>

<body <?php body_class('no-outline'); ?>>
<?php wp_body_open(); ?>

<!-- BEGIN of header -->
<header class="header-shop" style="background-image: url(<?php the_field('header_background', 'options'); ?>);">
    <div class="grid-container menu-grid-container">
        <div class="grid-x grid-margin-x align-justify">
            <div class="medium-3 small-3 cell">
                <?php if ($header_logo = get_field('header_logo', 'options')): ?>
                    <a href="<?php echo esc_url(home_url('/')) ?>" title="<?php echo get_bloginfo('name') ?>"
                       class="header__logo-wrapper">
                        <img src="<?php echo esc_url($header_logo['url']); ?>"
                             alt="<?php echo esc_attr($header_logo['alt']); ?>" class="header__logo"/>
                    </a>
                <?php endif; ?>
                <div class="cart">
                    <div class="cart__login grid-x">
                        <?php
                        $account_page_url = get_permalink(get_option('woocommerce_myaccount_page_id'));
                        if ($account_page_url) {
                            echo '<a href="' . esc_url($account_page_url) . '">LOG IN</a>';
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
                                <?php echo sprintf(_n('%d item', '%d items', WC()->cart->get_cart_contents_count()), WC()->cart->get_cart_contents_count()); ?>
                            </a>
                        </div>
                        <div class="cart__column">
                            <a id="clear-cart-button" class="cart__clear" href="#"><i class="fa-solid fa-xmark"></i></a>
                            <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="cart__edit">EDIT</a>
                        </div>
                    </div>
                    <div class="quick-access grid-x">
                        <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="cart__link cart__link-view">VIEW CART</a>
                        <a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="cart__link cart__link-checkout">CHECKOUT</a>
                    </div>
                    <?php get_search_form(); ?>
                </div>
            </div>
            <div class="medium-3 small-13 cell">
                <?php get_template_part('parts/socials'); // Social profiles ?>
            </div>
        </div>
    </div>
</header>
<!-- END of header -->
