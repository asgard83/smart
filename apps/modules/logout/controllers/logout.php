<?php
class logout extends MY_Controller{

	public function index()
	{
		$this->newsession->sess_destroy();
		redirect(base_url());
		exit();
	}
}
?>