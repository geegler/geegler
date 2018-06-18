<?php namespace System\Helpers;

//use App\Config\Url\UrlExt as Config;


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
		$exts = array('.php','.html','.tpl','.cgi','.html','.inc');
        foreach ($exts as $ext) {

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
	/*
	escape the url for form submission
	*/
	public static function escURL($url) {
 
		if ('' == $url) {
			return $url;
		}
	 
		$url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
	 
		$strip = array('%0d', '%0a', '%0D', '%0A');
		$url = (string) $url;
	 
		$count = 1;
		while ($count) {
			$url = str_replace($strip, '', $url, $count);
		}
	 
		$url = str_replace(';//', '://', $url);
	 
		$url = htmlentities($url);
	 
		$url = str_replace('&amp;', '&#038;', $url);
		$url = str_replace("'", '&#039;', $url);
	 
		if ($url[0] !== '/') {
			// We're only interested in relative links from $_SERVER['PHP_SELF']
			return '';
		} else {
			return $url;
		}
	}
    public static function testUrlHelper()
    {

        echo 'from ' . __class__ . '<br/>';

    }

}
