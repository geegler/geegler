<?php namespace System\Helpers\Error;

use System\Helpers\Url\UrlHelper;

class ErrorHelper
{
	public static function getErrorPage()
	{
		
		echo (str_replace('{{ site_url }}', UrlHelper::baseUrl(),file_get_contents(ERROR_PAGE)));
	}
}