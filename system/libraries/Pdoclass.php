<?php namespace System\Libraries\Db; use \PDO;
/*
* 
* Copyright Lorenzo D. Alipio <lorenzodeleonalipio@gmail.com>
* 
* This program is free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation; either version 2 of the License, or
* (at your option) any later version.
* 
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
* 
* You should have received a copy of the GNU General Public License
* along with this program; if not, write to the Free Software
* Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
* MA 02110-1301, USA.
* 
* pdoClass.php
*/


class PdoClass {
 
   private $db;

	public function __construct($host,$db_name,$db_user,$db_pass){
				//require_once('db_config.php');
			
		try{
		$this->db = new PDO('mysql:host='.$host.';dbname='. $db_name .';charset=utf8', $db_user, $db_pass ,array(PDO::ATTR_PERSISTENT => true));
    
	    $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
	    //echo 'connected';
		  return true;
		  
		}
		catch(PDOException $e) {
						return false;
						die('There is a connection error: ' .$e->getMessage());
					}
	}

	private function db_cnx(){
		return $this->db;
	
		}
	
	public function close(){
		if(self::db_cnx()){
			$this->db = null;
		}
	}
	public function query($query){
		if(self::db_cnx()){
			try{
				$this->stmt= $this->db->prepare($query);
				$this->stmt->execute();
				return array(true, $this->stmt->rowCount());
				
			}
		catch(PDOException $e){
			return false;
		}	
		}
		else{
			return false;
		}
	}
	// single item only query
	public function get_item($query){

		if(self::db_cnx()){
			try{
			$this->stmt = $this->db->prepare($query);
			$this->stmt->execute();
			$row_count = $this->stmt->rowCount();
			$result = $this->stmt->fetch();
			return array($result,$row_count);
			}
			 catch(PDOException $e) {
						return false;
						
					}
			}
			else{
				return false;
			}


	}
	//get multiple items as an array
	public function get_items($query){
		if(self::db_cnx()){
			try{
			$this->stmt = $this->db->prepare($query);
			$this->stmt->execute();
			$row_count = $this->stmt->rowCount();
			$result = $this->stmt->fetchAll();
			return array($result,$row_count);
		
		}
		catch(PDOException $e) {
					return false;
				}
		}
		else{
			return false;
		}
	}
	
	public function get_single($query){
		if(self::db_cnx()){
			try{
			$this->stmt = $this->db->prepare($query);
			$this->stmt->execute();
			//$row_count = $this->stmt->rowCount();
			return $this->stmt->fetch();
			//return($result);
			}
			 catch(PDOException $e) {
						return false;
						
					}
			}
			else{
				return false;
			}	
	
	
	
	}
    
    /* db insert */
	public function insert_items($table, $values=array())   {
            if(self::db_cnx()){
			try{
            $fieldnames = array_keys($values);
            $size = sizeof($fieldnames);
            //$i = 1;
            $sql = "INSERT INTO $table";
            $fields = '( ' . implode(' ,', $fieldnames) . ' )';
            $bound = '(:' . implode(', :', $fieldnames) . ' )';
            $sql .= $fields.' VALUES '.$bound;
            $stmt = $this->db->prepare($sql);
		//	echo $bound;
			//print_r(array_values($values));
			
			$x = implode(' ', array_values($values));
			//print_r($x);
			//print '<ul><li>' . implode('</li><li>', $values) . '</li></ul>';
			$stmt->execute(($values));
			}
		
			catch(PDOException $e) {
					return false;
                    /* comment the return false above to view error */
                    die('There is a connection error: ' .$e->getMessage());
						
					}
			}
		
        }
        
    
    
    
    
	public function update_db($tableName, $data, $where='1'){
		$query = 'UPDATE '.$tableName.' SET';
		$values = array();
		if(self::db_cnx()){
			try{
		foreach ($data as $name => $value) {
			$query .= ' '.$name.' = :'.$name.','; 
			$values[':'.$name] = $value; // save the placeholder
			}

			$query = substr($query, 0, -1).';'; // remove last , and add a ;
			

		$this->stmt = $this->db->prepare($query."WHERE '".$where."'");
		
		$this->stmt->execute($values); 
	
	}
	catch(PDOException $e) {
						return false;
						
					}
	}
	}
	
	public function insert($table, $data){
	if(self::db_cnx()){
		try{

			$q="INSERT INTO `$table` ";
	        $v=''; $n='';

	    foreach($data as $key=>$val){
		$n.="`$key`, ";
		if(strtolower($val)=='null') $v.="NULL, ";
		elseif(strtolower($val)=='now()') $v.="NOW(), ";
		else $v.= "'".$this->clean($val)."', ";
	   }

	$q .= "(". rtrim($n, ', ') .") VALUES (". rtrim($v, ', ') .");";
		$this->stmt = $this->db->prepare($q);
		$this->stmt->execute();
		$id = $this->db->lastInsertId();
		return array($this->stmt->rowCount(),$id);
	}
	catch(PDOException $e) {
						return false;
						
					}

    }
}
    private function clean($string){
    	return filter_var($string, FILTER_SANITIZE_STRING);
    }
}
// query for concat category
//$sql = "SELECT cat_id,GROUP_CONCAT(cat_id) from category where parent = \'1\' LIMIT 0, 30 ";	
