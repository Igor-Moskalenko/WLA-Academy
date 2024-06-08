<?php
/**
 * Template Name: Create an Account
 */
get_header(); ?>


<div class="grid-container">
    <div class="grid-x grid-margin-x">
        <div class="cell">
            <div class="form-wrapper">
                <?php echo do_shortcode('[gravityform id=3 title=true description=false ajax=true]'); ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>