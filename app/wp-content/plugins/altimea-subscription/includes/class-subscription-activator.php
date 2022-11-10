<?php

/**
 * Fired during plugin activation
 *
 * @link       http://www.altimea.com
 * @since      1.0.0
 *
 * @package    blogSubscription
 * @subpackage blogSubscription/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    blogSubscription
 * @subpackage blogSubscription/includes
 * @author     Altimea <apps@altimea.com>
 */
class blogSubscriptionActivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 * @return Void
	 */
	public static function activate($networkwide) {
		// create table
		$model = blogSubscriptionModel::getInstance();
		$model->install($networkwide);
	}

}
