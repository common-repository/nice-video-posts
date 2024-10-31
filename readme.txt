=== Nice Video Posts ===
Contributors: mjetpax
Donate link: http://trinitronic.com/wordpress/wordpress-nice-video-posts
Tags: video, videos, youtube video player, youtube video posts, youtube, video gallery, youtube gallery, custom post type, wordpress videos, video posts, video post type, youtube post type
Requires at least: 3.0
Tested up to: 3.5.2
Stable tag: trunk

Nice Video Posts provides you with an easy way to create custom YouTube video posts. Nice Video Posts has two layout options for your post archives. Choose either list layout or grid view to create a video gallery.

== Description ==

Nice Video Posts requires either the [Nice YouTube plugin](http://trinitronic.com/wordpress/wordpress-nice-youtube "Nice YouTube plugin") or [Nice YouTube Lite plugin](http://trinitronic.com/wordpress/wordpress-nice-youtube-lite "Nice YouTube Lite plugin") to operate properly.

With the Nice Video Posts plugin you get a convenient & flexible way to add video custom post types to your WordPress site!

Create categorized video post listings and archives in seconds. Once installed it's as easy to post and organize your videos as publishing standard WordPress posts. Get full control over the post content and the way it displays. Plus, set the plugin to grid view and create unique video galleries. Don't wait, get Nice Video Posts today!

Some cool features that you get:

* Instantly create video posts.
* Categorize your video posts using the Video Type settings.
* Create child Video Types.
* Easily add your video listings to any WordPress menu.
* Choose between list view or grid view for your video post archives.
* Set a default width for all videos.
* Choose to show or not to show the video post archive header title.
* Automatically includes video post archive page pagination.
* Set a default number of video posts to display per archive page.
* Set the default thumbnail size for your video posts archive pages.
* Optionally set a default description excerpt length for video post listings.
* Enable or disable the Video Post title display on archive pages.
* Includes a bonus shortcode for convenient video post listings within other content.

== Installation ==

*Important*
Nice Video Posts requires that the [Nice YouTube plugin](http://trinitronic.com/wordpress/wordpress-nice-youtube "Nice YouTube plugin") or [Nice YouTube Lite plugin](http://trinitronic.com/wordpress/wordpress-nice-youtube-lite "Nice YouTube Lite plugin") is installed in order to operate correctly. Please download and install one of those plugins before proceeding.

1. First install the [Nice YouTube plugin](http://trinitronic.com/wordpress/wordpress-nice-youtube "Nice YouTube plugin") or [Nice YouTube Lite plugin](http://trinitronic.com/wordpress/wordpress-nice-youtube-lite "Nice YouTube Lite plugin")
1. Log in and navigate to WP-Admin>>Plugins
1. Click the "Add New" button next to the Plugins title.
1. Click the "Upload" link on the Install Plugin page.
1. Click the "Choose File" button.
1. Locate and select the Nice Video Posts .zip file on your local computer
1. Click the Ok button on the pop-up window.
1. Click the install button on the Install Plugin page.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. That's it! You're all ready to start showing off your videos!!

Alternative installation

1. First install the [Nice YouTube plugin](http://trinitronic.com/wordpress/wordpress-nice-youtube "Nice YouTube plugin") or [Nice YouTube Lite plugin](http://trinitronic.com/wordpress/wordpress-nice-youtube-lite "Nice YouTube Lite plugin")
1. Unzip the Nice Video Posts plugin download file
1. Upload the entire niceVideoPosts folder to your wp-content/plugins/ directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. That's it! You're all ready to start posting your videos!!

== Changelog ==

= 1.0 =
* First release of the plugin

== Upgrade Notice ==

== Screenshots ==

== Documentation ==

*Using Nice Video Posts*

Usage is simple. It is very similar to creating regular WordPress posts.

**Creating a Nice Video Post**

1. In the wp-admin, click on the Video Posts menu item
1. Click into the sub-menu item labeled "Video Types"
1. Create a new default Video Type (video types are like categories).
1. Now click on Video Posts in the main admin side bar menu.
1. Click "Add New" to create a new video post and open the Nice Video Post editor.
1. Enter a title for your video post and optionally a description.
1. Enter the your video's YouTube video id in the Video Id field. You can find the video idea in the YouTube URL just after the "v=" and before the next & symbol. Example: http://www.youtube.com/watch?v=UXtjrb0WBhc&feature=c4-overview&list=UUBZ78mpRCvVKkAtsGPP8Z5w Note, in our example UXtjrb0WBhc is the YouTube video id.
1. Optionally enter the video author's name in the Video By field.
1. Assign a video type to your video post.
1. Save your changes. You've just created your first video post!

**Setting Front-end Navigation**

1. Go to Appearance>>Menu and create a new menu item that points to your Video Type. All new video posts assigned to this Video Type will now be listed at this menu link location.
1. Go to the front-end of the site, click your new video type menu link and check out your new video post!
1. That's pretty much all there is to it! So, get out there and start posting your videos!

*Configuring Nice Video Posts*
Nice Video Post comes with a number of options that provide flexibility and easy costomization. To customize the plugin's configuration do the following.

1. Go to wp-admin>>Plugins>>Editor
1. On the right hand upper portion of the Editor page you will see a drop down menu. Choose Nice Video Posts and click the Select button.
1. niceVideoPosts.php will appear in the Editor window.
1. Scroll down a bit and find the configuration settings of for the script. Alter the settings to match your project's requirements. The setting section will look similar to the following.

`/* Settings Notes:
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
$niceVideoPosts_archive_grid_show_post_title        = true; // Show post title for grid view, enter true or false.`

Make sure to dsave your changes when you are finished. This may require that you make the script writeable.

**Configuration Setting Details**

***$niceVideoPosts_post_video_width***
Set the width in pixels of the video that appear on post pages.

***$niceVideoPosts_archive_show_header***
Enable or disable the display of the archive page header information. Valid entries are true or false.

***$$niceVideoPosts_archive_show_header_title***
Set the archive page header title text.

***$$niceVideoPosts_archive_posts_per_page***
Set the amount of video posts to be displayed on an archive page.

***$niceVideoPosts_archive_thumbnail_width***
Set the width in pixels of the video thumbnail that appear on archive pages.

***$niceVideoPosts_archive_layout***
Enter which archive layout you want to use. Your options are list or grid view.


***$niceVideoPosts_archive_list_excerpt_length_value***
Set the number of allowed characters per post description excerpt on the archive page, when using the list layout.

***$niceVideoPosts_archive_grid_excerpt_length_value***
Set the number of allowed characters per post description excerpt on the archive page, when using the grid layout.

***$niceVideoPosts_archive_grid_show_post_title***
Enable or disable the display of the post title on the archaive page, when using grid view. Valid inputs are true or false.

**IMPORTANT**

In addition to the Nice Video Posts' settings above, all global settings for the Nice YouTube plugin or Nice YouTube Lite plugin will be applied. With this combination, you can more fully customize your visitor's video viewing experience. So, don't forget to adjust the Nice YouTube plugin settings as well.

*Nice Video Posts Shortcode*

Nice Video Posts additionally offers a very basic shortcode. This shortcode can be used to display the very latest video posts within other content, such as other posts or pages. Usage is very basic. simply enter the shortcode below.

`[nice-video-list]`

