<?php
	
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
	}

if ( ! class_exists( 'Wol_Shortcodes' ) ){
	
	/**
	 * Wol_Shortcodes class.
	 */
	class Wol_Shortcodes {
		
		/**
		 * option
		 * 
		 * @var mixed
		 * @access private
		 */
		private $option;
		
		/**
		 * __construct function.
		 * 
		 * @access public
		 * @return void
		 */
		public function __construct(){
			
			add_shortcode('wolbox', array( $this, 'box' ) );
			
			$this->option = get_option( 'wol_info_boxes_option' );
		}
		
		/**
		 * box function.
		 * 
		 * 
		 * @access public
		 * @param mixed $atts
		 * @param mixed $content (default: null)
		 * @return $html
		 */
		public function box( $atts, $content = null ) {
			
			$html = '';
			
			/**
			 * atts
			 * 
			 * type value: wol-info wol-alert wol-bullhorn wol-notice standard wol-info
			 * style value wol-rounded or empty standard wol-rounded ( border radius 25px)
			 * border value wol-no-border or wol-border wol-mixed-border standard wol-no-border if wol border background color and color are inverted and a 2px border appear
			 * position value left or right standard left
			 * @var mixed
			 * @access public
			 */
			$atts = shortcode_atts(
				array(
				    'type' 		=> 'wol-info',
				    'style' 	=> 'wol-rounded',
				    'border'	=> 'wol-no-border',
				    'position'	=> 'left',
				), $atts, 'wolbox' );
			
			if ( 'right' != $atts['position'] ){
				
				$atts['position'] = 'left';
			}
						
			
	
			$fa_info 		= ( isset( $this->option['fa_info'] )  && ! empty(  $this->option['fa_info'] ) ) ?
				 wp_kses_post( $this->option['fa_info'] ):
				'<i class="fas fa-info-circle"></i>';
				
			$fa_alert 		= ( isset( $this->option['fa_alert'] )  && ! empty( $this->option['fa_alert'] ) ) ?
				wp_kses_post( $this->option['fa_alert'] ):
				'<i class="fas fa-exclamation-triangle"></i>';
				
			$fa_bullhorn 	= ( isset( $this->option['fa_bullhorn'] )  && ! empty(  $this->option['fa_bullhorn'] ) ) ?
				wp_kses_post( $this->option['fa_bullhorn'] ):
				'<i class="fas fa-bullhorn"></i>';
				
			$fa_notice		= ( isset( $this->option['fa_notice'] )  && ! empty(  $this->option['fa_notice'] ) ) ?
				 wp_kses_post( $this->option['fa_notice'] ):
				'<i class="fas fa-bell"></i>';
			/**
			 * class
			 * 
			 * (default value: $atts['type'] . ' ' . $atts['style'] . ' ' . $atts['border'])
			 * 
			 * @var string
			 * @access public
			 */
			$class = $atts['type'] . ' ' . $atts['style'] . ' ' . $atts['border'];
			
			switch ( $atts['type'] ) {
				case 'wol-info':
					$fas = $fa_info;		
				break;
				case 'wol-alert':
					$fas =  $fa_alert;		
				break;
				case 'wol-bullhorn':
					$fas =$fa_bullhorn;
				break;
				case 'wol-notice':
					$fas = $fa_notice;
				break;

			}
			
			
			$html .= '<div class="wol-box ' . $class . ' ">';
			
				if ( 'left' == $atts['position'] ){
					$html .= '<div class="wol-icon">';
						$html .= $fas;
					$html .= '</div>';
					$html .= '<div class="wol-box-content">';
						$html .= $content;
					$html .= '</div>';
					
					} else {
						$html .= '<div class="wol-box-content">';
							$html .= $content;
						$html .= '</div>';
						$html .= '<div class="wol-icon">';
							$html .= $fas;
						$html .= '</div>';
				} 	
			$html .= '</div>';
						
			return $html;
			
		}
		
	}
}