<?php namespace System\Core\Controller;
//use System\Libraries\Tbs\GeeglerTbs;
use System\Core\Model\Model;
use System\Core\View\View;

/**
 * Controller
 * 
 * @package   
 * @author Lorenzo De Leon Alipio
 * @copyright geegler.com
 * @version 2015
 * @access public
 */
class Controller
{
 
    private $model,$view;
    private $render;
	
	
 
    public function __construct()
    {
       //$this->render = new GeeglerTbs();
       //$this->getRender();
    }
    
    public function getRender(){
        //$this->render = new GeeglerTbs();
         //return $this->render;
    }
    public static function testSystemController()
    {
        echo 'This is a test response from : '. __CLASS__;
        echo '<br/>';
        Model::testSystemModel();
        echo '<br/>';
        View::testSystemView();
    }
}