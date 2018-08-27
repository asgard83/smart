<?php

class Request_model extends CI_Model{

    public function setGovAgency()
    {
        if((int)$this->input->post('params') == 0)
        {
            $sRawQuery = "SELECT GA_ID AS ID, GA_NAME AS NAME FROM TR_GA ORDER BY 1 ASC";    
        }
        else
        {
            $sProvinceId = $this->main->get_uraian("SELECT LEFT(REGION_ID, 2) AS REGION_ID FROM TR_BBPOM WHERE BBPOM_ID = '". $this->newsession->userdata('BBPOM_ID') ."'","REGION_ID");
            if($sProvinceId!="")
                $sRawQuery = "SELECT OFFICE_ID AS ID, OFFICE_NAME AS NAME FROM TR_OFFICE WHERE REGION_ID LIKE '". $sProvinceId ."%__' ORDER BY 1 ASC";
            else
                $sRawQuery = "SELECT OFFICE_ID AS ID, OFFICE_NAME AS NAME FROM TR_OFFICE ORDER BY 1 ASC";
        }
        $TrAgency = $this->main->get_result($sRawQuery);
        if($TrAgency)
        {
            $arrTrAgency['error'] = "";
            $arrTrAgency['message'][] = array('value' => '',
                                                'option' => '');
            foreach($sRawQuery->result_array() as $rowAgency)
            {
                $arrTrAgency['message'][] = array('value' => $rowAgency['ID'],
                                                    'option' => $rowAgency['NAME']);
            }
            return $arrTrAgency;							 
        }
        else
        {
            return array('error' => 'Data tidak ditemukan');
        }
    }
}