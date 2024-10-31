<?php
/**
 * @package Nice Video Posts
 */
/*
Plugin Name: Nice Video Posts
Plugin URI: http://trinitronic.com/index.php/Downloads/downloads.html
Description: Nice Video Posts is a custom post type for displaying videos.
Version: 1.00
Author: TriniTronic
Author URI: http://trinitronic.com
License: GPLv2 or later
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

/* Settings Notes:
 * - When using grid view, set the width for the .nicevideoposts-grid-wrap CSS style
 * (/niceVideoPosts/css/style.css) to match the width of the
 * niceVideoPosts_archive_thumbnail_width setting.
 */
$niceVideoPosts_post_video_width                    = 640; // Width in pixels of the post page video, enter an integer.
$niceVideoPosts_archive_show_header                 = false; // Show the header, valid values = true or false.
$niceVideoPosts_archive_show_header_title           = "Video Posts"; // Header title, enter title text.
$niceVideoPosts_archive_posts_per_page              = 12; // Number of posts to show on archive page, enter an integer.
$niceVideoPosts_archive_thumbnail_width             = 356; // Width in pixels of the archive page thumbnails, enter an integer.
$niceVideoPosts_archive_layout                      = "list"; // Defines archive page layout, valid values = grid or list.
$niceVideoPosts_archive_list_excerpt_length_value   = 42; // Defines archive page excerpt for list layout, enter an integer.
$niceVideoPosts_archive_grid_excerpt_length_value   = 0; // Defines archive page excerpt for grid layout, enter an integer. Set to 0 for no excerpt.
$niceVideoPosts_archive_grid_show_post_title        = true; // Show post title for grid view, enter true or false.

/*
 * Creates & defines custom post type.
 */
function niceVideoPosts_create_video_post_type()
{
    register_post_type('video_posts',
        array(
            labels=>array(
                'name' => 'Video Posts',
                'singular_name' => 'Video Post',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Video Post',
                'edit' => 'Edit',
                'edit_item' => 'Edit Video Post',
                'new_item' => 'New Video Post',
                'view' => 'View',
                'view_item' => 'View Video Post',
                'search_items' => 'Search Video Posts',
                'not_found' => 'No Video Posts found',
                'not_found_in_trash' => 'No Video Posts found in trash',
                'parent' => 'Parent Video Post'
            ),
            'public' => true,
            'menu_position' => 20,
            'supports' => array('title', 'editor', 'comments'),
            'taxonomies' => array(''),
            'menu_icon' => plugins_url('img/video-post-16x16.png', __FILE__),
            'has_archive' => true,
            'rewrite' => array('slug' => 'video-posts')
        )
    );

    /*
     * Add custom taxonomies for video post types
     */
    register_taxonomy(
        'video_posts_video_type',
        'video_posts',
        array(
            'labels' => array(
                'name' => 'Video Type',
                'add_new_item' => 'Add New Video Type',
                'new_item_name' => "New Video Type Name"
            ),
            'show_ui' => false,
            'show_tagcloud' => false,
            'hierarchical' => true,
            'update_count_callback' => '_update_post_term_count',
            'rewrite' => array('slug' => 'video-posts-type')
        )
    );
}

/*
* Adds extra fields meta box
 */
function niceVideoPosts_admin_init()
{
    add_meta_box(
        'niceVideoPosts_details_meta_box',
        'Video Post Details',
        'niceVideoPosts_display_video_post_details_meta_box',
        'video_posts',
        'normal',
        'high'
    );
}

/*
* Builds display of extra fields meta box
 */
function niceVideoPosts_display_video_post_details_meta_box( $video_post )
{

    // Retrieve current meta box settings based on custom post ID
    $video_id = esc_html( get_post_meta( $video_post->ID, 'video_id', true ) );
    $video_author = esc_html( get_post_meta( $video_post->ID, 'video_author', true ) );
    //$video_rating = intval( get_post_meta( $video_post->ID, 'rating', true ) );
    ?>
    <table>
        <tr>
            <td style="width: 100%">Video Id</td>
            <td><input type='text' size='80' name='video_post_video_id' value='<?php echo $video_id; ?>' /></td>
        </tr>
        <tr>
            <td style="width: 100%">Video by</td>
            <td><input type='text' size='80' name='video_post_author_name' value='<?php echo $video_author; ?>' /></td>
        </tr>
        <tr>
            <td>Video Type</td>
            <td>
                <?php
                // Retrieve array of taxonomy types assigned to post
                $assigned_types = wp_get_post_terms( $video_post->ID, "video_posts_video_type" );

                // Retrieve array of all taxonomy types in system
                $video_types = get_terms
                    (
                        'video_posts_video_type',
                        array
                        (
                            'orderby'    => "name",
                            'hide_empty' => 0
                        )
                    );

                // Check if taxonomy types were found
                if ( $video_types )
                {
                    foreach ( $video_types as $video_type )
                    {
                        echo '<input type="checkbox" name="video_posts_video_type[]" value="'.$video_type->term_id.'"';
                        $checked = '';
                        foreach($assigned_types as $assigned_type)
                        {
                            if($video_type->term_id == $assigned_type->term_id)
                            {
                                $checked = ' checked';
                            }
                        }
                        echo $checked.'> '.$video_type->name.'<br>';
                    }
                }
                ?>
            </td>
        </tr>
    </table>
<?php
}

/*
 * Saves input of extra fields
 */
function niceVideoPosts_add_video_post_fields($post_id=false)
{
    // check whether anything should be done
    if(get_post_type() != 'video_posts')
    {
        return;
    }

    // Is user allowed to do it?
    if ( !current_user_can( 'edit_post', $post_id ) )
    {
        return;
    }

    // If present, store data in post meta table
    if ( isset( $_POST['video_post_video_id'] ) && $_POST['video_post_video_id'] != '' )
    {
        update_post_meta( $post_id, "video_id", $_POST['video_post_video_id'] );
    }

    // If present, store data in post meta table
    if ( isset( $_POST['video_post_author_name'] ) && $_POST['video_post_author_name'] != '' )
    {
        update_post_meta( $post_id, "video_author", $_POST['video_post_author_name'] );
    }

    if(isset($_POST['video_posts_video_type']) && $_POST['video_posts_video_type'] != '')
    {
        wp_set_post_terms($post_id, $_POST['video_posts_video_type'], 'video_posts_video_type');
    }
}

/*
 * Defines tmpl file path used for frontend display for custom post type.
 */
function niceVideoPosts_template_include($template_path)
{
    if(get_post_type() == 'video_posts')
    {
        if(is_single())
        {
            // Check if tmpl file exists in the theme.
            // If not, use the tmpl file from the plugin.
            If($theme_file = locate_template(array('single-video-post.php')))
            {
                $template_path = $theme_file;
            }
            else
            {
                $template_path = plugin_dir_path(__FILE__).'/single-video-post.php';
            }
        }
        else if(is_archive())
        {
            if($theme_file = locate_template(array('archive-video-posts.php')))
            {
                $template_path = $theme_file;
            }
            else
            {
                $template_path = plugin_dir_path(__FILE__).'/archive-video-posts.php';
            }
        }
    }

    return $template_path;
}

/*
 * Adds nice-video-list short code behavior
 */
function niceVideoPosts_list()
{
    global $niceVideoPosts_archive_posts_per_page;

    // query array to retrieve video listings
    $query_params = array( 'post_type' => 'video_posts',
                           'post_status' => 'publish',
                           'posts_per_page' => $niceVideoPosts_archive_posts_per_page
                        );

    // If available, Retrieve page query variable
    $page_num = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

    // If page number is higher than 1, add to query array
    if ( $page_num != 1 )
    {
        $query_params['paged'] = $page_num;
    }

    // Execute query
    $video_posts_query = new WP_Query;
    $video_posts_query->query( $query_params );

    // Check if any posts were returned by query
    if ( $video_posts_query->have_posts() )
    {
        // Display posts in table layout
        $output = '<table>';
        $output .= '<tr><th style="width: 350px"><strong>Title</strong></th>';
        $output .= '<th><strong>Video by</strong></th></tr>';

        // Cycle through all items retrieved
        while ( $video_posts_query->have_posts() )
        {
            $video_posts_query->the_post();

            $output .= '<tr><td><a href="' . post_permalink();
            $output .= '">';
            $output .= get_the_title( get_the_ID() ) . '</a></td>';
            $output .= '<td>';
            $output .= esc_html( get_post_meta( get_the_ID(), 'video_author', true ) );
            $output .= '</td></tr>';
        }

        $output .= '</table>';

        // // Display page navigation links
        // if ( $video_posts_query->max_num_pages > 1 )
        // {
        //     $output .= '<nav id="nav-below">';
        //     $output .= '<div class="nav-previous">';
        //     $output .= get_next_posts_link( '<span class="meta-nav">&larr;</span> Older ', $video_posts_query->max_num_pages );
        //     $output .= '</div>';
        //     $output .= '<div class="nav-next">';
        //     $output .= get_previous_posts_link( 'Newer <span class="meta-nav">&rarr;</span>', $video_posts_query->max_num_pages );
        //     $output .= '</div>';
        //     $output .= '</nav>';
        // }

        // Reset post data query
        wp_reset_query();
    }

    return $output;

}

/*
 * Create submenu item to manage posts' taxonomy
 */
function niceVideoPosts_add_video_type_item()
{
    global $submenu;

    $submenu['edit.php?post_type=video_posts'][501] =
        array(
            'Video Type',
            'manage_options' ,
            admin_url( '/edit-tags.php?taxonomy=video_posts_video_type&post_type=video_posts' )
        );
}

/*
 * Create custom columns for admin post list
 */
function niceVideoPosts_add_video_posts_columns($columns)
{
    $columns['video_post_author_name'] = 'Video by';
    //$columns['video_post_rating'] = 'Rating';
    $columns['video_posts_video_type'] = 'Type';

    //unset($columns['comments']);

    return $columns;
}

/*
 * Populate admin post list columns
 */
function niceVideoPosts_populate_columns($column)
{
    switch ($column)
    {
        case 'video_post_author_name':
            $column_data = esc_html(get_post_meta(get_the_ID(), 'video_author', true));
            echo $column_data;
            break;
        // case 'video_post_rating':
        //     $column_data = esc_html(get_post_meta(get_the_ID(), 'rating', true));
        //     echo $column_data.' stars';
        //     break;
        case 'video_posts_video_type':
            $data = wp_get_post_terms(get_the_ID(), 'video_posts_video_type');

            if($data)
            {
                $column_data = '';
                $delim = false;
                foreach($data as $v)
                {
                    if($delim)
                    {
                        $column_data .= ', ';
                    }

                    $column_data .= $v->name;
                    $delim = true;
                }
            }
            else
            {
                $column_data = 'Unassigned';
            }
            echo $column_data;
            break;
    }

}

/*
 * Make sortable columns
 */
function niceVideoPosts_sortable_columns($columns)
{
    $columns['video_post_author_name'] = 'video_post_author_name';
    //$columns['video_post_rating'] = 'video_post_rating';

    return $columns;
}

/*
 * Modify query for sortable admin columns
 */
function niceVideoPosts_column_ordering($vars)
{
    if (!is_admin())
    {
        return $vars;
    }

    if (isset($vars['orderby']) && 'video_posts_author' == $vars['orderby'])
    {
        $vars = array_merge(
            $vars,
            array(
                'meta_key' => 'video_posts_author',
                'orderby' => 'meta_value'
            )
        );
    }

    return $vars;
}

/*
 * Add admin post list taxonomy filtering
 */
function niceVideoPosts_video_type_filter_list()
{
    $screen = get_current_screen();
    global $wp_query;
    if ( $screen->post_type == 'video_posts' ) {
        wp_dropdown_categories( array(
            'show_option_all'   =>  'Show All Video Post Types',
            'taxonomy'          =>  'video_posts_video_type',
            'name'              =>  'video_posts_video_type',
            'orderby'           =>  'name',
            'selected'          =>  (isset($wp_query->query['video_posts_video_type']) ?
                                    $wp_query->query['video_posts_video_type'] : ''),
            'hierarchical'      =>  false,
            'depth'             =>  3,
            'show_count'        =>  false,
            'hide_empty'        =>  true,
        ) );
    }
}

/*
 * Modify query for post list taxonomy filtering
 */
function niceVideoPosts_perform_video_type_filtering($query)
{
    $qv = &$query->query_vars;

    if ( !empty( $qv['video_posts_video_type'] ) && is_numeric( $qv['video_posts_video_type'] ) ) {
            $term = get_term_by( 'id', $qv['video_posts_video_type'], 'video_posts_video_type' );
            $qv['video_posts_video_type'] = $term->slug;
    }
}

/*
 * Modify page title
 */
function niceVideoPosts_format_video_post_title($the_title)
{
    // Check to see if current post is our custom post type
    // and is a single post type
    if ( get_post_type() == 'video_posts' && is_single() ) {
        // Retrieve the author data from custom fields
        $video_author = esc_html( get_post_meta( get_the_ID(), 'video_author', true ) );

        // Append the author to the title string that was received
        $title = the_title()." by ".$video_author." | ";
    }

    return $title;
}

/*
 * Sets how many posts display on archive page.
 */
function niceVideoPosts_set_archive_post_per_page($query)
{
    global $niceVideoPosts_archive_posts_per_page;

    if($query->query_vars['post_type'] == 'video_posts')
    {
        $query->query_vars['posts_per_page'] = $niceVideoPosts_archive_posts_per_page;
    }

  return $query;
}

function niceVideoPosts_excerpt_length($length)
{
    global $niceVideoPosts_archive_list_excerpt_length_value;
    global $niceVideoPosts_archive_grid_excerpt_length_value;
    global $niceVideoPosts_archive_layout;

    if ($niceVideoPosts_archive_layout == "grid")
    {
        return $niceVideoPosts_archive_grid_excerpt_length_value;
    }
    else
    {
        return $niceVideoPosts_archive_list_excerpt_length_value;
    }

}

function niceVideoPosts_add_stylesheet() {
    // Respects SSL, Style.css is relative to the current file
    wp_register_style( 'niceVideoPosts-style', plugins_url('css/style.css', __FILE__) );
    wp_enqueue_style( 'niceVideoPosts-style' );
}

/*
 * Actions
 */
add_action('init', 'niceVideoPosts_create_video_post_type'); //create custom post type
add_action('admin_init', 'niceVideoPosts_admin_init'); //add admin meta box
add_action('save_post', 'niceVideoPosts_add_video_post_fields'); //store post to db
add_action('admin_menu', 'niceVideoPosts_add_video_type_item'); //create admin menu item for taxonomy type
add_action('manage_posts_custom_column', 'niceVideoPosts_populate_columns'); //add data to admin post list columns
add_action( 'restrict_manage_posts', 'niceVideoPosts_video_type_filter_list' ); //add filter function on post taxonomy for admin panel.
add_filter( 'parse_query', 'niceVideoPosts_perform_video_type_filtering' ); //register function to be called on posts query
add_action( 'pre_get_posts', 'niceVideoPosts_set_archive_post_per_page' ); //register function to set posts per page.
 add_action( 'wp_enqueue_scripts', 'niceVideoPosts_add_stylesheet' ); //Register function to add CSS stylesheet

/*
 * Shortcodes
 */
add_shortcode('nice-video-list', 'niceVideoPosts_list' ); //shortcode for archive list

/*
 * Filters
 */
add_filter('template_include', 'niceVideoPosts_template_include', 1); //Grab template for frontend display.
add_filter('manage_edit-video_posts_columns', 'niceVideoPosts_add_video_posts_columns'); //add columns to admin post list
add_filter('manage_edit-video_posts_sortable_columns', 'niceVideoPosts_sortable_columns'); //sort custom columns
add_filter('request', 'niceVideoPosts_column_ordering'); //register function to modify column ordering request
add_filter('wp_title', 'niceVideoPosts_format_video_post_title'); //register function to update page title
add_filter('widget_text', 'shortcode_unautop'); //Enable shortcode replacement in widget area
add_filter('widget_text', 'do_shortcode', 11); //Enable shortcode replacement in widget area
add_filter( 'excerpt_length', 'niceVideoPosts_excerpt_length', 999 ); //Register function to control length of excerpt

?>