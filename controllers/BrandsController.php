<?php

/**
 * This is the Brand Controller class.
 *
 * @author donal.ellis@rmit.edu.au
 */
session_start();

require_once(LIBRARY_PATH . DS . 'Template.php');
require_once(APP_PATH . DS . 'models/Brand.php');
require_once(APP_PATH . DS . 'models/Distributor.php');

Class BrandsController
{
	public function __construct()
	{
		$this->template = new Template;
		$this->template->template_dir = APP_PATH . DS . 'views' . DS . 'brands' . DS;

		$this->template->title = 'Brands';
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

		$this->template->brands = Brand::retrieve();
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
			header("Location: /Test/users/{$_SESSION['user']['user_id']}");
			exit;
    	}
		// get the user with id = $id
		$this->template->id = $id;

		$brands = Brand::retrieve(array('brand_id' => $id));

		if (count($brands) == 1) 
		{
			$this->template->brands = $brands;
		} 
		else if (count($brands) == 0) 
		{
			$this->template->id = $id;
		}

		$this->template->display('show.php');
	}

	/** 
	* Only admin can access to this page
	* Admin able to add new brand
	*/
	public function add() 
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

		if (isset($_SESSION['brands']['errors'])) 
		{
			$this->template->errors = $_SESSION['brands']['errors'];
			unset($_SESSION['brands']['errors']);
		}
		if (isset($_SESSION['brands'])) 
		{
			$this->template->brands = $_SESSION['brands'];
			unset($_SESSION['brands']);
		}

		$this->template->distributors = Distributor::retrieve();
		$this->template->display('add.php');
	}

	/** 
	* Datase will create new row on brand table, store data entered from admin
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
			header("Location: /Test/brands/new");
			exit;
		}

		$data = array(
			'brand_name' => $_POST['brand_name'],
			'dist_id' => $_POST['dist_id']
		);

		if(!Brand::validates($data))
		{
			$_SESSION['brands'] = $data;
			$_SESSION['brands']['errors'] = Brand::errors();
			header("Location: /Test/brands/new");
			exit;
		}

		$id = Brand::create($_POST);
		$_SESSION['brands']['brand_id'] = $id;
		header("Location: /Test/brands/{$id}");
		exit;
	}

	/** 
	* Only admin can access to this page
	* Admin able edit the brand
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

		// retrieve the brand from table and disply it on edit page
		if(!$brands = Brand::retrieve(array('brand_id' => $id)))
		{
			header("Location: /Test/brands/{$_SEESION['brands']['brand_id']}");
			exit;
		}
		$this->template->brands = $brands;

		if(isset($_SESSION['brands']['errors']))
		{
			$this->template->errors = $_SESSION['brands']['errors'];
			unset($_SESSION['brands']['errors']);
		}

		$this->template->display('edit.php');
	}

	/** 
	* Database update the new data on the brand selected 
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
			header("Location: /Test/brands/{$id}");
			exit;
		}

		if(!Brand::validates($_POST))
		{
			$_SESSION['brands']['errors'] = Brand::errors();
			header("Location: /Test/brands/{$id}/edit");
			exit;
		}

		Brand::update($id, $_POST);
		header("Location: /Test/brands/{$id}");
		exit;		
	}
}