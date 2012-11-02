<?php
/*
Plugin Name: WordPress NextGen GalleryView
Plugin URI: https://github.com/jbrien/WordPress-Nextgen-GalleryView
Description: jQuery JavaScript Gallery plugin extending NextGen Gallery's slideshow abilities without breakage. Uses GalleryView - jQuery Content Gallery Plugin by Jack Anderson (http://www.spaceforaname.com/galleryview/).
Author: John Brien, Brandon Hubbard
Author URI: https://github.com/jbrien
Version: 0.9                         
*/ 

//#################################################################
// Restrictions
  if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }

include "nggGalleryViewSharedFunctions.php";
  
class GalleryView {
  
  function admin_menu() {  
    add_menu_page('GalleryView Defaults', 'GalleryView', 'read', plugin_basename( dirname(__FILE__)), array($this, 'general_page')); // add_options_page
    add_submenu_page( plugin_basename( dirname(__FILE__)), 'GalleryView Defaults', 'GalleryView Defaults', 'read', plugin_basename( dirname(__FILE__)), array($this, 'general_page'));
    add_submenu_page( plugin_basename( dirname(__FILE__)), 'Option Generator', 'Options Generator', 'read', 'specific_galleryview', array($this, 'specific_page'));
  } 
  
  
  function save_request() {
    global $data_ngs, $_REQUEST;
    
    $data_ngs['showPanels'] = (bool)   $_REQUEST['showPanels'];
    // panel_width	integer (pixels)	400	Width of panel
    $data_ngs['panelWidth'] = (int)    $_REQUEST['panelWidth'];
    // panel_height	integer (pixels)	300	Height of panel
    $data_ngs['panelHeight'] = (int)    $_REQUEST['panelHeight'];
    $data_ngs['panelScale'] = (string)    $_REQUEST['panelScale'];
    
    // transition_speed	jQuery time value (200,’slow’,etc)	400	Duration of transition animation
    $data_ngs['transitionSpeed'] = (int)   $_REQUEST['transitionSpeed'];
    // transition_interval	jQuery time value (200,’slow’,etc)	6000	Length of time between transitions (0 = no automatic transitions)
    $data_ngs['transitionInterval'] = (int)   $_REQUEST['transitionInterval'];
    // fade_panels	boolean	true	Determines whether panels fade during transitions or switch instantly.
    $data_ngs['fadePanels'] = (bool)   $_REQUEST['fadePanels'];
    
    // show_captions	boolean	false	Determines whether or not frame captions are displayed
    $data_ngs['showCaptions'] = (bool)   $_REQUEST['showCaptions'];
    // overlay_position	‘top’ | ‘bottom’	‘bottom’	Position of overlay within panel
    $data_ngs['overlayPosition'] = (string)    $_REQUEST['overlayPosition'];
    // overlay_opacity	float 0.0 – 1.0	0.6	Opacity of panel overlay background
    $data_ngs['overlayOpacity'] = (float)   $_REQUEST['overlayOpacity'];
    
    $data_ngs['showFilmstrip'] = (bool)   $_REQUEST['showFilmstrip'];
    // filmstrip_position	‘top’ | ‘bottom’	‘bottom’	Position of filmstrip within gallery
    $data_ngs['filmstripPosition'] = (string)    $_REQUEST['filmstripPosition'];
    $data_ngs['pointerSize'] = (int)   $_REQUEST['pointerSize'];
    // frame_width	integer (pixels)	80	Width of filmstrip frame
    $data_ngs['frameWidth'] = (int)    $_REQUEST['frameWidth'];
    // frame_height	integer (pixels)	80	Height of filmstrip frame
    $data_ngs['frameHeight'] = (int)    $_REQUEST['frameHeight'];
    $data_ngs['frameScale'] = (string)    $_REQUEST['frameScale'];
    $data_ngs['frameGap'] = (int)   $_REQUEST['frameGap'];
    // overlay_opacity	float 0.0 – 1.0	0.6	Opacity of panel overlay background
    $data_ngs['frameOpacity'] = (float)   $_REQUEST['frameOpacity'];
    
    // easing	jQuery easing value (’linear’,’swing’,etc)	’swing’	Controls animation of filmstrip and pointer
    $data_ngs['easingValue'] = (string)    $_REQUEST['easingValue'];
    // nav_theme	(’light’ | ‘dark’)	‘light’	Color of navigation buttons and frame pointer
    $data_ngs['navTheme'] = (string)    $_REQUEST['navTheme'];
    // pause_on_hover	boolean	false	If true, animations will pause when the mouse hovers over the panel (requires 500ms hover to pause)    
    $data_ngs['pauseOnHover'] = (bool)   $_REQUEST['pauseOnHover'];
    $data_ngs['startFrame'] = (int)   $_REQUEST['startFrame'];  
  }
  
  function specific_page() {
  	global $data_ngs, $wpdb;

    if (isset($_REQUEST["enviar"]))
      $this->save_request();
  
    $code  = "[galleryview id=yyy";
    $code .= " showPanels=" . ($data_ngs['showPanels']    ?'true':'false');
    $code .= " showCaptions=" . ($data_ngs['showCaptions'] ?'true':'false');
    $code .= " showFilmstrip=" . ($data_ngs['showFilmstrip'] ?'true':'false');

    if ($data_ngs['showPanels'] ) {
      $code .= " panelWidth=" . $data_ngs['panelWidth'];
      $code .= " panelHeight=" . $data_ngs['panelHeight'];
      $code .= " panelScale=" . $data_ngs['panelScale'];
      $code .= " transitionSpeed=" . $data_ngs['transitionSpeed'];
      $code .= " transitionInterval=" . $data_ngs['transitionInterval'];
      $code .= " fadePanels=" . ($data_ngs['fadePanels'] ?'true':'false');
    }
    if ($data_ngs['showCaptions']) {
      $code .= " overlayPosition=" . $data_ngs['overlayPosition'];
      $code .= " overlayOpacity=" . $data_ngs['overlayOpacity'];
    }
    if ($data_ngs['showFilmstrip']) {
      $code .= " frameWidth=" . $data_ngs['frameWidth'];
      $code .= " frameHeight=" . $data_ngs['frameHeight'];
      $code .= " filmstripPosition=" . $data_ngs['filmstripPosition'];
      $code .= " pointerSize=" . $data_ngs['pointerSize'];
      $code .= " frameScale=" . $data_ngs['frameScale'];
      $code .= " frameGap=" . $data_ngs['frameGap'];
      $code .= " frameOpacity=" . $data_ngs['frameOpacity'];
      $code .= " easingValue=" . $data_ngs['easingValue'];
    }
    $code .= " navTheme=" . $data_ngs['navTheme'];
    $code .= " startFrame=" . $data_ngs['startFrame'];
    $code .= " pauseOnHover=" . ($data_ngs['pauseOnHover'] ?'true':'false');
            
    $code .= "]";
      
    $code_2 = "<?php \n  echo  do_shortcode(\"" . $code . "\"); \n?>";
      
    ?>
  	<div class="wrap">
      <h2>NextGen GalleryView</h2>

      <form method="post">      
        <div>   
          <fieldset class="options" style="padding:20px; margin-top:20px;">
            <legend> Specific Options </legend>
              
              Allows a gallery to have a behavior other that the General one. 
              <br/><br/>

              <?php $this->show_admin_layouts(); ?>

              <div class="submit"> 
                <input type="submit" name="enviar" value="Generate Code">
              </div>

            <hr style="width:90%; border:1px solid #DFDFDF;">
            
            <br/>You have two options:
            
            <br><br><b>1. Write on your post</b> (You must replace 'yyy' with your Gallery Id)<br>
            
            <textarea style="width:700px; height:130px;"><?php echo $code; ?></textarea>

            <br><br><b>2. Write on any php page</b> (You must replace 'yyy' with your Gallery Id)<br>
            
            <textarea style="width:700px; height:130px;"><?php echo $code_2; ?></textarea>
            
            <hr style="width:90%; border:1px solid #DFDFDF;">
            
            <br/>If you remove, for example, "width=300, " the General option will be used on that item.
          </fieldset>
        </div>  
        
        <?php $this->example_show($code); ?>
      </form>
    </div>
  <?php }
  
  function general_page() {
  	global $data_ngs, $data_ngs_default, $wpdb;

    $msg = "";
        
    if (isset($_REQUEST["enviar"]) == "Back to Default") {
      $data_ngs = $data_ngs_default;
      update_option('dataNextGenGalleryView', $data_ngs);
      $msg = "Data saved successfully.";
    } elseif (isset($_REQUEST["enviar"])) {
      $this->save_request();
      
      update_option('dataNextGenGalleryView', $data_ngs);
      $msg = "Data saved successfully.";
    }
  	
  	if ($msg != '') echo '<div id="message"class="updated fade"><p>' . $msg . '</p></div>';
    
    $code = "[galleryview id=yyy]";    
    ?>    
  	<div class="wrap">
      <h2>NextGen GalleryView</h2>    
      <form method="post">      
        <div>   
          <fieldset class="options" style="padding:20px; margin-top:20px;">
            <legend> Default Options </legend>      
              <?php $this->show_admin_layouts(); ?>      

              <div class="submit" style="clear:both;"> 
                <input type="submit" name="enviar" value="Save">
                <input type="submit" name="enviar" value="Back to Default">
              </div>
              
            <hr style="width:90%; border:1px solid #DFDFDF;">
            <br><br><b>Write on your post</b> (You must replace 'yyy' with your Gallery Id)<br>

            <textarea style="width:700px; height:60px;"><?php echo $code; ?></textarea>            
          </fieldset>
        </div>  
        
        <?php $this->example_show($code); ?>
      </form>
    </div>
  	<?php
  }  
  
  function example_show($code) {
    global $_REQUEST, $data_ngs, $wpdb; 
    
    $gal_id = isset($_REQUEST['gal_id']); 

    $gallerylist = $wpdb->get_results("SELECT * FROM $wpdb->nggallery ORDER BY gid ASC");

    $select = "";
    if(is_array($gallerylist))
      foreach($gallerylist as $gallery) {
        $selected = ($gallery->gid == $gal_id )?	' selected="selected"' : "";
        $select .= '<option value="'.$gallery->gid.'"'.$selected.' >('.$gallery->gid.') '.$gallery->title.'</option>'."\n";
      }
      
    if ($gal_id)
      $real_deal = do_shortcode( str_replace("yyy", $gal_id, $code) );
    ?>     
    <div>
      <fieldset class="options" style="padding:20px; margin-top:20px; margin-bottom:20px;">
        <legend> Example </legend>
        
        This is how your gallery will look like with the options above (after you <b>save</b> them). <br/><br/>

        <div class="submit">           
          <div class="alignleft actions">
            <select id="gal_id" name="gal_id" style="width:250px;">;
              <option value="0"> Choose a gallery </option>
              <?php echo $select; ?>
            </select>
            <input type="submit" id="enviar" name="enviar" value="Select" class="button-secondary" />
          </div>            
        </div>
        <br/>
        <div class="slides">
          <?php
          
          if (!empty($real_deal)) {
    echo $real_deal;
}           ?>
        </div>
      </fieldset>
    </div>
  <?php } 
  
  function show_admin_layouts() { 
    global $data_ngs; ?>
          <div style="clear:both; padding-top:10px;">
            <div style="width:120px; float:left;"> Show Panel </div>
            <div style="width:120px; float:left;"> <input type="checkbox" id="showPanels" name="showPanels" <?php echo ($data_ngs['showPanels']? "checked=\"checked\"": "") ?> onClick="if(this.checked){document.getElementById('panel_options').style.display='';} else{document.getElementById('panel_options').style.display='none';};" > </div>
          </div>

          <fieldset id="panel_options" class="options" style="padding:20px; margin-top:0px; display:<?php echo ($data_ngs['showPanels']?'':'none')?>;">
            <legend> Panel Options </legend>

              <div style="">
                <div style="width:120px; float:left;"> Panel Width </div>
                <div style="width:120px; float:left;"> <input type="text" name="panelWidth" value="<?php echo $data_ngs['panelWidth']?>" style="width:60px;">px </div>
              </div>

              <div style="clear:left; padding-top:10px;">
                <div style="width:120px; float:left;"> Panel Height </div>
                <div style="width:120px; float:left;"> <input type="text" name="panelHeight" value="<?php echo $data_ngs['panelHeight']?>" style="width:60px;">px </div>
              </div>

              <div style="clear:both; padding-top:10px;">
                <div style="width:120px; float:left;"> Panel Scaling </div>
                <div style="width:120px; float:left;"> 
                  <select name="panelScale">
                    <option value="crop" <?php echo ($data_ngs['panelScale'] == "crop"                ? "selected":"") ?>> Crop to Fill       </option>
                    <option value="nocrop" <?php echo ($data_ngs['panelScale'] == "nocrop"           ? "selected":"") ?>> No Cropping    </option>
                  </select>
                </div>
              </div>

              <div style="clear:left; padding-top:10px;">
                <div style="width:120px; float:left;"> Transition Speed (in milliseconds) </div>
                <div style="width:120px; float:left;"> <input type="text" name="transitionSpeed" value="<?php echo $data_ngs['transitionSpeed']?>" style="width:60px;"></div>
              </div>

              <div style="clear:left; padding-top:10px;">
                <div style="width:120px; float:left;"> Transition Interval (in milliseconds, set to 0 for manual transitions) </div>
                <div style="width:120px; float:left;"> <input type="text" name="transitionInterval" value="<?php echo $data_ngs['transitionInterval']?>" style="width:60px;"></div>
              </div>
              
              <div style="clear:both; padding-top:10px;">
                <div style="width:120px; float:left;"> Fade Panels </div>
                <div style="width:120px; float:left;"> <input type="checkbox" id="fadePanels" name="fadePanels" <?php echo ($data_ngs['fadePanels']? "checked=\"checked\"": "") ?> > </div>
              </div>

          </fieldset>

          <div style="clear:both; padding-top:10px;">
            <div style="width:120px; float:left;"> Show Captions </div>
            <div style="width:120px; float:left;"> <input type="checkbox" id="showCaptions" name="showCaptions" <?php echo ($data_ngs['showCaptions']? "checked=\"checked\"": "") ?> onClick="if(this.checked){document.getElementById('caption_options').style.display='';} else{document.getElementById('caption_options').style.display='none';};" > </div>
          </div>

          <fieldset id="caption_options" class="options" style="padding:20px; margin-top:0px; display:<?php echo ($data_ngs['showCaptions']?'':'none')?>;">
            <legend> Caption Options </legend>

            <div style="clear:both; padding-top:10px;">
              <div style="width:120px; float:left;"> Caption Overlay Position </div>
              <div style="width:120px; float:left;"> 
                <select name="overlayPosition">
                  <option value="top" <?php echo ($data_ngs['overlayPosition'] == "top" ? "selected":"") ?>> Top       </option>
                  <option value="bottom" <?php echo ($data_ngs['overlayPosition'] == "bottom" ? "selected":"") ?>> Bottom    </option>
                </select>
              </div>
            </div>

            <div style="clear:left; padding-top:10px;">
              <div style="width:120px; float:left;"> Caption Overlay Opacity (0.0 - 1.0) </div>
              <div style="width:120px; float:left;"> <input type="text" name="overlayOpacity" value="<?php echo $data_ngs['overlayOpacity']?>" style="width:60px;"></div>
            </div>

          </fieldset>

          <div style="clear:both; padding-top:10px;">
            <div style="width:120px; float:left;"> Show Filmstrip </div>
            <div style="width:120px; float:left;"> <input type="checkbox" id="showFilmstrip" name="showFilmstrip" <?php echo ($data_ngs['showFilmstrip']? "checked=\"checked\"": "") ?> onClick="if(this.checked){document.getElementById('filmstrip_options').style.display='';} else{document.getElementById('filmstrip_options').style.display='none';};" > </div>
          </div>

          <fieldset id="filmstrip_options" class="options" style="padding:20px; margin-top:0px; display:<?php echo ($data_ngs['showFilmstrip']?'':'none')?>;">
            <legend> Filmstrip Options </legend>
            
            <div style="clear:both; padding-top:10px;">
              <div style="width:120px; float:left;"> Filmstrip Position </div>
              <div style="width:120px; float:left;"> 
                <select name="filmstripPosition">
                  <option value="top" <?php echo ($data_ngs['filmstripPosition'] == "top" ? "selected":"") ?>> Top       </option>
                  <option value="bottom" <?php echo ($data_ngs['filmstripPosition'] == "bottom" ? "selected":"") ?>> Bottom    </option>
                  <option value="left" <?php echo ($data_ngs['filmstripPosition'] == "left" ? "selected":"") ?>> Left      </option>
                  <option value="right" <?php echo ($data_ngs['filmstripPosition'] == "right" ? "selected":"") ?>> Right     </option>
                </select>
              </div>
            </div>
            
            <div style="clear:both; padding-top:10px;">
              <div style="width:120px; float:left;"> Pointer Size </div>
              <div style="width:120px; float:left;"> <input type="text" name="pointerSize" value="<?php echo $data_ngs['pointerSize']?>" style="width:60px;">px </div>
            </div>
            
            <div style="clear:both;">
              <div style="width:120px; float:left;"> Frame Width </div>
              <div style="width:120px; float:left;"> <input type="text" name="frameWidth" value="<?php echo $data_ngs['frameWidth']?>" style="width:60px;">px </div>
            </div>

            <div style="clear:both; padding-top:10px;">
              <div style="width:120px; float:left;"> Frame Height </div>
              <div style="width:120px; float:left;"> <input type="text" name="frameHeight" value="<?php echo $data_ngs['frameHeight']?>" style="width:60px;">px </div>
            </div>
          
            <div style="clear:both; padding-top:10px;">
              <div style="width:120px; float:left;"> Filmstrip Scaling </div>
              <div style="width:120px; float:left;"> 
                <select name="frameScale">
                  <option value="crop" <?php echo ($data_ngs['frameScale'] == "crop" ? "selected":"") ?>> Crop to Fill       </option>
                  <option value="nocrop" <?php echo ($data_ngs['frameScale'] == "nocrop" ? "selected":"") ?>> No Cropping    </option>
                </select>
              </div>
            </div>

            <div style="clear:both; padding-top:10px;">
              <div style="width:120px; float:left;"> Frame Gap </div>
              <div style="width:120px; float:left;"> <input type="text" name="frameGap" value="<?php echo $data_ngs['frameGap']?>" style="width:60px;">px </div>
            </div>
            
            <div style="clear:both; padding-top:10px;">
              <div style="width:120px; float:left;"> Frame Opacity (0.0 - 1.0) </div>
              <div style="width:120px; float:left;"> <input type="text" name="frameOpacity" value="<?php echo $data_ngs['frameOpacity']?>" style="width:60px;">px </div>
            </div>

            <div style="clear:both; padding-top:10px;">
              <div style="width:120px; float:left;"> Filmstrip Animation (easing effect) </div>
              <div style="width:120px; float:left;"> 
                <select name="easingValue">
                  <option value="swing" <?php echo ($data_ngs['easingValue'] == "swing" ? "selected":"") ?>> Swing       </option>
                  <option value="easeInQuad" <?php echo ($data_ngs['easingValue'] == "easeInQuad" ? "selected":"") ?>> easeInQuad    </option>
                  <option value="easeOutQuad" <?php echo ($data_ngs['easingValue'] == "easeOutQuad" ? "selected":"") ?>> easeOutQuad      </option>
                  <option value="easeInOutQuad" <?php echo ($data_ngs['easingValue'] == "easeInOutQuad" ? "selected":"") ?>> easeInOutQuad     </option>
                  <option value="easeInCubic" <?php echo ($data_ngs['easingValue'] == "easeInCubic" ? "selected":"") ?>> easeInCubic     </option>
                  <option value="easeOutCubic" <?php echo ($data_ngs['easingValue'] == "easeOutCubic" ? "selected":"") ?>> easeOutCubic       </option>
                  <option value="easeInOutCubic" <?php echo ($data_ngs['easingValue'] == "easeInOutCubic" ? "selected":"") ?>> easeInOutCubic    </option>
                  <option value="easeInQuart" <?php echo ($data_ngs['easingValue'] == "easeInQuart" ? "selected":"") ?>> easeInQuart      </option>
                  <option value="easeOutQuart" <?php echo ($data_ngs['easingValue'] == "easeOutQuart" ? "selected":"") ?>> easeOutQuart     </option>
                  <option value="easeInOutQuart" <?php echo ($data_ngs['easingValue'] == "easeInOutQuart" ? "selected":"") ?>> easeInOutQuart     </option>
                  <option value="easeInQuint" <?php echo ($data_ngs['easingValue'] == "easeInQuint" ? "selected":"") ?>> easeInQuint       </option>
                  <option value="easeOutQuint" <?php echo ($data_ngs['easingValue'] == "easeOutQuint" ? "selected":"") ?>> easeOutQuint    </option>
                  <option value="easeInOutQuint" <?php echo ($data_ngs['easingValue'] == "easeInOutQuint" ? "selected":"") ?>> easeInOutQuint      </option>
                  <option value="easeInSine" <?php echo ($data_ngs['easingValue'] == "easeInSine" ? "selected":"") ?>> easeInSine     </option>
                  <option value="easeOutSine" <?php echo ($data_ngs['easingValue'] == "easeOutSine" ? "selected":"") ?>> easeOutSine     </option>
                  <option value="easeInOutSine" <?php echo ($data_ngs['easingValue'] == "easeInOutSine" ? "selected":"") ?>> easeInOutSine       </option>
                  <option value="easeInExpo" <?php echo ($data_ngs['easingValue'] == "easeInExpo" ? "selected":"") ?>> easeInExpo    </option>
                  <option value="easeOutExpo" <?php echo ($data_ngs['easingValue'] == "easeOutExpo" ? "selected":"") ?>> easeOutExpo      </option>
                  <option value="easeInOutExpo" <?php echo ($data_ngs['easingValue'] == "easeInOutExpo" ? "selected":"") ?>> easeInOutExpo     </option>
                  <option value="easeInCirc" <?php echo ($data_ngs['easingValue'] == "easeInCirc" ? "selected":"") ?>> easeInCirc     </option>
                  <option value="easeOutCirc" <?php echo ($data_ngs['easingValue'] == "easeOutCirc" ? "selected":"") ?>> easeOutCirc       </option>
                  <option value="easeInOutCirc" <?php echo ($data_ngs['easingValue'] == "easeInOutCirc" ? "selected":"") ?>> easeInOutCirc    </option>
                  <option value="easeInElastic" <?php echo ($data_ngs['easingValue'] == "easeInElastic" ? "selected":"") ?>> easeInElastic      </option>
                  <option value="easeOutElastic" <?php echo ($data_ngs['easingValue'] == "easeOutElastic" ? "selected":"") ?>> easeOutElastic     </option>
                  <option value="easeInOutElastic" <?php echo ($data_ngs['easingValue'] == "easeInOutElastic" ? "selected":"") ?>> easeInOutElastic     </option>
                  <option value="easeInBack" <?php echo ($data_ngs['easingValue'] == "easeInBack" ? "selected":"") ?>> easeInBack       </option>
                  <option value="easeOutBack" <?php echo ($data_ngs['easingValue'] == "easeOutBack" ? "selected":"") ?>> easeOutBack    </option>
                  <option value="easeInOutBack" <?php echo ($data_ngs['easingValue'] == "easeInOutBack" ? "selected":"") ?>> easeInOutBack      </option>
                  <option value="easeInBounce" <?php echo ($data_ngs['easingValue'] == "easeInBounce" ? "selected":"") ?>> easeInBounce     </option>
                  <option value="easeOutBounce" <?php echo ($data_ngs['easingValue'] == "easeOutBounce" ? "selected":"") ?>> easeOutBounce     </option>
                  <option value="easeInOutBounce" <?php echo ($data_ngs['easingValue'] == "easeInOutBounce" ? "selected":"") ?>> easeInOutBounce     </option>
                </select>
              </div>
            </div>

          </fieldset>

          <div style="clear:both; padding-bottom:8px;"></div>
          <fieldset>
            <legend> Advanced Options </legend>
             <div style="width:120px; float:left;"> Theme </div>
              <div style="width:120px; float:left;"> 
                <select name="navTheme">
                  <option value="dark" <?php echo ($data_ngs['navTheme'] == "dark" ? "selected":"") ?>> Dark       </option>
                  <option value="light" <?php echo ($data_ngs['navTheme'] == "light" ? "selected":"") ?>> Light    </option>
                </select>
              </div>
            <div style="clear:both; padding-top:10px;">
              <div style="width:120px; float:left;"> Starting Frame </div>
              <div style="width:120px; float:left;"> <input type="text" name="startFrame" value="<?php echo $data_ngs['startFrame']?>" style="width:60px;"></div>
            </div>
            <div style="clear:both; padding-top:10px;">
              <div style="width:120px; float:left;"> Pause On Hover </div>
              <div style="width:120px; float:left;"> <input type="checkbox" id="pauseOnHover" name="pauseOnHover" <?php echo ($data_ngs['pauseOnHover']? "checked=\"checked\"": "") ?> > </div>
            </div>
          </fieldset>

          <div style="clear:both; padding-bottom:8px;"></div>  

            <div class="submit"></div>          
  <?php }
}

function init_jquery() {
  wp_enqueue_script('jquery');
  wp_enqueue_script('jquery-timers');
   wp_enqueue_script('jquery-easing');
   wp_enqueue_script('jquery-gallerview');
}

$galleryview = new GalleryView();

add_action('admin_menu' , array($galleryview, 'admin_menu'));
add_shortcode('galleryview', 'nggGalleryViewShow');
add_action('init', 'init_jquery');
// add_action('wp_head'   , 'nggGalleryViewHead');

if (isset($_REQUEST["page"]) == "specific_galleryview") add_action('admin_head', 'nggGalleryViewHeadAdmin');

if (isset($_REQUEST["page"]) == plugin_basename( dirname(__FILE__))) add_action('admin_head', 'nggGalleryViewHeadAdmin');




?>