<?php

session_start();

require_once(LIBRARY_PATH . DS . 'Template.php');
require_once(APP_PATH . DS . 'models/Order.php');

class OrdersController
{

	public function __construct() 
	{
		$this->template = new Template;
		$this->template->template_dir = APP_PATH . DS . 'views' . DS . 'orders' . DS;

		$this->template->title = 'Order';
	}

	public function index() 
	{
		$this->template->orders = Order::retrieve();
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
	
		$this->template->id = $id;

		$orders = Order::show(array('model_id' => $id));
		
		if (count($orders) >= 1) 
		{
			$this->template->orders = $orders;
		} 
		else if (count($orders) == 0) 
		{
			$this->template->id = $id;
		}

		$this->template->display('show.php');
	}

	public function confirm()
	{
		if (!isset($_SESSION['user']))
		{
			header("Location: /Test/session/new");
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

  public function receipt() {

    $this->template->orders = Order::chkorder();
    $this->template->display('receipt.php');
  }

}
