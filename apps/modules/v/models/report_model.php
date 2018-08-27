<?php

class Report_model extends CI_Model{

    public function getReportPeriodeRecom()
    {
        if($this->newsession->userdata('isLogin'))
		{
            print_r($_POST);
        }
    }

    public function getReportPeriodeFollowUp()
    {
        if($this->newsession->userdata('isLogin'))
		{
            print_r($_POST);
        }
    }
}