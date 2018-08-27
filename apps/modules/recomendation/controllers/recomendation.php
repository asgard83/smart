<?php
class recomendation extends MY_Controller{
	var $content = "";

	public function __construct()
	{
		$this->load->model('recomendation/recomendation_model');
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
            $arrdata = $this->recomendation_model->getRecomendation($id);
            $this->content = $this->load->view('recomendation/preview', $arrdata, true);
            $this->index();
        }
    }

}
?>