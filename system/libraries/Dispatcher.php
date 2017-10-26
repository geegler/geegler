<?php namespace System\Libraries\Dispatch;

use System\Helpers\Error\ErrorHelper;
use \ReflectionClass;
use \InvalidArgumentException;

class Dispatcher implements DispatcherInterface
{
    protected $params = array();
    public function __construct($uri_segments)
    {
        //print_r($uri_segments);
        
        
        @list($controller, $method, $params) = explode('/', $uri_segments, 3);
        if (isset($controller)) {
            $this->requestedController($controller);
            
        }
        if (isset($method)) {
            $this->requestedMethod($method);
            //echo $method .'<br/>';
        }
        if (isset($params)) {
            $params = array_filter(explode("/", $params));

            $this->requestedParams($params);

        }

    }

    public function requestedController($controller)
    {

        if (file_exists(APPPATH . 'controllers/' . strtolower($controller) . '.php')) {
            require_once (APPPATH . 'controllers/' . strtolower($controller) . '.php');
            if (!class_exists($controller)) {
                //throw new InvalidArgumentException("The action controller '$controller' has not been defined.");
               ErrorHelper::getErrorPage();
          die();
            }
            $this->controller = $controller;
            return $this;
        }else{
			ErrorHelper::getErrorPage();
          die();
		}
    }

    public function requestedMethod($method)
    {
        $reflector = new ReflectionClass($this->controller);
        if (!$reflector->hasMethod($method)) {
           // throw new InvalidArgumentException("The controller action '$action' has been not defined.");
           ErrorHelper::getErrorPage();
          die();
        }
        $this->method = $method;
        return $this;
    }

    public function requestedParams(array $params)
    {
       $this->params = $params;
        return $this;
    }

    public function serveRequest()
    {
      call_user_func_array(array(new $this->controller, $this->method), $this->params);
    }
    
    public static function testDispatcher()
    {
        echo 'this is from dispatcher' . __namespace__ . '<br/>';
    }


}
