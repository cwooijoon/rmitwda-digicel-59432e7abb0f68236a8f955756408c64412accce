<?php

require_once(LIBRARY_PATH . DS . 'Database.php');

/**
 * This is the Distributor class.
 *
 * @author donal.ellis@rmit.edu.au
 */
Class Distributor {

	/**
	* If validation fails, errors are written to this variable.
	*/
	private static $errors;

	/**
	* A method for validating the data
	*
	* @param $data An array of POSTed data.
	* @return bool Whether the data is valid or not.
	*/
	public static function validates(array &$data) {
		$errors = array();

		// error checks from specific to general
		// error check for distributor name input type
		if(!preg_match("/^[a-zA-Z0-9 _]*$/", $data['dist_name'])) {
			$errors['dist_name'] = 'Only alphanumerics allowed';
		}
		if(!isset($data['dist_name']) || empty($data['dist_name'])) {
			$errors['dist_name'] = 'Please enter a distributor name';
		}
		// only unset the distributor name data after checking for all errors
		if(isset($errors['dist_name'])) {
			unset($data['dist_name']);
		}
		
		// error check for contact number input type
		if(!preg_match("/^[0-9]{10}$/", $data['contact_number'])) {
			$errors['contact_number'] = 'Only 10 digits allowed';
		}
		if(!isset($data['contact_number']) || empty($data['contact_number'])) {
			$errors['contact_number'] = 'Please enter a contact number';
		}
		// only unset the contact number data after checking for all errors
		if(isset($errors['contact_number'])) {
			unset($data['contact_number']);
		}
		
		// error check for email input type
		if(!preg_match("/^[A-Za-z0-9._%-]+@[A-Z0-9.-]+\.[a-z]{2,4}$/", $data['email'])) {
			$errors['email'] = 'invalid email type';
		}
		if(!isset($data['email']) || empty($data['email'])) {
			$errors['email'] = 'Please enter email address';
		}
		// only unset the email data after checking for all errors
		if(isset($errors['email'])) {
			unset($data['email']);
		}

		self::$errors =$errors;
		if(count($errors)) {
			return false;
		}

		return true;
	}
	
	/**
    * Returns any validation errors.
    *
    * @return array An array of errors, or an empty array.
    */
	public static function errors() {
		return self::$errors;
	}

   /**
    * A method for retrieving users from the distributors table.
    *
    * @param array $data An optional array of key:value pairs to be used as
    *                    parameters in the SQL query.
    * @return array An array of database Objects where each Object represents a
    *               distributor.
    */
	public static function retrieve(array $data = array()) {
		$sql = 'SELECT * FROM distributor';
		$values = array();

		if (count($data)) {
      		$count = 0;

      		foreach ($data as $key => $value) {
			if ((++$count) == 1) {
          			$sql .= " WHERE {$key} = ?";
          			$values[] = $value;
        		}
        		else {
          			$sql .= " AND {$key} = ?";
          			$values[] = $value;
       			}
     	 	}	
   		}

  	 	try {
      		$database = Database::getInstance();

	  	 	$statement = $database->pdo->prepare($sql);

   	   		$statement->execute($values);
     		// result is FALSE if no rows found
      		$result = $statement->fetchAll(PDO::FETCH_OBJ);

      		$database->pdo = null;
    	}
    	catch (PDOException $e) {
     		echo $e->getMessage();
      		exit;
    	}

    	if (count($result) > 1) {
      		return $result;
    	}
    	else if (count($result) == 1) {
      		return $result[0];
    	}
    	else {
      		return NULL;
    	}
  }
    /**
    * Writes a new row to the distributors table based on given data.
    *
    * @param array $data The POSTed data.
    * @return int Returns id of the inserted row (or throws an Exception)
    */
	public static function create(array $data) {
	
		// TODO could do a check here to ensure data exists
		$sql = 'INSERT INTO distributor (dist_name, contact_number, email)
					VALUES (?, ?, ?)';
		$values = array(
			$data['dist_name'],
			$data['contact_number'],
			$data['email']
		);

		try {
			$database = Database::getInstance();

			$statement = $database->pdo->prepare($sql);
			$return = $statement->execute($values);

			if ($return) {
				$id = $database->pdo->lastInsertID();
			}

			$database->pdo = null;
		}
		catch (PDOException $e) {
			echo $e->getMessage();
			exit;
		}

		if ($return) {
			return $id;
		}

		return false;
	}
   /**
    * Updates an existing row in the distributors table based on given data.
    *
    * @param int $id The row id of the distributor to update.
    * @param array $data The POSTed data.
    * @return int bool Whether update was successful or not.
    */
	public static function update($id, array $data) {
	
		// TODO could do a check here to ensure data exists
		$sql = 'UPDATE distributor SET dist_name = ?, contact_number = ?, email = ? WHERE dist_id = ?';
		$values = array(
			$data['dist_name'],
			$data['contact_number'],
			$data['email'],
			$id );

		try {
			$database = Database::getInstance();

			$statement = $database->pdo->prepare($sql);
			$return = $statement->execute($values);

			$database->pdo = null;	
		}
		catch(PDOException $e) {
			echo $e->getMessage();
			exit;
		}

		return $return;
	}
}