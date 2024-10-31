<?php get_header(); ?>

<section id="primary">
    <div id="content" role="main" style="width: 80%">

    <?php if ( have_posts() ) :

    if ($niceVideoPosts_archive_show_header)
    {
    ?>
        <header class="page-header">
            <h1 class="page-title"><?php echo $niceVideoPosts_archive_show_header_title; ?></h1>
        </header>
    <?php
    }
    ?>
    <div>
        <!-- Start the Loop -->
        <?php

        $niceVideoPosts_show_content = true;
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

        if(is_plugin_active('niceYouTube/niceYouTube.php'))
        {
            $niceVideoPosts_shortcode = '[niceyoutube';
        }
        else if(is_plugin_active('niceYouTubeLite/niceYouTubeLite.php'))
        {
            $niceVideoPosts_shortcode = '[niceyoutubelite';
        }
        else
        {
            echo '<p style="color: red;">The <a style="color:red;" href="http://trinitronic.com/wordpress/wordpress-nice-paypal-button">Nice YouTube plugin</a> or <a style="color:red;" href="http://trinitronic.com/wordpress/wordpress-nice-paypal-button-lite">Nice Youtube Lite plugin</a> must be installed and activated for Nice Video Posts to work correctly.</p>';
            $niceVideoPosts_show_content = false;
        }

        if ($niceVideoPosts_show_content)
        {
            ?>
            <div class="nicevideoposts-archive-wrap">
            <?php
            while ( have_posts() ) : the_post();

            if($niceVideoPosts_archive_layout == "grid")
            {
                // Grid layout
            ?>
                <div class="nicevideoposts-grid-wrap">
                    <?php
                    $niceVideoPosts_vidId = esc_html( get_post_meta( get_the_ID(), 'video_id', true ));
                    echo apply_filters('the_content', $niceVideoPosts_shortcode.' id="'.$niceVideoPosts_vidId.'" width="'.$niceVideoPosts_archive_thumbnail_width.'"]');
                    ?>
                    <?php
                    if($niceVideoPosts_archive_grid_show_post_title)
                    { ?>
                    <h1 class="nicevideoposts-grid-title">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_title(); ?></a>
                    </h1>
                    <?php } ?>
                    <?php
                    if ($niceVideoPosts_archive_grid_excerpt_length_value != 0)
                    { ?>
                    <div class="nicevideoposts-grid-excerpt">
                        <?php the_excerpt(); ?>
                    </div>
                    <?php } ?>
                </div>
            <?php
            }
            else
            {
                // List layout
            ?>
                <div class="nicevideoposts-list-wrap">
                    <div class="nicevideoposts-list-thumbnails">
                    <?php
                    $niceVideoPosts_vidId = esc_html( get_post_meta( get_the_ID(), 'video_id', true ));
                    echo apply_filters('the_content', $niceVideoPosts_shortcode.' id="'.$niceVideoPosts_vidId.'" width="'.$niceVideoPosts_archive_thumbnail_width.'"]');
                    ?>
                    </div>
                    <div class="nicevideoposts-list-content-wrap">
                        <h1 class="nicevideoposts-list-title">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h1>
                        <div class="nicevideoposts-list-excerpt">
                            <?php the_excerpt(); ?>
                        </div>
                    </div>
                    <div class="nicevideoposts-clearboth"></div>
                </div>
            <?php
            }

            endwhile;
         ?>
                <div style="clear: both;"></div>
            </div>
        </div>

    <!-- Display page navigation -->
    <?php global $wp_query;
            if ( isset( $wp_query->max_num_pages ) && $wp_query->max_num_pages > 1 )
            { ?>
                <nav id="<?php echo $nav_id; ?>">
                    <div class="nav-previous"><?php previous_posts_link( '<span class="meta-nav">&larr;</span> Previous' ); ?></div>
                    <div class="nav-next"><?php next_posts_link( 'Next <span class="meta-nav">&rarr;</span>'); ?></div>
                </nav>
    <?php   }
        } //if Nice YouTube (or Lite) plugin is active
     endif; //if have_posts() ?>
    </div>
</section>

<?php get_footer(); ?>