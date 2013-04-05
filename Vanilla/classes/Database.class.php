<?php
class Database {
	/* Connection info */
	private $host     = "localhost";
	private $username = "root";
	private $password = "";
	private $database = "smite";
	
	// Our PDO link
	private $PDO;

	public function __construct(){
		try{
			$this->PDO = new PDO("mysql:host=$this->host;dbname=$this->database", $this->username, $this->password);
			$this->PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch(PDOException $e){
			new Error($e->getMessage());
		}
	}

	/*
	 * insert(string $table, array $data)
	 * Inserts a row into $table. Keys for $data are the columns and their values are the values to be inserted.
	 * Returns true on success, false on failure.
	*/
	public function insert($table, $data){
		try {
			$keys = array_keys($data);
			$cols = $keys[0];
			$values = ':' . $keys[0];
			for($i = 1; $i < count($keys); $i++){
				$cols .= ', ' . $keys[$i];
				if($data[$keys[$i]] == "CURRENT_TIMESTAMP" || $data[$keys[$i]] == "NOW()"){
					$values .= ', ' . $data[$keys[$i]];
					unset($data[$keys[$i]]);
				} else {
					$values .= ', :' . $keys[$i];
				}
			}
			$sql = 'INSERT INTO `' . $table . '`(' . $cols . ') VALUES (' . $values . ')';
			$sth = $this->PDO->prepare($sql);
			$sth->execute($data);
			if($sth->rowCount() > 0){
				return true;
			}
			return false;
		} catch(PDOException $e){
			new Error('PDOException: ' . $e->getMessage());
		}
	}

	/* 
	 * select(string $table, array $where)
	 * Selects rows from $table based on $where
	 * $where should be "column" => "value". All column/value pairs are put together using AND, however you can insert an "OR" to do or
	 * IE: $where = array("username" => "admin", "OR", "email" => "admin@mail.com"); // will return row where username is admin OR email is admin@mail.com
	 * IE: $where = array("username" => "admin", "email" => "admin@mail.com"); // Will return row where username is admin AND email is admin@mail.com
	 * Returns array
	*/
	public function select($table, $where){
		try {
			$i = 0;
			$stuff = '';
			$prev_value = '';
			foreach($where as $key => $value){
				if(strtolower($value) != "or"){
					if($i != 0){
						if(strtolower($prev_value) == "or"){
							$stuff .= ' OR ';
						} else {
							$stuff .= ' AND ';
						}
					}
					$stuff .= '`' . $key . '` = :' . $key;
					$where[':' . $key] = $value;
					unset($where[$key]);
				} else {
					unset($where[$key]);
				}
				$i++;
				$prev_value = $value;
			}
			$sql = 'SELECT * FROM `' . $table . '` WHERE ' . $stuff;
			$sth = $this->PDO->prepare($sql);
			$sth->execute($where);
			$result = $sth->fetchAll();
			if(!isset($result[1])){
				return $result[0]; // If only one row is returned, return just that row
			}
		} catch(PDOException $e){
			new Error('PDOException: ' . $e->getMessage());
		}
	}
}