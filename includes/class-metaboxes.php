<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
	}
if ( ! class_exists( 'Wol_Box_Metaboxes' ) ){
	
	/**
	 * Wol_Box_Metaboxes class.
	 */
	class Wol_Box_Metaboxes{
		
		/**
		 * options
		 * 
		 * @var mixed
		 * @access private
		 */
		private $options;
		
		/**
		 * __construct function.
		 * 
		 * @access public
		 * @return void
		 */
		public function __construct(){
			
			 $this->options = get_option( 'wol_cpt_option' );
			 
			 add_action( 
			 	'add_meta_boxes', 
			 	array(
			 		$this,
			 		'wol_box_meta_boxes'
			 ) );
		}
		
		/**
		 * wol_box_meta_boxes function.
		 * 
		 * @access public
		 * @return void
		 */
		public function wol_box_meta_boxes() {
			if ( ! empty( $this->options['cpt'] ) && is_array( $this->options['cpt'] ) ){
				
				foreach ( $this->options['cpt'] as $cpt ){
					
					add_meta_box( 'wol-box-cpt', __( 'Build your info box', 'wol-info-boxes' ), array( $this, 'wol_box_display_callback' ), sanitize_text_field( $cpt ) );
				}
			
			}
		}

		
		/**
		 * wol_box_display_callback function.
		 * 
		 * @access public
		 * @param mixed $post
		 * @return void
		 */
		public function wol_box_display_callback( $post ) { ?>
		
			<div class="wrap">
			
				<?php echo wolinfoboxes()->build_box->build_box(); ?>
			</div>
		
		<?php
		}
	}
}