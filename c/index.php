<?php
/*
 * c/index.php
 * This is the controller. To make a new page, call 'new page($pagename);'
 * This is named index to prevent people from looking inside of the directory, I'm lazy.
*/

class Page {
	/*
	 * __construct(string $page, bool $nostyle=false)
	 * This is called when page is created. Arguments are passed through page when it is created.
	 * This will include all classes which will be available for use in m/$page.php or v/default.php
	 * Using heavy logic in v/default.php is discouraged
	 * v/default.php will not be included if $nostyle is set to true, and instead $content will be echo'd	*/
	public function __construct($page, $nostyle=false){
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

		$content = ''; // Initialize content variable
		$page = preg_replace("[^A-Za-z0-9/]", "", $page); // Sanitize the page to prevent unauthorized access

		/* Include model file */
		if(file_exists("m/" . $page . ".php")){
			include "m/" . $page . ".php";
		} else {
			include "m/404.php";
		}

		if(!$nostyle){
			include "v/default.php";
		} else {
			echo $content;
		}
	}
}
?>