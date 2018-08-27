<?php
class followup extends MY_Controller{
	var $content = "";

	public function __construct()
	{
		$this->load->model('followup/followup_model');
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

    public function preview($id)
    {
        if($this->newsession->userdata('isLogin'))
		{
            $arrdata = $this->followup_model->getRecomendation($id);
            $this->content = $this->load->view('followup/preview', $arrdata, true);
            $this->index();
        }
    }

}
?>