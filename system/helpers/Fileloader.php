<?php
namespace System\Helpers\FileLoad;

/**
 * Loader
 * 
 * @package   
 * @author Lorenzo De Leon Alipio
 * @copyright geegler.com
 * @version 2015
 * @access public
 */
 
class Loader
{
    public static function load_config($config_name)
    {

        if (file_exists(CONFIG . $config_name . '.php')) {
            require_once (CONFIG . $config_name . '.php');
            //echo CONFIG.$config_name.'.php';

        }

    }
    
    public static function load_theme_file($template_file,$engine_type = 'native' ){
        if($engine_type == 'native'){
            if(file_exists($template_file)){
                include_once($template_file);
            }
        }
    }

    public static function load_config_xml($xml_file){
        if(file_exists(CONFIG_XML . $xml_file . '.xml')){
            return simplexml_load_file(CONFIG_XML . $xml_file . '.xml');
        }
    }
    public static function load_helper($helper_name)
    {

        if (file_exists(HELPER . $helper_name . '.php')) {
            require_once (HELPER . $helper_name . '.php');

        } else {
            return false;

        }

    }

    public static function load_library($lib_name)
    {
        if (file_exists(LIB . $lib_name . '.php')) {
            require_once (LIB . $lib_name . '.php');

        }

    }

    public static function load_controller($controller_name)
    {

        if (file_exists(CONTROLLER . strtolower($controller_name . '.php'))) {
            require_once (CONTROLLER . strtolower($controller_name . '.php'));
			return true;

        }else{
			return false;
		}

    }
    
    public static function load_model($model_name)
    {
        if(file_exists(MODEL . strtolower($model_name . 'model.php'))){
            
            require_once(MODEL .strtolower($model_name . 'model.php'));
            
        }
    }

    public static function load_sylib($lib_name)
    {
        if (file_exists(SYS_LIB . $lib_name . '.php')) {
            require_once (SYS_LIB . $lib_name . '.php');
        }
    }
	
	public static function load_error(){
		if(file_exists(ERROR_PAGE)){
		echo (file_get_contents(ERROR_PAGE));
		
		}
		
	}
    
    public static function testFileLoader()
    {
        echo 'from'. __CLASS__ .'<br/>';
    }

}
