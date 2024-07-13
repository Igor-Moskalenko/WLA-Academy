<?php
/**
 * @param array $settings
 */

$settings = $module->settings;
$number_of_testimonials = $settings->number_of_testimonials;
$query = FLBuilderLoop::query($settings);


if ($query->have_posts()): ?>
    <div class="testimonials-slider">
        <div class="testimonials-item">
            <?php
            // Counter to track testimonials displayed
            $testimonial_count = 0;

            while ($query->have_posts() && ($number_of_testimonials == 0 || $testimonial_count < $number_of_testimonials)):
                $query->the_post();
                $testimonial_count++;
                ?>
                <div class="testimonials-item__wrapper">
                    <div class="testimonials-item__image">
                        <?php the_post_thumbnail('full', array('class' => 'testimonials-img')); ?>
                    </div>
                    <div class="testimonials-item__content">
                        <div class="testimonials-item__quote">
                            <?php echo wpautop(get_the_content()); ?>
                        </div>
                        <h4><?php echo get_the_title(); ?></h4>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
    <?php
    wp_reset_postdata();
endif;
?>