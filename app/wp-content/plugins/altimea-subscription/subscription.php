<?php

/**
 * WordPress plugin generator by Altimea
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.altimea.com
 * @since             1.0.0
 * @package           blogSubscription
 *
 * @wordpress-plugin
 * Plugin Name:       Blog subscription
 * Plugin URI:        http://www.altimea.com
 * Description:       Plugin from save information of register
 * Version:           1.0.0
 * Author:            Altimea
 * Author URI:        http://www.altimea.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       subscription
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! defined( 'SUBSCRIPTION_FILE' ) ) {
	define( 'SUBSCRIPTION_FILE', __FILE__ );
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-subscription-activator.php
 * @param Boolean $networkwide status multisite
 * @return Void
 */
function activate_subscription($networkwide) {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-subscription-activator.php';
	blogSubscriptionActivator::activate($networkwide);
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-subscription-deactivator.php
 * @param Boolean $networkwide status multisite
 * @return Void
 */
function deactivate_subscription($networkwide) {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-subscription-deactivator.php';
	blogSubscriptionDeactivator::deactivate($networkwide);
}

register_activation_hook( __FILE__, 'activate_subscription' );
register_deactivation_hook( __FILE__, 'deactivate_subscription' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/libraries/class-subscription-gulpfile.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-subscription.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_subscription() {

	$plugin = new blogSubscription();
	$plugin->run();

}
run_subscription();
