<?php
if (!class_exists('WP_PluginBase')) require_once('lib/wp-plugin-base/wp-plugin-base.php');
if (!class_exists('GenericPlugin')){

    class GenericPlugin extends WP_PluginBase{

        // Define your class vars here

        function GenericPlugin(){
            $this->__construct();
        }

        function __construct(){
            // Add your constructor here

            parent::__construct();
        }

        // Do some work here
    }

}