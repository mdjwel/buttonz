<?php
/**
 * Plugin Name: 	  ButtonZ
 * Plugin URI:  	  https://wordpress.org/plugins/buttonz
 * Author: 			  Spider Themes
 * Author URI:		  https://spider-themes.net
 * Description: 	  ButtonZ is a powerful plugin for creating any kind of button that you can imagine with Elementor.
 * Requires PHP:      5.6
 * Requires at least: 4.7
 * Tested up to:      5.5
 * Version:     	  1.0.2
 * License: 		  GPL v3
 * Text Domain: 	  buttonz
 * Domain Path: 	  /languages
**/

if (!defined('ABSPATH')) {
    exit;
}

define('BUTTONZ_VERSION', '1.0.0');
define('BUTTONZ_MINIMUM_ELEMENTOR_VERSION', '2.5.0');
define('BUTTONZ_PATH', plugin_dir_path(__FILE__));
define('BUTTONZ_URL', plugin_dir_url(__FILE__));

require_once __DIR__ . '/vendor/autoload.php';
require_once BUTTONZ_PATH . 'includes/elementor-checker.php';
require_once BUTTONZ_PATH . 'includes/extras.php';
require_once BUTTONZ_PATH . 'includes/hover-animation.php';

class ButtonZ {

    private static $_instance = null;

    public static function get_instance() {
        if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
    }

    public function __construct() {
		add_action('plugins_loaded', [$this, 'init']);
    }
    
    public function init() {

		if (!did_action('elementor/loaded')) {
			add_action('admin_notices', 'buttonz_addon_failed_load');
			return;
        }
        
		if (!version_compare(ELEMENTOR_VERSION, BUTTONZ_MINIMUM_ELEMENTOR_VERSION, '>=')) {
			add_action('admin_notices', [$this, 'buttonz_addon_failed_outofdate']);
			return;
        }

        add_filter( 'elementor/icons_manager/additional_tabs', [ $this, 'font_icons']);
        //self :: generate_custom_font_icons();

        /**
         * Loading widgets Stylesheets and Scripts
         */
        // Enqueue Stylesheets
        add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'enqueue_widget_styles' ] );

        // Registering widget scripts
        add_action( 'elementor/frontend/after_register_scripts', [ $this, 'enqueue_widget_scripts' ] );
        add_action( 'elementor/editor/before_enqueue_scripts', [ $this, 'enqueue_widget_scripts' ] );


		add_action('elementor/widgets/widgets_registered', [$this, 'register_widgets']);
		add_action('upgrader_process_complete', [$this, 'wp_upe_upgrade_completed'], 10, 2);
		add_action('admin_enqueue_scripts', [$this,'buttonz_scripts']);
		add_action( 'elementor/editor/before_enqueue_scripts', function() {
			wp_register_style( 'ub-editor-css', BUTTONZ_URL . 'assets/css/admin.css');
			wp_enqueue_style( 'ub-editor-css' );
		});
		add_action('admin_init', [$this, 'display_notice']);
		load_plugin_textdomain('buttonz', false, dirname(plugin_basename(__FILE__)) . '/languages' );
		add_filter( 'wpml_elementor_widgets_to_translate', [ $this, 'wpml_widgets_to_translate_filter' ] );
	}

    /***
     * Added Custom Font Icon Integrated Elementor Icon Library
     */
    public function font_icons( $custom_fonts ) {
        $css_data = plugins_url( 'assets/vendors/elegant-icon/style.css', __FILE__ );
        $json_data = plugins_url( '/assets/vendors/elegant-icon/eleganticons.json', __FILE__ );

        $custom_fonts['buttonz_eleganticon_font'] = [
            'name'          => 'eleganticons',
            'label'         => esc_html__( 'Elegant Icons', 'buttonz' ),
            'url'           => $css_data,
            'prefix'        => '',
            'displayPrefix' => '',
            'labelIcon'     => 'icon_star',
            'ver'           => '',
            'fetchJson'     => $json_data,
            'native'        => true,
        ];
        return $custom_fonts;
    }

    public static function generate_custom_font_icons(){
        $css_source = '';
        global $wp_filesystem;
        require_once ( ABSPATH . '/wp-admin/includes/file.php' );
        WP_Filesystem();
        $css_file =  BUTTONZ_PATH . '/assets/vendors/elegant-icon/style.css';
        if ( $wp_filesystem->exists( $css_file ) ) {
            $css_source = $wp_filesystem->get_contents( $css_file );
        }
        preg_match_all( "/\.(.*?):\w*?\s*?{/", $css_source, $matches, PREG_SET_ORDER, 0 );
        $iconList = [];
        foreach ( $matches as $match ) {
            $icon = str_replace('', '', $match[1]);
            $icons = explode(' ', $icon);
            $iconList[] = current($icons);
        }
        $icons = new \stdClass();
        $icons->icons = $iconList;
        $icon_data = json_encode($icons);
        $js_file = BUTTONZ_PATH . '/assets/vendors/elegant-icon/eleganticons.json';
        global $wp_filesystem;
        require_once ( ABSPATH . '/wp-admin/includes/file.php' );
        WP_Filesystem();
        if ( $wp_filesystem->exists( $js_file ) ) {
            $content =  $wp_filesystem->put_contents( $js_file, $icon_data) ;
        }
    }

	public function wpml_widgets_to_translate_filter( $widgets ) {
		$widgets[ 'ultimate_button' ] = [
		   'conditions' => [ 'widgetType' => 'ultimate_button' ],
		   'fields'     => [
			[
			   'field'       => 'text',
			   'type'        => __( 'ButtonZ : Title', 'buttonz' ),
			   'editor_type' => 'LINE'
			],
		 ],
		];
	   
		return $widgets;
	}

	public function buttonz_scripts(){
		wp_enqueue_style( 'ub-css', BUTTONZ_URL . 'assets/admin.css',array(),BUTTONZ_VERSION,'all');
		wp_enqueue_script( 'ub-common', BUTTONZ_URL . 'assets/admin.js',array('jquery'), BUTTONZ_VERSION,true);
	}

	public function display_notice() {

		if ( isset($_GET['buttonz_dismiss']) && $_GET['buttonz_dismiss'] == 1 ) {
	        add_option('buttonz_dismiss' , true);
	    }

		$upgrade = get_option('buttonz_upgraded');
		$dismiss = get_option('buttonz_dismiss');
		
		if(!get_option('ub-top-notice')){
			add_option('ub-top-notice',strtotime(current_time('mysql')));
		}
		if(get_option('ub-top-notice') && get_option('ub-top-notice') != 0) {
			if( get_option('ub-top-notice') < strtotime('-3 days')) { //if greater than 3 days
				//add_action('admin_notices', 			array($this,'buttonz_top_admin_notice'));
				add_action('wp_ajax_buttonz_top_notice',	array($this,'buttonz_top_notice_dismiss'));
			}
		}
	}

	public function buttonz_top_notice_dismiss(){
		update_option('ub-top-notice','0');
		exit();
	}
	
	public function buttonz_top_admin_notice(){
		?>
        <div class="ub-notice notice notice-success is-dismissible">
            <img class="ub-iconimg" src="<?php echo BUTTONZ_URL; ?>assets/icon.png" style="float:left;" />
            <p style="width:80%;"><?php _e('Enjoying our <strong>ButtonZ - Elementor Addon?</strong> We hope you liked it! If you feel this plugin helped you, You can give us a 5 star rating!<br>It will motivate us to serve you more !','buttonz'); ?> </p>
            <span class="ub-done"><?php _e('Already Done','buttonz'); ?></span>
        </div>
		<?php
	}

	public function wp_upe_upgrade_completed($upgrader_object, $options) {

		$our_plugin = plugin_basename( __FILE__ );

		if ($options['action'] == 'update' && $options['type'] == 'plugin' && isset( $options['plugins'])) {
			foreach($options['plugins'] as $plugin) {
				if ($plugin == $our_plugin) {
					add_option('buttonz_upgraded', true);
				}
			}
		}

	}

    public function register_widgets() {
        require_once(BUTTONZ_PATH . 'widgets/Button.php');
    }

    public function enqueue_widget_styles() {
		wp_enqueue_style( 'ub-front-style', BUTTONZ_URL . 'assets/css/style.css', array(), BUTTONZ_VERSION );
		wp_deregister_style('elementor-animations');
        wp_register_style( 'animate', BUTTONZ_URL . 'assets/css/animate.css' );
        wp_register_style( 'hover', BUTTONZ_URL . 'assets/css/hover-min.css' );
        wp_register_style( 'themify-icon', BUTTONZ_URL . 'assets/vendors/themify-icon/themify-icon.css' );
        wp_register_style( 'ub-icomoon', BUTTONZ_URL . 'assets/vendors/icomoon/style.css' );
    }

    public function enqueue_widget_scripts() {
		//wp_register_script( 'splitting', BUTTONZ_URL . 'assets/vendors/splitting/splitting.min.js' );
    }
}

ButtonZ::get_instance();


/**
 * Initialize the plugin tracker
 *
 * @return void
 */
function appsero_init_tracker_buttonz() {

    if ( ! class_exists( 'Appsero\Client' ) ) {
        require_once __DIR__ . '/vendor/appsero/client/src/Client.php';
    }

    $client = new Appsero\Client( '80230a82-c292-450e-9441-84bef7ed6ba6', 'ButtonZ &#8211; Elementor Addon', __FILE__ );

    // Active insights
    $client->insights()->init();

}

appsero_init_tracker_buttonz();
