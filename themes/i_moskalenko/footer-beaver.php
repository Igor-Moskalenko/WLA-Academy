<?php
/**
 * Footer Beaver
 */
?>

<!-- BEGIN of footer -->
<footer class="footer-beaver">

    <div class="grid-container fluid">
        <div class="grid-x grid-margin-x align-middle">
            <div class="cell large-12">
                <?php
                if (has_nav_menu('beaver-footer-menu')) {
                    wp_nav_menu(array('theme_location' => 'beaver-footer-menu', 'menu_class' => 'beaver-footer-menu', 'depth' => 1));
                }
                ?>
            </div>
        </div>
    </div>

    <div class="footer-beaver__wrapper" style="background-image: url(<?php the_field('background_photo', 'options'); ?>);">
    <div class="footer-beaver__content">
        <div class="grid-container fluid">
            <div class="grid-x grid-margin-x">
                <div class="cell large-2">
                    <div class="footer__logo">
                        <?php if ($footer_logo = get_field('beaver_footer_logo', 'options')):
                            echo wp_get_attachment_image($footer_logo['id'], 'medium');
                        else:
                            show_custom_logo();
                        endif; ?>
                    </div>
                </div>
                <div class="cell large-2">
                    <?php if ($address = get_field('beaver_address', 'options')): ?>
                        <div class="footer__address">
                            <h5 class="footer__address-title">Mailing Address</h5>
                            <p><?php echo $address ?></p>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="cell large-2">
                    <?php if ($phone = get_field('beaver_phone', 'options')): ?>
                        <div class="footer__phone">
                            <h5>Telephone</h5>
                            <a class="footer__phone-link" href="tel:<?php echo $phone; ?>"><?php echo $phone; ?></a>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="cell large-2">
                    <?php if ($email = get_field('beaver_email', 'options')): ?>
                        <div class="footer__email">
                            <h5>General Inquires</h5>
                            <a class="footer__email-link" href="mailto:<?php echo $email ?>"><?php echo $email ?></a>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="cell large-2">
                    <?php if ($sub_email = get_field('sub_email', 'options')): ?>
                        <div class="footer__email">
                            <h5>MEDIA InquirIes</h5>
                            <a class="footer__email-link"
                               href="mailto:<?php echo $sub_email ?>"><?php echo $sub_email ?></a>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="cell large-2">
                    <?php get_template_part('parts/socials'); // Social profiles ?>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-beaver__copyright">
        <div class="grid-container fluid">
            <div class="grid-x grid-margin-x align-middle">
                <div class="cell large-6">
                    <?php if ($copyright = get_field('copyright', 'options')): ?>
                        <p class="footer__copyright">
                            <?php echo $copyright; ?>
                        </p>
                    <?php endif; ?>
                </div>

                <div class="cell large-6">
                    <?php if ($designed = get_field('designed', 'options')): ?>
                        <div class="footer__designed">
                            <?php echo $designed; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    </div>

</footer>
<!-- END of footer -->
<?php wp_footer(); ?>
</body>

</html>