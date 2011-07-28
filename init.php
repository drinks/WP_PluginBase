<?php
/*
Plugin Name: Generic Plugin
Plugin URI: http://github.com/dandrinkard/WP_PluginBase
Description: Simple base class for WordPress plugins.
Version: 0.1
Author: Dan Drinkard
Author URI: http://displayawesome.com
License: MIT
*/
include_once('generic-plugin.php');
$Generic_Plugin = new GenericPlugin();
register_activation_hook(WP_PLUGIN_DIR . '/' . basename(dirname(__FILE__)) . '/init.php', 'install_generic_plugin');
function install_generic_plugin(){
    $plugin = new GenericPlugin();
    $plugin->activate();
}