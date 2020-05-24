<?php
	
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
	}

if ( ! class_exists( 'Wol_Build_Box' ) ){
	
	/**
	 * Wol_Build_Box class.
	 */
	class Wol_Build_Box{
		
		
		/**
		 * __construct function.
		 * 
		 * @access public
		 * @return void
		 */
		public function __construct(){
			
			// Enqueue general scripts and styles in admin
			add_action( 'admin_enqueue_scripts', array(
				$this,
				'enqueue_admin_script_and_style'
			) );

			// Enqueue general scripts and styles in frontend
			add_action( 'wp_enqueue_scripts', array(
				$this,
				'enqueue_frontend_script_and_style'
			) );

			
			add_shortcode( 'wol-build-box', 
				array( 
				$this,
				'build_box' 
			) );
		}
		
		/**
		 * build_box function.
		 * 
		 * @access public
		 * @return void
		 */
		public function build_box(){
			
			$html = '';
			
		
			
				$html .= '<div class="wol-admin-box">';
					$html .= '<div class="wol-admin-radio">';
					
						$html .= '<div>' . __( 'Select Macro type', 'wol-info-boxes' ) . '</div>';
						$html .= '<div class="radio-group">';
							$html .= '<input id="info" type="radio" value="wol-info" name="macro"/><label for="info">' . __( 'Info', 'wol-info-boxes' ) . '</label>';
							$html .= '<input id="notice" type="radio" value="wol-notice" name="macro"/><label for="notice">' . __( 'Notice', 'wol-info-boxes' ) . '</label>';
							$html .= '<input id="announce" type="radio" value="wol-bullhorn" name="macro"/><label for="announce">' . __( 'Announce', 'wol-info-boxes' ) . '</label>';
							$html .= '<input id="alert" type="radio" value="wol-alert" name="macro"/><label for="alert">' . __( 'Alert', 'wol-info-boxes' ) . '</label>';
						$html .= '</div>';
						
						$html .= '<div>' . __( 'Select Style', 'wol-info-boxes' ) . '</div>';
						$html .= '<div class="radio-group">';
							$html .= '<input id="noborder" type="radio" value="" name="style"/><label for="noborder">' . __( 'No border', 'wol-info-boxes' ) . '</label>';
							$html .= '<input id="border" type="radio" value="wol-border" name="style"/><label for="border">' . __( 'Border', 'wol-info-boxes' ) . '</label>';
							$html .= '<input id="borderbackground" type="radio" value="wol-mixed-border" name="style"/><label for="borderbackground">' . __( 'Border and background', 'wol-info-boxes' ) . '</label>';
						$html .= '</div>';
						
						$html .= '<div>' . __( 'Select Border Type', 'wol-info-boxes' ) . '</div>';
						$html .= '<div class="radio-group">';
							$html .= '<input id="square" type="radio" value="" name="border"/><label for="square">' . __( 'Square', 'wol-info-boxes' ) . '</label>';
							$html .= '<input id="rounded" type="radio" value="wol-rounded" name="border"/><label for="rounded">' . __( 'Rounded', 'wol-info-boxes' ) . '</label>';
						$html .= '</div>';
						
						$html .= '<div>' . __( 'Select Icon Position', 'wol-info-boxes' ) . '</div>';
						$html .= '<div class="radio-group">';
							$html .= '<input id="left" type="radio" value="left" name="position"/><label for="left">' . __( 'Left', 'wol-info-boxes' ) . '</label>';
							$html .= '<input id="right" type="radio" value="right" name="position"/><label for="right">' . __( 'right', 'wol-info-boxes' ) . '</label>';
						$html .= '</div>';
					$html .= '</div>';
					
					
					$html .= '<div class="wol-admin-shortcode">';
						$html .= '<div>';
							$html .= '[wolbox type="<span class="macro"></span>" style="<span class="style"></span>" border="<span class="border"></span>" position="<span class="position"></span>"]' . __( 'Your text here...', 'wol-info-boxes' ) . '[/wolbox]';
							$html .= '</div>';
					$html .= '</div>';
			
				$html .= '</div>';
			return $html;
			
		}
		
		/**
		 * enqueue_admin_script_and_style function.
		 * 
		 * @access public
		 * @param mixed $hook
		 * @return void
		 */
		public function enqueue_admin_script_and_style( $hook ) {

			wp_register_script( 'wol-build-box', WOL_UTI_PLUGIN_URL . 'assets/js/wol.build.box.js', array( 'jquery' ), '1.0.0', TRUE );
			wp_enqueue_script( 'wol-build-box' );
			
		}
		
		/**
		 * enqueue_frontend_script_and_style function.
		 * 
		 * @access public
		 * @param mixed $hook
		 * @return void
		 */
		public function enqueue_frontend_script_and_style( $hook ) {

			wp_register_script( 'wol-build-box', WOL_UTI_PLUGIN_URL . 'assets/js/wol.build.box.js', array( 'jquery' ), '1.0.0', TRUE );
			wp_enqueue_script( 'wol-build-box' );

			
		}
		
		
	}
	
	
}