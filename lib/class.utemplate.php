<?php
/**
 * uTemplate
 * A (very!) simple template renderer for PHP
 *
 * Usage: uTemplate::render('/path/to/my/template.php',
 *                                array('title'=>'Hello World!', 'text'=>"How's the weather?"),
 *                                true)
 * // template.php
 * <?php
 * <h1><?=$title?></h1>
 * <p><?=$text?></p>
 *
 * @author Dan Drinkard <dan.drinkard@gmail.com>
 * @copyright Copyright (c) 2011, Dan Drinkard
 * @license http://opensource.org/licenses/MIT MIT
*/
if(!class_exists('uTemplate')){
    class uTemplate {
        function parse($file, $context=array()){
            foreach($context as $key=>$value):
                $$key = $value;
            endforeach;
            ob_start();
            include($file);
            $html = ob_get_contents();
            ob_end_clean();

            return $html;
        }

        function render($file, $context=array()){
            echo uTemplate::parse($file, $context);
        }
    }
}