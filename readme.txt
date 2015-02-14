=== Plugin Name ===
Contributors: ovann86
Donate link: http://www.itsupportguides.com/
Tags: comments, disqus, latest, shortcode
Requires at least: 4.0
Tested up to: 4.1
Stable tag: 1.2
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

List your websites latest Disqus comments in a page, post or widget

== Description ==

This plugin will allow you to list your websites latest Disqus comments in a page, post or widget.

Simply install and activate the plugin, browse to 'Comments' -> 'Disqus Latest Comments' menu, add in your Disqus shortname, then include the [disqus-latest] shortcode in the page, post or widget of your choosing.

You can see a working example of the plugin at [www.itsupportguides.com](http://www.itsupportguides.com/latest-comments/ "www.itsupportguides.com latest comments").

== Installation ==

1. Install plugin from WordPress administration or upload folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in the WordPress administration
1. In the WordPress administration, browse to 'Comments' -> 'Disqus Latest Comments'
1. Enter your Disqus shortname and any other settings as desired and save the changes
1. Open or create the post or page you want the comments to be included in
1. Enter the shortcode [disqus-latest] into the content area and save the changes
1. The comments will now be displayed on the post of page where the shortcode has been used

== Frequently Asked Questions ==

= How does this work? =

This plugin uses the Disqus API to retieve the latest comments for the given Disqus account.

= What are the settings =

On the 'Comments' -> 'Disqus Latest Comments' page you will find several settings.

'Disqus Shortname' - This is where you need to add the shortname for the websites Disqus account.

'Number of comments' - This controls how many latest comments are displayed.

'Hide avatars' - This disables the avatars (images) displayed with each comment.

'Avatar size' - This controls the size of the avatar (image) displayed with each comment.

'Except length'- This controls the length of the comment displayed on the page.

'Style' - This allows you to select three different styles for the comments - grey, green and blue. You may also choose none.

'Bypass Cache' - This option can be used if a website is caching the page or post the comments are being displayed on, or the website is caching the Disqus API request. 

= What are the default values =

'Disqus Shortname' is required - there is no default. A warning message will be displayed instead of the comments scren if you do not specify a shortname.

'Number of comments' - 5

'Hide avatars' - Off - avatars will be displayed

'Avatar size' - 35 pixels

'Except length' - 200 characters 

'Style' - None

'Bypass Cache' - No

== Screenshots ==

1. This screenshot shows the comments that are displayed on the front end with the 'Grey' style applied.
2. This screenshot shows the options for configuring the plugin.

== Changelog ==

= 1.2 =
* Fix: Resolved issue with using shortcode in widget areas - where comments would appear before the widget title.
* Maintenance: Tidy plugin code.

= 1.1 =
* Feature: Added 'Bypass Cache' option in case website caches Disqus API requests.
* Fix: Resolved issue with Avatar Size and Excerpt Length not working.
* Fix: Changed Avatar Size to use only the three supported Disqus avatar sizes - 35px, 34px and 92px.

= 1.0 =
* First public release.