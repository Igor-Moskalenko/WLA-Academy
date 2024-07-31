<?php
/**
 * Footer
 */
?>

<!-- BEGIN of footer -->
<footer class="footer">
    <div class="footer-top">
        <div class="grid-container">
            <div class="grid-x">
                <div class="large-4 medium-4 small-12 cell">
                    <?php if ($facebook_link = get_field('facebook_link', 'options')): ?>
                        <a class="footer-top__facebook" href="<?php echo esc_url($facebook_link); ?>" target="_blank">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>
                    <?php endif; ?>
                </div>
                <div class="large-4 medium-4 small-12 cell">
                    <?php if ($twitter_link = get_field('twitter_link', 'options')): ?>
                        <a class="footer-top__twitter" href="<?php echo esc_url($twitter_link); ?>" target="_blank">
                            <i class="fa-brands fa-twitter"></i>
                        </a>
                    <?php endif; ?>
                </div>
                <div class="large-4 medium-4 small-12 cell">
                    <?php if ($pinterest_link = get_field('pinterest_link', 'options')): ?>
                        <a class="footer-top__pinterest" href="<?php echo esc_url($pinterest_link); ?>" target="_blank">
                            <i class="fa-brands fa-pinterest"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="grid-container">
            <div class="grid-x grid-margin-x">
                <div class="cell medium-2 small-12">
                    <div class="footer__menu">
                        <h6 class="footer__title">Category</h6>
                        <?php
                        if (has_nav_menu('category-menu')) {
                            wp_nav_menu(array('theme_location' => 'category-menu', 'menu_class' => 'category-menu menu vertical', 'depth' => 1));
                        }
                        ?>
                    </div>
                </div>

                <div class="cell medium-2 small-12">
                    <div class="footer__menu">
                        <h6 class="footer__title">Our Account</h6>
                        <?php
                        if (has_nav_menu('account-menu')) {
                            wp_nav_menu(array('theme_location' => 'account-menu', 'menu_class' => 'account-menu menu vertical', 'depth' => 1));
                        }
                        ?>
                    </div>
                </div>
                <div class="cell medium-2 small-12">
                    <div class="footer__menu">
                        <h6 class="footer__title">Our Support</h6>
                        <?php
                        if (has_nav_menu('support-menu')) {
                            wp_nav_menu(array('theme_location' => 'support-menu', 'menu_class' => 'support-menu menu vertical', 'depth' => 1));
                        }
                        ?>
                    </div>
                </div>
                <div class="cell medium-3 small-12">
                    <h6 class="footer__title">Newsletter</h6>
                    <?php if ($newsletter_description = get_field('newsletter_description', 'options')): ?>
                        <p class="footer__description"><?php echo $newsletter_description; ?></p>
                    <?php endif; ?>
                    <div class="footer__search">
                        <form>
                            <input type="text" class="text" value="Insert Email" onfocus="this.value = '';"
                                   onblur="if (this.value == '') {this.value = 'Insert Email';}">
                            <input type="submit" value="Submit">
                        </form>
                    </div>
                    <?php if ($footer_newsletter_image = get_field('footer_newsletter_image', 'options')): ?>
                        <img src=<?php echo $footer_newsletter_image['url'] ?> alt="">
                    <?php endif; ?>
                </div>
                <div class="cell medium-3 small-12">
                    <h6 class="footer__title">About Us</h6>
                    <?php if ($about_description = get_field('about_description', 'options')): ?>
                        <p class="footer__description"><?php echo $about_description; ?></p>
                    <?php endif; ?>
                    <?php if ($phone = get_field('phone', 'options')): ?>
                        <p class="footer-phone"><span>Phone: </span><a
                                    href="tel:<?php echo $phone ?>"><?php echo $phone; ?></a></p>
                    <?php endif; ?>
                    <?php if ($email = get_field('email', 'options')): ?>
                        <p class="footer-email"><span>Email: </span><a
                                    href="mailto:<?php echo $email ?>"><?php echo $email; ?></a></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php if ($copyright = get_field('copyright', 'options')): ?>
        <div class="footer__copy">
            <div class="grid-container">
                <div class="grid-x grid-margin-x">
                    <div class="medium-6 small-12 cell ">
                        <?php echo $copyright; ?>
                    </div>
                    <div class="medium-6 small-12 cell ">
                        <?php get_template_part('parts/socials'); // Social profiles ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

</footer>
<!-- END of footer -->
<!--<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>-->
<?php wp_footer(); ?>
</body>

</html>