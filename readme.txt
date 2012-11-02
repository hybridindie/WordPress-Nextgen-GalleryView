=== Plugin Name ===
Tags: nextgen, smoothgallery, galleryview, picture, photo, photos, widgets, pictures, photo-albums, post, admin, media, gallery, images, slideshow
Requires at Least
Tested up to: 3.0.3
Stable tag: 0.5.2

jQuery JavaScript Gallery plugin extending NextGen Gallery's slideshow abilities without breakage. Uses GalleryView - jQuery Content Gallery Plugin by [Jack Anderson](http://www.spaceforaname.com/galleryview/).

== Description ==

**Nextgen GalleryView**: A Wordpress Plugin that allows you to use the jQuery GalleryView Plugin with your **NextGen-Gallery** galleries.

In order to use the GalleryView Plugin you kinda need to be using [NextGen Gallery](http://wordpress.org/extend/plugins/nextgen-gallery/).

You can see it live on my woodworking portfolio [John Brien Modern Woodworks](http://jbmodernwoodworks.com/).
You can read about it on my blog of rants [John Brien](http://blog.hybridindie.com/)

== Installation == 

First have [NextGen Gallery](http://wordpress.org/extend/plugins/nextgen-gallery/) installed and working
Install [WordPress-Nextgen-GalleryView](http://wordpress.org/extend/plugins/wordpress-nextgen-galleryview)
Set the Defaults under the GalleryView Menu

Please be aware that if you are upgrading, your shortcodes from the previous versions will not work. Theme developers using the raw code in their themes you will have to do an update as well. I do apologize for this but there were issues with the syntax causing problems and I have more plans for this plugin moving forward. This is for the best, you won't be disappointed moving forward I promise.

== Screenshots ==

1. Screenshot Default Options
2. Screenshot Panel Options
3. Screenshot Caption Options
4. Screenshot Filmstrip Options
5. Screenshot Output Generator
6. Screenshot Preview Selector

== Change Log ==

  Version 0.5.2
    
    * Bug fix with custom gallery params getting ignored due to case structure

  Version 0.5.1
    
    * Bug fixed for them developers 
    * Update code generator to document proper theme integrations (do_shortcode should be echo do_shortcode)
    
  Version 0.5
  
    * Changed the Shortcode code to be inline with other WordPress Shortcode
    * Fixed issues with things not being output as expected [thx André Grobbee]
    * Major refactor; around 100 LOC removed
    * Prep for next steps in the plugin's future
    
  Version 0.4.2
  
    * Fixes for hover
    * Fixes for Styling Conflicts is WordPress 3.0
    
  Version 0.4.1
  
    * Typo fixes
    
  Version 0.4
  
    * More Code Cleanup and the other release stuff
    
  Version 0.3
  
    * Misc bug fixes
    * Code Cleanup
    * Prep for public release

  Version 0.2
  
    * One off Galleries configured through the short code

  Version 0.1
  
    * First release
