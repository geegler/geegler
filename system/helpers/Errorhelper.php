<?php namespace System\Helpers;

use System\Helpers\UrlHelper;

class ErrorHelper
{
	public static function getErrorPage()
	{
		
		echo (str_replace('{{ site_url }}', UrlHelper::baseUrl(),file_get_contents(ERROR_PAGE)));
	}
	
	public static function testErrorhelper()
	{
		echo 'This is from: '. __CLASS__ .'<br/>';
	}
}
