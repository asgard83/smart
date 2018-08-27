<?php
class Request extends MY_Controller{

	public function __construct()
	{
		
	}

	public function index()
	{
		echo "Bad Request";
	}

	public function get_gov_agency()
	{
		if(strtolower($_SERVER['REQUEST_METHOD']) != "post")
		{
			$msg = array('error' => 'Invalid or Bad Request');
		}
		else
		{
			$this->load->model('request/request_model');
			$response = $this->request_model->setGovAgency();
		}
		echo json_encode($response);
	}

}
?>