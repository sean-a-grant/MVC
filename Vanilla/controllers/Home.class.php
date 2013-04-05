<?php
class Home extends BaseController {
	public function index(){
		$home = new HomeModel();
		$this->view->user_status = $home->user_status();
		$this->displayView();
	}
}