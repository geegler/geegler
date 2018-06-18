<?php namespace System\Libraries;
//use Dflydev\DotAccessData\Data;//https://packagist.org/packages/dflydev/dot-access-data#v1.1.0
/**
 * @author tester
 * @copyright 2017
 */

class TemplateClass
{
    public function __construct(){
        
    }
    
    public static function render($themefile,$data,$cache= null, $cache_time = null){
         $cachefile_name =  md5($_SERVER['REQUEST_URI']).'__'.$themefile;
        $deftheme = TPL_PHP . $themefile .'.php';
        if($cache && $cache_time){
            $cacheduration = $cache_time;
            $cachefile = DEF_CACHE .$cachefile_name.'.php';
        
        if(file_exists($cachefile) && (time() - $cacheduration < filemtime($cachefile)) ){
             readfile($cachefile);// $cachefile;
             //file_get_contents($cachefile);
             exit();
        }else{
        ob_start();
         header('Content-Type: text/html; charset: UTF-8');
        $data= $data;
        include $deftheme;
        $cachefile = DEF_CACHE .$cachefile_name.'.php';
        $fp = fopen($cachefile, 'w');
        fwrite($fp, ob_get_contents());
        // close the file
        fclose($fp);
        }
        ob_end_flush();
    }else{
        //page caching is disabled
        ob_start();
         header('Content-Type: text/html; charset: UTF-8');
        $data= $data;
        include $deftheme;
        ob_end_flush();
    }
    }
	
	public static function testTemplateClass(){
		echo 'test result from '. __CLASS__ .'<br/>';
	}
}
