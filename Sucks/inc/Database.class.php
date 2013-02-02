<?php
/*
 * Database.class.php extends Singleton
 * Responsible for creating mysqli objects
*/
class Database extends Singleton {
	public static $mysqli;

	/*
	 * mysqli()
	 * Checks if a connection exists. If it doesn't, make one. Return the connection
	 * Returns false on failure
	*/
	public function mysqli(){
		if(isset(self::$mysqli)){
			if(self::$mysqli->connect_error){
				die(self::$mysqli->connect_error);
			} else {
				return self::$mysqli;
			}
		} else {
			self::$mysqli = new mysqli('localhost', 'root', '', 'chain');
			return self::mysqli();
		}
	}
	
	/*
	 * fetchArray(mysqli_result $result)
	 * Fetches an associative array of $result. Array keys are prepended with their respective table names in the format of: (table).(column)
	*/
	public function fetchArray($result){
		$rows = array();
		$fieldcount = $result->field_count;
		$i = 0;
		while($row = $result->fetch_row()){
			for($n = 0; $n < $fieldcount; $n++){
				$meta = $result->fetch_field_direct($n);
				$rows[$i][$meta->table . '.' .  $meta->name] = $row[$n];
			}
			$i++;
		}
        //if(count($rows) == 1) $rows = $rows[0];
		return $rows;
	}

	/*
	 * search(string $table, string[] $columns, string $searchValue, string $exclude=null, boolean $exactMatch=false)
	 * Searches $table for $searchValue inside of $columns. If $exclude is not null, $columns containing $exclude will not be included.
	 * If $exactMatch is true, direction comparison will be used. If false, %LIKE% will be used.
	 * Returns an array of rows, empty array on no results
	 * Returns false on error

	 * Warning: Requires the mysqlnd driver. If the mysqlnd driver is not being used, false will always be returned.
	*/
	public function search($table, $columns, $searchValue, $exclude=null, $exactMatch=false){
		if(strpos(mysqli_get_client_info(), 'mysqlnd ') === false){
			return false;
		}

		$bind = array();
		$result = array();
		$table = self::mysqli()->real_escape_string($table);
		$sql = "SELECT * FROM `$table` WHERE";
		foreach($columns as $key => $col){
			if($key == (count($columns)-1)){
				$sql .= ' ' . $col . ' LIKE ? AND ' . $col . ' NOT LIKE ?';
			} else {
				$sql .= ' ' . $col . ' LIKE ? AND ' . $col . ' NOT LIKE ? OR';
			}
			$bind[0] = (isset($bind[0])) ? $bind[0] . "ss" : 'ss';
			
			if($exactMatch){
				$bind[] = $searchValue;
			} else {
				$bind[] = "%" . $searchValue . "%";
			}
			

			if($exclude == null){
				$bind[] = "";
			} else {
				$bind[] = "%" . $exclude . "%";
			}
		}
		
		foreach($bind as $key => $value){
			$bind[$key] = &$bind[$key]; // Makes them references for bind_param
		}
		
		if($stmt = self::mysqli()->prepare($sql)){
			call_user_func_array(array($stmt, "bind_param"), $bind); // See what I did there? Dynamic bind_param. Nifty
			try {

			} catch(Exception $e){

			}
			$stmt->execute();
			
			$results = $stmt->get_result();
			while($row = $results->fetch_array(MYSQLI_ASSOC)){
				$result[] = $row;
			}
			return $result;
		}
		return false;
	}
}
?>