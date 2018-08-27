<?php if(!defined('_VALID_ACCESS')) die('direct access is not allowed.');

class DB{
	var $conn;
	
	function connect($host, $user, $pass, $dbase){
		$this->conn = mssql_connect($host, $user, $pass) or die('Koneksi gagal : ' . mssql_get_last_message());
		if($this->conn){
			mssql_select_db($dbase, $this->conn) or die('Tidak dapat memilih database : ' . mssql_get_last_message());
		}
		return $this->conn;
	}
	
	function close(){
		mssql_close($this->conn);
	}

	
	function query($query){
		$query = mssql_query($query, $this->conn);
		return $query;
	}
	
	function insert($table, $data=NULL){
		$fields  = "";
		$values = "";
		$query = "";
		foreach ($data as $k => $v){
			$fields .= "$k,";
			$values .= "'".preg_replace('/[\']/', '"',$v)."',";
		}
		$fields = substr($fields,0,-1);
		$values = substr($values,0,-1);
		$query = "SET DATEFORMAT DMY INSERT INTO ".$table." (".$fields.") VALUES (".$values.")";
		return $this->query(str_replace("'GETDATE()'","GETDATE()",$query));
	}

	function update($table,$data=NULL,$clausa="") {
        $string = "";
        $query = "";
        foreach($data as $k => $v){
            $string .= $k . "=".$v.",";
        }
        $string = substr($string,0,-1);
        $string = preg_replace( "/,$/" , "" , $string);
      	if(isset($clausa)){
			foreach ($clausa as $field => $value){
			  $field_names  = "$field = ";
			  $field_values = "$value AND ";
			  $xclausa .= $field_names.$field_values;
			}
			$xclausa = substr($xclausa, 0, -4);
			$xclausa = preg_replace( "/,$/" , "" , $xclausa );
			$query = "SET DATEFORMAT DMY UPDATE ".$table." SET ".$string." WHERE ".$xclausa."";
			if(!$query){
			  die($query);
			}
		}else{
			$query = "SET DATEFORMAT DMY UPDATE ".$table." SET ".$string."";
			if (!$query){
				die($query);
			}
		}
        return $this->query(str_replace("'GETDATE()'","GETDATE()",$query));
	}

	function num_row($query){ 
		$num_rows = mssql_num_rows($this->query($query));
		return $num_rows;
	}
	
	function row($query){
		$rows = mssql_fetch_array($this->query($query),MSSQL_ASSOC);
		return $rows;
	}
	
	function get_uraian($query, $select){
		if($this->num_row($query) > 0){
			$q = $this->row($query);
			return $q[$select];
		}else{
			return "";
		}
	}
	
	function result_array($query){
		$data = $this->query($query);
		if($this->num_row($query) == 0){
			return array();
		}
		while($row = mssql_fetch_array($data, MSSQL_ASSOC)){
			$result_array[] = $row;
		}
		return $result_array;
	}
	
	function num_fields($query){
		$data = $this->query($query);
		return @mssql_num_fields($data);
	}
	
	function fields_name($query){
		$field_names = array();
		$data = $this->query($query);
		while ($field = mssql_fetch_field($data)){
			$field_names[] = $field->name;
		}
		return $field_names;
	}
	
	function affected_rows(){
		return @mssql_rows_affected($this->conn);
	}
}
?>