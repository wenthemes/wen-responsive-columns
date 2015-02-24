<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * Dashboard. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           WEN_Responsive_Columns
 *
 * @wordpress-plugin
 * Plugin Name:       WEN Responsive Columns
 * Plugin URI:        http://example.com/wen-responsive-columns-uri/
 * Description:       WEN Responsive Columns.
 * Version:           1.0.0
 * Author:            Your Name or Your Company
 * Author URI:        http://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wen-responsive-columns
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wen-responsive-columns-activator.php
 */
function activate_wen_responsive_columns() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wen-responsive-columns-activator.php';
	WEN_Responsive_Columns_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wen-responsive-columns-deactivator.php
 */
function deactivate_wen_responsive_columns() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wen-responsive-columns-deactivator.php';
	WEN_Responsive_Columns_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wen_responsive_columns' );
register_deactivation_hook( __FILE__, 'deactivate_wen_responsive_columns' );

/**
 * The core plugin class that is used to define internationalization,
 * dashboard-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wen-responsive-columns.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wen_responsive_columns() {

	$plugin = new WEN_Responsive_Columns();
	$plugin->run();

}
run_wen_responsive_columns();
