<?php
/**
 * Template Name: Beaver Page
 */

get_header('beaver'); ?>
         <?php if ( have_posts() ) : ?>
             <?php while ( have_posts() ) : the_post(); ?>
                 <div class="beaver-content">
                     <?php the_content( '', true ); ?>
                 </div>
             <?php endwhile; ?>
         <?php endif; ?>
<?php get_footer('beaver'); ?>