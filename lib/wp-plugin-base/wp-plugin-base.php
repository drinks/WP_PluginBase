<?php
/**
 * WP_PluginBase
 * A simplistic settings scaffold for WordPress plugins
 *
 * @author Dan Drinkard <dan.drinkard@gmail.com
 * @copyright Copyright (c) 2011, Dan Drinkard
 * @license http://opensource.org/licenses/MIT MIT
 */
if (!class_exists('uTemplate')) include_once(dirname(__FILE__) . '/lib/class.utemplate.php');
if (!function_exists('Markdown')) include_once(dirname(__FILE__).'/lib/Markdown/markdown.php');

class WP_PluginBase{

    var $description,
        $settings_namespace = 'wp_plugin_base',
        $settings_page_title = 'Wordpress Plugin Base',
        $settings_page_capability = 'manage_options',
        $settings = array(
            array('name'=>'Setting Name',
                  'slug'=>'setting_name',
                  'type'=>'text'), // can be 'text', 'checkbox', 'textarea'
        );

    function __construct(){
        $this->description = file_get_contents(dirname(__FILE__) . '/../../ADMIN.md');
        /* register hooks */
        add_action('admin_init', array(&$this, 'register_settings'));
        add_action('admin_menu', array(&$this, 'add_settings_page'));
    }

    function add_settings_page(){
        add_options_page($this->settings_page_title,
                         $this->settings_page_title,
                         $this->settings_page_capability,
                         $this->settings_namespace . '_settings_page',
                         array(&$this, 'settings_page'));
    }

    function register_settings(){
        register_setting($this->settings_namespace . '_options', $this->settings_namespace);
    }

    function settings_page(){
        $context = array('plugin_settings'=>$this->settings,
                         'settings_namespace'=>$this->settings_namespace,
                         'settings_page_title'=>$this->settings_page_title,
                         'description'=>$this->description);
        uTemplate::render(dirname(__FILE__) . '/templates/settings_page.php', $context);
    }

}