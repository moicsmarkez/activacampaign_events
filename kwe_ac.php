<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              facebook.com/moicsmarkez
 * @since             1.0.0
 * @package           Kwe_ac
 *
 * @wordpress-plugin
 * Plugin Name:       KeiwebCo AC
 * Plugin URI:        keiwebco.com
 * Description:       Plugin de sincronia para anunciar eventos de seguimientos de usuarios con active campaign. VERSION BETA
 * Version:           1.1.18
 * Author:            moicsmarkez
 * Author URI:        facebook.com/moicsmarkez
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       kwe_ac
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) { 
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */  
define( 'KWE_AC_VERSION', '2.2.48' );

/** 
 * The code that runs during plugin activation.
 * This action is documented in includes/class-kwe_ac-activator.php 
 */
function activate_kwe_ac() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-kwe_ac-activator.php';
	Kwe_ac_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-kwe_ac-deactivator.php
 */
function deactivate_kwe_ac() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-kwe_ac-deactivator.php';
	Kwe_ac_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_kwe_ac' );
register_deactivation_hook( __FILE__, 'deactivate_kwe_ac' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-kwe_ac.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_kwe_ac() {

	$plugin = Kwe_ac::get_instance();
	$plugin->run();

}
run_kwe_ac();
