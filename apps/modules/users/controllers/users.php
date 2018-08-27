<?php
class Users extends MY_Controller{
	var $content = "";

	public function __construct()
	{
		$this->load->model('users/users_model');
	}

	public function index()
    {
        if(!$this->newsession->userdata('isLogin'))
		{ 
			redirect(site_url('dashboard'));
			exit();
		}
		else
		{
			$this->content = (!$this->content) ? $this->load->view('backend/default', '', true) : $this->content;
			$data = $this->main->set_content('dashboard', $this->content);
			$this->parser->parse('backend/dashboard', $data);  
		}
	}

    public function create($object)
    {
        if($this->newsession->userdata('isLogin'))
		{
            $arrdata = $this->users_model->getUser($object);
            $this->content = $this->load->view('users/create-user', $arrdata, true);
            $this->index();
        }
    }
}
?>