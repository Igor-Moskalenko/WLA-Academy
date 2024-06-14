<div class="testimonials-slider">
    <?php
    /**
     * @var array $args
     */
    $amount = isset($args['amount']) ? intval($args['amount']) : -1;
    $terms = isset($args['terms']) ? $args['terms'] : '';

    $args = array(
        'post_type' => 'testimonials',
        'order' => 'ASC',
        'orderby' => 'menu_order',
        'posts_per_page' => $amount,
    );

    if (!empty($terms)) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'testimonial_category',
                'field' => 'slug',
                'terms' => $terms,
            ),
        );
    }

    $query = new WP_Query($args);

    if ($query->have_posts()): ?>
        <div class="testimonials-item">
            <?php while ($query->have_posts()):
                $query->the_post(); ?>
                <div>
                    <div class="testimonials-item__wrapper">
                        <div class="testimonials-item__image">
                            <?php the_post_thumbnail('full', array('class' => 'testimonials-img')); ?>
                        </div>
                        <div class="testimonials-item__content">
                            <div class="testimonials-item__quote">
                                <?php the_content(); ?>
                            </div>
                            <h4><?php echo get_the_title(); ?></h4>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        <?php
        wp_reset_postdata();
    endif;
    ?>
</div>

<script type="text/javascript">
    (function ($) {
        $(document).ready(function () {
            $('.testimonials-item').slick({
                arrows: false,
                dots: true,
                infinite: true,
                speed: 500,
                slidesToShow: 1,
                slidesToScroll: 1,
            });
        });
    })(jQuery);
</script>