<?php namespace System\Core\Model;

class Model
{
    public function __construct()
    {
        
    }
    
    public static function testSystemModel()
    {
        echo 'this is a test response from : '. __CLASS__;
    }
}