<!-- BEGIN of Post -->
<article id="post-<?php the_ID(); ?>" <?php post_class('preview preview--' . get_post_type()); ?>>
    <div class="grid-x grid-margin-x">

        <div class="event-image__wrapper rel-wrap">
            <?php
            $image = get_field('featured_image');
            if (!empty($image)): ?>
                <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>"
                    class="stretched-img" />
            <?php endif; ?>
        </div>

        <div class="cell auto">
            <h3 class="preview__title">
                <a href="<?php the_permalink(); ?>"
                    title="<?php echo esc_attr(sprintf(__('Permalink to %s', 'default'), the_title_attribute('echo=0'))); ?>"
                    rel="bookmark"><?php echo get_the_title() ?: __('No title', 'default'); ?>
                </a>
            </h3>

            <?php if ($date = get_field('date')): ?>
                <p><?php echo $date ?></p>
            <?php endif; ?>

            <div class="event-description">
                <?php
                $description = get_field('description');
                if ($description) {
                    $description_parts = explode('<!--more-->', $description);
                    if (isset($description_parts[0])) {
                        echo $description_parts[0];
                    }
                    if (isset($description_parts[1])) {
                        echo '<p><a href="' . get_permalink() . '#more">Read More</a></p>';
                    }
                }
                ?>

            </div>
        </div>
    </div>
</article>
<!-- END of Post -->