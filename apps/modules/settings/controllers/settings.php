<?php
class Settings extends MY_Controller{
	var $content = "";

	public function __construct()
	{
		$this->load->model('settings/settings_model');
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

    public function manages($component)
    {
        if($this->newsession->userdata('isLogin'))
		{
            if($component == "user")
            {
                $arrdata = $this->settings_model->lstUser();
                if($this->input->post("data-post")){
                    echo $arrdata;
                }else{
                    $this->content = $this->load->view('list/table', $arrdata, true);
                    $this->index();
                }
            }
        }
    }
}
?>