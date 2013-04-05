<?php
abstract class BaseController {
	protected $postValues;
	protected $urlValues;
	protected $action;
	protected $view;

	public function __construct($action, $urlvalues, $postvalues){
		/* Variables and such for our page to use */
		$this->action = $action;
		$this->posts = $postvalues;
		$this->gets = $urlvalues;
		$this->view = new View();

		/* Basic startup scripts for the page */
		$this->setupGlobalView();
		if(!isset($_SESSION)){
			session_start();
		}
	}

	/*
	 * setupGlobalView()
	 * This sets up the view with site-wide variables
	*/
	public function setupGlobalView(){
		$this->view->navbar = array(
			array(
					"name" => "Premier League",
					"href" => "#",
					"children" => array(
						array(
								"name" => "Something",
								"href" => "#"
								),
						array(
								"name" => "Yo what's up",
								"href" => "#"
								)
					)
				),
			array(
					"name" => "Free League",
					"href" => "#"
				),
			array(
					"name" => "Events",
					"href" => "#"
				),
			array(
					"name" => "Downloads",
					"href" => "#"
				),
			array(
					"name" => "Support",
					"href" => "#"
				)
			);
	}

	public function executeAction(){
		return $this->{$this->action}();
	}

	/*
	 * displayView(boolean $ajax, string $action_name)
	 * Displays the view. When $action_name is -1, the default view will be loaded (classname + actionname).
	 * When ajax is true, the theme is not included with the view - good for AJAX requests or pages inside of other pages
	*/
	protected function displayView($ajax=false, $action_name=-1){
		$action_name = ($action_name == -1) ? $this->action : $action_name;
		$viewloc = _ROOT . '/views/' . get_class($this) . '/' . $action_name . '.php';
		if(file_exists($viewloc)){

			ob_start();
			$view = $this->view; // Copy our view object locally, so the views can use it.
			require $viewloc;
			$view->_contents = ob_get_clean();

			if($ajax){
				echo $view->_contents;
			} else {
				require _ROOT . '/views/template.php';
			}
		} else {
			return new Error('Error: View (' . $viewloc . ') is missing');
		}
		
	}
}