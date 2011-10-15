<?php

require_once(LIBRARY_PATH . DS . 'Database.php');

/**
 * This is the Brand class.
 *
 * @author donal.ellis@rmit.edu.au
 */
Class Brand {

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
		
		// error check for brand name input type
		if(!preg_match("/^[a-zA-Z0-9 _]*$/", $data['brand_name'])) {
			$errors['brand_name'] = 'Only alphanumerics allowed';
		}
		if(!isset($data['brand_name']) || empty($data['brand_name'])) {
			$errors['brand_name'] = 'Please enter a brand name';
		}
		// only unset the name data after checking for all errors
		if(isset($errors['brand_name'])) {
			unset($data['brand_name']);
		}
		
		self::$errors =$errors;
		
		if(count($errors)){
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
    * A method for retrieving brands from the brands table.
    *
    * @param array $data An optional array of key:value pairs to be used as
    *                    parameters in the SQL query.
    * @return array An array of database Objects where each Object represents a
    *               brand.
    */
	public static function retrieve(array $data = array()) {
		
		$sql = 'SELECT * FROM brand, distributor WHERE brand.dist_id = distributor.dist_id';
		$values = array();
		
		if (count($data)) {
      		foreach ($data as $key => $value) {
          			$sql .= " AND {$key} = ?";
          			$values[] = $value;
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
    * Writes a new row to the brands table based on given data.
    *
    * @param array $data The POSTed data.
    * @return int Returns id of the inserted row (or throws an Exception)
    */
	public static function create(array $data) {
	// TODO could do a check here to ensure data exists
		$sql = 'INSERT INTO brand (brand_name, dist_id)
					VALUES (?, ?)';
		$values = array(
			$data['brand_name'],
			$data['dist_id']
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
    * Updates an existing row in the brands table based on given data.
    *
    * @param int $id The row id of the brand to update.
    * @param array $data The POSTed data.
    * @return int bool Whether update was successful or not.
    */
	public static function update($id, array $data) {
		$sql = 'UPDATE brand SET brand_name = ?, dist_id = ? WHERE brand_id = ?';
		$values = array(
			$data['brand_name'],
			$data['dist_id'],
			$id
		);
		
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
