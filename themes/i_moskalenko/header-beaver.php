<?php
/**
 * Header Beaver
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <!-- Set up Meta -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
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
<div class="header__menu-toggle">
    <div class="title-bar hide-for-medium" data-responsive-toggle="off-canvas" data-hide-for="medium">
        <button class="menu-icon" type="button" data-open="offCanvasLeft" aria-label="Menu" aria-controls="off-canvas"><span></span></button>
    </div>
</div>
<header class="header-beaver">
    <!-- Off-canvas wrapper -->
    <div class="off-canvas-wrapper">
        <div class="off-canvas position-left reveal-for-large" id="offCanvasLeft" data-off-canvas>
            <div class="logo text-center medium-text-center">
                <h1><?php show_custom_logo(); ?><span class="css-clip"><?php echo get_bloginfo( 'name' ); ?></span></h1>
            </div>

            <?php if ($title = get_field('logo_title', 'options')): ?>
                <p class="header-beaver__title"><?php echo $title ?></p>
            <?php endif; ?>

            <?php if (has_nav_menu('beaver-header-menu')): ?>
                <nav class="beaver-menu-nav">
                    <?php wp_nav_menu(
                        array(
                            'theme_location' => 'beaver-header-menu',
                            'menu_class' => 'beaver-menu',
                            'items_wrap' => '<ul id="%1$s" class="%2$s" data-responsive-menu="accordion medium-dropdown" data-submenu-toggle="true" data-multi-open="false" data-close-on-click-inside="false">%3$s</ul>',
                        )
                    ); ?>
                </nav>
            <?php endif; ?>

            <?php get_template_part( 'parts/socials' ); // Social profiles ?>
        </div>
</header>
<!-- END of header -->


