<?php

class Inspection_model extends CI_Model{

    public function getInspection($id)
    {
        if($this->newsession->userdata('isLogin'))
		{
            $arrInspectionId    = explode("-", $id);
            $InspectionId       = "'".join("','", $arrInspectionId)."'";
            $arrInspection      = array();

            $qTmLetterInspection = "SELECT LETTER_ID FROM TM_LETTER_INSPECTION WHERE INSPECTION_ID IN (".$InspectionId.")";
            $dTmLetterInspection = $this->main->get_result($qTmLetterInspection);
            
            if($dTmLetterInspection)
            {
                foreach($qTmLetterInspection->result_array() as $rowTmLetterInspection)
                {
                    $arrLetterId[] = $rowTmLetterInspection['LETTER_ID'];
                }
                $qTmLetter = "SELECT DISTINCT(LETTER_NUMBER) AS LETTER_NUMBER, CONVERT(VARCHAR(10), LETTER_DATE, 105) AS LETTER_DATE
                             FROM TM_LETTER 
                             WHERE LETTER_ID IN (".join(",", $arrLetterId).") 
                             GROUP BY LETTER_NUMBER, CONVERT(VARCHAR(10), LETTER_DATE, 105)";
                $dTmLetter = $this->main->get_result($qTmLetter);
                if($dTmLetter)
                {
                    foreach($qTmLetter->result_array() as $rowTmLetter)
                    {
                        $arrInspection['letter'] = $rowTmLetter;
                    }

                    $TmInspection = "SELECT A.INSPECTION_ID, A.TRADER_TYPE_ID, 
                                     CONVERT(VARCHAR(10), A.INSPECTION_DATE_START, 120) AS INSPECTION_DATE_START,
                                     CONVERT(VARCHAR(10), A.INSPECTION_DATE_END, 120) AS INSPECTION_DATE_END,
                                     A.INSPECTION_RESULT, A.INSPECTION_BPOM_RESULT,
                                     B.TRADER_NAME, B.TRADER_INDUSTRY, B.TRADER_OWNER, B.TRADER_NPWP,
                                     B.TRADER_ADDRESS_1, B.TRADER_ADDRESS_2, B.TRADER_PHONE, B.TRADER_FAX, B.TRADER_PERMIT,
                                     C.BBPOM_NAME, C.BBPOM_ADDRESS
                                     FROM TM_INSPECTION A
                                     LEFT JOIN TM_TRADER B ON A.TRADER_ID = B.TRADER_ID
                                     LEFT JOIN TR_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID
                                     WHERE A.INSPECTION_ID IN (".$InspectionId.") ";
                    $dTmInspection = $this->main->get_result($TmInspection);
                    if($dTmInspection)
                    {
                        foreach($TmInspection->result_array() as $row)
                        {
                            $arrInspection['obj'][] = $row;
                        }
                    }

                    $arrInspection['action'] = site_url('post/set_recom_inspection');

                    $arrInspection['selectGroupAgency']   = array(
                                                                    ''  => 'Pilih Instansi',
                                                                    '0' => 'Instansi Pusat',
                                                                    '1' => 'Instansi Daerah'
                                                                );
                    $arrInspection['selectGroupOffice']   = array('' => '');
                }
            }
            return $arrInspection;
        }
    }

    public function storeRecomInspection()
    {
        if($this->newsession->userdata('isLogin'))
		{
            $respon = FALSE;
            $iTmRecomInspection = 0;
            
            $iCounter = count($_POST['objRecomInspection']['INSPECTION_ID']);
            $TmRecomInspection = $this->main->post_to_query($_POST['objRecom']);
            $arrRecomInspection = $this->input->post('objRecomInspection');
            
            $groupId = "";
            $recomFirst = "";

            $arrKeysRecomInspection = array_keys($arrRecomInspection);
            for($s = 0; $s < $iCounter; $s++){
                $TmRecomInspection['RECOM_ID'] = (int)$this->main->get_uraian("SELECT MAX(RECOM_ID) AS SEQ FROM TX_RECOM", "SEQ") + 1;
                $recomFirst = $TmRecomInspection['RECOM_ID'];
                $TmRecomInspection['GROUP_ID'] = ($groupId == "" ? $recomFirst : $groupId);
                $TmRecomInspection['RECOM_STATUS'] = 'Draft';
                $TmRecomInspection['USER_ID'] = $this->newsession->userdata('USER_ID');
                $TmRecomInspection['RECOM_DATE_CREATED'] = 'GETDATE()';
                for($j=0;$j<count($arrKeysRecomInspection);$j++)
                {
                    $TmRecomInspection[$arrKeysRecomInspection[$j]] = $arrRecomInspection[$arrKeysRecomInspection[$j]][$s];
                }
                
                $this->db->insert('TX_RECOM', $TmRecomInspection);
                if($this->db->affected_rows() > 0)
                {
                    $arrInspectionUpdate = array('INSPECTION_STATUS' => 'Rekomendasi');
                    $this->db->where('INSPECTION_ID', $TmRecomInspection['INSPECTION_ID']);
                    $this->db->update('TM_INSPECTION', $arrInspectionUpdate);
                    if($this->db->affected_rows() == 1 ){
                        $TlRecom = array(
                            'RECOM_ID'                  => $TmRecomInspection['RECOM_ID'],
                            'RECOM_LOG_DATE_CREATED'    => 'GETDATE()',
                            'RECOM_LOG_STATUS'          => 'Draft Rekomendasi',
                            'RECOM_LOG_ACTION'          => 'Insert Draft Rekomendasi',
                            'RECOM_LOG_NOTE'            => $this->input->post('comments'),
                            'RECOM_LOG_HISTORY'         => 'Log History',
                            'USER_ID'                   => $this->newsession->userdata('USER_ID')
                        );
                        $this->db->insert('TL_RECOM', $TlRecom);
                        if($this->db->affected_rows() > 0)
                        {
                            $iTmRecomInspection++;
                        }
                    }
                }
                $groupId = $recomFirst;

            }
            if($iTmRecomInspection == $iCounter)
            {
                $respon = TRUE;
            }
            
            if($respon)
            {
                return array(
                    'error' => '',
                    'message' => 'Data rekomendasi berhasil di tambahkan',
                    'returnurl' => site_url('v/recomendation/new')
                );
            }
            else
            {
                return array(
                    'error' => 'Data rekomendasi gagal dikirim.'
                );
            }
            
        }
    }
}