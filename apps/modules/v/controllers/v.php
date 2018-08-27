<?php
class V extends MY_Controller{
	var $content = "";

	public function __construct()
	{
		$this->load->model('v/inspections_model');
		$this->load->model('v/recomendation_model');
		$this->load->model('v/followup_model');
		$this->load->model('v/hello_model');
        $this->load->model('v/sla_model');
        $this->load->model('v/inbox_model');
		$this->load->model('v/monitoring_model');
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

    public function inspection()
    {
        if($this->newsession->userdata('isLogin'))
		{
            $arrdata = $this->inspections_model->lstInspection();
            if($this->input->post("data-post")){
                echo $arrdata;
            }else{
                $this->content = $this->load->view('list/table', $arrdata, true);
                $this->index();
            }
        }
    }

    public function recomendation($menu="")
    {
        if($this->newsession->userdata('isLogin'))
		{
            $arrdata = $this->recomendation_model->lstRecomendation($menu);
            if($this->input->post("data-post")){
                echo $arrdata;
            }else{
                $this->content = $this->load->view('list/table', $arrdata, true);
                $this->index();
            }
        }
    }

    public function followup($menu="")
    {
        if($this->newsession->userdata('isLogin'))
		{
            $arrdata = $this->followup_model->lstFollowUp($menu);
            if($this->input->post("data-post")){
                echo $arrdata;
            }else{
                $this->content = $this->load->view('list/table', $arrdata, true);
                $this->index();
            }
        }
    }

    public function monitoring($agency, $timeline)
    {
        if($this->newsession->userdata('isLogin'))
		{
            $arrdata = $this->monitoring_model->lstMonitoring($agency, $timeline);
            if($this->input->post("data-post")){
                echo $arrdata;
            }else{
                $this->content = $this->load->view('list/table', $arrdata, true);
                $this->index();
            }
        }
    }
	
	public function hello()
    {
        if($this->newsession->userdata('isLogin'))
		{
            $arrdata = $this->hello_model->lstHello();
            if($this->input->post("data-post")){
                // echo $arrdata;
            }else{
                $this->content = $this->load->view('list/table', $arrdata, true);
                $this->index();
            }
        }
    }

    public function sla() 
    {
        if($this->newsession->userdata('isLogin'))
		{
            $arrdata = $this->sla_model->lstSla();
            if($this->input->post("data-post")){
                echo $arrdata;
            }else{
                $this->content = $this->load->view('list/table', $arrdata, true);
                $this->index();
            }
        }
    }

    public function inbox()
    {
        if($this->newsession->userdata('isLogin'))
		{
            $arrdata = $this->inbox_model->lstInbox();
            $this->content = $this->load->view('inbox/inbox', $arrdata, true);
            $this->index();
        }
        
    }

    public function report()
    {
        if($this->newsession->userdata('isLogin'))
		{
            $arrdata['actRecom'] = site_url('post/get_report_recom');
            $arrdata['actFollowUp'] = site_url('post/get_report_followup');
            $this->content = $this->load->view('v/report', $arrdata, true);
            $this->index();
        }
    }

}
?>