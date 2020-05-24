<?php
	
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
	}

if ( ! class_exists( 'Wol_Custom_Css' ) ){	
	
	/**
	 * Wol_Custom_Css class.
	 */
	class Wol_Custom_Css{
			
	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct(){
		
		add_action( 'wp_enqueue_scripts', array(
				$this,
				'custom_css'
			) );

	}
		
	
	/**
	 * custom_css function.
	 * 
	 * @access public
	 * @return void
	 */
	public function custom_css(){
		
		wp_register_style( 'wol-utility-css', WOL_UTI_PLUGIN_URL . 'assets/css/wolly-box-frontend.css' );
		wp_enqueue_style( 'wol-utility-css' );

		$options = get_option( 'wol_info_boxes_option' );
	
		
	
		$standard = array (
			
			'border_radius'								=> (int)27,
			'info_color_no_bkg' 						=> '#03ad00',
			'info_border_color_no_bkg' 					=> '#03ad00',
			'info_color_colored_bkg' 					=> '#000000',
			'info_bckg_color_colored_bkg' 				=> '#cfc',
			'info_border_color_colored_bkg' 			=> '#03ad00',
			'info_color_colored_bkg_no_border' 			=> '#ffffff',
			'info_bckg_color_colored_bkg_no_border' 	=> '#03ad00',
			
			'alert_color_no_bkg' 						=> '#ff0000',
			'alert_border_color_no_bkg' 				=> '#ff0000',
			'alert_color_colored_bkg' 					=> '#000000',
			'alert_bckg_color_colored_bkg' 				=> '#ffcccc',
			'alert_border_color_colored_bkg' 			=> '#ff0000',
			'alert_color_colored_bkg_no_border' 		=> '#ffffff',
			'alert_bckg_color_colored_bkg_no_border' 	=> '#ff0000',
			
			
			'bullhorn_color_no_bkg' 					=> '#0000FF',
			'bullhorn_border_color_no_bkg' 				=> '#0000FF',
			'bullhorn_color_colored_bkg' 				=> '#000000',
			'bullhorn_bckg_color_colored_bkg' 			=> '#bdeaff',
			'bullhorn_border_color_colored_bkg' 		=> '#0000FF',
			'bullhorn_color_colored_bkg_no_border' 		=> '#ffffff',
			'bullhorn_bckg_color_colored_bkg_no_border' => '#0000FF',
			
			'notice_color_no_bkg' 						=> '#FFA500',
			'notice_border_color_no_bkg' 				=> '#FFA500',
			'notice_color_colored_bkg' 					=> '#000000',
			'notice_bckg_color_colored_bkg' 			=> '#FFDB99',
			'notice_border_color_colored_bkg' 			=> '#FFA500',
			'notice_color_colored_bkg_no_border' 		=> '#ffffff',
			'notice_bckg_color_colored_bkg_no_border' 	=> '#FFA500',	
		);
	
		$new_standard = array_merge( $standard, $options );
		
		$border_radius = ( isset( $new_standard['border_radius'] ) && ! empty( $new_standard['border_radius'] ) ) ?
			$new_standard['border_radius'] :
			(int)27;
		/*
		 * INFO COLORS
		 *
		 */
		$info_color_no_bkg = ( isset( $new_standard['info_color_no_bkg'] ) && ! empty( $new_standard['info_color_no_bkg'] ) ) ?
			$new_standard['info_color_no_bkg'] :
			'#03ad00';
		$info_border_color_no_bkg = ( isset( $new_standard['info_border_color_no_bkg'] ) && ! empty( $new_standard['info_border_color_no_bkg'] ) ) ?
			$new_standard['info_border_color_no_bkg'] :
			'#03ad00';

		
		$info_color_colored_bkg = ( isset( $new_standard['info_color_colored_bkg'] ) && ! empty( $new_standard['info_color_colored_bkg'] ) ) ?
			$new_standard['info_color_colored_bkg'] :
			'#000000';
		$info_bckg_color_colored_bkg = ( isset( $new_standard['info_bckg_color_colored_bkg'] ) && ! empty( $new_standard['info_bckg_color_colored_bkg'] ) ) ?
			$new_standard['info_bckg_color_colored_bkg'] :
			'#cfc';
		$info_border_color_colored_bkg = ( isset( $new_standard['info_border_color_colored_bkg'] ) && ! empty( $new_standard['info_border_color_colored_bkg'] ) ) ?
			$new_standard['info_border_color_colored_bkg'] :
			'#03ad00';
			
			
		$info_color_colored_bkg_no_border = ( isset( $new_standard['info_color_colored_bkg_no_border'] ) && ! empty( $new_standard['info_color_colored_bkg_no_border'] ) ) ?
			$new_standard['info_color_colored_bkg_no_border'] :
			'#ffffff';
			
		$info_bckg_color_colored_bkg_no_border = ( isset( $new_standard['info_bckg_color_colored_bkg_no_border'] ) && ! empty( $new_standard['info_bckg_color_colored_bkg_no_border'] ) ) ?
			$new_standard['info_bckg_color_colored_bkg_no_border'] :
			'#03ad00';
		
		/*
		 * ALERT COLORS
		 *
		 */
		
		$alert_color_no_bkg = ( isset( $new_standard['alert_color_no_bkg'] ) && ! empty( $new_standard['alert_color_no_bkg'] ) ) ?
			$new_standard['alert_color_no_bkg'] :
			'#ff0000';
		$alert_border_color_no_bkg = ( isset( $new_standard['alert_border_color_no_bkg'] ) && ! empty( $new_standard['alert_border_color_no_bkg'] ) ) ?
			$new_standard['alert_border_color_no_bkg'] :
			'#ff0000';

		
		$alert_color_colored_bkg = ( isset( $new_standard['alert_color_colored_bkg'] ) && ! empty( $new_standard['alert_color_colored_bkg'] ) ) ?
			$new_standard['alert_color_colored_bkg'] :
			'#000000';
		$alert_bckg_color_colored_bkg = ( isset( $new_standard['alert_bckg_color_colored_bkg'] ) && ! empty( $new_standard['alert_bckg_color_colored_bkg'] ) ) ?
			$new_standard['alert_bckg_color_colored_bkg'] :
			'#ffcccc';
		$alert_border_color_colored_bkg = ( isset( $new_standard['alert_border_color_colored_bkg'] ) && ! empty( $new_standard['alert_border_color_colored_bkg'] ) ) ?
			$new_standard['alert_border_color_colored_bkg'] :
			'#ff0000';
			
			
		$alert_color_colored_bkg_no_border = ( isset( $new_standard['alert_color_colored_bkg_no_border'] ) && ! empty( $new_standard['alert_color_colored_bkg_no_border'] ) ) ?
			$new_standard['alert_color_colored_bkg_no_border'] :
			'#ffffff';
			
		$alert_bckg_color_colored_bkg_no_border = ( isset( $new_standard['alert_bckg_color_colored_bkg_no_border'] ) && ! empty( $new_standard['alert_bckg_color_colored_bkg_no_border'] ) ) ?
			$new_standard['alert_bckg_color_colored_bkg_no_border'] :
			'#ff0000';
		
		/*
		 * BULLHORN COLORS
		 *
		 */
		 
		 $bullhorn_color_no_bkg = ( isset( $new_standard['bullhorn_color_no_bkg'] ) && ! empty( $new_standard['bullhorn_color_no_bkg'] ) ) ?
			$new_standard['bullhorn_color_no_bkg'] :
			'#0000FF';
		$bullhorn_border_color_no_bkg = ( isset( $new_standard['bullhorn_border_color_no_bkg'] ) && ! empty( $new_standard['bullhorn_border_color_no_bkg'] ) ) ?
			$new_standard['bullhorn_border_color_no_bkg'] :
			'#0000FF';

		
		$bullhorn_color_colored_bkg = ( isset( $new_standard['bullhorn_color_colored_bkg'] ) && ! empty( $new_standard['bullhorn_color_colored_bkg'] ) ) ?
			$new_standard['bullhorn_color_colored_bkg'] :
			'#000000';
		$bullhorn_bckg_color_colored_bkg = ( isset( $new_standard['bullhorn_bckg_color_colored_bkg'] ) && ! empty( $new_standard['bullhorn_bckg_color_colored_bkg'] ) ) ?
			$new_standard['bullhorn_bckg_color_colored_bkg'] :
			'#bdeaff';
		$bullhorn_border_color_colored_bkg = ( isset( $new_standard['bullhorn_border_color_colored_bkg'] ) && ! empty( $new_standard['bullhorn_border_color_colored_bkg'] ) ) ?
			$new_standard['bullhorn_border_color_colored_bkg'] :
			'#0000FF';
			
			
		$bullhorn_color_colored_bkg_no_border = ( isset( $new_standard['bullhorn_color_colored_bkg_no_border'] ) && ! empty( $new_standard['bullhorn_color_colored_bkg_no_border'] ) ) ?
			$new_standard['bullhorn_color_colored_bkg_no_border'] :
			'#ffffff';
			
		$bullhorn_bckg_color_colored_bkg_no_border = ( isset( $new_standard['bullhorn_bckg_color_colored_bkg_no_border'] ) && ! empty( $new_standard['bullhorn_bckg_color_colored_bkg_no_border'] ) ) ?
			$new_standard['bullhorn_bckg_color_colored_bkg_no_border'] :
			'#0000FF';

		/*
		 * NOTICE COLORS
		 *
		 */
		 
		$notice_color_no_bkg = ( isset( $new_standard['notice_color_no_bkg'] ) && ! empty( $new_standard['notice_color_no_bkg'] ) ) ?
			$new_standard['notice_color_no_bkg'] :
			'#FFA500';
		$notice_border_color_no_bkg = ( isset( $new_standard['notice_border_color_no_bkg'] ) && ! empty( $new_standard['notice_border_color_no_bkg'] ) ) ?
			$new_standard['notice_border_color_no_bkg'] :
			'#FFA500';

		
		$notice_color_colored_bkg = ( isset( $new_standard['notice_color_colored_bkg'] ) && ! empty( $new_standard['notice_color_colored_bkg'] ) ) ?
			$new_standard['notice_color_colored_bkg'] :
			'#000000';
		$notice_bckg_color_colored_bkg = ( isset( $new_standard['notice_bckg_color_colored_bkg'] ) && ! empty( $new_standard['notice_bckg_color_colored_bkg'] ) ) ?
			$new_standard['notice_bckg_color_colored_bkg'] :
			'#FFDB99';
		$notice_border_color_colored_bkg = ( isset( $new_standard['notice_border_color_colored_bkg'] ) && ! empty( $new_standard['notice_border_color_colored_bkg'] ) ) ?
			$new_standard['notice_border_color_colored_bkg'] :
			'#FFA500';
			
			
		$notice_color_colored_bkg_no_border = ( isset( $new_standard['notice_color_colored_bkg_no_border'] ) && ! empty( $new_standard['notice_color_colored_bkg_no_border'] ) ) ?
			$new_standard['notice_color_colored_bkg_no_border'] :
			'#ffffff';
			
		$notice_bckg_color_colored_bkg_no_border = ( isset( $new_standard['notice_bckg_color_colored_bkg_no_border'] ) && ! empty( $new_standard['notice_bckg_color_colored_bkg_no_border'] ) ) ?
			$new_standard['notice_bckg_color_colored_bkg_no_border'] :
			'#FFA500';
 
		 
		 
		 
		/**
		 * new_css
		 * 
		 * (default value: '')
		 * 
		 * @var string
		 * @access public
		 */
		$new_css = '';
		
		$new_css .= '.wol-rounded { border-radius: ' . $border_radius . 'px; }';
		/*
		 * CSS for INFO BOX
		 *
		 */

		$new_css .= '.wol-info.wol-border { background-color: #ffffff; color: ' . $info_color_no_bkg . '; border: solid ' . $info_border_color_no_bkg . ' 2px; }';
		$new_css .= '.wol-info.wol-mixed-border { background-color: ' . $info_bckg_color_colored_bkg . '; color: ' . $info_color_colored_bkg . '; border: solid ' . $info_border_color_colored_bkg . ' 2px; }
			.wol-info.wol-mixed-border .wol-icon .fas { color: ' . $info_border_color_colored_bkg . '; }';
		
		$new_css .= '.wol-info{ background-color: ' . $info_bckg_color_colored_bkg_no_border . '; color: ' . $info_color_colored_bkg_no_border . '; }';
		
		/*
		 * CSS for ALERT BOX
		 *
		 */
		$new_css .= '.wol-alert.wol-border { background-color: #ffffff; color: ' . $alert_color_no_bkg . '; border: solid ' . $alert_border_color_no_bkg . ' 2px; }';
		$new_css .= '.wol-alert.wol-mixed-border { background-color: ' . $alert_bckg_color_colored_bkg . '; color: ' . $alert_color_colored_bkg . '; border: solid ' . $alert_border_color_colored_bkg . ' 2px; }
			.wol-alert.wol-mixed-border .wol-icon .fas { color: ' . $alert_border_color_colored_bkg . '; }';
		
		$new_css .= '.wol-alert{ background-color: ' . $alert_bckg_color_colored_bkg_no_border . '; color: ' . $alert_color_colored_bkg_no_border . '; }';
		
		
		/*
		 * CSS for BULLHORN BOX
		 *
		 */
		 
		$new_css .= '.wol-bullhorn.wol-border { background-color: #ffffff; color: ' . $bullhorn_color_no_bkg . '; border: solid ' . $bullhorn_border_color_no_bkg . ' 2px; }';
		$new_css .= '.wol-bullhorn.wol-mixed-border { background-color: ' . $bullhorn_bckg_color_colored_bkg . '; color: ' . $bullhorn_color_colored_bkg . '; border: solid ' . $bullhorn_border_color_colored_bkg . ' 2px; }
			.wol-bullhorn.wol-mixed-border .wol-icon .fas { color: ' . $bullhorn_border_color_colored_bkg . '; }';
		
		$new_css .= '.wol-bullhorn{ background-color: ' . $bullhorn_bckg_color_colored_bkg_no_border . '; color: ' . $bullhorn_color_colored_bkg_no_border . '; }';
		
		/*
		 * CSS for NOTICE BOX
		 *
		 */
		$new_css .= '.wol-notice.wol-border { background-color: #ffffff; color: ' . $notice_color_no_bkg . '; border: solid ' . $notice_border_color_no_bkg . ' 2px; }';
		$new_css .= '.wol-notice.wol-mixed-border { background-color: ' . $notice_bckg_color_colored_bkg . '; color: ' . $notice_color_colored_bkg . '; border: solid ' . $notice_border_color_colored_bkg . ' 2px; }
			.wol-notice.wol-mixed-border .wol-icon .fas { color: ' . $notice_border_color_colored_bkg . '; }';
		
		$new_css .= '.wol-notice{ background-color: ' . $notice_bckg_color_colored_bkg_no_border . '; color: ' . $notice_color_colored_bkg_no_border . '; }';
 
		 
		 
		wp_add_inline_style( 'wol-utility-css', $new_css );
    			
	}
	
	}
}
	
