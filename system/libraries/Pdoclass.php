<?php namespace System\Libraries; use \PDO;
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

	public function __construct(array $dbcredits){
				
				if (is_array($dbcredits)){
					$host = $dbcredits['host'];
					$db_name = $dbcredits['dbname'];
					$db_user = $dbcredits['dbuser'];
					$db_pass = $dbcredits['dbpass'];
				}
			
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

	public function dbCon(){
		return $this->db;
	
		}
	
	public function close(){
		if(self::dbCon()){
			$this->db = null;
		}
	}
	public function query($query, $type){
		if(self::dbCon()){
			try{
				$this->stmt= $this->db->prepare($query);
				$this->stmt->execute();
				//return array(true, $this->stmt->rowCount());
				if($type='select'){
					return $this->stmt->fetch(PDO::FETCH_ASSOC);
				}
				
				
				
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
	public function getItem($query){

		if(self::dbCon()){
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
	/*
	* select item
	* example:
	* $res = $crud->dbSelect('animals', 'animal_id', 3 );
	*/
	//this will replace get_items method below
	public function dbSelect($table, $fieldname=null, $id=null)
        {
            self::dbCon();
            $sql = "SELECT * FROM `$table` WHERE `$fieldname`=:id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
			$row_count = $stmt->rowCount();
            $result = $stmt->fetch();//fetchAll(PDO::FETCH_ASSOC);
			return array($result,$row_count);
        }

	//get multiple items as an array
	public function get_items($query){
		if(self::dbCon()){
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
		if(self::dbCon()){
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
	/* example
	$db->insert_items(
						  'members', 
						[
						'firstName' => 'Bryan',
						'lastName' => 'Lee',
						'userName' => 'bLee', 
						'email'   => 'blee@gmail.com',
						]
						);
	
	
	
	
	*/
	public function insert_items($table, $values=array())   {
            if(self::dbCon()){
			try{
            $fieldnames = array_keys($values);
            $size = sizeof($fieldnames);
            //$i = 1;
            $sql = "INSERT INTO $table";
            $fields = '( ' . implode(' ,', $fieldnames) . ' )';
            $bound = '(:' . implode(', :', $fieldnames) . ' )';
            $sql .= $fields.' VALUES '.$bound;
            $stmt = $this->db->prepare($sql);
		
			$stmt->execute(($values));
			}
		
			catch(PDOException $e) {
					return false;
                    /* comment the return false above to view error */
                    die('There is a connection error: ' .$e->getMessage());
						
					}
			}
		
        }
        
    
	
	/*
    * example:
		 * $crud->dbUpdate('animals', 'animal_name', 'troy', 'animal_id', 3);
			('table name','column to update', 'value to update', 'col_id','id_no')
     */
        public function dbUpdate($table, $fieldname, $value, $pk, $id)
        {
            self::dbCon();
            $sql = "UPDATE `$table` SET `$fieldname`='{$value}' WHERE `$pk` = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->execute();
        }
		
	public function dbUpdateArray($table, $fieldnames= array(), $sort_fieldname){
		if(is_array($fieldnames)){
			$q_a = 'UPDATE '.$table .' SET ';
			$q_b = '';
		foreach($fieldnames as $field => $value){
			if($field == $sort_fieldname){
				
			}else{
				$q_b .= $field.'=:'. $field .', ';
			}
		}
			$q_b .= substr(trim($q_b), 0, -1);
			$q_c = ' WHERE '.$sort_fieldname .'=:'.$sort_fieldname;
			$query = $q_a . $q_b . $q_c;
			$stmt = $this->db->prepare($query);
			$stmt->execute($fieldnames);
			
		}
	}
    
	
	public function dbDelete($table, $fieldname, $id)
        {
            if(self::dbCon()){
            $sql = "DELETE FROM `$table` WHERE `$fieldname` = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->execute();
			
			return true;
			
			}else{
				return false;
			}
        }
		
	public function insert($table, $data){
	if(self::dbCon()){
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
	/*
	Join sample array
	$query = [
			  'members' =>['userID','uniqID',
						  'firstName', 'lastName',
			              'userName',
			               ],
				'user_settings' =>['userBio','userLocation', 'userProfile', 'userIndustry', 'userFquote',
								   'allowComments','allowInvites','acceptGifts', 'instantFriend', 'acceptGifts',
								   'shareProfile', 'shareAlbum', 'shareFriends', 'shareGroup', 'sharePlaylist',
				                 ],
				'ON' =>['userID' => 'userID',
					   ],
				'WHERE'=>['shareProfile' => 1],
				'AND' => 'uniqID',
				'BIND' => 'uniqID',
				];
	
	
	*/
	public function joinQuery($query = array(), $table_a, $table_b,$bind_value){
		if(self::dbCon()){
			try{
		if(count($query) == 6){
			$keys = array_keys($query);
			$table_a = ((isset($keys[0]) && $keys[0] == $table_a) ? $keys[0] : '');
			$table_b = $keys[1];
			$on = ((isset($keys[2]) && $keys[2] == 'ON')? $keys[2] : '' );
			$where = ((isset($keys[3]) && $keys[3] == 'WHERE')? $keys[3] : '');
			$and = ((isset($keys[4]) && $keys[4] == 'AND')? $keys[4] : '');
			$bind = ((isset($keys[5]) && $keys[5] == 'BIND' && (isset($bind_value)))? $keys[5] : '');
			$aa = $table_a[0];
			$ab = $table_b[0]; 
		// we have a full
			$a = "SELECT ";
			$x = 0;
		//foreach($query as $table => $fieldnames){
		if($query[$table_a] && is_array($query[$table_a])){
			foreach($query[$table_a] as $first){
				//echo $first .'<br/>';
				$a .= ' '.$aa.'.'.$first .',';
			}
		}
		if($query[$table_b] && is_array($query[$table_b])){
			foreach($query[$table_b] as $sec){
				$a .= ' '.$ab.'.'.$sec .',';
			}
		}
		$af = substr(trim($a), 0, -1);
		$af .= ' FROM '. $table_a .' '. $aa .' JOIN '. $table_b .' '.$ab .' '. $on .' ' ;
		if($on == 'ON' && (is_array($query[$on]))){
			foreach($query[$on] as $k => $v){
				$af .= $aa.'.'. $k .' = '. $ab.'.'.$v;
			}
		}
		if($where == 'WHERE' && is_array($query[$where])){
			$af .= ' WHERE ';
			foreach($query[$where] as $kk => $vv){
				$af .= $ab.'.'.$kk .' = '. $vv .' ';
			}
		}
		if($and == 'AND' && (isset($query[$and]))){
			$af .= 'AND';
			if($bind == 'BIND' && ($query[$and] == $query[$bind])){
				$af .= ' '. $aa.'.'.$query[$bind] .' =:'.$query[$bind];
			}
		}
		//echo (':'.$query[$bind].'value'. $bind_val) .'<br/>';
		  $stmt = $this->db->prepare($af);
          $stmt->bindParam(':'.$query[$bind], $bind_value);
          $stmt->execute();
		  $res = $stmt->fetch(PDO::FETCH_ASSOC);
		 //print_r(json_encode($res));
	//}
	//echo $af .'<br/>';
			return $res;
		}
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
