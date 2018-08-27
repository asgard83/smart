<?php
class Post extends MY_Controller{

	public function __construct()
	{
		
	}

	public function index()
	{
		echo "Bad Request";
	}

	public function set_register_user()
	{
		if(strtolower($_SERVER['REQUEST_METHOD']) != "post")
		{
			$msg = array('error' => 'Invalid or Bad Request');
		}
		else
		{
			$this->load->model('accounts/accounts_model');
			$msg = $this->accounts_model->createRegisterUser();
		}
		echo json_encode($msg);
	}

	public function set_recom_inspection()
	{
		if($this->newsession->userdata('isLogin'))
		{
			if(strtolower($_SERVER['REQUEST_METHOD']) != "post")
			{
				$msg = array('error' => 'Invalid or Bad Request');
			}
			else
			{
				$this->load->model('inspection/inspection_model');
				$msg = $this->inspection_model->storeRecomInspection();
			}
			echo json_encode($msg);
		}
	}

	public function set_inpsection_followup()
	{
		if($this->newsession->userdata('isLogin'))
		{
			if(strtolower($_SERVER['REQUEST_METHOD']) != "post")
			{
				$msg = "MSG#Request Not Allowed#".base_url();
			}
			else
			{
				$this->load->model('recomendation/recomendation_model');
				$msg = $this->recomendation_model->storeupdateFollowUpRecomendation();
			}
			echo json_encode($msg);
		}
	}

	public function set_send_recom()
	{
		if($this->newsession->userdata('isLogin'))
		{
			if(strtolower($_SERVER['REQUEST_METHOD']) != "post")
			{
				$msg = "MSG#Request Not Allowed#".base_url();
			}
			else
			{
				$this->load->model('recomendation/recomendation_model');
				$msg = $this->recomendation_model->storeSendRecomendation();
			}
			echo $msg;
		}
	}

	public function set_recom_follow_up()
	{
		if($this->newsession->userdata('isLogin'))
		{
			if(strtolower($_SERVER['REQUEST_METHOD']) != "post")
			{
				$msg = array('error' => 'Invalid or Bad Request');
			}
			else
			{
				$this->load->model('recomendation/recomendation_model');
				$msg = $this->recomendation_model->storeUpdateRecomendation();
			}
			echo json_encode($msg);
		}
	}

	public function set_action_follow_up()
	{
		if($this->newsession->userdata('isLogin'))
		{
			if(strtolower($_SERVER['REQUEST_METHOD']) != "post")
			{
				$msg = array('error' => 'Invalid or Bad Request');
			}
			else
			{
				$this->load->model('followup/followup_model');
				$msg = $this->followup_model->storeActionRecomRecomendation();
			}
			echo json_encode($msg);
		}
	}

	public function set_compose_message()
	{
		if($this->newsession->userdata('isLogin'))
		{
			if(strtolower($_SERVER['REQUEST_METHOD']) != "post")
			{
				$msg = array('error' => 'Invalid or Bad Request');
			}
			else
			{
				$this->load->model('inbox/inbox_model');
				$msg = $this->inbox_model->storeComposeMessage();
			}
			echo json_encode($msg);
		}
	}

	public function set_reply_message()
	{
		if($this->newsession->userdata('isLogin'))
		{
			if(strtolower($_SERVER['REQUEST_METHOD']) != "post")
			{
				$msg = array('error' => 'Invalid or Bad Request');
			}
			else
			{
				$this->load->model('inbox/inbox_model');
				$msg = $this->inbox_model->storeReplyMessage();
			}
			echo json_encode($msg);
		}
	}

	public function get_message($id)
	{
		if($this->newsession->userdata('isLogin'))
		{
			$this->load->model('inbox/inbox_model');
			$arrdata = $this->inbox_model->getMessageDetail($id);
			echo $this->load->view('inbox/view', $arrdata, true);
		}
	}

	public function get_counting_dashboard($agency, $time)
	{
		if($this->newsession->userdata('isLogin'))
		{
			$this->load->model('dashboard/dashboardmodel');
			$data = $this->dashboardmodel->getCountingDashboardTimeline($agency, $time);
			echo $data;
		}
	}

	public function get_report_recom()
	{
		if($this->newsession->userdata('isLogin'))
		{
			$this->load->model('v/report_model');
			echo $this->report_model->getReportPeriodeRecom();
		}
	}

	public function get_report_followup()
	{
		if($this->newsession->userdata('isLogin'))
		{
			$this->load->model('v/report_model');
			echo $this->report_model->getReportPeriodeFollowUp();
		}
	}

}
?>