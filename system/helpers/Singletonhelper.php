<?php namespace Geegler\Helpers;

final class SingletonHelper{
 
    /**
     * Maintains collection of instantiated classes
     */
    private static $instances = array();
    
    /**
     * Overload constructor
     */
    private function __construct(){}
    
    /**
     * Manages instantiation of classes
     * 
     * @param $class
     * 
     * @return self instance of the class
     */
    public static function instance($class)
    {        
        //instantiate class as necessary
        self::create($class);    
        
        //return instance
        return self::$instances[$class];
    }
    
    /**
     * Creates the instances
     * 
     * @param $class
     * 
     * @return none
     */
    private static function create($class)
    {
        //check if an instance of requested class exists
        if (!array_key_exists($class , self::$instances))
        {
            self::$instances[$class] = new $class;
        }
    }
}