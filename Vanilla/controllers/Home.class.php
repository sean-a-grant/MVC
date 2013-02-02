<?php
class Home extends BaseController {
	public function index(){
		$homemodel = new HomeModel();
		$this->view->online_status = $homemodel->index();
		$this->displayView();
	}
}