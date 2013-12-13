<?php
/**
 * WP_PluginBase
 * A simplistic settings scaffold for WordPress plugins
 * While WordPress has a settings API, it creates a DB row for
 * each setting. This follows the pattern of a single row with
 * a serialized settings array loaded into a class attribute.
 *
 * @author Dan Drinkard <dan.drinkard@gmail.com
 * @copyright Copyright (c) 2011, Dan Drinkard
 * @license http://opensource.org/licenses/MIT MIT
 */


if (!class_exists('uTemplate')) include_once(dirname(__FILE__) . '/lib/class.utemplate.php');
if (!function_exists('Markdown')) include_once(dirname(__FILE__).'/lib/Markdown/markdown.php');

class WP_PluginBase{

    var $description = 'Add an <kbd>ADMIN.md</kbd> file to the root directory of your plugin or an attribute called <kbd>$description</kbd> to your main plugin class to change this message.',
        $namespace = 'wp_plugin_base',
        $title = 'WP Plugin Base',
        $capability = 'manage_options',
        $settings = array(
            /**
             * name: The text for the setting's label in admin
             * type: text | textarea | checkbox  TODO: (| radio (w/'options' array) | select (w/'options array))
             * value: default value for first initialization
             */
            'setting_slug' =>
                array('name'=>'Setting Name',
                      'type'=>'text',
                      'value'=>'Hello, world!'),
        );

    function __construct(){
        $description_path = WP_PLUGIN_DIR . '/'.basename(dirname(dirname(dirname(__FILE__)))).'/ADMIN.md';
        $description = @file_get_contents($description_path);
        $this->description = $description ? $description : $this->description;
        $this->load_settings();
        // register hooks
        add_action('admin_init', array(&$this, 'register_settings'));
        add_action('admin_menu', array(&$this, 'add_settings_page'));
    }

    /**
     * Installs settings on first activation
     */
    function activate(){
        if (!get_option($this->namespace)) $this->save_settings();
    }

    /**
     * Registers a WP settings page from instance vars
     */
    function add_settings_page(){
        add_options_page($this->title,
                         $this->title,
                         $this->capability,
                         $this->namespace . '_settings_page',
                         array(&$this, 'settings_page'));
    }

    /**
     * Registers the settings our plugin will use (should be just one)
     */
    function register_settings(){
        register_setting($this->namespace . '_options', $this->namespace);
    }

    /**
     * Provides context and renders the actual settings page
     */
    function settings_page(){
        $context = array('settings'=>$this->settings,
                         'namespace'=>$this->namespace,
                         'title'=>$this->title,
                         'description'=>$this->description);
        uTemplate::render(dirname(__FILE__) . '/templates/settings_page.php', $context);
    }

    /**
     * Accessor for settings, presence of 2nd param will set value
     */
    function setting($setting, $value=null){
        if ($value !== null):
            $this->settings[$setting]['value'] = $value;
            $this->save_settings();
        endif;
        return $this->settings[$setting] ?
               $this->settings[$setting]['value'] :
               null;
    }

    /**
     * Loads settings from the DB into $this->settings
     */
    function load_settings(){
        $settings = get_option($this->namespace, array());
        foreach ($settings as $key=>$value):
            if(array_key_exists($key, $this->settings))
                $this->setting($key, $value);
        endforeach;
    }

    /**
     * Saves settings back to the DB from $this->settings
     */
    function save_settings(){
        $settings = array();
        foreach ($this->settings as $slug=>$setting):
            $settings[$slug] = $setting['value'];
        endforeach;
        add_option($this->namespace, $settings);
    }

}