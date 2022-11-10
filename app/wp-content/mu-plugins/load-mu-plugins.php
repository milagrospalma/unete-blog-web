<?php
/**
 * Plugin Name: Must-use plugins para el proyecto
 * Plugin URI:  http://www.altimea.com
 * Description: Inicialización de los mu-plugins necesarios en el proyecto.
 * Author:      Altimea
 * Author URI:  http://www.altimea.com
 * Version:     1.0.0
 **/


# Manually load our custom Mu-Plugins in the right order to avoid dependency issues
require(WPMU_PLUGIN_DIR . '/countries/available/countries.php');
require(WPMU_PLUGIN_DIR . '/countries/country.php');

$helpers_file = trailingslashit(get_stylesheet_directory()) . 'inc/helpers.php';
if(file_exists($helpers_file)){
    require_once $helpers_file;
}