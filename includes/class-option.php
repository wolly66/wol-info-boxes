<?php
	
class Wol_Shortcode_Option
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;
    
    private $options_cpt;

    /**
     * Start up
     */
    public function __construct()
    {
        
         add_action( 
        	'admin_menu', 
        	array( 
        	$this, 
        	'create_wol_box_menu_page' 
        ) );
        add_action( 
        	'admin_init', 
        	array( 
        	$this, 
        	'page_init' 
        ) );
        
        add_action( 
        	'admin_init', 
        	array( 
        	$this, 
        	'page_init_cpt' 
        ) );
        
        add_action( 
        	'admin_enqueue_scripts',
        	array(
        	$this, 
        	'wol_option_backend_scripts'
        ) );
    }

    	
	public function create_wol_box_menu_page(){
	
		add_menu_page( 'wol-info-boxes', 'Wol Info Box', 'manage_options', 'wol-info-boxes' , array( $this, 'render_wol_info_boxes' ), 'dashicons-info', 81 );
		
		add_submenu_page( 'wol-info-boxes', __( 'Box Builder', 'wol-info-boxes' ), __( 'Box Builder', 'wol-info-boxes' ), 'manage_options', 'wol-box-builder', array( $this,  'build_boxes' ) );
		
		add_submenu_page( 'wol-info-boxes', __( 'Choose post type', 'wol-info-boxes' ), __( 'Choose post type', 'wol-info-boxes' ), 'manage_options', 'wol-box-cpt', array( $this,  'choose_cpt' ) );
	}
	
	public function render_wol_info_boxes(){
		
		// Set class property
        $this->options = get_option( 'wol_info_boxes_option' );
        ?>
        <div class="wrap">
            <h2><?php _e( 'Wol Info Boxes', 'wol-info-boxes' ); ?></h2>           
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'wol_shortcode_option_group' );   
                do_settings_sections( 'wol-info-boxes' );
                submit_button(); 
            ?>
            </form>
        </div>
        <?php
	}
	
	public function build_boxes(){
		?>
		
		<div class="wrap">
			
			<h2><?php echo get_admin_page_title(); ?></h2>
			
			<?php echo wolinfoboxes()->build_box->build_box(); ?>
		</div>
		
		<?php
	}
	
	public function choose_cpt(){
		// Set class property
        $this->options_cpt = get_option( 'wol_cpt_option' );
        ?>
        <div class="wrap">
            <h2><?php _e( 'Choose post type', 'wol-info-boxes' ); ?></h2>           
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'wol_cpt_option_group' );   
                do_settings_sections( 'wol-box-cpt' );
                submit_button(); 
            ?>
            </form>
        </div>
        
		
		<?php
	}
	
	public function page_init_cpt()
    {        
        register_setting(
            'wol_cpt_option_group', // Option group
            'wol_cpt_option', // Option name
            array( $this, 'sanitize_cpt' ) // Sanitize
        );
		
		/*
		 * GENERAL SECTION
		 *
		 */
		 add_settings_section(
            'cpt_section_id', // ID
            __( 'CPT settings', 'wol-info-boxes' ), // Title
            array( $this, 'print_cpt_section_info' ), // Callback
            'wol-box-cpt' // Page
        );  

        add_settings_field(
            'choose_cpt', // ID
            __( 'CPTs', 'wol-info-boxes' ), // Title 
            array( $this, 'cpts_callback' ), // Callback
            'wol-box-cpt', // Page
            'cpt_section_id' // Section           
        );      

    }
    
    /**
     * Register and add settings
     */
    public function page_init()
    {        
        register_setting(
            'wol_shortcode_option_group', // Option group
            'wol_shortcode_option', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );
		
		/*
		 * GENERAL SECTION
		 *
		 */
		 add_settings_section(
            'general_section_id', // ID
            __( 'General settings', 'wol-info-boxes' ), // Title
            array( $this, 'print_general_section_info' ), // Callback
            'wol-info-boxes' // Page
        );  

        add_settings_field(
            'border_radius', // ID
            __( 'Border radius', 'wol-info-boxes' ), // Title 
            array( $this, 'border_radius_callback' ), // Callback
            'wol-info-boxes', // Page
            'general_section_id' // Section           
        );      

        add_settings_field(
            'info_fa', 
            __( 'Font Awesome for INFO', 'wol-info-boxes' ), 
            array( $this, 'fa_info_callback' ), 
            'wol-info-boxes', 
            'general_section_id'
        );  
        
        add_settings_field(
            'alert_fa', 
            __( 'Font Awesome for ALERT', 'wol-info-boxes' ), 
            array( $this, 'fa_alert_callback' ), 
            'wol-info-boxes', 
            'general_section_id'
        );  
        
        add_settings_field(
            'bullhorn_fa', 
            __( 'Font Awesome for BULLHORN', 'wol-info-boxes' ), 
            array( $this, 'fa_bullhorn_callback' ), 
            'wol-info-boxes', 
            'general_section_id'
        );
        
        add_settings_field(
            'notice_fa', 
            __( 'Font Awesome for NOTICE', 'wol-info-boxes' ), 
            array( $this, 'fa_notice_callback' ), 
            'wol-info-boxes', 
            'general_section_id'
        );  

		/*
		 * INFO SECTION
		 *
		 */
        add_settings_section(
            'info_white_bckg_section_id', // ID
            __( 'INFO for white background shortcode settings', 'wol-info-boxes' ), // Title
            array( $this, 'print_info_section_info' ), // Callback
            'wol-info-boxes' // Page
        );  

        add_settings_field(
            'info_color_no_bkg', // ID
            __( 'Text color for white background', 'wol-info-boxes' ), // Title 
            array( $this, 'info_color_no_bkg_callback' ), // Callback
            'wol-info-boxes', // Page
            'info_white_bckg_section_id' // Section           
        );      

        add_settings_field(
            'info_border_color_no_bkg', 
            __( 'Border color for white background', 'wol-info-boxes' ), 
            array( $this, 'info_border_color_no_bkg_callback' ), 
            'wol-info-boxes', 
            'info_white_bckg_section_id'
        );  
        
         add_settings_section(
            'info_colored_bckg_section_id', // ID
            __( 'INFO for colored background WITH border shortcode settings', 'wol-info-boxes' ), // Title
            array( $this, 'print_info_colored_section_info' ), // Callback
            'wol-info-boxes' // Page
        );  

        add_settings_field(
            'info_color_no_bkg', // ID
            __( 'Text color for colored background', 'wol-info-boxes' ), // Title 
            array( $this, 'info_color_colored_bkg_callback' ), // Callback
            'wol-info-boxes', // Page
            'info_colored_bckg_section_id' // Section           
        );  
        
        add_settings_field(
            'info_bckg_color_no_bkg', // ID
            __( 'Background color for colored background', 'wol-info-boxes' ), // Title 
            array( $this, 'info_bckg_color_colored_bkg_callback' ), // Callback
            'wol-info-boxes', // Page
            'info_colored_bckg_section_id' // Section           
        );     

        add_settings_field(
            'info_border_color_no_bkg', 
            __( 'Border color for colored background', 'wol-info-boxes' ), 
            array( $this, 'info_border_color_colored_bkg_callback' ), 
            'wol-info-boxes', 
            'info_colored_bckg_section_id'
        );  
        
        add_settings_section(
            'info_colored_bckg_no_border_section_id', // ID
            __( 'INFO for colored background WITHOUT BORDER shortcode settings', 'wol-info-boxes' ), // Title
            array( $this, 'print_info_colored_no_border_section_info' ), // Callback
            'wol-info-boxes' // Page
        );  

        add_settings_field(
            'info_color_no_bkg', // ID
            __( 'Text color for colored background WITHOUT BORDER', 'wol-info-boxes' ), // Title 
            array( $this, 'info_color_colored_bkg_no_border_callback' ), // Callback
            'wol-info-boxes', // Page
            'info_colored_bckg_no_border_section_id' // Section           
        );  
        
        add_settings_field(
            'info_bckg_color_no_bkg', // ID
            __( 'Background color for colored background WITHOUT BORDER', 'wol-info-boxes' ), // Title 
            array( $this, 'info_bckg_color_colored_bkg_no_border_callback' ), // Callback
            'wol-info-boxes', // Page
            'info_colored_bckg_no_border_section_id' // Section           
        );     
        
        /*
		 * ALERT SECTION
		 *
		 */
        add_settings_section(
            'alert_white_bckg_section_id', // ID
            __( 'alert for white background shortcode settings', 'wol-info-boxes' ), // Title
            array( $this, 'print_alert_section_alert' ), // Callback
            'wol-info-boxes' // Page
        );  

        add_settings_field(
            'alert_color_no_bkg', // ID
            __( 'Text color for white background', 'wol-info-boxes' ), // Title 
            array( $this, 'alert_color_no_bkg_callback' ), // Callback
            'wol-info-boxes', // Page
            'alert_white_bckg_section_id' // Section           
        );      

        add_settings_field(
            'alert_border_color_no_bkg', 
            __( 'Border color for white background', 'wol-info-boxes' ), 
            array( $this, 'alert_border_color_no_bkg_callback' ), 
            'wol-info-boxes', 
            'alert_white_bckg_section_id'
        );  
        
         add_settings_section(
            'alert_colored_bckg_section_id', // ID
            __( 'alert for colored background WITH border shortcode settings', 'wol-info-boxes' ), // Title
            array( $this, 'print_alert_colored_section_alert' ), // Callback
            'wol-info-boxes' // Page
        );  

        add_settings_field(
            'alert_color_no_bkg', // ID
            __( 'Text color for colored background', 'wol-info-boxes' ), // Title 
            array( $this, 'alert_color_colored_bkg_callback' ), // Callback
            'wol-info-boxes', // Page
            'alert_colored_bckg_section_id' // Section           
        );  
        
        add_settings_field(
            'alert_bckg_color_no_bkg', // ID
            __( 'Background color for colored background', 'wol-info-boxes' ), // Title 
            array( $this, 'alert_bckg_color_colored_bkg_callback' ), // Callback
            'wol-info-boxes', // Page
            'alert_colored_bckg_section_id' // Section           
        );     

        add_settings_field(
            'alert_border_color_no_bkg', 
            __( 'Border color for colored background', 'wol-info-boxes' ), 
            array( $this, 'alert_border_color_colored_bkg_callback' ), 
            'wol-info-boxes', 
            'alert_colored_bckg_section_id'
        );  
        
        add_settings_section(
            'alert_colored_bckg_no_border_section_id', // ID
            __( 'alert for colored background WITHOUT BORDER shortcode settings', 'wol-info-boxes' ), // Title
            array( $this, 'print_alert_colored_no_border_section_alert' ), // Callback
            'wol-info-boxes' // Page
        );  

        add_settings_field(
            'alert_color_no_bkg', // ID
            __( 'Text color for colored background WITHOUT BORDER', 'wol-info-boxes' ), // Title 
            array( $this, 'alert_color_colored_bkg_no_border_callback' ), // Callback
            'wol-info-boxes', // Page
            'alert_colored_bckg_no_border_section_id' // Section           
        );  
        
        add_settings_field(
            'alert_bckg_color_no_bkg', // ID
            __( 'Background color for colored background WITHOUT BORDER', 'wol-info-boxes' ), // Title 
            array( $this, 'alert_bckg_color_colored_bkg_no_border_callback' ), // Callback
            'wol-info-boxes', // Page
            'alert_colored_bckg_no_border_section_id' // Section           
        );     
   
		/*
		 *  BULLHORN SECTION
		 *
		 */
        add_settings_section(
            'bullhorn_white_bckg_section_id', // ID
            __( 'bullhorn for white background shortcode settings', 'wol-info-boxes' ), // Title
            array( $this, 'print_bullhorn_section_bullhorn' ), // Callback
            'wol-info-boxes' // Page
        );  

        add_settings_field(
            'bullhorn_color_no_bkg', // ID
            __( 'Text color for white background', 'wol-info-boxes' ), // Title 
            array( $this, 'bullhorn_color_no_bkg_callback' ), // Callback
            'wol-info-boxes', // Page
            'bullhorn_white_bckg_section_id' // Section           
        );      

        add_settings_field(
            'bullhorn_border_color_no_bkg', 
            __( 'Border color for white background', 'wol-info-boxes' ), 
            array( $this, 'bullhorn_border_color_no_bkg_callback' ), 
            'wol-info-boxes', 
            'bullhorn_white_bckg_section_id'
        );  
        
         add_settings_section(
            'bullhorn_colored_bckg_section_id', // ID
            __( 'bullhorn for colored background WITH border shortcode settings', 'wol-info-boxes' ), // Title
            array( $this, 'print_bullhorn_colored_section_bullhorn' ), // Callback
            'wol-info-boxes' // Page
        );  

        add_settings_field(
            'bullhorn_color_no_bkg', // ID
            __( 'Text color for colored background', 'wol-info-boxes' ), // Title 
            array( $this, 'bullhorn_color_colored_bkg_callback' ), // Callback
            'wol-info-boxes', // Page
            'bullhorn_colored_bckg_section_id' // Section           
        );  
        
        add_settings_field(
            'bullhorn_bckg_color_no_bkg', // ID
            __( 'Background color for colored background', 'wol-info-boxes' ), // Title 
            array( $this, 'bullhorn_bckg_color_colored_bkg_callback' ), // Callback
            'wol-info-boxes', // Page
            'bullhorn_colored_bckg_section_id' // Section           
        );     

        add_settings_field(
            'bullhorn_border_color_no_bkg', 
            __( 'Border color for colored background', 'wol-info-boxes' ), 
            array( $this, 'bullhorn_border_color_colored_bkg_callback' ), 
            'wol-info-boxes', 
            'bullhorn_colored_bckg_section_id'
        );  
        
        add_settings_section(
            'bullhorn_colored_bckg_no_border_section_id', // ID
            __( 'bullhorn for colored background WITHOUT BORDER shortcode settings', 'wol-info-boxes' ), // Title
            array( $this, 'print_bullhorn_colored_no_border_section_bullhorn' ), // Callback
            'wol-info-boxes' // Page
        );  

        add_settings_field(
            'bullhorn_color_no_bkg', // ID
            __( 'Text color for colored background WITHOUT BORDER', 'wol-info-boxes' ), // Title 
            array( $this, 'bullhorn_color_colored_bkg_no_border_callback' ), // Callback
            'wol-info-boxes', // Page
            'bullhorn_colored_bckg_no_border_section_id' // Section           
        );  
        
        add_settings_field(
            'bullhorn_bckg_color_no_bkg', // ID
            __( 'Background color for colored background WITHOUT BORDER', 'wol-info-boxes' ), // Title 
            array( $this, 'bullhorn_bckg_color_colored_bkg_no_border_callback' ), // Callback
            'wol-info-boxes', // Page
            'bullhorn_colored_bckg_no_border_section_id' // Section           
        );     
        
        /*
		 *  NOTICE SECTION
		 *
		 */
        add_settings_section(
            'notice_white_bckg_section_id', // ID
            __( 'notice for white background shortcode settings', 'wol-info-boxes' ), // Title
            array( $this, 'print_notice_section_notice' ), // Callback
            'wol-info-boxes' // Page
        );  

        add_settings_field(
            'notice_color_no_bkg', // ID
            __( 'Text color for white background', 'wol-info-boxes' ), // Title 
            array( $this, 'notice_color_no_bkg_callback' ), // Callback
            'wol-info-boxes', // Page
            'notice_white_bckg_section_id' // Section           
        );      

        add_settings_field(
            'notice_border_color_no_bkg', 
            __( 'Border color for white background', 'wol-info-boxes' ), 
            array( $this, 'notice_border_color_no_bkg_callback' ), 
            'wol-info-boxes', 
            'notice_white_bckg_section_id'
        );  
        
         add_settings_section(
            'notice_colored_bckg_section_id', // ID
            __( 'notice for colored background WITH border shortcode settings', 'wol-info-boxes' ), // Title
            array( $this, 'print_notice_colored_section_notice' ), // Callback
            'wol-info-boxes' // Page
        );  

        add_settings_field(
            'notice_color_no_bkg', // ID
            __( 'Text color for colored background', 'wol-info-boxes' ), // Title 
            array( $this, 'notice_color_colored_bkg_callback' ), // Callback
            'wol-info-boxes', // Page
            'notice_colored_bckg_section_id' // Section           
        );  
        
        add_settings_field(
            'notice_bckg_color_no_bkg', // ID
            __( 'Background color for colored background', 'wol-info-boxes' ), // Title 
            array( $this, 'notice_bckg_color_colored_bkg_callback' ), // Callback
            'wol-info-boxes', // Page
            'notice_colored_bckg_section_id' // Section           
        );     

        add_settings_field(
            'notice_border_color_no_bkg', 
            __( 'Border color for colored background', 'wol-info-boxes' ), 
            array( $this, 'notice_border_color_colored_bkg_callback' ), 
            'wol-info-boxes', 
            'notice_colored_bckg_section_id'
        );  
        
        add_settings_section(
            'notice_colored_bckg_no_border_section_id', // ID
            __( 'notice for colored background WITHOUT BORDER shortcode settings', 'wol-info-boxes' ), // Title
            array( $this, 'print_notice_colored_no_border_section_notice' ), // Callback
            'wol-info-boxes' // Page
        );  

        add_settings_field(
            'notice_color_no_bkg', // ID
            __( 'Text color for colored background WITHOUT BORDER', 'wol-info-boxes' ), // Title 
            array( $this, 'notice_color_colored_bkg_no_border_callback' ), // Callback
            'wol-info-boxes', // Page
            'notice_colored_bckg_no_border_section_id' // Section           
        );  
        
        add_settings_field(
            'notice_bckg_color_no_bkg', // ID
            __( 'Background color for colored background WITHOUT BORDER', 'wol-info-boxes' ), // Title 
            array( $this, 'notice_bckg_color_colored_bkg_no_border_callback' ), // Callback
            'wol-info-boxes', // Page
            'notice_colored_bckg_no_border_section_id' // Section           
        );     


    }
    public function sanitize_cpt( $input )
    {
        $new_input = array();
        if( isset( $input['cpt'] ) && is_array( $input['cpt'] ) ){
	        foreach ( $input['cpt'] as $c ){
		        
		        $new_input['cpt'][] =  sanitize_text_field( $c );
		        
	        }
            
       
       }
        
		return $new_input;
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        
        
        if( isset( $input['border_radius'] ) )
            $new_input['border_radius'] =  absint( $input['border_radius'] );

        if( isset( $input['fa_info'] ) )
            $new_input['fa_info'] =  wp_kses_post( $input['fa_info'] ) ;
			
		if( isset( $input['fa_alert'] ) )
            $new_input['fa_alert'] =  wp_kses_post( $input['fa_alert'] );
            	
        if( isset( $input['fa_bullhorn'] ) )
            $new_input['fa_bullhorn'] =  wp_kses_post( $input['fa_bullhorn']) ;
            
        if( isset( $input['fa_notice'] ) )
            $new_input['fa_notice'] =  wp_kses_post( $input['fa_notice'] );

        
        if( isset( $input['info_color_no_bkg'] ) )
            $new_input['info_color_no_bkg'] =  esc_attr( $input['info_color_no_bkg'] );

        if( isset( $input['info_border_color_no_bkg'] ) )
            $new_input['info_border_color_no_bkg'] = esc_attr( $input['info_border_color_no_bkg'] );
			
		if( isset( $input['info_color_colored_bkg'] ) )
            $new_input['info_color_colored_bkg'] = esc_attr( $input['info_color_colored_bkg'] );
            	
        if( isset( $input['info_bckg_color_colored_bkg'] ) )
            $new_input['info_bckg_color_colored_bkg'] = esc_attr( $input['info_bckg_color_colored_bkg'] );
            
        if( isset( $input['info_border_color_colored_bkg'] ) )
            $new_input['info_border_color_colored_bkg'] = esc_attr( $input['info_border_color_colored_bkg'] );
		
		if( isset( $input['info_color_colored_bkg_no_border'] ) )
            $new_input['info_color_colored_bkg_no_border'] = esc_attr( $input['info_color_colored_bkg_no_border'] );
            	
        if( isset( $input['info_bckg_color_colored_bkg_no_border'] ) )
            $new_input['info_bckg_color_colored_bkg_no_border'] = esc_attr( $input['info_bckg_color_colored_bkg_no_border'] );
            
            
            
        if( isset( $input['alert_color_no_bkg'] ) )
            $new_input['alert_color_no_bkg'] =  esc_attr( $input['alert_color_no_bkg'] );

        if( isset( $input['alert_border_color_no_bkg'] ) )
            $new_input['alert_border_color_no_bkg'] = esc_attr( $input['alert_border_color_no_bkg'] );
			
		if( isset( $input['alert_color_colored_bkg'] ) )
            $new_input['alert_color_colored_bkg'] = esc_attr( $input['alert_color_colored_bkg'] );
            	
        if( isset( $input['alert_bckg_color_colored_bkg'] ) )
            $new_input['alert_bckg_color_colored_bkg'] = esc_attr( $input['alert_bckg_color_colored_bkg'] );
            
        if( isset( $input['alert_border_color_colored_bkg'] ) )
            $new_input['alert_border_color_colored_bkg'] = esc_attr( $input['alert_border_color_colored_bkg'] );
		
		if( isset( $input['alert_color_colored_bkg_no_border'] ) )
            $new_input['alert_color_colored_bkg_no_border'] = esc_attr( $input['alert_color_colored_bkg_no_border'] );
            	
        if( isset( $input['alert_bckg_color_colored_bkg_no_border'] ) )
            $new_input['alert_bckg_color_colored_bkg_no_border'] = esc_attr( $input['alert_bckg_color_colored_bkg_no_border'] );
            
            
            
        if( isset( $input['bullhorn_color_no_bkg'] ) )
            $new_input['bullhorn_color_no_bkg'] =  esc_attr( $input['bullhorn_color_no_bkg'] );

        if( isset( $input['bullhorn_border_color_no_bkg'] ) )
            $new_input['bullhorn_border_color_no_bkg'] = esc_attr( $input['bullhorn_border_color_no_bkg'] );
			
		if( isset( $input['bullhorn_color_colored_bkg'] ) )
            $new_input['bullhorn_color_colored_bkg'] = esc_attr( $input['bullhorn_color_colored_bkg'] );
            	
        if( isset( $input['bullhorn_bckg_color_colored_bkg'] ) )
            $new_input['bullhorn_bckg_color_colored_bkg'] = esc_attr( $input['bullhorn_bckg_color_colored_bkg'] );
            
        if( isset( $input['bullhorn_border_color_colored_bkg'] ) )
            $new_input['bullhorn_border_color_colored_bkg'] = esc_attr( $input['bullhorn_border_color_colored_bkg'] );
		
		if( isset( $input['bullhorn_color_colored_bkg_no_border'] ) )
            $new_input['bullhorn_color_colored_bkg_no_border'] = esc_attr( $input['bullhorn_color_colored_bkg_no_border'] );
            	
        if( isset( $input['bullhorn_bckg_color_colored_bkg_no_border'] ) )
            $new_input['bullhorn_bckg_color_colored_bkg_no_border'] = esc_attr( $input['bullhorn_bckg_color_colored_bkg_no_border'] );
            
            
        if( isset( $input['notice_color_no_bkg'] ) )
            $new_input['notice_color_no_bkg'] =  esc_attr( $input['notice_color_no_bkg'] );

        if( isset( $input['notice_border_color_no_bkg'] ) )
            $new_input['notice_border_color_no_bkg'] = esc_attr( $input['notice_border_color_no_bkg'] );
			
		if( isset( $input['notice_color_colored_bkg'] ) )
            $new_input['notice_color_colored_bkg'] = esc_attr( $input['notice_color_colored_bkg'] );
            	
        if( isset( $input['notice_bckg_color_colored_bkg'] ) )
            $new_input['notice_bckg_color_colored_bkg'] = esc_attr( $input['notice_bckg_color_colored_bkg'] );
            
        if( isset( $input['notice_border_color_colored_bkg'] ) )
            $new_input['notice_border_color_colored_bkg'] = esc_attr( $input['notice_border_color_colored_bkg'] );
		
		if( isset( $input['notice_color_colored_bkg_no_border'] ) )
            $new_input['notice_color_colored_bkg_no_border'] = esc_attr( $input['notice_color_colored_bkg_no_border'] );
            	
        if( isset( $input['notice_bckg_color_colored_bkg_no_border'] ) )
            $new_input['notice_bckg_color_colored_bkg_no_border'] = esc_attr( $input['notice_bckg_color_colored_bkg_no_border'] );

        return $new_input;
    }
    
            
     /** 
     * Print the Section text
     */
    public function print_cpt_section_info()
    {
        _e( 'Choose CPTs settings below:', 'wol-info-boxes' );
                  
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function cpts_callback()
    {
	    
	    $post_types = get_post_types();
	    
	    foreach ( $post_types as $key => $pt ){ 
	    
	     	$checked = ( in_array( $key, $this->options_cpt['cpt'] ) ) ?
		    	sanitize_text_field( $key ):
		    	'';
	    ?>
	    	<input type="checkbox" name="wol_cpt_option[cpt][]" value="<?php echo $key; ?>" <?php checked( $checked, $key ); ?>/> <?php echo $pt; ?> <br />
		    
	    <?php }
        
    }
   
        
    /** 
     * Print the Section text
     */
    public function print_general_section_info()
    {
        _e( 'Enter INFO shortcode settings below:', 'wol-info-boxes' );
        
        
        
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function border_radius_callback()
    {
        printf(
            '<input  type="number" id="id_number" name="wol_shortcode_option[border_radius]" value="%s" />',
            ( isset( 
            	$this->options['border_radius'] ) && ! empty( $this->options['border_radius'] ) ) ? 
            	absint( $this->options['border_radius']) : 
            	(int)27
        );
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function fa_info_callback()
    {
        printf(
            '<input  type="text" id="title" name="wol_shortcode_option[fa_info]" value="%s" class="regular-text"/>',
            ( isset( 
            	$this->options['fa_info'] ) && ! empty( $this->options['fa_info'] ) ) ? 
            	esc_attr( $this->options['fa_info']) : 
            	esc_attr( '<i class="fas fa-info-circle"></i>' )
        );
    }
    
    public function fa_alert_callback()
    {
        printf(
            '<input  type="text" id="title" name="wol_shortcode_option[fa_alert]" value="%s" class="regular-text"/>',
            ( isset( 
            	$this->options['fa_alert'] ) && ! empty( $this->options['fa_alert'] ) ) ? 
            	esc_attr( $this->options['fa_alert']) : 
            	esc_attr ( '<i class="fas fa-exclamation-triangle"></i>' )
        );
    }
	
	public function fa_bullhorn_callback()
    {
        printf(
            '<input  type="text" id="title" name="wol_shortcode_option[fa_bullhorn]" value="%s" class="regular-text"/>',
            ( isset( 
            	$this->options['fa_bullhorn'] ) && ! empty( $this->options['fa_bullhorn'] ) ) ? 
            	esc_attr( $this->options['fa_bullhorn'] ) : 
            	esc_attr('<i class="fas fa-bullhorn"></i>' )
        );
    }

	public function fa_notice_callback()
    {
        printf(
            '<input  type="text" id="title" name="wol_shortcode_option[fa_notice]" value="%s" class="regular-text"/>',
            ( isset( 
            	$this->options['fa_notice'] ) && ! empty( $this->options['fa_notice'] ) ) ? 
            	esc_attr( $this->options['fa_notice']) : 
            	esc_attr( '<i class="fas fa-bell"></i>' )
        );
    }

    
   
    

    /** 
     * Print the Section text
     */
    public function print_info_section_info()
    {
        _e( 'Enter INFO shortcode settings below:', 'wol-info-boxes' );
        
        
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function info_color_no_bkg_callback()
    {
        printf(
            '<input class="color-field" type="text" id="id_number" name="wol_shortcode_option[info_color_no_bkg]" value="%s" />',
            ( isset( 
            	$this->options['info_color_no_bkg'] ) && ! empty( $this->options['info_color_no_bkg'] ) ) ? 
            	esc_attr( $this->options['info_color_no_bkg']) : 
            	'#03ad00'
        );
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function info_border_color_no_bkg_callback()
    {
        printf(
            '<input class="color-field" type="text" id="title" name="wol_shortcode_option[info_border_color_no_bkg]" value="%s" />',
            ( isset( 
            	$this->options['info_border_color_no_bkg'] ) && ! empty( $this->options['info_border_color_no_bkg'] ) ) ? 
            	esc_attr( $this->options['info_border_color_no_bkg']) : 
            	'#03ad00'
        );
    }
    
	
	
    public function print_info_colored_section_info()
    {
        _e( 'Enter INFO shortcode settings below:', 'wol-info-boxes' );
        
        
    }
	
	
    /** 
     * Get the settings option array and print one of its values
     */
    public function info_color_colored_bkg_callback()
    {
        printf(
            '<input class="color-field" type="text" id="id_number" name="wol_shortcode_option[info_color_colored_bkg]" value="%s" />',
            ( isset( 
            	$this->options['info_color_colored_bkg'] ) && ! empty( $this->options['info_color_colored_bkg'] ) ) ? 
            	esc_attr( $this->options['info_color_colored_bkg']) : 
            	'#000000'
        );
    }
    
    public function info_bckg_color_colored_bkg_callback()
    {
        printf(
            '<input class="color-field" type="text" id="id_number" name="wol_shortcode_option[info_bckg_color_colored_bkg]" value="%s" />',
            ( isset( 
            	$this->options['info_bckg_color_colored_bkg'] ) && ! empty( $this->options['info_bckg_color_colored_bkg'] ) ) ? 
            	esc_attr( $this->options['info_bckg_color_colored_bkg']) : 
            	'#cfc'
        );
    }
    /** 
     * Get the settings option array and print one of its values
     */
    public function info_border_color_colored_bkg_callback()
    {
        printf(
            '<input class="color-field" type="text" id="title" name="wol_shortcode_option[info_border_color_colored_bkg]" value="%s" />',
            ( isset( 
            	$this->options['info_border_color_colored_bkg'] ) && ! empty( $this->options['info_border_color_colored_bkg'] ) ) ? 
            	esc_attr( $this->options['info_border_color_colored_bkg']) : 
            	'#03ad00'
        );
    }
   

	public function print_info_colored_no_border_section_info()
    {
        _e( 'Enter INFO shortcode settings below:', 'wol-info-boxes' );
        
        
    }
	

    /** 
     * Get the settings option array and print one of its values
     */
    public function info_color_colored_bkg_no_border_callback()
    {
        printf(
            '<input class="color-field" type="text" id="id_number" name="wol_shortcode_option[info_color_colored_bkg_no_border]" value="%s" />',
            ( isset( 
            	$this->options['info_color_colored_bkg_no_border'] ) && ! empty( $this->options['info_color_colored_bkg_no_border'] ) ) ? 
            	esc_attr( $this->options['info_color_colored_bkg_no_border']) : 
            	'#ffffff'
        );
    }
    
    public function info_bckg_color_colored_bkg_no_border_callback()
    {
        printf(
            '<input class="color-field" type="text" id="id_number" name="wol_shortcode_option[info_bckg_color_colored_bkg_no_border]" value="%s" />',
            ( isset( 
            	$this->options['info_bckg_color_colored_bkg_no_border'] ) && ! empty( $this->options['info_bckg_color_colored_bkg_no_border'] ) ) ? 
            	esc_attr( $this->options['info_bckg_color_colored_bkg_no_border']) : 
            	'#03ad00'
        );
    }
    
    
    
    /** 
     * Print the Section text
     */
    public function print_alert_section_alert()
    {
        _e( 'Enter alert shortcode settings below:', 'wol-info-boxes' );
       
        
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function alert_color_no_bkg_callback()
    {
        printf(
            '<input class="color-field" type="text" id="id_number" name="wol_shortcode_option[alert_color_no_bkg]" value="%s" />',
            ( isset( 
            	$this->options['alert_color_no_bkg'] ) && ! empty( $this->options['alert_color_no_bkg'] ) ) ? 
            	esc_attr( $this->options['alert_color_no_bkg']) : 
            	'#ff0000'
        );
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function alert_border_color_no_bkg_callback()
    {
        printf(
            '<input class="color-field" type="text" id="title" name="wol_shortcode_option[alert_border_color_no_bkg]" value="%s" />',
            ( isset( 
            	$this->options['alert_border_color_no_bkg'] ) && ! empty( $this->options['alert_border_color_no_bkg'] ) ) ? 
            	esc_attr( $this->options['alert_border_color_no_bkg']) : 
            	'#ff0000'
        );
    }
    
	
	
    public function print_alert_colored_section_alert()
    {
        _e( 'Enter alert shortcode settings below:', 'wol-info-boxes' );
        
        
    }
	
	
    /** 
     * Get the settings option array and print one of its values
     */
    public function alert_color_colored_bkg_callback()
    {
        printf(
            '<input class="color-field" type="text" id="id_number" name="wol_shortcode_option[alert_color_colored_bkg]" value="%s" />',
            ( isset( 
            	$this->options['alert_color_colored_bkg'] ) && ! empty( $this->options['alert_color_colored_bkg'] ) ) ? 
            	esc_attr( $this->options['alert_color_colored_bkg']) : 
            	'#000000'
        );
    }
    
    public function alert_bckg_color_colored_bkg_callback()
    {
        printf(
            '<input class="color-field" type="text" id="id_number" name="wol_shortcode_option[alert_bckg_color_colored_bkg]" value="%s" />',
            ( isset( 
            	$this->options['alert_bckg_color_colored_bkg'] ) && ! empty( $this->options['alert_bckg_color_colored_bkg'] ) ) ? 
            	esc_attr( $this->options['alert_bckg_color_colored_bkg']) : 
            	'#ffcccc'
        );
    }
    /** 
     * Get the settings option array and print one of its values
     */
    public function alert_border_color_colored_bkg_callback()
    {
        printf(
            '<input class="color-field" type="text" id="title" name="wol_shortcode_option[alert_border_color_colored_bkg]" value="%s" />',
            ( isset( 
            	$this->options['alert_border_color_colored_bkg'] ) && ! empty( $this->options['alert_border_color_colored_bkg'] ) ) ? 
            	esc_attr( $this->options['alert_border_color_colored_bkg']) : 
            	'#ff0000'
        );
    }
   

	public function print_alert_colored_no_border_section_alert()
    {
        _e( 'Enter alert shortcode settings below:', 'wol-info-boxes' );
        
        
    }
	

    /** 
     * Get the settings option array and print one of its values
     */
    public function alert_color_colored_bkg_no_border_callback()
    {
        printf(
            '<input class="color-field" type="text" id="id_number" name="wol_shortcode_option[alert_color_colored_bkg_no_border]" value="%s" />',
            ( isset( 
            	$this->options['alert_color_colored_bkg_no_border'] ) && ! empty( $this->options['alert_color_colored_bkg_no_border'] ) ) ? 
            	esc_attr( $this->options['alert_color_colored_bkg_no_border']) : 
            	'#ffffff'
        );
    }
    
    public function alert_bckg_color_colored_bkg_no_border_callback()
    {
        printf(
            '<input class="color-field" type="text" id="id_number" name="wol_shortcode_option[alert_bckg_color_colored_bkg_no_border]" value="%s" />',
            ( isset( 
            	$this->options['alert_bckg_color_colored_bkg_no_border'] ) && ! empty( $this->options['alert_bckg_color_colored_bkg_no_border'] ) ) ? 
            	esc_attr( $this->options['alert_bckg_color_colored_bkg_no_border']) : 
            	'#ff0000'
        );
    }

    
    
    public function print_bullhorn_section_bullhorn()
    {
        _e( 'Enter bullhorn shortcode settings below:', 'wol-info-boxes' );
        
        
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function bullhorn_color_no_bkg_callback()
    {
        printf(
            '<input class="color-field" type="text" id="id_number" name="wol_shortcode_option[bullhorn_color_no_bkg]" value="%s" />',
            ( isset( 
            	$this->options['bullhorn_color_no_bkg'] ) && ! empty( $this->options['bullhorn_color_no_bkg'] ) ) ? 
            	esc_attr( $this->options['bullhorn_color_no_bkg']) : 
            	'#0000FF'
        );
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function bullhorn_border_color_no_bkg_callback()
    {
        printf(
            '<input class="color-field" type="text" id="title" name="wol_shortcode_option[bullhorn_border_color_no_bkg]" value="%s" />',
            ( isset( 
            	$this->options['bullhorn_border_color_no_bkg'] ) && ! empty( $this->options['bullhorn_border_color_no_bkg'] ) ) ? 
            	esc_attr( $this->options['bullhorn_border_color_no_bkg']) : 
            	'#0000FF'
        );
    }
    
	
	
    public function print_bullhorn_colored_section_bullhorn()
    {
        _e( 'Enter bullhorn shortcode settings below:', 'wol-info-boxes' );
        
        
    }
	
	
    /** 
     * Get the settings option array and print one of its values
     */
    public function bullhorn_color_colored_bkg_callback()
    {
        printf(
            '<input class="color-field" type="text" id="id_number" name="wol_shortcode_option[bullhorn_color_colored_bkg]" value="%s" />',
            ( isset( 
            	$this->options['bullhorn_color_colored_bkg'] ) && ! empty( $this->options['bullhorn_color_colored_bkg'] ) ) ? 
            	esc_attr( $this->options['bullhorn_color_colored_bkg']) : 
            	'#000000'
        );
    }
    
    public function bullhorn_bckg_color_colored_bkg_callback()
    {
        printf(
            '<input class="color-field" type="text" id="id_number" name="wol_shortcode_option[bullhorn_bckg_color_colored_bkg]" value="%s" />',
            ( isset( 
            	$this->options['bullhorn_bckg_color_colored_bkg'] ) && ! empty( $this->options['bullhorn_bckg_color_colored_bkg'] ) ) ? 
            	esc_attr( $this->options['bullhorn_bckg_color_colored_bkg']) : 
            	'#bdeaff'
        );
    }
    /** 
     * Get the settings option array and print one of its values
     */
    public function bullhorn_border_color_colored_bkg_callback()
    {
        printf(
            '<input class="color-field" type="text" id="title" name="wol_shortcode_option[bullhorn_border_color_colored_bkg]" value="%s" />',
            ( isset( 
            	$this->options['bullhorn_border_color_colored_bkg'] ) && ! empty( $this->options['bullhorn_border_color_colored_bkg'] ) ) ? 
            	esc_attr( $this->options['bullhorn_border_color_colored_bkg']) : 
            	'#0000FF'
        );
    }
   

	public function print_bullhorn_colored_no_border_section_bullhorn()
    {
        _e( 'Enter bullhorn shortcode settings below:', 'wol-info-boxes' );
        
        
    }
	

    /** 
     * Get the settings option array and print one of its values
     */
    public function bullhorn_color_colored_bkg_no_border_callback()
    {
        printf(
            '<input class="color-field" type="text" id="id_number" name="wol_shortcode_option[bullhorn_color_colored_bkg_no_border]" value="%s" />',
            ( isset( 
            	$this->options['bullhorn_color_colored_bkg_no_border'] ) && ! empty( $this->options['bullhorn_color_colored_bkg_no_border'] ) ) ? 
            	esc_attr( $this->options['bullhorn_color_colored_bkg_no_border']) : 
            	'#ffffff'
        );
    }
    
    public function bullhorn_bckg_color_colored_bkg_no_border_callback()
    {
        printf(
            '<input class="color-field" type="text" id="id_number" name="wol_shortcode_option[bullhorn_bckg_color_colored_bkg_no_border]" value="%s" />',
            ( isset( 
            	$this->options['bullhorn_bckg_color_colored_bkg_no_border'] ) && ! empty( $this->options['bullhorn_bckg_color_colored_bkg_no_border'] ) ) ? 
            	esc_attr( $this->options['bullhorn_bckg_color_colored_bkg_no_border']) : 
            	'#0000FF'
        );
    }
	
	
	public function print_notice_section_notice()
    {
        _e( 'Enter notice shortcode settings below:', 'wol-info-boxes' );
                
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function notice_color_no_bkg_callback()
    {
        printf(
            '<input class="color-field" type="text" id="id_number" name="wol_shortcode_option[notice_color_no_bkg]" value="%s" />',
            ( isset( 
            	$this->options['notice_color_no_bkg'] ) && ! empty( $this->options['notice_color_no_bkg'] ) ) ? 
            	esc_attr( $this->options['notice_color_no_bkg']) : 
            	'#FFA500'
        );
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function notice_border_color_no_bkg_callback()
    {
        printf(
            '<input class="color-field" type="text" id="title" name="wol_shortcode_option[notice_border_color_no_bkg]" value="%s" />',
            ( isset( 
            	$this->options['notice_border_color_no_bkg'] ) && ! empty( $this->options['notice_border_color_no_bkg'] ) ) ? 
            	esc_attr( $this->options['notice_border_color_no_bkg']) : 
            	'#FFA500'
        );
    }
    
	
	
    public function print_notice_colored_section_notice()
    {
        _e( 'Enter notice shortcode settings below:', 'wol-info-boxes' );
        
        
    }
	
	
    /** 
     * Get the settings option array and print one of its values
     */
    public function notice_color_colored_bkg_callback()
    {
        printf(
            '<input class="color-field" type="text" id="id_number" name="wol_shortcode_option[notice_color_colored_bkg]" value="%s" />',
            ( isset( 
            	$this->options['notice_color_colored_bkg'] ) && ! empty( $this->options['notice_color_colored_bkg'] ) ) ? 
            	esc_attr( $this->options['notice_color_colored_bkg']) : 
            	'#000000'
        );
    }
    
    public function notice_bckg_color_colored_bkg_callback()
    {
        printf(
            '<input class="color-field" type="text" id="id_number" name="wol_shortcode_option[notice_bckg_color_colored_bkg]" value="%s" />',
            ( isset( 
            	$this->options['notice_bckg_color_colored_bkg'] ) && ! empty( $this->options['notice_bckg_color_colored_bkg'] ) ) ? 
            	esc_attr( $this->options['notice_bckg_color_colored_bkg']) : 
            	'#FFDB99'
        );
    }
    /** 
     * Get the settings option array and print one of its values
     */
    public function notice_border_color_colored_bkg_callback()
    {
        printf(
            '<input class="color-field" type="text" id="title" name="wol_shortcode_option[notice_border_color_colored_bkg]" value="%s" />',
            ( isset( 
            	$this->options['notice_border_color_colored_bkg'] ) && ! empty( $this->options['notice_border_color_colored_bkg'] ) ) ? 
            	esc_attr( $this->options['notice_border_color_colored_bkg']) : 
            	'#FFA500'
        );
    }
   

	public function print_notice_colored_no_border_section_notice()
    {
        _e( 'Enter notice shortcode settings below:', 'wol-info-boxes' );
        
        
    }
	

    /** 
     * Get the settings option array and print one of its values
     */
    public function notice_color_colored_bkg_no_border_callback()
    {
        printf(
            '<input class="color-field" type="text" id="id_number" name="wol_shortcode_option[notice_color_colored_bkg_no_border]" value="%s" />',
            ( isset( 
            	$this->options['notice_color_colored_bkg_no_border'] ) && ! empty( $this->options['notice_color_colored_bkg_no_border'] ) ) ? 
            	esc_attr( $this->options['notice_color_colored_bkg_no_border']) : 
            	'#ffffff'
        );
    }
    
    public function notice_bckg_color_colored_bkg_no_border_callback()
    {
        printf(
            '<input class="color-field" type="text" id="id_number" name="wol_shortcode_option[notice_bckg_color_colored_bkg_no_border]" value="%s" />',
            ( isset( 
            	$this->options['notice_bckg_color_colored_bkg_no_border'] ) && ! empty( $this->options['notice_bckg_color_colored_bkg_no_border'] ) ) ? 
            	esc_attr( $this->options['notice_bckg_color_colored_bkg_no_border']) : 
            	'#FFA500'
        );
    }
    
    

    
    public function wol_option_backend_scripts( $hook ) {
        wp_enqueue_media();
        wp_enqueue_style( 'wp-color-picker');
        wp_enqueue_script( 'wp-color-picker');
        
        wp_enqueue_script( 
        	'wol-color-picker', 
        	WOL_UTI_PLUGIN_URL . '/assets/js/wol.color-picker.js', 
        	array( 'jquery' ), 
        	'1.0.0', 
        	true );

    }
    
    

}

if( is_admin() )
    $wol_shortcode_option = new Wol_Shortcode_Option();