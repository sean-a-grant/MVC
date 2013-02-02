<?php
class Loader {
	private $controller;
	private $action;
	private $urlValues;

	/* 
	 * Store our URL request and identify controller and action.
	 * If controller is not defined, it will be home.
	 * If action is not defined, it will be index.
	*/
	public function __construct($request){
		// Set up autoloading
		spl_autoload_register("self::autoload");

		// Detect controller/action
		$this->urlValues = $request;
		if(empty($this->urlValues['controller'])){
			$this->controller = "Home";
		} else {
			$this->controller = $this->urlValues['controller'];
		}
		if(empty($this->urlValues['action'])){
			$this->action = "index";
		} else {
			$this->action = $this->urlValues['action'];
		}
	}

	/*
	 * Create and return the controller used for the request.
	*/
	public function createController(){
		if(file_exists(_ROOT . '/controllers/' . $this->controller . '.class.php')){
			require _ROOT . '/controllers/' . $this->controller . '.class.php';
			if(class_exists($this->controller)){
				$parents = class_parents($this->controller);
				if(in_array("BaseController", $parents)){
					if(method_exists($this->controller, $this->action)){
						return new $this->controller($this->action, $this->urlValues);
					}
				}
			}
		}
		return new Error("badUrl", $this->urlValues);
	}


	/*
	 * public autoload($name)
	 *
	 * Params:
	 	string $name: autoload is called when an undefined class is attempted to be created. $name is that class name.
	 *
	 * Warning:
	 	This does not autoload controllers, as for controllers should be manually loaded through the Loader class.
	 *
	 * Returns:
	 	Class $name if $name is found
	*/
	public function autoload($name){
		$files = array(
			_ROOT . '/classes/' . $name . '.class.php',
			_ROOT . '/models/' . $name . '.class.php'
		);

		foreach($files as $file){
			if(file_exists($file)){
				include $file;
			}
		}
	}
}