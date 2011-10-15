<?php

require_once(LIBRARY_PATH . DS . 'Database.php');

Class Processor
{

	private static $errors;

	public static function validates(array &$data)
	{
		$errors = array();

		//Currently none

		self::$errors =$errors;
		
		if(count($errors))
		{
			return false;
		}

		return true;
	}

	public static function errors()
	{
		return self::$errors;
	}

	public static function retrieve(array $data = array())
	{
		
		$sql = 'SELECT * 
				FROM product p, processor pr, category c, brand b
					WHERE p.product_id = pr.product_id
					AND p.category_id = c.category_id
					AND p.brand_id = b.brand_id';
						
		$values = array();
		
		if (count($data))
		{
      		foreach ($data as $key => $value)
   		   	{

          		$sql .= " AND {$key} = ?";
          		$values[] = $value;

     	 	}	
   		 }
		
  	 	try
  	 	{
      		$database = Database::getInstance();

	  	 	$statement = $database->pdo->prepare($sql);

   	   		$statement->execute($values);
     		// result is FALSE if no rows found
      		$result = $statement->fetchAll(PDO::FETCH_OBJ);

      		$database->pdo = null;
    	}
    	catch (PDOException $e)
    	{
     		echo $e->getMessage();
      		exit;
    	}

    	if (count($result) > 1)
    	{
      		return $result;
    	}
    	else if (count($result) == 1)
    	{
      		return $result[0];
    	}
    	else
    	{
      		return NULL;
    	}
	}


	public static function create(array $data)
	{
		$sql = 'INSERT INTO processor (proc_name, proc_model, proc_speed, category_id, brand_id, stock, price, warranty, comments)
					VALUES (?, ?, ?, 6, ?, ?, ?, ?, ?)';
		$values = array(
			$data['proc_name'],
			$data['proc_model'],
			$data['proc_speed'],
			$data['brand_id'],
			$data['stock'],
			$data['price'],
			$data['warranty'],
			$data['comments']
		);
		
		try
		{
			$database = Database::getInstance();

			$statement = $database->pdo->prepare($sql);
			$return = $statement->execute($values);

			if ($return)
			{
				$id = $database->pdo->lastInsertID();
			}
			
			$database->pdo = null;
		}
		catch (PDOException $e)
		{
			echo $e->getMessage();
			exit;
		}

		if ($return)
		{
			return $id;
		}

		return false;
	}
	
	public static function update($id, array $data)
	{
		$sql = 'UPDATE processor 
					SET proc_name = ?, proc_model = ?, proc_speed = ?, brand_id = ?, stock = ?, price = ?, warranty = ?, comments = ? 
						WHERE proc_id = ?';
		$values = array(
			$data['proc_name'],
			$data['proc_model'],
			$data['proc_speed'],
			$data['brand_id'],
			$data['stock'],
			$data['price'],
			$data['warranty'],
			$data['comments'],
			$id
		);
		
		try
		{
			$database = Database::getInstance();
			
			$statement = $database->pdo->prepare($sql);
			$return = $statement->execute($values);
			
			$database->pdo = null;	
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
			exit;
		}
		
		return $return;
	}
}
