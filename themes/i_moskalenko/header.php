<?php
/**
 * Header
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

<!-- <div class="preloader hide-for-medium">
<div class="preloader__icon"></div>
</div> -->

<!-- BEGIN of header -->
<header class="header">
    <div class="grid-container menu-grid-container">
        <div class="grid-x grid-margin-x align-middle align-justify">
            <div class="medium-3 small-3 cell">
                <?php if ($header_logo = get_field('header_logo', 'options')): ?>
                    <a href="<?php echo esc_url(home_url('/')) ?>" title="<?php echo get_bloginfo('name') ?>"
                       class="header__logo-wrapper">
                        <img src="<?php echo esc_url($header_logo['url']); ?>"
                             alt="<?php echo esc_attr($header_logo['alt']); ?>" class="header__logo"/>
                    </a>
                <?php endif; ?>
            </div>
            <div class="medium-3 small-13 cell">
                <?php get_template_part('parts/socials'); // Social profiles ?>
            </div>
        </div>
    </div>
</header>
<!-- END of header -->