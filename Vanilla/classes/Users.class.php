<?php
class Users {

	/*
	 * getById(int $id)
	 * Returns the user with id equal to $id
	 * Returns false if no user with that id
	*/
	public function getById($id){
		$user = $this->database->select('users', array('id'=>$id));
		if(empty($user)){
			return false;
		} else {
			return $user[0];
		}
	}

	/*
	 * create(string username, string password)
	 * Puts a new user in the database
	 * This does not validate/check their info, except for username collisions (will return "Username taken" if username collision found)
	*/
	public function create($username, $password){
		$salt = mcrypt_create_iv(25);
		$password = $salt . hash(_preferred_hash_method, $password);
		$username_check = $this->database->select('users', array('username' => $username));
		if(!empty($username_check)){
			return "Username taken";
		}
		
	}
}