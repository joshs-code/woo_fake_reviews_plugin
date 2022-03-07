<?php

/**
 * Plugin Name:       Woo Fake Reviews
 * Description:       Create quality fake reviews for your products in seconds!
 * Version:           0.0.1
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Joshua Almasin
 * Author URI:        https://jalmasin.tech
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       woo-fake-reviews
 * Domain Path:       /languages
 */

 if ( !defined('ABSPATH' ) ) exit;
 
 define('WFR_BASE_PATH', plugin_dir_path( __FILE__ ));
 define('WFR_URL', plugin_dir_url( __FILE__ ));

require WFR_BASE_PATH . 'vendor/autoload.php';

function activate() {
	require_once WFR_BASE_PATH . 'inc/class-activator.php';
	Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-t-deactivator.php
 */
function deactivate() {
	require_once WFR_BASE_PATH . 'inc/class-deactivator.php';
	Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate' );
register_deactivation_hook( __FILE__, 'deactivate' );


Joshua\WooFakeReviews\Init::getInstance()->startUp();