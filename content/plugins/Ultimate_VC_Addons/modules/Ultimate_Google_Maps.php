<?php
/*
* Add-on Name: Ultimate Google Maps
* Add-on URI: https://www.brainstormforce.com
*/
if(!class_exists("Ultimate_Google_Maps")){
	class Ultimate_Google_Maps{
		function __construct(){
			add_action("admin_init",array($this,"google_maps_init"));
			add_shortcode("ultimate_google_map",array($this,"display_ultimate_map"));
			add_action('wp_enqueue_scripts',array($this,'front_scripts'));
		}
		function front_scripts(){
			global $post;
			$postdata = get_post($post->ID);
			$shortcode_exist = preg_match( '#\[ *ultimate_google_map([^\]])*\]#i', $postdata->post_content );
			if($shortcode_exist){
				wp_enqueue_script("googleapis","https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false","1.0",array(),false);
				wp_enqueue_style('ultimate-maps',plugins_url('../assets/css/',__FILE__).'maps.css');
			}
		}
		function google_maps_init(){
			if ( function_exists('vc_map'))
			{
				vc_map( array(
					"name" => __("Google Map", "smile"),
					"base" => "ultimate_google_map",
					"class" => "vc_google_map",
					"controls" => "full",
					"show_settings_on_create" => true,
					"icon" => "vc_google_map",
					"description" => __("Display Google Maps to indicate your location.", "smile"),
					"category" => __("Ultimate VC Addons", "smile"),
					"params" => array(
						array(
							"type" => "textfield",
							"class" => "",
							"heading" => __("Width (in %)", "smile"),
							"param_name" => "width",
							"admin_label" => true,
							"value" => "100%"
						),
						array(
							"type" => "textfield",
							"class" => "",
							"heading" => __("Height (in px)", "smile"),
							"param_name" => "height",
							"admin_label" => true,
							"value" => "300px"
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => __("Map type", "smile"),
							"param_name" => "map_type",
							"admin_label" => true,
							"value" => array(__("Roadmap", "smile") => "ROADMAP", __("Satellite", "smile") => "SATELLITE", __("Hybrid", "smile") => "HYBRID", __("Terrain", "smile") => "TERRAIN")
						),
						array(
							"type" => "textfield",
							"class" => "",
							"heading" => __("Latitude", "smile"),
							"param_name" => "lat",
							"admin_label" => true,
							"value" => "18.591212",
							"description" => __("You can use this <a href='http://www.birdtheme.org/useful/googletool.html' target='_blank'>http://www.birdtheme.org/useful/googletool.html</a> tool to designate coordinates", "smile")
						),
						array(
							"type" => "textfield",
							"class" => "",
							"heading" => __("Longitude", "smile"),
							"param_name" => "lng",
							"admin_label" => true,
							"value" => "73.741261",
							"description" => __("You can use this <a href='http://www.birdtheme.org/useful/googletool.html' target='_blank'>http://www.birdtheme.org/useful/googletool.html</a> tool to designate coordinates", "smile")
						),
						array(
							"type" => "dropdown",
							"heading" => __("Map Zoom", "smile"),
							"param_name" => "zoom",
							"value" => array(
								__("18 - Default", "smile") => 12, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 13, 14, 15, 16, 17, 18, 19, 20
							)
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => __("Street view control", "smile"),
							"param_name" => "streetviewcontrol",
							"value" => array(__("Disable", "smile") => "false", __("Enable", "smile") => "true")
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => __("Map type control", "smile"),
							"param_name" => "maptypecontrol",
							"value" => array(__("Disable", "smile") => "false", __("Enable", "smile") => "true")
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => __("Map pan control", "smile"),
							"param_name" => "pancontrol",
							"value" => array(__("Disable", "smile") => "false", __("Enable", "smile") => "true")
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => __("Zoom control", "smile"),
							"param_name" => "zoomcontrol",
							"value" => array(__("Disable", "smile") => "false", __("Enable", "smile") => "true")
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => __("Zoom control size", "smile"),
							"param_name" => "zoomcontrolsize",
							"value" => array(__("Small", "smile") => "SMALL", __("Large", "smile") => "LARGE"),
							"dependency" => Array("element" => "zoomControl","value" => array("true")),
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => __("Marker/Point icon", "smile"),
							"param_name" => "marker_icon",
							"value" => array(__("Use Google Default", "smile") => "default", __("Use Plugin's Default", "smile") => "default_self", __("Upload Custom", "smile") => "custom"),
						),
						array(
							"type" => "attach_image",
							"class" => "",
							"heading" => __("Upload Image Icon:", "smile"),
							"param_name" => "icon_img",
							"admin_label" => true,
							"value" => "",
							"description" => __("Upload the custom image icon.", "smile"),
							"dependency" => Array("element" => "marker_icon","value" => array("custom")),
						),
						array(
							"type" => "textarea_html",
							"class" => "",
							"heading" => __("Info Window Text", "smile"),
							"param_name" => "content",
							"value" => "",
						),
						array(
							"type" => "dropdown",
							"class" => "",
							"heading" => __("Top margin", "smile"),
							"param_name" => "top_margin",
							"value" => array(
								__("Page (small)", "smile") => "page_margin_top", 
								__("Section (large)", "smile") => "page_margin_top_section",  
								__("None", "smile") => "none"
							)
						)
					)
				));
			}

		}
		function display_ultimate_map($atts,$content = null){
			// enqueue js
			wp_enqueue_script('ultimate-appear');
			if(get_option('ultimate_row') == "enable"){
				wp_enqueue_script('ultimate-row-bg',plugins_url('../assets/js/',__FILE__).'ultimate_bg.js');
			}
			wp_enqueue_script('ultimate-custom');
			
			// enqueue css
			wp_enqueue_style('ultimate-animate');
			wp_enqueue_style('ultimate-style');
			
			$width = $height = $map_type = $lat = $lng = $zoom = $streetviewcontrol = $maptypecontrol = $top_margin = $pancontrol = $zoomcontrol = $zoomcontrolsize = $marker_icon = $icon_img = $output = '';
			extract(shortcode_atts(array(
				//"id" => "map",
				"width" => "100%",
				"height" => "300px",
				"map_type" => "ROADMAP",
				"lat" => "18.591212",
				"lng" => "73.741261",
				"zoom" => "14",
				"streetviewcontrol" => "",
				"maptypecontrol" => "",
				"pancontrol" => "",
				"zoomcontrol" => "",
				"zoomcontrolsize" => "",
				"marker_icon" => "",
				"icon_img" => "",
				"top_margin" => "page_margin_top"
			), $atts));
			$marker_lat = $lat;
			$marker_lng = $lng;
			if($marker_icon == "default_self"){
				$icon_url = plugins_url("../assets/img/icon-marker-pink.png",__FILE__);
			} elseif($marker_icon == "default"){
				$icon_url = "";
			} else {
				$ico_img = wp_get_attachment_image_src( $icon_img, 'large');
				$icon_url = $ico_img[0];
			}
			$id = "map_".uniqid();
			$map_type = strtoupper($map_type);
			$width = (substr($width, -1)!="%" && substr($width, -2)!="px" ? $width . "px" : $width);
			$height = (substr($height, -1)!="%" && substr($height, -2)!="px" ? $height . "px" : $height);
			$output .= "<div id='" . $id . "' class='ultimate_google_map wpb_content_element'" . ($width!="" || $height!="" ? " style='" . ($width!="" ? "width:" . $width . ";" : "") . ($height!="" ? "height:" . $height . ";" : "") . "'" : "") . ($top_margin!="none" ? " class='" . $top_margin . "'" : "") . "></div>";
			$output .= "<script type='text/javascript'>
			var map_$id = null;
			var coordinate_$id;
			try
			{			
				var map_$id = null;
				var coordinate_$id;
				coordinate_$id=new google.maps.LatLng($lat, $lng);
				var mapOptions= 
				{
					zoom: $zoom,
					center: coordinate_$id,
					mapTypeId: google.maps.MapTypeId.$map_type,
					scaleControl: true,
					streetViewControl: $streetviewcontrol,
					mapTypeControl: $maptypecontrol,
					panControl: $pancontrol,
					zoomControl: $zoomcontrol,
					zoomControlOptions: {
					  style: google.maps.ZoomControlStyle.$zoomcontrolsize
					}
				};
				var map_$id = new google.maps.Map(document.getElementById('$id'),mapOptions);";
				if($marker_lat!="" && $marker_lng!="")
				{
				$output .= "
					var marker_$id = new google.maps.Marker({
						position: new google.maps.LatLng($marker_lat, $marker_lng),
						animation:  google.maps.Animation.DROP,
						map: map_$id,
						icon: '".$icon_url."'
					});
					google.maps.event.addListener(marker_$id, 'click', toggleBounce);";
					
					if($content !== ""){
						$output .= "
							var infowindow = new google.maps.InfoWindow();
							infowindow.setContent('<div class=\"map_info_text\" style=\'color:#000;\'>".trim(preg_replace('/\s+/', ' ', do_shortcode($content)))."</div>');
							infowindow.open(map_$id,marker_$id);";
					}
				}
				$output .= "
			}
			catch(e){};
			jQuery(document).ready(function($){
				$(window).resize(function(){
					if(map_$id!=null)
						map_$id.setCenter(coordinate_$id);
				});
			});
			function toggleBounce() {
			  if (marker_$id.getAnimation() != null) {
				marker_$id.setAnimation(null);
			  } else {
				marker_$id.setAnimation(google.maps.Animation.BOUNCE);
			  }
			}
			</script>";
			return $output;
		}
	}
	new Ultimate_Google_Maps;
}