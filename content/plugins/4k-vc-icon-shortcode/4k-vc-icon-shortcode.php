<?php
/*
Plugin Name: 4k Icons for Visual Composer
Description: Adds a shortcode to Visual Composer for using 9,000+ icons
Author: Benjamin Intal, Gambit
Version: 2.1
Author URI: http://gambit.ph
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

defined( 'GAMBIT_VC_4K_ICONS' ) or define( 'GAMBIT_VC_4K_ICONS', 'gambit-vc-4k-icons' );


/*******************************************************
 * Titan Start
 *******************************************************/

require_once( trailingslashit( dirname( __FILE__ ) ) . 'titan-shortcode-extension/class-titan-shortcode.php' );

/*
 * When using the embedded framework, use it only if the framework
 * plugin isn't activated.
 */

// Don't do anything when we're activating a plugin to prevent errors
// on redeclaring Titan classes
if ( ! empty( $_GET['action'] ) && ! empty( $_GET['plugin'] ) ) {
    if ( $_GET['action'] == 'activate' ) {
        return;
    }
}
// Check if the framework plugin is activated
$useEmbeddedFramework = true;
$activePlugins = get_option('active_plugins');
if ( is_array( $activePlugins ) ) {
    foreach ( $activePlugins as $plugin ) {
        if ( is_string( $plugin ) ) {
            if ( stripos( $plugin, '/titan-framework.php' ) !== false ) {
                $useEmbeddedFramework = false;
                break;
            }
        }
    }
}
// Use the embedded Titan Framework
if ( $useEmbeddedFramework ) {
    require_once( plugin_dir_path( __FILE__ ) . 'titan-framework/titan-framework.php' );
}



/*******************************************************
 * Start 4k Shortcode
 *******************************************************/


class FourKIconShortcode {

	private static $printedIconArray = false;
	private static $iconId = 1;

	function __construct() {
		add_action( 'after_setup_theme', array( $this, 'integrateWithVC' ), 1 );
		add_action( 'after_setup_theme', array( $this, 'createShortcodes' ), 2 );
		add_action( 'admin_head', array( $this, 'createFontClassArray' ) );
		add_action( 'plugins_loaded', array( $this, 'loadTextDomain' ) );
	}


	public function createFontClassArray() {
		// Check if Visual Composer is installed
		if ( ! defined( 'WPB_VC_VERSION' ) || ! function_exists( 'wpb_map' ) ) {
			return;
		}

		if ( ! self::$printedIconArray ) {
			include( trailingslashit( dirname( __FILE__ ) ) . 'inc/font-js-classes.php' );
		}
		self::$printedIconArray = true;
	}


	public function integrateWithVC() {
		// Check if Visual Composer is installed
		if ( ! defined( 'WPB_VC_VERSION' ) || ! function_exists( 'wpb_map' ) ) {
			return;
		}

		add_shortcode_param( '4k_icon', array( $this, 'createIconSettingsField' ), plugins_url( 'js/script-vc.js', __FILE__ ) );
	}


	/**
	 * Loads the translations
	 *
	 * @return	void
	 * @since	1.0
	 */
	public function loadTextDomain() {
		load_plugin_textdomain( GAMBIT_VC_4K_ICONS, false, basename( dirname( __FILE__ ) ) . '/languages/' );
	}


	public function createIconSettingsField( $settings, $value ) {
	    $dependency = vc_generate_dependencies_attributes($settings);
	    return '<div class="my_param_block">'
		  	  . '<style>.fourk_select_window i {'
			  . 'display:inline-block;height:40px;min-width:40px;text-align:center;padding:5px;vertical-align:middle;border:1px solid #ddd;margin:2px;cursor:pointer;box-sizing:content-box'
		  	  . '}</style>'
  			  .'<div class="4k_icon_preview" style="display: inline-block;
					margin-right: 10px;
					height: 60px;
					width: 90px;
					text-align: center;
					background: #FAFAFA;
					font-size: 60px;
					padding: 15px 0;
					margin-bottom: 10px;
					border: 1px solid #DDD;
					float: left;
					box-sizing: content-box;"><i class="bk-ice-cream"></i></div>'
	              .'<input placeholder="' . __( "Search icon or pick one below...", GAMBIT_VC_4K_ICONS ) . '" name="' . $settings['param_name'] . '"'
				. ' data-param-name="' . $settings['param_name'] . '"'
				. ' data-icon-css-path="' . plugins_url( '/', __FILE__ ) . '"'
	              .'class="wpb_vc_param_value wpb-textinput'
	              .$settings['param_name'].' '.$settings['type'].'_field" type="text" value="'
	              .$value.'" ' . $dependency . ' style="width: 230px; margin-right: 10px; vertical-align: top; float: left; margin-bottom: 10px"/>'
				. '<select class="4k_icon_filter" style="
						width: auto;
						display: inline-block;
						vertical-align: top;
						float: left;
						"><option value="">- ' . __( "Search Filter", GAMBIT_VC_4K_ICONS ) . ' -</option>
						<option value="all">' . __( "Show all icons (may be a bit slow)", GAMBIT_VC_4K_ICONS ) . '</option>
						<option value="lp-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "105 Loops", "Pranav" )
						. '</option>'
						. '<option value="mi-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "50 Mini Icons", "Victor Erixon" )
						. '</option>'
						. '<option value="sw-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "80 Shades of White Icons", "Victor Erixon" )
						. '</option>'
						. '<option value="oi-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "Any Old Icon", "Ian Yates" )
						. '</option>'
						. '<option value="ba-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "Batch", "Adam Whitcroft" )
						. '</option>'
						. '<option value="br-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "Brandico", "Fontello" )
						. '</option>'
						. '<option value="bk-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "Brankic1979", "Brankic1979" )
						. '</option>'
						. '<option value="bc-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "Broccolidry", "Visual Idiot" )
						. '</option>'
						. '<option value="cl-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "Clear Icons", "Appzgear" )
						. '</option>'
						. '<option value="cn-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "Countricons", "Freepik" )
						. '</option>'
						. '<option value="ct-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "Cuticons", "Vaibhav Bhat" )
						. '</option>'
						. '<option value="dr-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "Dripicons", "Amit Jakhu" )
						. '</option>'
						. '<option value="ec-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "Eco Ico", "Matthew Skiles" )
						. '</option>'
						. '<option value="elu-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "Elusive Icons", "Aristath" )
						. '</option>'
						. '<option value="en-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "Entypo", "Daniel Bruce" )
						. '</option>'
						. '<option value="ft-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "Fat Icons", "Designerz Base" )
						. '</option>'
						. '<option value="file-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "File Formats", "Freepik" )
						. '</option>'
						. '<option value="fa-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "Font Awesome", "Dave Gandy" )
						. '</option>'
						. '<option value="fo-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "Fontelico", "Fontello" )
						. '</option>'
						. '<option value="foa-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "Foundation Icons - Accessibility", "ZURB" )
						. '</option>'
						. '<option value="draw-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "Hand Drawn", "Freepik" )
						. '</option>'
						. '<option value="im-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "Icon Minia", "Egemen Kapusuz" )
						. '</option>'
						. '<option value="imf-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "IcoMoon - Free", "Keyamoon" )
						. '</option>'
						. '<option value="ic-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "Iconic", "PJ. Onori" )
						. '</option>'
						. '<option value="ion-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "Ionicons", "Drifty" )
						. '</option>'
						. '<option value="ls-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "Ligature Symbols", "Kazuyuki Motoyama" )
						. '</option>'
						. '<option value="lis-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "Line Icon Set", "Situ Herrera" )
						. '</option>'
						. '<option value="el-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "Line Icons", "Elegant Themes" )
						. '</option>'
						. '<option value="ln-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "Linecons", "Sergey Shmidt" )
						. '</option>'
						. '<option value="mk-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "Maki", "Mapbox" )
						. '</option>'
						. '<option value="ma-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "Map Icons", "Scott de Jonge" )
						. '</option>'
						. '<option value="mt-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "Meteocons", "Alessio Atzeni" )
						. '</option>'
						. '<option value="mfg-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "MFG Labs", "MFG Labs" )
						. '</option>'
						. '<option value="mo-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "Mobile Phones", "Freepik" )
						. '</option>'
						. '<option value="mp-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "Modern Pictograms", "John Caserta" )
						. '</option>'
						. '<option value="mn-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "MonoSocialIcons Font", "Ivan Drinchev" )
						. '</option>'
						. '<option value="moon-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "Moon Phase 1", "Freepik" )
						. '</option>'
						. '<option value="mm-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "Multimedia", "Freepik" )
						. '</option>'
						. '<option value="ow-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "OpenWeb Icons", "Matthias Pfefferle" )
						. '</option>'
						. '<option value="creditcard-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "Payment Cards", "Freepik" )
						. '</option>'
						. '<option value="payment-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "Payment Logos", "Freepik" )
						. '</option>'
						. '<option value="business-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "Simpleicon Business", "SimpleIcon" )
						. '</option>'
						. '<option value="ecommerce-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "Simpleicon eCommerce", "SimpleIcon" )
						. '</option>'
						. '<option value="place-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "Simpleicon Places", "SimpleIcon" )
						. '</option>'
						. '<option value="st-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "Steadysets", "Tommy Sahl" )
						. '</option>'
						. '<option value="ty-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "Typicons", "Stephen Hutchings" )
						. '</option>'
						. '<option value="ty2-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "Typicons (Updated)", "Stephen Hutchings" )
						. '</option>'
						. '<option value="u8-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "Universal 08", "Freepik" )
						. '</option>'
						. '<option value="u12-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "Universal 12", "Freepik" )
						. '</option>'
						. '<option value="gesture-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "Using Gesture", "Mobiletuxedo" )
						. '</option>'
						. '<option value="games-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "Video Games", "Freepik" )
						. '</option>'
						. '<option value="wi-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "Weather Icons", "Erik Flowers" )
						. '</option>'
						. '<option value="ws-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "Web Symbols", "Just Be Nice Studio" )
						. '</option>'
						. '<option value="wl-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "Website Logos", "Freepik" )
						. '</option>'
						. '<option value="wb-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "WebHostingHub Glyphs", "WebHostingHub" )
						. '</option>'
						. '<option value="zm-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "WPZoom Developer Icon Set", "David Ferreria" )
						. '</option>'
						. '<option value="usa-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "StateFace", "ProPublica" )
						. '</option>'
						. '<option value="zo-">'
						. sprintf( __( '%s by %s', GAMBIT_VC_4K_ICONS ), "Zocial", "Sam Collins" )
						. '</option>
						</select>'
				. '<div class="fourk_select_window" style="display: none; font-size: 40px; width: 100%; padding: 8px;
					box-sizing: border-box;
					-moz-box-sizing: border-box;
					background: #FAFAFA;
					height: 250px;
					overflow-y: scroll;
					border: 1px solid #DDD;
					clear: both"></div>'
	          .'</div>';
	}


	public function createShortcodes() {
		$titan = TitanFramework::getInstance( GAMBIT_VC_4K_ICONS );

		// Create a shortcode. After doing this, the shortcode will be
		// automatically placed in a drop down box in the Visual Editor
		// for easy shortcode selecting.
		// The shortcode will also be automatically integrated with
		// Visual Composer
		$titan->createShortcode( array(
		    'tag' => '4k_icon',
		    'name' => __( '4k Icon', GAMBIT_VC_4K_ICONS ),
			'desc' => __( 'Awesome styleable icon', GAMBIT_VC_4K_ICONS ),
			// URL to my icon for Visual Composer
		    'icon' => plugins_url( 'vc-icon.png', __FILE__ ),
			// All my attributes, define as many as we need
		    'attributes' => array(
		        'icon' => array(
		            'name' => __( 'Choose your icon', GAMBIT_VC_4K_ICONS ),
		            'type' => '4k_icon',
					'holder' => 'div',
					'desc' => __( 'Choose an icon. Type in the text box above to search for a specific icon. Use the drop down above to filter or show icons from specific icon sets.', GAMBIT_VC_4K_ICONS ),
		        ),
				'icon_color' => array(
					'name' => __( 'Icon Color', GAMBIT_VC_4K_ICONS ),
					'default' => '#3498db',
					'type' => 'color',
					'desc' => __( 'Pick a color for your icon.', GAMBIT_VC_4K_ICONS ),
				),
				'icon_size' => array(
					'name' => __( 'Icon Size', GAMBIT_VC_4K_ICONS ),
					'default' => '50',
					'type' => 'text',
					'desc' => __( 'The size of your icon in pixels.', GAMBIT_VC_4K_ICONS )
				),
		        'shape' => array(
		            'name' => __( 'Background Shape', GAMBIT_VC_4K_ICONS ),
		            'default' => 'none',
		            'type' => 'select',
		            'options' => array(
						'none' => __( 'No background shape', GAMBIT_VC_4K_ICONS ),
						'circle' => __( 'Circle', GAMBIT_VC_4K_ICONS ),
						'square' => __( 'Square', GAMBIT_VC_4K_ICONS ),
						'rounded' => __( 'Rounded-Square', GAMBIT_VC_4K_ICONS )
					),
		            'desc' => __( "Select a background shape for your icon. <em>(Changes may not be visible in the frontend editor)</em>", GAMBIT_VC_4K_ICONS ),
		        ),
		        'shape_type' => array(
		            'name' => __( 'Background Shape Type', GAMBIT_VC_4K_ICONS ),
		            'default' => 'solid',
		            'type' => 'select',
		            'options' => array(
						'solid' => __( 'Normal, solid background', GAMBIT_VC_4K_ICONS ),
						'button' => __( 'Solid background with a dark bottom border', GAMBIT_VC_4K_ICONS ),
						'thin-border' => __( 'Thin bordered background', GAMBIT_VC_4K_ICONS ),
						'thick-border' => __( 'Thick bordered background', GAMBIT_VC_4K_ICONS ),
					),
		            'desc' => __( "Select a type of background shape for your icon. This is only applied when there are no hover effects.", GAMBIT_VC_4K_ICONS ),
					'dependency' => array(
 						'element' => 'hover_effect',
						'value' => array( 'none' )
					),
		        ),
				'border_radius' => array(
					'name' => __( 'Background Shape Border Radius', GAMBIT_VC_4K_ICONS ),
					'default' => '8',
					'type' => 'text',
					'desc' => __( 'The border radius of the background shape in pixels.', GAMBIT_VC_4K_ICONS ),
					'dependency' => array(
 						'element' => 'shape',
						'value' => array( 'rounded' )
					),
				),
				'shape_color' => array(
					'name' => __( 'Background Shape Color', GAMBIT_VC_4K_ICONS ),
					'default' => '#dddddd',
					'type' => 'color',
					'desc' => __( "Pick a color for your icon's background shape.", GAMBIT_VC_4K_ICONS ),
					'dependency' => array(
 						'element' => 'shape',
						'value' => array( 'circle', 'square', 'rounded' )
					),
				),
				'shape_size' => array(
					'name' => __( 'Shape Size', GAMBIT_VC_4K_ICONS ),
					'default' => '60',
					'type' => 'text',
					'desc' => __( "The size for your icon's background shape in pixels.", GAMBIT_VC_4K_ICONS ),
					'dependency' => array(
 						'element' => 'shape',
						'value' => array( 'circle', 'square', 'rounded' )
					),
				),
				'hover_effect' => array(
					'name' => __( 'Hover Effect', GAMBIT_VC_4K_ICONS ),
					'default' => 'none',
					'type' => 'select',
					'desc' => __( "The hover effect to play when the mouse hovers over the icon. <em>(Changes may not be visible in the frontend editor)</em>", GAMBIT_VC_4K_ICONS ),
		            'options' => array(
						'none' => __( 'No hover effect', GAMBIT_VC_4K_ICONS ),
						'faint-circle' => '(faint-circle) ' . __( "Faint background shape that solidifies on hover with an outline", GAMBIT_VC_4K_ICONS ),
						'solid-outline' => '(solid-outline) ' . __( "Solid background shape that gets smaller when hovered on and shows a border", GAMBIT_VC_4K_ICONS ),
						'flip-vertical' => '(flip-vertical) ' . __( "Solid background shape, that flips vertically when hovered with inverted colors", GAMBIT_VC_4K_ICONS ),
						'flip-horizontal' => '(flip-horizontal) ' . __( "Solid background shape, that flips horizontally when hovered with inverted colors", GAMBIT_VC_4K_ICONS ),
						'swipe-down' => '(swipe-down) ' . __( "Solid background shape, icon swipes down on hover and gets replaced with inverted colors", GAMBIT_VC_4K_ICONS ),
						'swipe-up' => '(swipe-up) ' . __( "Solid background shape, icon swipes up on hover and gets replaced with inverted colors", GAMBIT_VC_4K_ICONS ),
						'swipe-left' => '(swipe-left) ' . __( "Solid background shape, icon swipes left on hover and gets replaced with inverted colors", GAMBIT_VC_4K_ICONS ),
						'swipe-right' => '(swipe-right) ' . __( "Solid background shape, icon swipes right on hover and gets replaced with inverted colors", GAMBIT_VC_4K_ICONS ),
						'fill-up' => '(fill-up) ' . __( "Outlined background shape that gets filled up from the bottom when hovered", GAMBIT_VC_4K_ICONS ),
						'border-solid' => '(border-solid) ' . __( "Border background shape that gets filled up from the edges when hovered", GAMBIT_VC_4K_ICONS ),
						'border-thick' => '(border-thick) ' . __( "Border background shape that gets smaller with another thicker border when hovered", GAMBIT_VC_4K_ICONS ),
					),
					'dependency' => array(
 						'element' => 'shape',
						'value' => array( 'circle', 'square', 'rounded' )
					),
				),
				'hover_on' => array(
					'name' => __( 'Hover Effect Trigger', GAMBIT_VC_4K_ICONS ),
					'default' => 'icon',
					'type' => 'select',
					'desc' => __( "Choose the element which would trigger the hover effect. You may need to play around this value depending on your hover effect since some may have additional containers for the effect. <em>(Changes may not be visible in the frontend editor)</em>", GAMBIT_VC_4K_ICONS ),
		            'options' => array(
						'icon' => 'When the mouse hovers over the icon',
						'parent' => "When the mouse hovers over the icon's container",
						'parent2' => sprintf( __( "When the mouse hovers over the icon's container (%d containers outward)", GAMBIT_VC_4K_ICONS ), 2),
						'parent3' => sprintf( __( "When the mouse hovers over the icon's container (%d containers outward)", GAMBIT_VC_4K_ICONS ), 3),
						'parent4' => sprintf( __( "When the mouse hovers over the icon's container (%d containers outward)", GAMBIT_VC_4K_ICONS ), 4),
						"row" => __( "When the mouse hovers over the row", GAMBIT_VC_4K_ICONS )
					),
					'dependency' => array(
 						'element' => 'hover_effect',
						'value' => array( 'faint-circle', 'solid-outline', 'solid-outline2', 'flip-vertical', 'flip-horizontal', 'swipe-down', 'swipe-up', 'swipe-left', 'swipe-right', 'fill-up', 'border-solid', 'border-thick' ),
					),
				),
				'link' => array(
					'name' => __( 'Link to go to When Icon is Clicked', GAMBIT_VC_4K_ICONS ),
					'default' => '',
					'type' => 'text',
					'desc' => __( "Enter a URL here to make your icon a link.", GAMBIT_VC_4K_ICONS ),
				),
				'link_new_window' => array(
					'name' => __( 'Open The Link in a New Window?', GAMBIT_VC_4K_ICONS ),
					'default' => array( __( 'Check this to open the link above in a new window', GAMBIT_VC_4K_ICONS ) => 'new_window' ),
					'type' => 'checkbox',
					'dependency' => array(
 						'element' => 'link',
						'not_empty' => true
					),
				),
		        'float' => array(
		            'name' => __( 'Icon Float', GAMBIT_VC_4K_ICONS ),
		            'default' => 'none',
		            'type' => 'select',
		            'options' => array(
						'none' => __( "Don't float", GAMBIT_VC_4K_ICONS ),
						'left' => __( 'Float left', GAMBIT_VC_4K_ICONS ),
						'right' => __( 'Float right', GAMBIT_VC_4K_ICONS ),
					),
		            'desc' => __( "The float rule of the icon.", GAMBIT_VC_4K_ICONS ),
		        ),
		        'overflow_next' => array(
		            'name' => __( 'Overflow the Next Content?', GAMBIT_VC_4K_ICONS ),
		            'default' => array( 'Overflow the next block' => 'overflow' ),
		            'type' => 'checkbox',
		            'desc' => __( "If the next content box is a single text block, you can check this field in order for the icon to occupy the whole height (not like when floated). This only applies when you have the float field set to left or right.", GAMBIT_VC_4K_ICONS ),
					'dependency' => array(
 						'element' => 'float',
						'value' => array( 'left', 'right' ),
					),
		        ),
		        'margin' => array(
		            'name' => __( 'Icon Margin', GAMBIT_VC_4K_ICONS ),
		            'default' => '20',
		            'type' => 'textfield',
		            'desc' => __( "The margin in pixels. By default this margin will be placed on the bottom of your icon. If floated left or right, this margin will also be used on the side the icon meets your content.", GAMBIT_VC_4K_ICONS ),
		        ),
		        'extra_class' => array(
		            'name' => __( 'Class name', GAMBIT_VC_4K_ICONS ),
		            'default' => '',
		            'type' => 'textfield',
		            'desc' => __( "You can add an extra class name to this icon if you want to add custom CSS styles to it.", GAMBIT_VC_4K_ICONS ),
		        ),
		    ),
			// The callback function to render my shortcode,
			// This can be a callable array, this behaves the same
		        // as the function you pass to add_shortcode()
		    'function' => array( $this, 'renderShortcode' )
		) );
	}


	// All $atts are filled up with the default values for you,
	// Start rendering my shortcode
	public function renderShortcode( $atts, $content ) {
		$ret = '';

		// Enqueue the CSS
		if ( ! empty( $atts['icon'] ) ) {
			$cssFile = substr( $atts['icon'], 0, stripos( $atts['icon'], '-' ) );
			wp_enqueue_style( '4k-icon-' . $cssFile, plugins_url( 'icons/css/' . $cssFile . '.css', __FILE__ ) );
			wp_enqueue_style( '4k-icons', plugins_url( 'css/icon-styles.css', __FILE__ ) );
			wp_enqueue_script( '4k-icons', plugins_url( 'js/script.js', __FILE__ ), array( 'jquery' ) );
		}

		$divClasses = array();

		if ( empty( $atts['shape'] ) ) {
			$atts['shape'] = 'none';
		}

		$dataAttributes = array();
		$shapeColor = $atts['shape_color'];
		if ( ! empty( $shapeColor ) && $atts['shape'] != 'none' ) {
			$shapeColor = $this->hex2rgb( $shapeColor );
			if ( $atts['shape'] != 'none' && $atts['hover_effect'] == 'faint-circle' ) {
				$shapeColor[] = '.2';
				$dataAttributes[] = "data-hover-background='" . $atts['shape_color'] . "'";
			} else {
				$shapeColor[] = '1';
			}
			$shapeColor = 'rgba(' . implode( ',', $shapeColor ) . ')';
		}

		$containerStyles = array();
		$divStyles = array();
		$beforeStyles = array();
		$afterStyles = array();
		$iconStyles = array();
		$iconHoverStyles = array();

		$containerStyles[] = 'text-align:' . 'center';//$atts['alignment'];

		if ( $atts['shape'] == 'none' ) {
			$atts['hover_effect'] = 'none';
		}

		if ( $atts['shape'] != 'none' ) {
			$divStyles[] = 'background-color:' . $shapeColor;
			$divStyles[] = 'padding:' . ( ( (int)$atts['shape_size'] - (int)$atts['icon_size'] ) / 2 ) . 'px 0';
			$divStyles[] = 'width:' . (int)$atts['shape_size'] . 'px';
			$divStyles[] = 'height:' . (int)$atts['icon_size'] . 'px';
			$beforeStyles[] = 'border-color:' . $atts['shape_color'];
			$afterStyles[] = 'border-color:' . $atts['shape_color'];
		} else {
			$divStyles[] = 'background-color: transparent';
		}

		if ( $atts['shape'] == 'rounded' ) {
			$divStyles[] = 'border-radius:' . (int)$atts['border_radius'] . 'px';
			$beforeStyles[] = 'border-radius:' . ( (int)$atts['border_radius'] * 2 ) . 'px';
			$afterStyles[] = 'border-radius:' . ( (int)$atts['border_radius'] * 2 ) . 'px';
			if ( $atts['hover_effect'] == 'fill-up'
			     || $atts['hover_effect'] == 'border-solid' ) {
				$afterStyles[] = 'border-radius:' . ( (int)$atts['border_radius'] ) . 'px';
			}
			if ( $atts['hover_effect'] == 'solid-outline' ) {
				$afterStyles[] = 'border-radius:' . ( (int)$atts['border_radius'] ) . 'px';
				$beforeStyles[] = 'border-radius:' . ( (int)$atts['border_radius'] ) . 'px';
			}
			if ( $atts['hover_effect'] == 'border-thick' ) {
				$afterStyles[] = 'border-radius:' . ( (int)$atts['border_radius'] ) . 'px';
				$beforeStyles[] = 'border-radius:' . ( (int)$atts['border_radius'] * 1.5 ) . 'px';
			}
		} else if ( $atts['shape'] == 'circle' ) {
			$divStyles[] = 'border-radius:100%';
			$beforeStyles[] = 'border-radius:100%';
			$afterStyles[] = 'border-radius:100%';
		}

		// Shape type
		if ( $atts['hover_effect'] == 'none' && $atts['shape'] != 'none' ) {
			if ( $atts['shape_type'] == 'button' ) {
				$divStyles[] = 'box-shadow: inset 0 -5px 0 rgba(0, 0, 0, 0.2)';
			} else if ( $atts['shape_type'] == 'thin-border' ) {
				$divStyles[] = 'background-color: transparent';
				$divStyles[] = 'box-shadow: inset 0 0 0 2px ' . $atts['shape_color'];
			} else if ( $atts['shape_type'] == 'thick-border' ) {
				$divStyles[] = 'background-color: transparent';
				$divStyles[] = 'box-shadow: inset 0 0 0 4px ' . $atts['shape_color'];
			}

				// 'solid' => __( 'Normal, solid background', GAMBIT_VC_4K_ICONS ),
				// 'button' => __( 'Solid background with a dark bottom border', GAMBIT_VC_4K_ICONS ),
				// 'thin-border' => __( 'Thin bordered background', GAMBIT_VC_4K_ICONS ),
				// 'thick-border' => __( 'Thick bordered background', GAMBIT_VC_4K_ICONS ),
		}

		if ( $atts['hover_effect'] == 'solid-outline'
		     || $atts['hover_effect'] == 'fill-up'
		     || $atts['hover_effect'] == 'border-solid'
		     || $atts['hover_effect'] == 'border-thick' ) {
			$beforeStyles[] = 'background:' . $atts['shape_color'];
			// $afterStyles[] = 'background:' . $atts['shape_color'];
			$iconHoverStyles[] = 'color:' . $atts['shape_color'];
			$afterStyles[] = 'box-shadow: inset 0 0 0 3px ' . $atts['shape_color'];
		}
		if ( $atts['hover_effect'] == 'border-thick' ) {
			$beforeStyles[] = 'box-shadow: inset 0 0 0 4px ' . $atts['shape_color'];
		}

		$iconStyles[] = 'font-size:' . (int)$atts['icon_size'] . 'px';
		$iconStyles[] = 'line-height:' . (int)$atts['icon_size'] . 'px';
		$iconStyles[] = 'color:' . $atts['icon_color'];
		if ( $atts['hover_effect'] == 'fill-up'
		     || $atts['hover_effect'] == 'border-solid' ) {
			$iconStyles[] = 'color:' . $atts['shape_color'];
		}

		$containerStyles = array_filter( $containerStyles );
		$divStyles = array_filter( $divStyles );
		$beforeStyles = array_filter( $beforeStyles );
		$afterStyles = array_filter( $afterStyles );
		$iconStyles = array_filter( $iconStyles );
		$iconHoverStyles = array_filter( $iconHoverStyles );

		$divClasses[] = 'fourk-icon';
		$divClasses[] = $atts['shape'];
		$divClasses[] = $atts['hover_effect'];
		$divClasses[] = $atts['extra_class'];
		$divClasses = array_filter( $divClasses );

		/*
		 * Add styles
		 */

		// Normal styles used for everything
		$ret .= "<style>
			#fourk" . self::$iconId . " { " . implode( ';', $containerStyles ) . " }
			#fourk" . self::$iconId . " .fourk-icon { " . implode( ';', $divStyles ) . " }
			#fourk" . self::$iconId . " .fourk-icon:before { " . implode( ';', $beforeStyles ) . " }
			#fourk" . self::$iconId . " .fourk-icon:after { " . implode( ';', $afterStyles ) . " }
			#fourk" . self::$iconId . " i { " . implode( ';', $iconStyles ) . " }
			#fourk" . self::$iconId . " .fourk-icon.hovered i { " . implode( ';', $iconHoverStyles ) . " }
			#fourk" . self::$iconId . " i { text-align: center; }";


		// Additional styles for the flip effect (flip effect adds a new element)
		if ( stripos( $atts['hover_effect'], 'flip-' ) !== false ) {
			$axis = 'X';
			if ( $atts['hover_effect'] == 'flip-horizontal' ) {
				$axis = 'Y';
			}
			$ret .= "#fourk" . self::$iconId . " .back {
				-webkit-transform: translateX(-" . ( (int)$atts['shape_size'] / 2 ) . "px) rotate{$axis}(180deg);
				   -moz-transform: translateX(-" . ( (int)$atts['shape_size'] / 2 ) . "px) rotate{$axis}(180deg);
				    -ms-transform: translateX(-" . ( (int)$atts['shape_size'] / 2 ) . "px) rotate{$axis}(180deg);
				     -o-transform: translateX(-" . ( (int)$atts['shape_size'] / 2 ) . "px) rotate{$axis}(180deg);
				        transform: translateX(-" . ( (int)$atts['shape_size'] / 2 ) . "px) rotate{$axis}(180deg);
			} #fourk" . self::$iconId . " .back i {
				color: {$atts['shape_color']};
			} #fourk" . self::$iconId . " .back {
				" . implode( ';', $divStyles ) . ";
				background-color: {$atts['icon_color']};
			} #fourk" . self::$iconId . " .hovered + .back {
				-webkit-transform: translateX(-" . ( (int)$atts['shape_size'] / 2 ) . "px) rotate{$axis}(0deg);
				   -moz-transform: translateX(-" . ( (int)$atts['shape_size'] / 2 ) . "px) rotate{$axis}(0deg);
				    -ms-transform: translateX(-" . ( (int)$atts['shape_size'] / 2 ) . "px) rotate{$axis}(0deg);
				     -o-transform: translateX(-" . ( (int)$atts['shape_size'] / 2 ) . "px) rotate{$axis}(0deg);
				        transform: translateX(-" . ( (int)$atts['shape_size'] / 2 ) . "px) rotate{$axis}(0deg);
			}";
			$divClasses[] = 'front';
		} else if ( stripos( $atts['hover_effect'], 'swipe-' ) !== false ) {
			$translate = 'X';
			$translateOffset = 'Y';
			if ( $atts['hover_effect'] == 'swipe-up' || $atts['hover_effect'] == 'swipe-down' ) {
				$translate = 'Y';
				$translateOffset = 'X';
			}
			$negate = '';
			$iconNegate = '-';
			if ( $atts['hover_effect'] == 'swipe-right' || $atts['hover_effect'] == 'swipe-down' ) {
				$negate = '-';
				$iconNegate = '';
			}
			$ret .= "#fourk" . self::$iconId . " .swipe {
				" . implode( ';', $divStyles ) . ";
				background-color: {$atts['icon_color']};
				width: " . (int)$atts['shape_size'] . "px;
				height:" . (int)$atts['icon_size'] . "px;
			} #fourk" . self::$iconId . " .swipe i {
				color: {$atts['shape_color']};
			} #fourk" . self::$iconId . " .swipe {
				-webkit-transform: translate{$translate}({$negate}" . ( (int)$atts['shape_size'] * .99 ) . "px);
				   -moz-transform: translate{$translate}({$negate}" . ( (int)$atts['shape_size'] * .99 ) . "px);
				    -ms-transform: translate{$translate}({$negate}" . ( (int)$atts['shape_size'] * .99 ) . "px);
				     -o-transform: translate{$translate}({$negate}" . ( (int)$atts['shape_size'] * .99 ) . "px);
				        transform: translate{$translate}({$negate}" . ( (int)$atts['shape_size'] * .99 ) . "px);
				opacity: 0;
			} #fourk" . self::$iconId . " .hovered .swipe {
				-webkit-transform: translate{$translate}(0);
				   -moz-transform: translate{$translate}(0);
				    -ms-transform: translate{$translate}(0);
				     -o-transform: translate{$translate}(0);
				        transform: translate{$translate}(0);
				opacity: 1;
			} #fourk" . self::$iconId . " .hovered > i {
				-webkit-transform: translate{$translate}({$iconNegate}" . ( (int)$atts['shape_size'] * .99 ) . "px);
				   -moz-transform: translate{$translate}({$iconNegate}" . ( (int)$atts['shape_size'] * .99 ) . "px);
				    -ms-transform: translate{$translate}({$iconNegate}" . ( (int)$atts['shape_size'] * .99 ) . "px);
				     -o-transform: translate{$translate}({$iconNegate}" . ( (int)$atts['shape_size'] * .99 ) . "px);
				        transform: translate{$translate}({$iconNegate}" . ( (int)$atts['shape_size'] * .99 ) . "px);
			}";

			// prevent edge bleed through
			$ret .= "#fourk" . self::$iconId . " .fourk-icon.hovered {
				background: {$atts['icon_color']} !important;
				-webkit-transition-delay: .3s;
				   -moz-transition-delay: .3s;
				    -ms-transition-delay: .3s;
				     -o-transition-delay: .3s;
				        transition-delay: .3s;
			} #fourk" . self::$iconId . " .fourk-icon {
				-webkit-transition-duration: 0s;
				   -moz-transition-duration: 0s;
				    -ms-transition-duration: 0s;
				     -o-transition-duration: 0s;
				        transition-duration: 0s;
			}";
		} else if ( $atts['hover_effect'] == 'fill-up' ) {
			$ret .= "#fourk" . self::$iconId . " .fourk-icon:before {
				-webkit-transform: translateY(" . ( (int)$atts['shape_size'] * .99 ) . "px);
				   -moz-transform: translateY(" . ( (int)$atts['shape_size'] * .99 ) . "px);
				    -ms-transform: translateY(" . ( (int)$atts['shape_size'] * .99 ) . "px);
				     -o-transform: translateY(" . ( (int)$atts['shape_size'] * .99 ) . "px);
				        transform: translateY(" . ( (int)$atts['shape_size'] * .99 ) . "px);
				border-radius: 0;
			} #fourk" . self::$iconId . " .fourk-icon.hovered:before {
				-webkit-transform: translateY(0);
				   -moz-transform: translateY(0);
				    -ms-transform: translateY(0);
				     -o-transform: translateY(0);
				        transform: translateY(0);
			} #fourk" . self::$iconId . " .fourk-icon.hovered i {
				color: {$atts['icon_color']};
			}";
		} else if ( $atts['hover_effect'] == 'border-solid' ) {
			$ret .= "#fourk" . self::$iconId . " .fourk-icon.hovered:after {
				box-shadow: inset 0 0 0 " . ( (int)$atts['shape_size'] / 1.9 ) . "px " . $atts['shape_color'] . ";
			} #fourk" . self::$iconId . " .fourk-icon.hovered i {
				color: {$atts['icon_color']};
			}";
		}

		// Floats & margins
		if ( $atts['float'] != 'none' ) {
			$margin = 'right';
			if ( $atts['float'] == 'right' ) {
				$margin = 'left';
			}
			$ret .= "#fourk" . self::$iconId . " {
				float: {$atts['float']};
				margin-{$margin}: {$atts['margin']}px;
			}";
		} else {
			$ret .= "#fourk" . self::$iconId . " {
				margin-bottom: {$atts['margin']}px;
			}";
		}

		// Overflow
		if ( $atts['overflow_next'] == 'overflow' ) {
			$ret .= "#fourk" . self::$iconId . " + * {
				overflow: hidden;
			}";
		}

		// Link
		if ( ! empty( $atts['link'] ) ) {
			$ret .= "#fourk" . self::$iconId . " .fourk-icon, #fourk" . self::$iconId . " .fourk-icon + * {
				cursor: pointer;
			}";
		}

		$ret .= "</style>";

		// Compress styles a bit for readability
		$ret = preg_replace( "/\s?(\{|\})\s?/", "$1",
			preg_replace( "/\s+/", " ",
			str_replace( "\n", "", $ret ) ) )
			. "\n";

		/*
		 * Link
		 */
		if ( ! empty( $atts['link'] ) ) {
			$target = '_self';
			if ( $atts['link_new_window'] == 'new_window' ) {
				$target = '_blank';
			}
			$ret .= "<script>
				jQuery(document).ready(function(\$) {
					'use strict';
					\$('#fourk" . self::$iconId . " .fourk-icon, #fourk" . self::$iconId . " .fourk-icon + *').click(function() {
						window.open('" . esc_url( $atts['link'] ) . "', '" . $target . "');
					});
				})
			</script>";
		}


		/*
		 * Add the necessary html
		 */

		$ret .= "<div id='fourk" . self::$iconId . "' class='fourk-icon-container'>";

		// Put everything in a container for the flip effect
		if ( stripos( $atts['hover_effect'], 'flip-' ) !== false ) {
			$ret .= "<div class='fourk-flip-container'>";
		}

		$ret .= "<div class='" . implode( ' ', $divClasses ) . "' data-hover-trigger='" . $atts['hover_on'] . "' " . implode( ' ', $dataAttributes ) . ">";

		$ret .= "<i class='" . $atts['icon'] . "'></i>";

		if ( stripos( $atts['hover_effect'], 'swipe-' ) !== false ) {
			$ret .= "<div class='swipe'><i class='" . $atts['icon'] . "'></i></div>";
		}

		$ret .= "</div>";

		// Add a new element for the flip effect
		if ( stripos( $atts['hover_effect'], 'flip-' ) !== false ) {
			$ret .= "<div class='back'><i class='" . $atts['icon'] . "'></i></div>";
			$ret .= "</div>";
		}

		$ret .= "</div>";

		self::$iconId++;

		return $ret;
	}

	private function hex2rgb($hex) {
	   $hex = str_replace("#", "", $hex);

	   if(strlen($hex) == 3) {
	      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
	      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
	      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
	   } else {
	      $r = hexdec(substr($hex,0,2));
	      $g = hexdec(substr($hex,2,2));
	      $b = hexdec(substr($hex,4,2));
	   }
	   $rgb = array($r, $g, $b);
	   return $rgb; // returns an array with the rgb values
	}
}
new FourKIconShortcode();
