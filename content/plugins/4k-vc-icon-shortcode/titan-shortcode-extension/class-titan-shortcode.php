<?php

/**
 * Titan Framework Shortcode
 * Features:
 * 	Easier shortcode creation
 *	Automatic Visual Composer integration
 *	Will not overwrite existing shortcodes
 *	Automatic dropdown inclusion in the TinyMCE visual editor
 *
 * @author Benjamin Intal
 * @version 1.0.2
 * @copyright Benjamin Intal & Gambit, 25 February, 2014
 * @package TitanFramework Shortcode
 **/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'TitanFrameworkShortcode' ) ) {

	/**
	 * Titan Framework Shortcode Class
	 *
	 * @since	1.0
	 **/
	class TitanFrameworkShortcode {

		const JS_SHORTCODE_VAR = '_titan_framework_shortcodes';

		private $defaultSettings = array(
			'tag' => 'myshortcode', // [tagname]
			'name' => '', // for VC, shortcode name
			'icon' => '', // for VC, url to your .png icon
			'category' => '', // for VC
			'desc' => '', // for VC, description below the name in the VC selection box
			/*
			 * Attributes can either be a normal array containing attribute => default value pairs,
			 * or an associative array containing the values of $this->defaultAttributes
			*/
			'attributes' => array(),
			'function' => array( 'TitanFrameworkShortcode', 'genericShortcodeFunction' ), // callable
		);

		private $defaultAttributes = array(
			'default' => '', // default value
			'type' => 'text', // for VC, see http://kb.wpbakery.com/index.php?title=Vc_map for a list of all types, can also be some Titan types
			'options' => array(), // for VC, a list of value => label pairs IF the type is select
			'name' => '', // for VC, name of the attribute
			'desc' => '',
			'holder' => '',
			'dependency' => '',
		);

		// Hold the list of defined shortcodes
		public $shortcodes = array();

		// Only create a single instance of this class
		private static $instance;


		/**
		 * Get the singleton instance of TitanFrameworkShortcode
		 *
		 * @return	TitanFrameworkShortcode instance
		 * @since	1.0
		 **/
		public static function getInstance() {
			if ( empty( self::$instance ) ) {
				self::$instance = new TitanFrameworkShortcode();
			}
			return self::$instance;
		}


		/**
		 * Constructor
		 *
		 * @since	1.0
		 **/
		function __construct() {
			add_action( 'admin_head', array( $this, 'printDropDownStyle' ) );
			add_action( 'admin_head', array( $this, 'printShortcodes' ) );
			add_action( 'admin_head', array( $this, 'addTinyMCEDropDown' ) );
			add_action( 'admin_head', array( $this, 'printVisualComposerIcons' ) );
		}


		/**
		 * Prints the styles needed for Visual Composer, for icons
		 *
		 * @return	void
		 * @since	1.0
		 **/
		public function printVisualComposerIcons() {
			// Check if Visual Composer is installed
			if ( ! defined( 'WPB_VC_VERSION' ) || ! function_exists( 'wpb_map' ) ) {
				return;
			}

			echo "<style>";
			foreach ( $this->shortcodes as $shortcode ) {
				if ( empty( $shortcode['icon'] ) ) {
					continue;
				}

				// Add the icon for the element selection
				?>
				.wpb-content-layouts .wpb-layout-element-button .<?php echo TF . '-' . $shortcode['tag'] ?> {
					background-image: url(<?php echo esc_url( $shortcode['icon'] ) ?>);
					width: 16px;
					height: 16px;
					background-size: contain;
				}
				.wpb-content-layouts .wpb-layout-element-button .<?php echo TF . '-' . $shortcode['tag'] ?>.vc-element-icon {
					width: 32px;
					height: 32px;
				}
				<?php

				// Add the icon for the displayed element
				?>
				.wpb_<?php echo $shortcode['tag'] ?>.wpb_content_element > .wpb_element_wrapper {
					background-image: url(<?php echo esc_url( $shortcode['icon'] ) ?>);
				}
				<?php
			}
			echo "</style>";
		}


		/**
		 * Forms a string of a shortcode containing all the attributes
		 * with the default values
		 *
		 * @param	array $shortcode Settings array for a shortcode
		 * @return	string A shortcode string
		 * @since	1.0
		 **/
		private function formDefaultShortcode( $shortcode ) {
			$args = array();
			if ( is_array( $shortcode['attributes'] ) ) {
				foreach ( $shortcode['attributes'] as $attribute => $details ) {
					if ( is_array( $details ) ) {
						$details = array_merge( $this->defaultAttributes, $details );
						$args[] = sprintf( "%s='%s'",
							$attribute,
							htmlspecialchars( esc_attr( $details['default'] ) ) // Clean up the value for quotes
						);
					} else {
						$args[] = sprintf( "%s='%s'",
							$attribute,
							htmlspecialchars( esc_attr( $details ) ) // Clean up the value for quotes
						);
					}
				}
			}

			if ( count( $args ) ) {
				$args = ' ' . implode( ' ', $args );
			} else {
				$args = '';
			}

			return "[{$shortcode['tag']}{$args}]";
		}


		/**
		 * Prints the styles for the drop down in the visual editor
		 *
		 * @return	void
		 * @since	1.0
		 **/
		public function printDropDownStyle() {
			if ( ! count( $this->shortcodes ) ) {
				return;
			}

			?>
			<style>
			#content_<?php echo self::JS_SHORTCODE_VAR ?>_text {
				width: 110px;
			}
			</style>
			<?php
		}


		/**
		 * Prints the javascript for passing values to TinyMCE for
		 * the creation of the drop down list
		 *
		 * @return	void
		 * @since	1.0
		 **/
		public function printShortcodes() {
			if ( ! count( $this->shortcodes ) ) {
				return;
			}

			?>
			<script type="text/javascript">
				<?php
				// We need to check for undefined first so that we don't overwrite values
				// if multiple framework instances are used
				?>
				if ( typeof <?php echo self::JS_SHORTCODE_VAR ?> == 'undefined' ) {
					var <?php echo self::JS_SHORTCODE_VAR ?> = {};
				}
				<?php

				// Add our drop down label
				?>
				var <?php echo self::JS_SHORTCODE_VAR ?>_label = '<?php _e( 'Shortcodes', TF_I18NDOMAIN ) ?>';
				<?php

				// Define shortcodes as name => shortcode default pairs
				foreach ( $this->shortcodes as $shortcode ) {
					printf( '%s["%s"] = "%s";',
						self::JS_SHORTCODE_VAR,
						esc_attr( $shortcode['name'] ),
						$this->formDefaultShortcode( $shortcode )
					);
				}
				?>
			</script>
			<?php
		}


		/**
		 * Adds the drop down to TinyMCE
		 *
		 * @return	void
		 * @since	1.0
		 **/
		public function addTinyMCEDropDown() {
			if ( ! count( $this->shortcodes ) ) {
				return;
			}

			if ( ( current_user_can('edit_posts') || current_user_can('edit_pages') ) && get_user_option('rich_editing') ) {
				add_filter( 'mce_external_plugins', array( $this, 'addTinyMCEPlugin' ) );
				add_filter( 'mce_buttons', array( $this, 'addTinyMCEButton' ) );
			}
		}


		/**
		 * Adds the our shortcode drop down plugin to TinyMCE
		 *
		 * @param 	array $plugins a list of enabled plugins in TinyMCE
		 * @return	array TinyMCE plugins
		 * @since	1.0
		 **/
		public function addTinyMCEPlugin( $plugins ) {
			if ( empty( $plugins[ self::JS_SHORTCODE_VAR ] ) ) {
				$plugins[ self::JS_SHORTCODE_VAR ] = TitanFramework::getURL( 'admin-shortcodes.js', __FILE__ );
			}
			return $plugins;
		}


		/**
		 * Adds the drop down TinyMCE button
		 *
		 * @param 	array $buttons list of current buttons
		 * @return	array TinyMCE buttons
		 * @since	1.0
		 **/
		public function addTinyMCEButton( $buttons ) {
			array_push( $buttons, self::JS_SHORTCODE_VAR );
			return $buttons;
		}


		/**
		 * Adds our shortcodes to Visual Composer
		 *
		 * @param 	array $shortcode shortcode parameter array
		 * @return	void
		 * @since	1.0
		 **/
		private function addToVisualComposer( $shortcode ) {
			// Check if Visual Composer is installed
			if ( ! defined( 'WPB_VC_VERSION' ) || ! function_exists( 'wpb_map' ) ) {
				return;
			}
			if ( ! is_array( $shortcode['attributes'] ) ) {
				return;
			}

			$params = array();
			foreach ( $shortcode['attributes'] as $attribute => $details ) {
				// We need the detailed shortcode for VC to work properly
				if ( ! is_array( $details ) ) {
					return;
				}

				// Merge the default values
				$details = array_merge( $this->defaultAttributes, $details );

				// We standardize the type attribute with Titan's own type attribute
				// to make things easier. Convert it to VC's own types here
				$type = $details['type'];
				$default = $details['default'];

				if ( $type == 'text' ) {
					$type = 'textfield';
				} else if ( $type == 'select' || $type == 'dropdown' ) {
					$type = 'dropdown';
					$default = array();
					if ( ! empty( $details['options'] ) && is_array( $details['options'] ) ) {
						$default = $details['options'];
						// In VC, the keys are the labels, and the values are the value
						// We do the reverse in Titan, flip it but only for associative arrays
						if ( array_keys( $default ) !== range( 0, count( $default ) - 1 ) ) {
							$default = array_flip( $default );
						}
					}
				} else if ( $type == 'upload' || $type == 'image' ) {
					$type = 'attach_image';
				} else if ( $type == 'uploads' || $type == 'images' ) {
					$type = 'attach_images';
				} else if ( $type == 'color' ) {
					$type = 'colorpicker';
				} else {
					// same types with Titan:
					// checkbox
					// tetxarea
					// All other VC specific types will still work
				}

				$params[] = array(
					'type' => $type,
					'heading' => $details['name'],
					'param_name' => $attribute,
					'value' => $default,
					'description' => $details['desc'],
					'dependency' => $details['dependency'],
				);

				if ( ! empty( $details['holder'] ) ) {
					$params[ count($params) - 1 ]['holder'] = $details['holder'];
				}
			}

			// Register the shortcode
			wpb_map( array(
				"name" => $shortcode['name'],
				"base" => $shortcode['tag'],
				"icon" => TF . '-' . $shortcode['tag'],
				"description" => $shortcode['desc'],
				"params" => $params
			) );
		}


		/**
		 * Creates a shortcode
		 *
		 * @param 	array $settings shortcode parameter array
		 * @return	boolean	True if successfully created shortcode, false otherwise
		 * @since	1.0
		 **/
		public function createShortcode( $settings ) {
			// Add default settings
			$settings = array_merge( $this->defaultSettings, $settings );

			// Add default attributes (for the advanced usage only)
			if ( is_array( $settings['attributes'] ) ) {
				foreach ( $settings['attributes'] as $attribute => $details ) {
					if ( ! is_array( $value ) ) {
						break;
					}

					// Merge defaults
					$settings['attributes'][$key][$attribute] = array_merge( $this->defaultAttributes, $details );

					// make sure we have a name
					if ( empty( $details['name'] ) ) {
						$settings['attributes'][$key][$attribute]['name'] = $attribute;
					}
				}
			}

			if ( empty( $settings['tag'] ) ) {
				return false;
			}
			if ( empty( $settings['name'] ) ) {
				$settings['name'] = $settings['tag'];
			}

			// If the shortcode already exists, don't overwrite it
			if ( shortcode_exists( $settings['tag'] ) ) {
				return false;
			}

			// Check before adding the shortcode in our list
			foreach ( $this->shortcodes as $shortcode ) {
				if ( $shortcode['tag'] == $settings['tag'] ) {
					return false;
				}
			}

			// Take note of the new shortcode for future processes
			$this->shortcodes[] = $settings;

			// Add shortcode to Visual Composer
			$this->addToVisualComposer( $settings );

			// The our shortcode parse will add the shortcode to WP
			new TitanFrameworkShortcodeParser( $settings );

			return true;
		}


		/**
		 * A dummy shortcode handler, just in case nothing was supplied for the shortcode
		 *
		 * @param 	array $atts An array of shortcode attribute values
		 * @param	string $content the contents inside the shortcode
		 * @return	string rendered shortcode
		 * @since	1.0
		 **/
		public static function genericShortcodeFunction( $atts, $content ) {
			return $content;
		}
	}
}



if ( ! class_exists( 'TitanFrameworkShortcodeParser' ) ) {

	/**
	 * Titan Framework Shortcode Parser
	 *
	 * @since	1.0
	 **/
	class TitanFrameworkShortcodeParser {

		// Keep all the shortcode settings
		public $settings;


		/**
		 * Constructor
		 *
		 * @param 	array $settings shortcode settings array
		 * @return	void
		 * @since	1.0
		 **/
		function __construct( $settings ) {
			$this->settings = $settings;

			add_shortcode( $settings['tag'], array( $this, 'doShortcode' ) );
		}


		/**
		 * Returns an array of attributes along with their default values
		 *
		 * @return	array attributes with default values
		 * @since	1.0
		 **/
		private function getDefaultAttributes() {
			$defaults = array();
			if ( is_array( $this->settings['attributes'] ) ) {
				foreach ( $this->settings['attributes'] as $attribute => $details ) {
					if ( is_array( $details ) ) {
						$defaults[ $attribute ] = $details['default'];
					} else {
						$defaults[ $attribute ] = $details;
					}
				}
			}
			return $defaults;
		}


		/**
		 * Renders the shortcode, prepares the attributes then calls the
		 * function parameter of the shortcode
		 *
		 * @param 	array $atts An array of shortcode attribute values
		 * @param	string $content the contents inside the shortcode
		 * @return	string rendered shortcode
		 * @since	1.0
		 **/
		public function doShortcode( $atts, $content = '' ) {
			// Clean up attributes
			$atts = shortcode_atts( $this->getDefaultAttributes(), $atts, $this->settings['tag'] );

			// Call the callable normally
			return call_user_func( $this->settings['function'], $atts, $content );
		}
	}
}



if ( ! function_exists( 'titan_framework_init_shortcodes' ) ) {

	/**
	 * Initialize the shortcode class when Titan initializes
	 *
	 * @param 	TitanFramework $frameworkInstance the current framework instance being initialized (not used)
	 * @return	void
	 * @since	1.0
	 **/
    function titan_framework_init_shortcodes( $frameworkInstance ) {
        TitanFrameworkShortcode::getInstance();
    }
    add_action( 'tf_init', 'titan_framework_init_shortcodes' );
}

if ( ! function_exists( 'titan_framework_create_shortcode' ) ) {

	/**
	 * Handles the creation of shortcodes triggered from the framework
	 *
	 * @param 	array $settings shortcode settings array
	 * @return	void
	 * @since	1.0
	 **/
	function titan_framework_create_shortcode( $settings ) {
		$o = TitanFrameworkShortcode::getInstance();
		$o->createShortcode( $settings );
	}
	add_action( 'tf_create_shortcode', 'titan_framework_create_shortcode' );
}
