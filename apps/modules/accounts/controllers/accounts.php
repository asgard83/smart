<?php
class Accounts extends MY_Controller{
	var $content = "";

	public function __construct()
	{
		$this->load->model('accounts/accounts_model');
	}

    public function _remap($method,$args)
    {
        if (method_exists($this, $method))
        {
            $this->$method($args);
        }
        else
        {
            $this->index($method,$args);
        }
    }

	public function index($params)
    {
        if($this->newsession->userdata('isLogin'))
		{ 
			redirect(site_url('dashboard'));
			exit();
		}
		else
		{
            if($params == "register-user")
            {
                $arrRegister = $this->accounts_model->get_Register();
                $this->content = (!$this->content) ? $this->load->view('accounts/accounts_register', $arrRegister, true) : $this->content;
                
            }
			$data = $this->main->set_content('signin', $this->content);
			$this->parser->parse('portal/home', $data);
		}
	}
}
?>