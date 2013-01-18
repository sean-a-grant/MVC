<?php
/*
 * c/index.php
 * This is the controller. To make a new page, call 'new Page($pagename);'
 * This is named index to prevent people from looking inside of the directory, I'm lazy.
*/

class Page {
	/*
	 * __construct(string $mode)
	 * This will do the following in order:
	 * 1. Start the session
	 * 2. Include all includes and the singleton class
	 * 3. Include the model
	 * 
	 * It is the model's responsibility to load the view. Load the view through Page::loadView('theview')
	*/
	public function __construct($model){
		/* Run startup scripts */
		if(!isset($_SESSION)){
			session_start();
		}

		/* Include singleton class and all other classes */
		if(file_exists('inc/Singleton.class.php')){
			include('inc/Singleton.class.php');
			if($dh = opendir('inc/')){
				while(($file = readdir($dh)) !== false){
					if(filetype('inc/' . $file) == "file"){
						if($file != "Singleton.class.php"){
							include "inc/" . $file;
						}
					}
				}
			}
		} else {
			die("The site has not been setup correctly");
		}

		$model = preg_replace("[^A-Za-z0-9/]", "", $model); // Sanitize the page to prevent unauthorized access
		include 'm/' . $model . '.php';
	}

	public function loadView($view){
		include 'v/inc/header.php';
		include "v/" . preg_replace("[^A-Za-z0-9/]", "", $view) . ".php";
		include 'v/inc/footer.php';
	}
}
?>