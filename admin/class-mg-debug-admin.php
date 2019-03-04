<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://madg.com
 * @since      1.0.0
 *
 * @package    Mg_Debug
 * @subpackage Mg_Debug/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Mg_Debug
 * @subpackage Mg_Debug/admin
 * @author     Blake Watson <bwatson@madg.com>
 */
class Mg_Debug_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/mg-debug-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/mg-debug-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function add_plugin_admin_menu() {
		add_submenu_page(
			'options-general.php',
			'MG Debug',
			'MG Debug',
			'manage_options',
			$this->plugin_name,
			array( $this, 'display_admin_page' )
		);
	}

	public function display_admin_page() {
		$debug_logs = $this->get_debug_logs();
		$logs = [];

		date_default_timezone_set( 'America/Chicago' );

		foreach( $debug_logs as $log ) {
			$url = home_url( "wp-content/mg_debug/$log" );
	
			$timestamp = $this->get_timestamp( $log );
			$date = date( 'D, F j, Y - g:i:s a', $timestamp );

			$logs[] = [
				'filename' => $log,
				'date' => $date,
				'timestamp' => $timestamp,
				'url' => $url
			];
		}

		usort( $logs, function( $a, $b ) {
			if( $a['timestamp'] < $b['timestamp'] ) return 1;
			if( $a['timestamp'] > $b['timestamp'] ) return -1;
			return 0;
		} );

	    include_once( 'partials/' . $this->plugin_name . '-admin-display.php' );
	}

	public function get_timestamp( $filename ) {
		$timestamp = str_ireplace( 'debug-', '', $filename );
		$timestamp = str_ireplace( '.html', '', $timestamp );
		return intval( $timestamp );
	}

	public function get_debug_logs() {
		$handle = opendir( ABSPATH . 'wp-content/mg_debug' );
		$logs = [];

		while( false != ( $entry = readdir( $handle ) ) ) {
			if( strpos( $entry, 'debug' ) === false ) continue;
			$logs[] = $entry;
		}

		return $logs;
	}

	public function delete_all_logs() {
		$handle = opendir( ABSPATH . 'wp-content/mg_debug' );
		$logs = [];

		while( false != ( $entry = readdir( $handle ) ) ) {
			if( strpos( $entry, 'debug' ) === false ) continue;
			unlink( ABSPATH . 'wp-content/mg_debug/' . $entry );
		}

		echo 'true';
		wp_die();
	}

	public function delete_single_log() {
		$filename = $_POST['filename'];

		if( ! $filename ) {
			echo 'false';
			return wp_die();
		}

		$file_to_delete = ABSPATH . 'wp-content/mg_debug/' . $filename;

		if( unlink( $file_to_delete ) ) {
			echo 'true';
			return wp_die();
		}

		echo 'false';
		return wp_die();
	}

    public function get_id() {
        static $id = null;
        if( $id === null ) {
            $id = strval( time() );
        }
        return $id;
    }

    public function dump( $data ) {
		$things = $data['things'];
		
        ob_start();
        foreach( $things as $thing ) {
            d( $thing );
        }
        $contents = ob_get_clean();
        
        $mg_dump_id = self::get_id();
        $debug_dir = ABSPATH . 'wp-content/mg_debug';
        $debug_filename = "$debug_dir/debug-$mg_dump_id.html";
        file_put_contents( $debug_filename, $contents, FILE_APPEND );
	}
	
}
