<?php namespace System\Helpers\Url;

use App\Config\Url\UrlExt as Config;


class UrlHelper
{

    //for validExt(), please see localhost/geegler/demos/test.php

    public static function cleanUrl()
    {


        $requested_url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        if(substr($requested_url, -1) !=='/'){
            header('location: '. $requested_url .'/');
            die();
        }

        foreach (Config::urlExtensions() as $ext) {

            $ext = trim($ext);

            if (strpos($requested_url, $ext) !== false) {
                
                $modified_url = trim(str_replace($ext, '', $requested_url));
                
                if(substr($modified_url,-1) !== '/'){
                    header('Location: ' . $modified_url .'/' );

                      die();
                }
                else{
                    header('location: '. $modified_url);
                    die();
                }

                


            }


        }


    }


    public static function baseUrl()
    {

        if (isset($_SERVER['HTTP_HOST'])) {

            $base_url = (empty($_SERVER['HTTPS']) or strtolower($_SERVER['HTTPS']) === 'off') ?
                'http' : 'https';

            $base_url .= '://' . $_SERVER['HTTP_HOST'];

            $base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

        } else {

            $base_url = 'http://localhost/';

        }


        return ($base_url);


    }


    public static function testUrlHelper()
    {

        echo 'from ' . __class__ . '<br/>';

    }

}
