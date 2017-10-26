<?php namespace System\Helpers\Form;


class FormHelper
{
	///private $input, $submit, $textarea;
	
	public function __construct()
	{
		
	}

	public function openForm($method,$action, $type = null, $class = null,$id = null)
	{
		$class = (isset($class) ? 'class="'.$class.'"' : '');
		$id = (isset($id) ? 'id="'.$id.'"' : '');
		$type = (isset($type) ? 'type = "'.$type.'"' : '');
		
		
		return '<form '. $class .' '. $id .'  '. $type .'  method = "'. $method .'" action = "'. $action .'" >';
	}
	
	public function closeForm(){
		return '</form>';
	}
	
	public function validateToken($current_time, $stored_time, $token_max_life){
		if(isset($current_time) && isset($stored_time)){
			$stored_time = explode('___',$stored_time);
			$token_age = trim(base64_decode($stored_time[1]));
			$token_age = ($current_time - $token_age);
			return($token_age <= $token_max_life ? True : False );
		}
		
			return False;
	}
	
	public function inputProtect()
	{
		$current_time = $time_created = time();
		$token_max_life = (60 * 30); //30 minutes
		
		$token = md5('ewpcnverigAdQrtoijbbnLQXCKFOEIqlpsbnvgr829403rfWFFsdkotw');
		$token = $token .'___'. base64_encode($time_created);
		//To do make sure the session is not expire //
		if(isset($_SESSION['form_submission']) && $_SESSION['form_submission'] === $token && self::validateToken($current_time,$_SESSION['form_submission'], $token_max_life)){
			
			$input_token = $_SESSION['form_submission'];
			
		}else{
			  $input_token = $token;
		}
		   return '<input type="hidden" name="security_token" value ="'.$input_token .'">';
	}
	
	
	public function makeInput($type, $name, $value=null, $attributes = null, $id = null, $class= null, $jqueryvalidation = null)
	{
		//return '<input type = "'. $type .'" name ="'. $name .'" >';
		$input = '<input type="'.$type.'" name = "'.$name.'" ';
		$input .= ($value ? 'value ="'.$value.'" ' : '');
		$input .= ($attributes ? ' '. $attributes .' ' : '');
		$input .= ($id ? 'id = "'.$id.'" ' : '');
		$input .= ($class ? ' class="'.$class.'" ' : '');
        $input .= ($jqueryvalidation ? $jqueryvalidation : '');
		$input .= ' />';
		
		return $input;
		
	}
	
	public function makeSelect($name, $options = array(), $style = null)
    {
		if(is_array($options)){
			$select = '<select name="'.$name.'" ';
			$select .= (isset($style)? $style : '');
			$select .= '>';
			
			
			foreach($options as $option){
					$select .= '<option>'. $option .'</option>';
					}
					
				//$select  .= $items;
				$select  .= '</select>';
				
				return $select;
		}
	
    }
	
	public function testFormHelper(){
		echo 'Test result from :'.__CLASS__;
	}
}