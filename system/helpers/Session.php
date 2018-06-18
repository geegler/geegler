<?php namespace System\Helpers;
if (session_status() === PHP_SESSION_NONE) session_start();


class SessionHelper
{
	public function __construcrt(){
		
	}
	
	public static function setSession($session_name, $session_value){
		if(!(isset($_SESSION[$session_name]))){
			$_SESSION[$session_name] = $session_value;
		}
		
	}
	
	public static function setSessions($sessionNames = array()){
		if(is_array($sessionNames)){
			foreach($sessionNames as $index => $value){
				if(!isset($_SESSION[$index])){
					$_SESSION[$index] = $value;
				}
				
			}
		}else{
			
			  return false;
		}
	}
	
	public static function verifySession($session_name, $session_value = null){
		if(isset($_SESSION[$session_name]) && ($session_value)){
			return true;
		}
	}
	
	public static function verifySessions($session_names = array()){
		if (is_array($session_names)){
			foreach($session_names as $sname){
				
			}
		}
	}
	
	public static function removeSession($session_name){
		if(isset($_SESSION[$session_name])){
			unset($_SESSION[$session_name]);
		}
	}
	
	public static function removeSessions($session_names = array()){
		if(is_array($session_names)){
			foreach($session_names as $index){
				if(isset($_SESSION[$index])){
					unset($_SESSION[$index]);
				}
			}
		}
	}






}