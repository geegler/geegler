<?php namespace System\Libraries;

use \Twig_Autoloader;
use \Twig_Environment;
use \Twig_Loader_Filesystem;

Class TwigLib{

public function  __construct(){

	/*
	Ini_object::instance('Smarty');
	  $this->tpl = Ini_object::instance('Smarty');
	  $this->tpl->left_delimiter = '{% ';
    $this->tpl->right_delimiter = ' %}';
	  $this->tpl->template_dir = ( THEME_DIR );
    $this->tpl->compile_dir  = ( THEME_COMPILE );
    $this->tpl->caching = 0;
    $this->tpl->setCompileCheck(true);
    $this->tpl->cache_dir    = ( THEME_CACHE );
    $this->tpl->config_dir   = ( THEME_CONFIG );
    $this->settings = SiteSettings::getSiteSettings();
    */
	Twig_Autoloader::register();

}


public function set_content($content=array(),$templateName = null){
	/*
	//if (is_array($content)){
          $this->tpl->assign(self::siteCredentials());
	        $this->tpl->assign('content', $content);
	 return $this->tpl->display(THEME .$templateName);
	
	//}
	
	*/
	
	//$test = array('test'=>$content);
	//var_dump($test);
	
	Twig_Autoloader::register();
	try {
        ## define template directory
      $themeDir = new Twig_Loader_Filesystem(TWIG_TPL);
 
        ## initialize a new Twig environment
      $twig = new Twig_Environment($themeDir, array(
        'cache'       => TWIG_CACHE,
        'auto_reload' => true
      ));
 
      ## load template
      $theme = $twig->loadTemplate($templateName);
      
      
 
      ## We can set template variables and  render template as shown by the codes below
      echo $theme->render(array (
	  'content'=>$content,
      ));
 
    }
    catch (Exception $e) {
      die ('ERROR: ' . $e->getMessage());
    }
    
	}
	
	private function siteCredentials(){
	
	/*
    $this->tpl->assign(array(
         'copyright' => $this->settings->getSetting('sitecopyright'),
         'title' => $this->settings->getSetting('sitename'),
         'theme_style' => 'view/themes/green/',
         'process' => "pdo_data.php"
         ));
     */    
    }
	public static function test(){
		echo __CLASS__.'<br/>';
	}
}	
