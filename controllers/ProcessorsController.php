<?php

/**
 * This is the Processor Controller class.
 *
 * @author donal.ellis@rmit.edu.au
 */
session_start();

require_once(LIBRARY_PATH . DS . 'Template.php');
require_once(APP_PATH . DS . 'models/Processor.php');
require_once(APP_PATH . DS . 'models/Product.php');
require_once(APP_PATH . DS . 'models/Brand.php');
require_once(APP_PATH . DS . 'models/Category.php');

Class ProcessorsController
{
	public function __construct()
	{
		$this->template = new Template;

		$this->template->template_dir = APP_PATH . DS . 'views' . DS . 'products' . DS . 'processors' . DS;

		$this->template->title = 'Processors';
	}

	public function index()
	{
   	// must be logged in and the admin to access this page
    	if (!isset($_SESSION['user']))
    	{
      		header("Location: /Test/session/new");
   	   		exit;
   		}
    	if ($_SESSION['user']['account_type_id'] > 1)
    	{
    	  	header("Location: /Test/users/{$_SESSION['user']['user_id']}");
     		exit;
    	}

		$this->template->processors = Processor::retrieve();
   		$this->template->display('index.php');
	}

	public function show($id) 
	{
    	// must be logged in to access this page
		if (!isset($_SESSION['user']))
		{
			header("Location: /Test/session/new");
			exit;
		}

		if ($_SESSION['user']['account_type_id'] > 1 && $_SESSION['user']['user_id'] != $id) 
		{
			// this user cannot edit distributors
			header("Location: /Test/users/{$_SESSION['user']['user_id']}");
			exit;
    	}

		$this->template->id = $id;

		// get the user with id = $id
		$processors = Processor::retrieve(array('p.product_id' => $id));
		if (count($processors) == 1) 
		{
			$this->template->processors = $processors;
		} 
		else if (count($processors) == 0) 
		{
			$this->template->id = $id;
		}

		$this->template->display('show.php');
	}

	/** 
	* Only admin can access to this page
	* Admin able to add new processor
	*/
	public function add() 
 	{
		// must be logged in and the admin to access this page
		if (!isset($_SESSION['user'])) 
		{
			header("Location: /Test/session/new");
			exit;
		}
		if ($_SESSION['user']['account_type_id'] > 1) 
		{
			header("Location: /Test/users/{$_SESSION['user']['user_id']}");
			exit;
		}

		//currently no validation

		$this->template->brands = Brand::retrieve();
		$this->template->display('add.php');
	}

	/** 
	* Datase will create new row on processor table, store data entered from admin
	* 
	*/
	public function create()
	{
		if (!isset($_SESSION['user'])) 
		{
      		header("Location: /Test/session/new");
      		exit;
    	}

    	if ($_SESSION['user']['account_type_id'] > 1) 
    	{
      		header("Location: /Test/users/{$_SESSION['user']['user_id']}");
      		exit;
    	}

		if (!isset($_POST) || empty($_POST))
		{
			header("Location: /Test/products/processors/new");
			exit;
		}

		$productData = array(
			'brand_id' => $_POST['brand_id'],
			'stock' => $_POST['stock'],
			'price' => $_POST['price'],
			'warranty' => $_POST['warranty'],
			'comments' => $_POST['comments'],	
			'proc_name' => $_POST['proc_name'],
			'proc_model' => $_POST['proc_model'],
			'proc_speed' => $_POST['proc_speed'] 		
		);

		$id = Processor::create($productData);

		$_SESSION['processors']['product_id'] = $id;
		header("Location: /Test/products/processors/{$id}");
		exit;
	}

	/** 
	* Only admin can access to this page
	* Admin able edit the processor
	*/
	public function edit($id)
	{
		if(!isset($_SESSION['user']))
		{
			header("Location: /Test/session/new");
			exit;
		}
		if($_SESSION['user']['account_type_id'] > 1)
		{
			header("Location: /Test/users/{$_SESSION['user']['user_id']}");
			exit;
		}
		// retrieve the processor from table and disply it on edit page
		if(!$processors = Processor::retrieve(array('p.product_id' => $id)))
		{
			header("Location: /Test/products/processors/{$_SEESION['processors']['product_id']}");
			exit;
		}
		$this->template->processors = $processors;

		if(isset($_SESSION['processors']['errors']))
		{
			$this->template->errors = $_SESSION['processors']['errors'];
			unset($_SESSION['processors']['errors']);
		}

		$this->template->display('edit.php');
	}

	/** 
	* Database update the new data on the processor selected 
	* 
	*/
	public function update($id)
	{
		if(!isset($_SESSION['user']))
		{
			header("Location: /Test/session/new");
			exit;
		}
		if($_SESSION['user']['account_type_id'] > 1)
		{
			header("Location: /Test/users/{$_SESSION['user']['user_id']}");
			exit;
		}

		if(!isset($_POST) || empty($_POST))
		{
			header("Location: /Test/products/processors/{$id}");
			exit;
		}

		if(!Processor::validates($_POST))
		{
			$_SESSION['processors']['errors'] = Processor::errors();
			header("Location: /Test/products/processors/{$id}/edit");
			exit;
		}

		Processor::update($id, $_POST);
		header("Location: /Test/products/processors/{$id}");
		exit;		
	}
}
