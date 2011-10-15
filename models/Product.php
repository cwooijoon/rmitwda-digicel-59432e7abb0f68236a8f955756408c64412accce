<?php

require_once(LIBRARY_PATH . DS . 'Database.php');

/**
 * This is the Product class.
 *
 * @author donal.ellis@rmit.edu.au
 */
Class Product {
 
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

		//Currently none

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
    * A method for retrieving products from the products table.
    *
    * @param array $data An optional array of key:value pairs to be used as
    *                    parameters in the SQL query.
    * @return array An array of database Objects where each Object represents a
    *               product.
    */
	public static function retrieve(array $data = array()) {
		
		$sql = 'SELECT * 
				FROM product p, category c, brand b
					WHERE p.category_id = c.category_id
						AND p.brand_id = b.brand_id';
						
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
    * Writes a new row to the products table based on given data.
    *
    * @param array $data The POSTed data.
	* @return int Returns id of the inserted row (or throws an Exception)
    */
	public static function create(array $data) {
	
	// TODO could do a check here to ensure data exists
		$sql = 'INSERT INTO product (category_id, brand_id, stock, price, warranty, comments)
					VALUES (?, ?, ?, ?, ?, ?)';
		$values = array(
			$data['category_id'],
			$data['brand_id'],
			$data['stock'],
			$data['price'],
			$data['warranty'],
			$data['comments']
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
    * Updates an existing row in the products table based on given data.
    *
    * @param int $id The row id of the product to update.
    * @param array $data The POSTed data.
    * @return int bool Whether update was successful or not.
    */
	public static function update($id, array $data) {
		$sql = 'UPDATE product 
					SET category_id = ?, brand_id = ?, stock = ?, price = ?, warranty = ?, comments = ? 
						WHERE product_id = ?';
		$values = array(
			$data['category_id'],
			$data['brand_id'],
			$data['stock'],
			$data['price'],
			$data['warranty'],
			$data['comments']
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
