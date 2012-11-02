<?php
//#################################################################
// Initial Values
  $data_ngs_default = array("showPanels"         => 1,
                            "panelWidth"       => 800,
                            "panelHeight"       => 400,
                            "panelScale"        => "crop",
                            "transitionSpeed"   => 1000,
                            "transitionInterval" => 5000,
                            "fadePanels"        => 1,
                            "showCaptions"      => 0,
                            "overlayPosition"   => "bottom",
                            "overlayOpacity"    => 0.7,
                            "showFilmstrip"     => 1,
                            "filmstripPosition" => "bottom",
                            "pointerSize"       => 8,
                            "frameWidth"        => 80,
                            "frameHeight"       => 40,
                            "frameScale"        => "crop", 
                            "frameGap"          => 5,
                            "frameOpacity"      => 0.4,
                            "easingValue"       => "swing",
                            "navTheme"          => "dark",
                            "pauseOnHover"      => 0,
                            "startFrame"        => 1);


  $data_ngs = get_option('dataNextGenGalleryView');
  
  define('BASE_URL'  , get_option('siteurl'));
  define('GALLERYVIEW_URL', get_option('siteurl').'/wp-content/plugins/' . dirname(plugin_basename(__FILE__))); // get_bloginfo('wpurl')

//#################################################################

function nggGalleryViewHeadAdmin() { ?>
  <!-- begin nextgen-js-galleryview admin scripts -->
    <style>    
      fieldset {
        border:1px solid #DFDFDF;
        background:#fff;
        -moz-border-radius-bottomleft:6px;
        -moz-border-radius-bottomright:6px;
        -moz-border-radius-topleft:6px;
        -moz-border-radius-topright:6px;      
      }
      
      legend {
        font-weight:bold;
        padding:0px 6px;
      }    
    </style> 
  <?php  
}


function ngg_galleryview_scripts() {

   	wp_enqueue_script('jquery');
   
    // jQuery Timers
    wp_register_script('jquery-timers', WP_PLUGIN_URL.'/wordpress-nextgen-galleryview/GalleryView/scripts/jquery.timers-1.2.js', 'jquery', null, false);
    wp_enqueue_script('jquery-timers');
    
    // jQuery Easing
    wp_register_script('jquery-easing', WP_PLUGIN_URL.'/wordpress-nextgen-galleryview/GalleryView/scripts/jquery.easing.1.3.js', 'jquery', null, false);
    wp_enqueue_script('jquery-easing');
    
    // jQuery GalleryView
    wp_register_script('jquery-gallerview', WP_PLUGIN_URL.'/wordpress-nextgen-galleryview/GalleryView/scripts/jquery.galleryview.js', array('jquery', 'jquery-timers', 'jquery-easing'), null, false);
    wp_enqueue_script('jquery-gallerview');

    }
  add_action('wp_enqueue_scripts', 'ngg_galleryview_scripts');
  
  
################################################################################
// Loading CSS
################################################################################
	function ngg_galleryview_styles()  { 
	
	// Our CSS
	wp_register_style( 'galleryview', WP_PLUGIN_URL.'/wordpress-nextgen-galleryview/GalleryView/css/galleryview.css', '', null );
	wp_enqueue_style( 'galleryview' );
	
	}
	
	add_action('wp_enqueue_scripts', 'ngg_galleryview_styles');
    


function nggGalleryViewAlign($align, $margin, $who="") {
    switch ($align) {
      case "left"       : $align = "margin:0px auto 0px 0px;";           break;
      case "right"      : $align = "margin:0px 0px 0px auto;";           break;
      case "center"     : $align = "margin:0px auto;";                   break;
      case "float_left" : $align = "float:left;  margin:".$margin."px;"; break;
      case "float_right": $align = "float:right; margin:".$margin."px;"; break;
    }
  
  return $align;
}











function nggGalleryViewShow($info, $pictures = null) {	
  global $wpdb, $data_ngs;  

  extract(shortcode_atts(array(
  	"id"                  => isset($data_ngs["id"]),
    "showpanels"          => $data_ngs["showPanels"],
    "panelwidth"          => $data_ngs["panelWidth"],
    "panelheight"         => $data_ngs["panelHeight"],
    "panelscale"          => $data_ngs["panelScale"],
    "transitionspeed"     => $data_ngs["transitionSpeed"],
    "transitioninterval"  => $data_ngs["transitionInterval"],
    "fadepanels"          => $data_ngs["fadePanels"],
    "showcaptions"        => $data_ngs["showCaptions"],
    "overlayposition"     => $data_ngs["overlayPosition"],
    "overlayopacity"      => $data_ngs["overlayOpacity"],
    "showfilmstrip"       => $data_ngs["showFilmstrip"],   
    "filmstripposition"   => $data_ngs["filmstripPosition"],
    "pointersize"         => $data_ngs["pointerSize"],
    "framewidth"          => $data_ngs["frameWidth"],
    "frameheight"         => $data_ngs["frameHeight"],
    "framescale"          => $data_ngs["frameScale"],
    "framegap"            => $data_ngs["frameGap"],
    "frameopacity"        => $data_ngs["frameOpacity"],
    "easingvalue"         => $data_ngs["easingValue"],
    "navtheme"            => $data_ngs["navTheme"],
    "pauseonhover"        => $data_ngs["pauseOnHover"],
    "startframe"          => $data_ngs["startFrame"]
  	), $info));
  	if (class_exists('nggLoader')) {
      $galleryID = $wpdb->get_var("SELECT gid FROM $wpdb->nggallery WHERE gid  = '".esc_attr($id)."' ");
    }
    
  // Get the pictures
  if ($galleryID) {
    $ngg_options = get_option('ngg_options');  
    $pictures    = $wpdb->get_results("SELECT t.*, tt.* FROM $wpdb->nggallery AS t INNER JOIN $wpdb->nggpictures AS tt ON t.gid = tt.galleryid WHERE t.gid = '$galleryID' AND tt.exclude != 1 ORDER BY tt.$ngg_options[galSort] $ngg_options[galSortDir] ");
               
    $final = array();    
    foreach($pictures as $picture) {
      $aux = array();
      $aux["title"] = $picture->alttext; // $picture->alttext;
      $aux["desc"]  = $picture->description;
      $aux["link"]  = BASE_URL . "/" . $picture->path ."/" . $picture->filename;
      $aux["img"]   = BASE_URL . "/" . $picture->path ."/" . $picture->filename;
      $aux["thumb"] = BASE_URL . "/" . $picture->path ."/thumbs/thumbs_" . $picture->filename;
      
      $final[] = $aux;
    }
    
    $pictures = $final;
    
  } else {
    $galleryID = rand();
  }
  
  if (empty($pictures)) return "";
  
  $out = '<ul id="myGallery_'.$galleryID.'" class="galleryview">';
    
  // Error with only one element
  foreach ($pictures as $picture)
    if ($picture["img"]) {
      $out .= "<li>";
      $out .= "<img src=\"" . $picture["img"]   . "\" alt=\"".  $picture["title"] . "\" class=\"full\" />";
      if ($showcaptions) {
        $out .= "  <span class=\"panel-overlay\"> " . "<h2>" . $picture["title"] . "</h2>". "<p>". $picture["desc"] . "</p>". "</span>";
      }
      $out .= "</li>";    
    }

  $out .= ' </ul>';
  
  // Gather pictures and GalleryView Gallery
  $out .= '<script type="text/javascript">
            jQuery(document).ready(function($) {
            $(\'#myGallery_'.$galleryID.'\').galleryView({ '; // Leave a blank space in case there is no last comma to be removed later
              
  $out .= " show_panels: " . ($showpanels?'true':'false') . ",";
  $out .= " show_captions: " . ($showcaptions?'true':'false') . ",";
  $out .= " show_filmstrip: " . ($showfilmstrip?'true':'false') . ",";
  
  if ($showpanels) {
    $out .= " panel_width: $panelwidth,";
    $out .= " panel_height: $panelheight,";
    $out .= " panel_scale: \"$panelscale\",";
    $out .= " transition_speed: $transitionspeed,";
    $out .= " transition_interval: $transitioninterval,";
    $out .= " fade_panels: " . ($fadepanels?'true':'false') . ",";
  }
  if ($showcaptions) {
    $out .= " overlay_position: \"$overlayposition\",";
    $out .= " overlay_opacity: $overlayopacity,";
  }
  if ($showfilmstrip) {
    $out .= " frame_width: $framewidth,";
    $out .= " frame_height: $frameheight,";
    $out .= " filmstrip_position: \"$filmstripposition\",";
    $out .= " pointer_size: $pointersize,";
    $out .= " frame_scale: \"$framescale\",";
    $out .= " frame_gap: $framegap,";
    $out .= " frame_opacity: $frameopacity,";
    $out .= " easing: \"$easingvalue\",";
  }
  $out .= " nav_theme: \"$navtheme\",";
  $out .= " start_frame: $startframe,";
  $out .= " pause_on_hover: " . ($pauseonhover?'true':'false') . ",";
  
  
  $out = substr($out, 0, -1); // Remove last comma
  $out .= '   });});';
  $out .= '</script>';
  //$out .= '<!--' . print_r($info) . '-->';
  return $out;  
}








