<?php get_header(); ?>

<div id="primary">
    <div id="content" role="main">

        <!-- Cycle through all posts -->
        <?php while ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <header class="entry-header">

        <!-- Display Title -->
        <h1 class="entry-title"><?php the_title(); ?></h1>
        <!-- Display author name -->
        <div class="entry-meta">
            <span class="meta-prep meta-prep-author">
            <?php
            $video_author = esc_html( get_post_meta( get_the_ID(), 'video_author', true ) );
            if (isset($video_author) && $video_author != '')
            {
                echo 'by '.$video_author.' ';
            }

            $video_types = wp_get_post_terms(get_the_ID(), 'video_posts_video_type');

            if($video_types)
            {
                $delim = false;
                $typesCnt = count($video_types);
                for($i=0; $i < $typesCnt; $i++)
                {
                    if($delim == true)
                    {
                        echo ', ';
                    }

                    $video_type_url = get_bloginfo('url').'/video-posts-type/'.strtolower(str_replace(' ', '-',trim($video_types[$i]->name)));
                    echo '<a href="'.$video_type_url.'">'.$video_types[$i]->name.'</a>';
                    $delim = true;
                }
            }
            ?>
        </span></div>
        </header>
        <?php
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

        $niceVideoPosts_vidId = esc_html( get_post_meta( get_the_ID(), 'video_id', true ));
        $niceVideoPosts_show_content = true;

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

        if($niceVideoPosts_show_content)
        { ?>
        <div class="nicevideoposts-post-wrap">
            <!-- Display video -->
            <div class="nicevideoposts-post-video-wrap">
            <?php
            $niceVideoPosts_vidId = esc_html( get_post_meta( get_the_ID(), 'video_id', true ));
            echo apply_filters('the_content', $niceVideoPosts_shortcode.' id="'.$niceVideoPosts_vidId.'" width="'.$niceVideoPosts_post_video_width.'"]');
            ?>
            </div>
            <div class="nicevideoposts-clearboth"></div>

            <!-- Display video contents -->
            <div class="nicevideoposts-post-content">
                <div class="entry-content"><?php the_content(); ?></div>
            </div>
        </div>
        <?php } ?>
        </article>
        <!-- Display comment form -->
        <?php comments_template( '', true ); ?>
        <?php endwhile; ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>