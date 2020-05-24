<?php
/**
 * Plugin Name: Wol Info Boxes
 * Plugin URI: https://paolovalenti.org
 * Description: Many custom boxes for your posts, pages and CPT
 * Author: Wolly
 * Author URI: https://paolovalenti.info
 * Version: 0.9.0
 * Text Domain: wol-info-boxes
 * Domain Path: languages
 *
 * Wol Info Boxes is distributed under the terms of the GNU General
 * Public License as published by the Free Software Foundation, either version 2
 * of the License, or any later version.
 *
 * wol-info-boxes is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with wol-info-boxes. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package  Wol_Info_Boxes
 * @category Core
 * @author   Wolly 
 * @version 0.9.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Wol_Info_Boxes' ) ) {

	

	/**
	 * Main wol-info-boxes Class
	 *
	 * @since 1.0
	 */
	final class Wol_Info_Boxes {
		
		/** Singleton *************************************************************/

		/**
		 * wol-info-boxes instance.
		 *
		 * @access private
		 * @since  1.0
		 * @var    Wol_Utility The one true Wol_Utility
		 */
		private static $instance;

		/**
		 * The version number of Wol_Utility.
		 *
		 * @access private
		 * @since  1.0
		 * @var    string
		 */
		private $version = '0.9.0';
		
		/**
		 * custom_css
		 * 
		 * @var mixed
		 * @access public
		 */
		public $custom_css;
		
		/**
		 * shortcodes
		 * 
		 * @var mixed
		 * @access public
		 */
		public $shortcodes;
		
		/**
		 * build_box
		 * 
		 * @var mixed
		 * @access public
		 */
		public $build_box;
		
		/**
		 * metaboxes
		 * 
		 * @var mixed
		 * @access public
		 */
		public $metaboxes;
		
		/**
		 * Main Wol_Utility Instance
		 *
		 * Insures that only one instance of Wol_Utility exists in memory at any one
		 * time. Also prevents needing to define globals all over the place.
		 *
		 * @since     1.0
		 * @static
		 * @staticvar array $instance
		 * @uses      wol-info-boxes::setup_globals() Setup the globals needed
		 * @uses      wol-info-boxes::includes() Include the required files
		 * @uses      wol-info-boxes::setup_actions() Setup the hooks and actions
		 * @uses      wol-info-boxes::updater() Setup the plugin updater
		 * @return wol-info-boxes
		 */
		public static function instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Wol_Info_Boxes ) ) {
				self::$instance = new Wol_Info_Boxes;

				if ( version_compare( PHP_VERSION, '5.6', '<' ) ) {

					add_action( 'admin_notices', array(
						'Wol_Info_Boxes',
						'below_php_version_notice'
					) );

					return self::$instance;

				}
				self::$instance->setup_constants();


				self::$instance->includes();

				add_action( 'plugins_loaded', array(
					self::$instance,
					'setup_objects'
				), - 1 );

			

			}

			return self::$instance;
		}

		/**
		 * Throw error on object clone
		 *
		 * The whole idea of the singleton design pattern is that there is a single
		 * object therefore, we don't want the object to be cloned.
		 *
		 * @since  1.0
		 * @access protected
		 * @return void
		 */
		public function __clone() {
			// Cloning instances of the class is forbidden
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'wol-info-boxes' ), '1.0' );
		}

		/**
		 * Disable unserializing of the class
		 *
		 * @since  1.0
		 * @access protected
		 * @return void
		 */
		public function __wakeup() {
			// Unserializing instances of the class is forbidden
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'wol-info-boxes' ), '1.0' );
		}

		/**
		 * Show a warning to sites running PHP < 5.6
		 *
		 * @static
		 * @access private
		 * @since  1.0
		 * @return void
		 */
		public static function below_php_version_notice() {
			echo '<div class="error"><p>' . __( 'Your version of PHP is below the minimum version of PHP required by wol-info-boxes. Please contact your host and request that your version be upgraded to 5.6 or later.', 'wol-info-boxes' ) . '</p></div>';
		}

		/**
		 * Setup plugin constants
		 *
		 * @access private
		 * @since  1.0
		 * @return void
		 */
		private function setup_constants() {
			// Plugin version
			if ( ! defined( 'WOL_UTI_VERSION' ) ) {
				define( 'WOL_UTI_VERSION', $this->version );
			}

			// Plugin Folder Path
			if ( ! defined( 'WOL_UTI_PLUGIN_DIR' ) ) {
				define( 'WOL_UTI_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
			}

			// Plugin Folder URL
			if ( ! defined( 'WOL_UTI_PLUGIN_URL' ) ) {
				define( 'WOL_UTI_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
			}

			// Plugin Root File
			if ( ! defined( 'WOL_UTI_PLUGIN_FILE' ) ) {
				define( 'WOL_UTI_PLUGIN_FILE', __FILE__ );
			}

			// Make sure CAL_GREGORIAN is defined.
			if ( ! defined( 'CAL_GREGORIAN' ) ) {
				define( 'CAL_GREGORIAN', 1 );
			}
		}

		/**
		 * Include required files
		 *
		 * @access private
		 * @since  1.0
		 * @return void
		 */
		private function includes() {

			
			// Admin only used class
			if ( is_admin() ) {
				
				require_once WOL_UTI_PLUGIN_DIR . 'includes/class-option.php';
				require_once WOL_UTI_PLUGIN_DIR . 'includes/class-metaboxes.php';
				

			} else {

				// Frontend only used class


				require_once WOL_UTI_PLUGIN_DIR . 'includes/class-shortcodes.php';
				require_once WOL_UTI_PLUGIN_DIR . 'includes/class-custom-css.php';
				
				

			}
			require_once WOL_UTI_PLUGIN_DIR . 'includes/class-build-box.php';
			
		}

		/**
		 * Setup all objects
		 *
		 * @access public
		 * @since  1.6.2
		 * @return void
		 */
		public function setup_objects() {

			
			
			// Instantiate in admin only
			if ( is_admin() ) {
				
				self::$instance->metaboxes	= new Wol_Box_Metaboxes();

			} else {

				// Frontend only used class
				self::$instance->shortcodes	= new Wol_Shortcodes();
				self::$instance->custom_css	= new Wol_Custom_Css();

			}
			
			self::$instance->build_box	= new Wol_Build_Box();
			
			self::$instance->updater();

			// Enqueue general scripts and styles in admin
			add_action( 'admin_enqueue_scripts', array(
				self::$instance,
				'enqueue_admin_script_and_style'
			) );

			// Enqueue general scripts and styles in frontend
			add_action( 'wp_enqueue_scripts', array(
				self::$instance,
				'enqueue_frontend_script_and_style'
			) );
		}
		
		private function updater(){
			
			// ! TODO
		}
		/**
		 * Init settings
		 *
		 * @access public
		 * @since  1.0.0
		 * @return void
		 */
		public function init_settings() {

			wp_cache_add_non_persistent_groups( array ( 'wol-info-boxes' ) );

		}

		
		/**
		 * enqueue_admin_script_and_style function.
		 * 
		 * @access public
		 * @param mixed $hook
		 * @return void
		 */
		public function enqueue_admin_script_and_style( $hook ) {

			wp_enqueue_style( 'wol-box-admin-css', WOL_UTI_PLUGIN_URL . 'assets/css/wol-box-admin.css' );
			
		}
		
		/**
		 * enqueue_frontend_script_and_style function.
		 * 
		 * @access public
		 * @return void
		 */
		public function enqueue_frontend_script_and_style() {
			
			wp_enqueue_style( 'font-awesome-5', 'https://use.fontawesome.com/releases/v5.6.3/css/all.css' );
    

		}
		


	}// end class




} // End if class_exists check


/**
 * The main function responsible for returning the one true wol-info-boxes
 * Instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $wol-info-boxes = wol-info-boxes(); ?>
 *
 * @since 1.0
 * @return wol-info-boxes The one true wol-info-boxes Instance
 */
function wolinfoboxes() {
	return Wol_Info_Boxes::instance();
}

wolinfoboxes();
