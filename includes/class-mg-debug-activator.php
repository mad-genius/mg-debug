<?php

/**
 * Fired during plugin activation
 *
 * @link       https://madg.com
 * @since      1.0.0
 *
 * @package    Mg_Debug
 * @subpackage Mg_Debug/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Mg_Debug
 * @subpackage Mg_Debug/includes
 * @author     Blake Watson <bwatson@madg.com>
 */
class Mg_Debug_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		// Kint Debugger is required
		self::check_for_kint();
		// create the debug directory
		mkdir( get_home_path() . 'wp-content/mg_debug', 0775 );
		// empty index file for security
		file_put_contents( 'index.php', '<?php // Silence is golden. ?>' );
	}

	protected static function check_for_kint() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-mg-debug-notices.php';

        if ( ! is_plugin_active( 'kint-debugger/kint-debugger.php' ) ) {
            $notice = sprintf( 'You need to <a href="%s">Activate Kint Debugger</a> in order to use MG Debug.', admin_url( 'plugins.php' ) );
			Mg_Debug_Notices::create_notice( $notice, 'warning' );
			return wp_die();
        }
	}

}
