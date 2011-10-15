<?php

require_once(LIBRARY_PATH . DS . 'Database.php');

/**
 * This is the Category class.
 *
 * @author donal.ellis@rmit.edu.au
 */
Class Category {

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

		// error check for category name input type
		if(!preg_match("/^[a-zA-Z0-9 _]*$/", $data['category_name'])) {
			$errors['category_name'] = 'Only alphanumerics allowed';
		}
		if(!isset($data['category_name']) || empty($data['category_name'])) {
			$errors['category_name'] = 'Please enter a category name';
		}
		// only unset the name data after checking for all errors
		if(isset($errors['category_name'])) {
			unset($data['category_name']);
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
    * A method for retrieving users from the category table.
    *
    * @param array $data An optional array of key:value pairs to be used as
    *                    parameters in the SQL query.
    * @return array An array of database Objects where each Object represents a
    *               category.
    */
	public static function retrieve(array $data = array()) {
		
		$sql = 'SELECT * FROM category';
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
    * Writes a new row to the category table based on given data.
    *
    * @param array $data The POSTed data.
    * @return int Returns id of the inserted row (or throws an Exception)
    */
	public static function create(array $data) {
		$sql = 'INSERT INTO category (category_name)
					VALUES (?)';
		$values = array(
			$data['category_name']
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
    * Updates an existing row in the category table based on given data.
    *
    * @param int $id The row id of the category to update.
    * @param array $data The POSTed data.
    * @return int bool Whether update was successful or not.
    */
	public static function update($id, array $data) {
		$sql = 'UPDATE category SET category_name = ? WHERE category_id = ?';
		$values = array(
			$data['category_name'],
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
