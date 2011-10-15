<?php

require_once(LIBRARY_PATH . DS . 'Database.php');

Class Order
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
				FROM model';
						
		$values = array();
		
		if (count($data))
		{
      		foreach ($data as $key => $value)
   		   	{
          		if ((++$count) == 1)
        		{
          			$sql .= " WHERE {$key} = ?";
          			$values[] = $value;
        		}
        		else
        		{
          			$sql .= " AND {$key} = ?";
          			$values[] = $value;
       			}
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


	public static function show(array $data = array())
	{
		
		$sql = 'SELECT * 
					FROM processor, graphics, harddisk, monitor, motherboard, optical_rom, ram, model
						WHERE model.graphics_1 = graphics.graphics_id
							AND model.harddisk_1 = harddisk.hdd_id
							AND model.monitor_1 = monitor.disp_id
							AND model.motherboard_1 = motherboard.mb_id
							AND model.optical_rom_1 = optical_rom.rom_id
							AND model.processor_1 = processor.proc_id
							AND model.ram_1 = ram.ram_id
							AND model.model_id = ?';
						
		$values = array(
			$data['model_id']
		);
		
  	 	try
  	 	{
      		$database = Database::getInstance();

	  	 	$statement = $database->pdo->prepare($sql);

   	   		$statement->execute($values);
     		// result is FALSE if no rows found
      		$result = $statement->fetchAll(PDO::FETCH_ASSOC);

			if($result)
			{
				$query = "SELECT * FROM processor, harddisk, ram, model
								WHERE model.processor_2 = processor.proc_id
								AND model.harddisk_2 = harddisk.hdd_id
								AND model.ram_2 = ram.ram_id
								AND model.model_id = ?";
								
				$statement1 = $database->pdo->prepare($query);
				$statement1->execute($values);
				$return = $statement1->fetchAll(PDO::FETCH_ASSOC);
			}

      		$database->pdo = null;
    	}
    	catch (PDOException $e)
    	{
     		echo $e->getMessage();
      		exit;
    	}
    	
    	array_push($result, $return);

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

	public static function confirm(array $data)
	{
		
	}

	/*
	public static function create(array $data)
	{
		$sql = 'INSERT INTO product (category_id, brand_id, stock, price, warranty, comments)
					VALUES (1, ?, ?, ?, ?, ?)';
		$values = array(
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
				
				$values2 = array(
					$id,
					$data['proc_name'],
					$data['proc_model'],
					$data['proc_speed'],
				);
				
				$query = 'INSERT INTO processor (product_id, proc_name, proc_model, proc_speed)
							VALUES (?, ?, ?, ?)';
							
				$prepare = $database->pdo->prepare($query);
				$prepare->execute($values2);
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
		$sql = 'UPDATE product 
					SET brand_id = ?, stock = ?, price = ?, warranty = ?, comments = ? 
						WHERE product_id = ?';
		$values = array(
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
			
			if ($return)
			{
				$values2 = array(
					$data['proc_name'],
					$data['proc_model'],
					$data['proc_speed'],
					$id
				);
				
				$query = 'UPDATE processor 
							SET proc_name = ?, proc_model = ?, proc_speed = ?
								WHERE product_id = ?';
							
				$prepare = $database->pdo->prepare($query);
				$prepare->execute($values2);
			}
			
			$database->pdo = null;	
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
			exit;
		}
		
		return $return;
	}*/
}
