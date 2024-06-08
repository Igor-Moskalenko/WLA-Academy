<?php
/**
 * Archive
 *
 * Standard loop for the archive page
 */
get_header(); ?>

<main class="main-content">
    <div class="grid-container">
        <div class="grid-x grid-margin-x posts-list">
            <div class="cell small-12">
                <h2 class="page-title page-title--archive"><?php echo get_the_archive_title(); ?></h2>
            </div>
            <!-- BEGIN of Archive Content -->
            <div class="large-8 medium-8 small-12 cell">
                <div id="result">
                    <?php $args = array(
                        'post_type' => 'events',
                        'posts_per_page' => 3,
                        'paged' => 1,
                        'meta_key' => 'date',
                        'orderby' => 'meta_value',
                        'order' => 'ASC',
                    );

                    $query = new WP_Query($args);

                    if ($query->have_posts()):
                        while ($query->have_posts()):
                            $query->the_post();
                            get_template_part('parts/loop', 'events');
                        endwhile;
                        wp_reset_postdata();
                    else:
                        echo '<p>' . __('No entries found.') . '</p>';
                    endif;
                    ?>
                </div>
                <!-- Load More Button -->
                <button id="load-more" data-page="1"
                    style="display: <?= ($total_pages > 1) ? 'block' : 'none'; ?>;">Load More</button>

                <!-- BEGIN of pagination -->
                <!--                --><?php //foundation_pagination(); ?>
                <!-- END of pagination -->
            </div>
            <!-- END of Archive Content -->
            <!-- BEGIN of Sidebar -->
            <div class="large-4 medium-4 small-12 cell sidebar">
                <?php get_sidebar('right'); ?>
            </div>
            <!-- END of Sidebar -->
        </div>
    </div>
</main>
<?php get_footer(); ?>