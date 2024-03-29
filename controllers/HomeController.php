<?php

/**
 * This is the Home Controller class.
 *
 * @author donal.ellis@rmit.edu.au
 */
require_once(LIBRARY_PATH . DS . 'Template.php');

class HomeController {

  public function __construct()
  {
    $this->template = new Template;
    $this->template->template_dir = APP_PATH . DS . 'views' . DS . 'home' . DS;
  }

  public function index()
  {
    $this->template->display('index.php');
  }

}
