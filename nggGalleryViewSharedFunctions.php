<?php
//#################################################################
// Initial Values
  $data_ngs_default = array("showPanels"         => 1,
                            "panelWidth"       => 600,
                            "panelHeight"       => 400,
                            "panelScale"        => "nocrop",
                            "transitionSpeed"   => 800,
                            "transitionInterval" => 4000,
                            "fadePanels"        => 1,
                            "showCaptions"      => 0,
                            "overlayPosition"   => "bottom",
                            "overlayOpacity"    => 0.7,
                            "showFilmstrip"     => 1,
                            "filmstripPosition" => "bottom",
                            "pointerSize"       => 8,
                            "frameWidth"        => 60,
                            "frameHeight"       => 40,
                            "frameScale"        => "crop", 
                            "frameGap"          => 5,
                            "frameOpacity"      => 0.3,
                            "easingValue"       => "swing",
                            "navTheme"          => "dark",
                            "pauseOnHover"      => 0,
                            "startFrame"        => 1);

  add_option('dataNextGenGalleryView', $data_ngs_default, 'Data from NextGen GalleryView');
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
  <!-- end nextgen-js-galleryview admin scripts -->    
  <?php  
  nggGalleryViewHead();
}

function nggGalleryViewHead() {
  wp_enqueue_script('jquery');
  wp_enqueue_script('jquery-ui-core');
  echo '<!-- begin nextgen-js-galleryview scripts -->
          <script type="text/javascript"  src="'.GALLERYVIEW_URL.'/GalleryView/scripts/jquery.timers-1.1.2.js"></script>
          <script type="text/javascript"  src="'.GALLERYVIEW_URL.'/GalleryView/scripts/jquery.easing.1.3.js"></script>
          <script type="text/javascript"  src="'.GALLERYVIEW_URL.'/GalleryView/scripts/jquery.galleryview-2.0.js"></script>
          <link   type="text/css"        href="'.GALLERYVIEW_URL.'/GalleryView/css/galleryview.css" rel="stylesheet" media="screen" />
        <!-- end nextgen-js-galleryview scripts -->
       ';
}

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
  
  $info = array_merge( $data_ngs, $info );
  
  extract($info);

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
  
  $out = '<ul id="myGallery_'.$galleryID.'" class="gallery">';
    
  // Error with only one element
  foreach ($pictures as $picture)
    if ($picture["img"]) {
      $out .= "<li>";
      $out .= "<img src=\"" . $picture["img"]   . "\" alt=\"".  $picture["title"] . "\" class=\"full\" />";
      if ($showCaptions) {
        $out .= "  <span class=\"panel-overlay\"> " . "<h2>" . $picture["title"] . "</h2>". "<p>". $picture["desc"] . "</p>". "</span>";
      }
      $out .= "</li>";    
    }

  $out .= ' </ul>';
  
  // Gather pictures and GalleryView Gallery
  $out .= '<script type="text/javascript">
            jQuery(document).ready(function($) {
            $(\'#myGallery_'.$galleryID.'\').galleryView({ '; // Leave a blank space in case there is no last comma to be removed later
              
  $out .= " show_panels: " . ($showPanels?'true':'false') . ",";
  $out .= " show_captions: " . ($showCaptions?'true':'false') . ",";
  $out .= " show_filmstrip: " . ($showFilmstrip?'true':'false') . ",";
  
  if ($showPanels) {
    $out .= " panel_width: $panelWidth,";
    $out .= " panel_height: $panelHeight,";
    $out .= " panel_scale: \"$panelScale\",";
    $out .= " transition_speed: $transitionSpeed,";
    $out .= " transition_interval: $transitionInterval,";
    $out .= " fade_panels: " . ($fadePanels?'true':'false') . ",";
  }
  if ($showCaptions) {
    $out .= " overlay_position: \"$overlayPosition\",";
    $out .= " overlay_opacity: $overlayOpacity,";
  }
  if ($showFilmstrip) {
    $out .= " frame_width: $frameWidth,";
    $out .= " frame_height: $frameHeight,";
    $out .= " filmstrip_position: \"$filmstripPosition\",";
    $out .= " pointer_size: $pointerSize,";
    $out .= " frame_scale: \"$frameScale\",";
    $out .= " frame_gap: $frameGap,";
    $out .= " frame_opacity: $frameOpacity,";
    $out .= " easing: \"$easingValue\",";
  }
  $out .= " nav_theme: \"$navTheme\",";
  $out .= " start_frame: $startFrame,";
  $out .= " pause_on_hover: " . ($pauseOnHover?'true':'false') . ",";
  
  
  $out = substr($out, 0, -1); // Remove last comma
  $out .= '   });});';
  $out .= '</script>';
  //$out .= '<!--' . print_r($info) . '-->';
  return $out;  
}

?>