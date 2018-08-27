<?php

class Followup_model extends CI_Model{

    public function getRecomendation($id)
    {
        if($this->newsession->userdata('isLogin'))
		{
            $arrRecomendation['action'] = site_url('post/set_action_follow_up');
            $TxRecomdation = "SELECT A.RECOM_ID, A.INSPECTION_ID, A.GA_ID, A.OFFICE_ID, A.RECOM_NUMBER,  
                             CONVERT(VARCHAR(10), A.RECOM_DATE, 120) AS RECOM_DATE,
                             CONVERT(VARCHAR(10), A.RECOM_DATE_FOLLOWUP, 120) AS RECOM_DATE_FOLLOWUP,
                             A.RECOM_FOLLOWUP, A.FOLLOWUP_NUMBER, CONVERT(VARCHAR(10), A.FOLLOWUP_DATE, 120) AS FOLLOWUP_DATE,
                             A.FOLLOWUP, B.TRADER_TYPE_ID, 
                             CONVERT(VARCHAR(10), B.INSPECTION_DATE_START, 120) AS INSPECTION_DATE_START,
                             CONVERT(VARCHAR(10), B.INSPECTION_DATE_END, 120) AS INSPECTION_DATE_END,
                             B.INSPECTION_RESULT, B.INSPECTION_BPOM_RESULT,
                             C.TRADER_NAME, C.TRADER_INDUSTRY, C.TRADER_OWNER, C.TRADER_NPWP,
                             C.TRADER_ADDRESS_1, C.TRADER_ADDRESS_2, C.TRADER_PHONE, C.TRADER_FAX, C.TRADER_PERMIT,
                             D.BBPOM_NAME, D.BBPOM_ADDRESS, LTRIM(RTRIM(A.RECOM_STATUS)) AS RECOM_STATUS, A.RECOM_CC
                             FROM TX_RECOM A 
                             LEFT JOIN TM_INSPECTION B ON A.INSPECTION_ID = B.INSPECTION_ID
                             LEFT JOIN TM_TRADER C ON B.TRADER_ID = C.TRADER_ID
                             LEFT JOIN TR_BBPOM D ON B.BBPOM_ID = D.BBPOM_ID
                             WHERE A.RECOM_ID = " . $id;
            $dTxRecomdation = $this->main->get_result($TxRecomdation);
            if($dTxRecomdation)
            {
                foreach($TxRecomdation->result_array() as $row)
                {
                    $arrRecomendation['obj'] = $row;
                }
                
                if((strtolower($row['RECOM_STATUS']) == 'proses tindak lanjut' || strtolower($row['RECOM_STATUS']) == 'baru') && $this->newsession->userdata('GA_ID') != '1')
                {
                    $arrRecomendation['isProcessed'] = TRUE;
                }
                else
                {
                    $arrRecomendation['isProcessed'] = FALSE;
                }

                if((int)$row['OFFICE_ID'] == 0)
                {
                    $arrRecomendation['govAgency'] = $this->main->get_uraian("SELECT GA_NAME FROM TR_GA WHERE GA_ID = " . $row['GA_ID'], "GA_NAME");
                }
                else
                {
                    $arrRecomendation['govAgency'] = $this->main->get_uraian("SELECT OFFICE_NAME FROM TR_OFFICE WHERE OFFICE_ID = " . $row['OFFICE_ID'], "OFFICE_NAME");
                }

                $TlRecom = "SELECT A.RECOM_ID, CONVERT(CHAR(10), A.RECOM_LOG_DATE_CREATED,126) AS RECOM_LOG_DATE_CREATED,
                            CONVERT(CHAR(10), A.RECOM_LOG_DATE_CREATED,108) AS RECOM_LOG_DATE_CREATED_TIME, 
                            CONVERT(CHAR(19), A.RECOM_LOG_DATE_CREATED,120) AS RECOM_LOG_DATE_CREATED_AGO, 
                            A.RECOM_LOG_STATUS, A.RECOM_LOG_ACTION, A.RECOM_LOG_NOTE, A.RECOM_LOG_HISTORY,B.USER_NAME
                            FROM TL_RECOM A
                            LEFT JOIN TM_USER B ON A.USER_ID = B.USER_ID
                            WHERE A.RECOM_ID = " . $id;
                $arrRecomendation['TlRecom'] = $this->db->query($TlRecom)->result_array();
                    
            }
            return $arrRecomendation;
        }
    }

    public function storeActionRecomRecomendation()
    {
        if($this->newsession->userdata('isLogin'))
		{
            $respon = FALSE;
            $TxRecom = $this->main->post_to_query($_POST['objRecom']);
            $iRecomId = $TxRecom['RECOM_ID'];
            $iInspectionId = $TxRecom['INSPECTION_ID'];
            unset($TxRecom['RECOM_ID']);
            unset($TxRecom['INSPECTION_ID']);
            $TxRecom['RECOM_STATUS'] = 'Selesai';
            $TxRecom['RECOM_USER_FOLLOWUP'] = $this->newsession->userdata('USER_ID');
            $this->db->where(array('RECOM_ID' => $iRecomId, 'INSPECTION_ID' => $iInspectionId));
            $this->db->update('TX_RECOM', $TxRecom);
            if($this->db->affected_rows() == 1)
            {
                $arrInspectionUpdate = array('INSPECTION_STATUS' => 'Selesai');
                $this->db->where('INSPECTION_ID', $iInspectionId);
                $this->db->update('TM_INSPECTION', $arrInspectionUpdate);
                if($this->db->affected_rows() == 1 ){
                    $TlRecom = array(
                        'RECOM_ID'                  => $iRecomId,
                        'RECOM_LOG_DATE_CREATED'    => 'GETDATE()',
                        'RECOM_LOG_STATUS'          => 'Update Tindak Lanjut',
                        'RECOM_LOG_ACTION'          => 'Proses Tindak Lanjut Selesai',
                        'RECOM_LOG_NOTE'            => $this->input->post('comments'),
                        'RECOM_LOG_HISTORY'         => 'Log History',
                        'USER_ID'                   => $this->newsession->userdata('USER_ID')
                    );
                    $this->db->insert('TL_RECOM', $TlRecom);
                    if($this->db->affected_rows() > 0)
                    {
                        $respon = TRUE;
                    }
                }
            }
            
            if($respon)
            {
                return array(
                    'error' => '',
                    'message' => 'Data rekomendasi berhasil di tindak lanjuti',
                    'returnurl' => site_url('v/followup')
                );
            }
            else
            {
                return array(
                    'error' => 'Data rekomendasi gagal di tindak lanjuti.'
                );
            }

        }
    }
}