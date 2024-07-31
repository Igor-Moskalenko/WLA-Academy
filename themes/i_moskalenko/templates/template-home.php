<?php
/**
 * Template Name: Home Page
 */
get_header(); ?>

<!--HOME PAGE SLIDER-->
<?php home_slider_template(); ?>
<!--END of HOME PAGE SLIDER-->
<? //php get_header('mega-menu'); ?>

<!-- BEGIN of main content -->
<div class="grid-container">
    <div class="grid-x grid-margin-x">

        <div class="medium-3 small-12 cell widget-bar">
            <?php get_sidebar('left'); ?>
        </div>

        <div class="medium-9 small-12 cell">
            <section class="new-products">
                <div class="products__title-wrapper">
                    <?php if ($products_title_new = get_field('products_title_new')): ?>
                        <h3 class="products__title"><?php echo $products_title_new; ?></h3>
                    <?php endif; ?>
                    <div class="custom-arrows-new">
                    </div>
                </div>
                <?php echo do_shortcode('[products limit="-1" columns="3" orderby="id" order="DESC" visibility="visible" class="new-products__grid grid__products"] '); ?>
            </section>

            <section class="top-products">
                <div class="products__title-wrapper">
                    <?php if ($products_title_top = get_field('products_title_top')): ?>
                        <h3 class="products__title"><?php echo $products_title_top; ?></h3>
                    <?php endif; ?>
                    <div class="custom-arrows-top">
                    </div>
                </div>
                <?php echo do_shortcode('[products limit="-1" columns="3" orderby="popularity" order="DESC" visibility="visible" class="top-products__grid grid__products"] '); ?>
            </section>

            <section class="sale-products">
                <div class="products__title-wrapper">
                    <?php if ($products_title_sale = get_field('products_title_sale')): ?>
                        <h3 class="products__title"><?php echo $products_title_sale; ?></h3>
                    <?php endif; ?>
                    <div class="custom-arrows-sale">
                    </div>
                </div>
                <?php echo do_shortcode('[products limit="-1" columns="3" orderby="popularity" order="DESC" visibility="visible" on_sale="true" class="sale-products__grid grid__products"] '); ?>
            </section>

        </div>

        <div class="cell medium-12">
            <section class="brands">
                <?php echo do_shortcode('[pwb-all-brands per_page="7" image_size="full" hide_empty="false" order_by="name" order="ASC" title_position="none"] '); ?>
            </section>
        </div>

    </div>
</div>
<!-- END of main content -->

<?php get_footer(); ?>