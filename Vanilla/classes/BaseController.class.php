<?php
abstract class BaseController {
	protected $urlValues;
	protected $action;
	protected $view;

	public function __construct($action, $urlvalues){
		$this->action = $action;
		$this->urlValues = $urlvalues;
		$this->view = new View();
	}

	public function executeAction(){
		return $this->{$this->action}();
	}

	/*
	 * protected returnView($viewModel, $fullView);
	 *
	 * Params:
	 	boolean $ajax: When true, the main template will not be loaded. Good for AJAX requests.
	 *
	 * Returns:
	 	Null
	*/
	protected function displayView($ajax=false){
		$viewloc = _ROOT . '/views/' . get_class($this) . '/' . $this->action . '.php';
		ob_start();
		$view = $this->view; // Copy our view object locally, so the views can use it.
		require $viewloc;
		$view->_contents = ob_get_contents();
		ob_end_clean();
		if($ajax){
			echo $view->_contents;
		} else {
			require _ROOT . '/views/template.php';
		}
	}
}
