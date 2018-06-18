<?php namespace System\Helpers;

class CsrfHelper
{
	public function __construct(){
	
	}
	
	public function getTokenId() {
        if(isset($_SESSION['token_id'])) { 
                return $_SESSION['token_id'];
        } else {
                $token_id = $this->random(10);
                $_SESSION['token_id'] = $token_id;
                return $token_id;
        }
	}
	
	public function check_valid($method) {
        if($method == 'post' || $method == 'get') {
                $post = $_POST;
                $get = $_GET;
                if(isset(${$method}[$this->get_token_id()]) && (${$method}[$this->get_token_id()] == $this->get_token())) {
                        return true;
                } else {
                        return false;   
                }
        } else {
                return false;   
        }
	}

	public function form_names($names, $regenerate) {
 
        $values = array();
        foreach ($names as $n) {
                if($regenerate == true) {
                        unset($_SESSION[$n]);
                }
                $s = isset($_SESSION[$n]) ? $_SESSION[$n] : $this->random(10);
                $_SESSION[$n] = $s;
                $values[$n] = $s;       
        }
        return $values;
	}
	
	public static function randomString() {
        if (function_exists('openssl_random_pseudo_bytes')) {
                $string = base64_encode(openssl_random_pseudo_bytes(30));
        } else{
                $string = random_bytes(30);//substr(md5(mt_rand()), 0, 30);
    
        }
 //use this if + and / are not needed
		$find = array('+','/');
		$rep = array('P','S');
        return(str_replace($find,$rep,$string));
        //return (str_replace('/','S',$string));
}



}