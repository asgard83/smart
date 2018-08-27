<?php

class Recomendation_model extends CI_Model{

    public function getRecomendation($id)
    {
        if($this->newsession->userdata('isLogin'))
		{
            $arrRecomendation['action'] = site_url('post/set_inpsection_followup');
            $arrRecomendation['selectGroupAgency']   = array(
                                                            ''  => 'Pilih Instansi',
                                                            '0' => 'Instansi Pusat',
                                                            '1' => 'Instansi Daerah'
                                                        );
            $TxRecomHasInspection = "SELECT A.INSPECTION_ID FROM TX_RECOM A WHERE A.RECOM_ID = ". $id;
            $TmInspectionId = $this->main->get_uraian($TxRecomHasInspection, "INSPECTION_ID");

            $qTmLetterInspection = "SELECT LETTER_ID FROM TM_LETTER_INSPECTION WHERE INSPECTION_ID IN (".$TmInspectionId.")";
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
                        $arrRecomendation['letter'] = $rowTmLetter;
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
                                     WHERE A.INSPECTION_ID IN (".$TmInspectionId.") ";
                    $dTmInspection = $this->main->get_result($TmInspection);
                    if($dTmInspection)
                    {
                        foreach($TmInspection->result_array() as $row)
                        {
                            $arrRecomendation['obj'][] = $row;
                        }
                    }

                    $TxRecom = "SELECT RECOM_ID, GROUP_ID, INSPECTION_ID, OFFICE_ID, GA_ID, RECOM_NUMBER,
                                CONVERT(VARCHAR(10), RECOM_DATE, 120) AS RECOM_DATE, RECOM_FOLLOWUP,
                                FOLLOWUP_NUMBER, CONVERT(VARCHAR(10), FOLLOWUP_DATE, 120) AS FOLLOWUP_DATE,
                                FOLLOWUP, RECOM_STATUS, RECOM_CC, LEN(GA_ID) AS GA_NOT_NULL
                                FROM TX_RECOM
                                WHERE RECOM_ID = " . $id;
                    $dTxRecom = $this->main->get_result($TxRecom);
                    if($dTxRecom)
                    {
                        foreach($TxRecom->result_array() as $rowTxRecom)
                        {
                            $arrRecomendation['objRecom'] = $rowTxRecom;
                        }
						$arrRecomendation['selectGroupAgency']   = array(
                                                            ''  => 'Pilih Instansi',
                                                            '0' => 'Instansi Pusat',
                                                            '1' => 'Instansi Daerah'
                                                        );
                        
                        if((int)$rowTxRecom['OFFICE_ID'] > 0 && $rowTxRecom['GA_ID'] == '')
                        {
                            $arrRecomendation['labelInstansi'] = "Instansi Daerah";
                            $arrRecomendation['objGroupSelected'] = 1;
                            $arrRecomendation['selectGroupOffice'] = $this->main->set_combobox("SELECT OFFICE_ID AS ID, OFFICE_NAME FROM TR_OFFICE ORDER BY 1 ASC", "ID", "OFFICE_NAME");
                            $arrRecomendation['namaInstansi'] = $this->main->get_uraian("SELECT OFFICE_NAME FROM TR_OFFICE WHERE OFFICE_ID = " . $rowTxRecom['OFFICE_ID'], "OFFICE_NAME");
                            $arrRecomendation['objSelectName'] = 'objRecom[OFFICE_ID]';
                            $arrRecomendation['objValue'] = $rowTxRecom['OFFICE_ID'];
                        }
                        else if((int)$rowTxRecom['GA_ID'] > 0 && $rowTxRecom['OFFICE_ID'] == '')
                        {
                            $arrRecomendation['labelInstansi'] = "Instansi Pusat";
                            $arrRecomendation['objGroupSelected'] = 0;
                            $arrRecomendation['selectGroupOffice'] = $this->main->set_combobox("SELECT GA_ID AS ID, GA_NAME AS NAME FROM TR_GA ORDER BY 1 ASC", "ID", "GA_NAME");
                            $arrRecomendation['namaInstansi'] = $this->main->get_uraian("SELECT GA_NAME FROM TR_GA WHERE GA_ID = " . $rowTxRecom['GA_ID'], "GA_ID");
                            $arrRecomendation['objSelectName'] = 'objRecom[GA_ID]';
                            $arrRecomendation['objValue'] = $rowTxRecom['GA_ID'];
                        }
                        if($rowTxRecom['RECOM_STATUS'] == 'Draft')
                        {
                            $arrRecomendation['enableInput'] = TRUE;
                        }
                        else
                        {
                            $arrRecomendation['enableInput'] = FALSE;
                        }

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
            }
            return $arrRecomendation;
        }
    }

    public function storeUpdateRecomendation()
    {
        if($this->newsession->userdata('isLogin'))
		{
            $respon = FALSE;
            $arrTxRecomInspection = $this->main->post_to_query($_POST['objRecom']);
            $TxRecom = array('RECOM_STATUS' => 'Proses Tindak Lanjut');
            $this->db->where('RECOM_ID', $arrTxRecomInspection['RECOM_ID']);
            $this->db->update('TX_RECOM', $TxRecom);
            if($this->db->affected_rows() == 1)
            {
                $TmInspection = array('INSPECTION_STATUS' => 'Proses Tindak Lanjut');
                $this->db->where('INSPECTION_ID', $arrTxRecomInspection['INSPECTION_ID']);
                $this->db->update('TM_INSPECTION', $TmInspection);
                if($this->db->affected_rows() == 1)
                {
                     $TlRecom = array(
                        'RECOM_ID'                  => $arrTxRecomInspection['RECOM_ID'],
                        'RECOM_LOG_DATE_CREATED'    => 'GETDATE()',
                        'RECOM_LOG_STATUS'          => 'Kirim Rekomendasi',
                        'RECOM_LOG_ACTION'          => 'Update Kirim Rekomendasi',
                        'RECOM_LOG_NOTE'            => 'Kirim data rekomendasi ke Kementerian / Lembaga',
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
                    'message' => 'Data rekomendasi berhasil di kirim',
                    'returnurl' => site_url('v/recomendation/sent')
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
    // [+]

    public function storeSendRecomendation()
    {
        if($this->newsession->userdata('isLogin'))
		{
            $respon = FALSE;
            $iTxRecom = 0;
            $iCounter = count($this->input->post('tb_chk'));
            foreach ($this->input->post('tb_chk') as $v) 
            {
                $TxRecom = array('RECOM_STATUS' => 'Baru');
                $this->db->where('RECOM_ID', $v);
                $this->db->update('TX_RECOM', $TxRecom);
                if($this->db->affected_rows() > 0)
                {
                    $TlRecom = array(
                        'RECOM_ID'                  => $v,
                        'RECOM_LOG_DATE_CREATED'    => 'GETDATE()',
                        'RECOM_LOG_STATUS'          => 'Kirim Rekomendasi',
                        'RECOM_LOG_ACTION'          => 'Update Kirim Rekomendasi',
                        'RECOM_LOG_NOTE'            => 'Perubahan draft rekomendasi menjadi dikirim (baru)',
                        'RECOM_LOG_HISTORY'         => 'Log History',
                        'USER_ID'                   => $this->newsession->userdata('USER_ID')
                    );
                    $this->db->insert('TL_RECOM', $TlRecom);
                    if($this->db->affected_rows() > 0)
                    {
                        $iTxRecom++;
                    }
                }
            }
            if($iCounter == $iTxRecom)
            {
                return "MSG#Data pemeriksaan berhasil dikirim#".site_url('v/recomendation/sent');
            }
            else
            {
                return "MSG#Data pemeriksaan gagal dikirim#".site_url('v/recomendation/new');
            }
        }
        else
        {
            return "MSG#Authentication Failed#".base_url();
        }
    }

    public function storeRecomRecomendation()
    {
        if($this->newsession->userdata('isLogin'))
		{
            $respon = FALSE;
            $TxRecom = $this->main->post_to_query($_POST['objRecom']);
            $iRecomId = $TxRecom['RECOM_ID'];
            $iInspectionId = $TxRecom['INSPECTION_ID'];
            unset($TxRecom['RECOM_ID']);
            unset($TxRecom['INSPECTION_ID']);
            $TxRecom['RECOM_USER_FOLLOWUP']     = $this->newsession->userdata('USER_ID');
            $TxRecom['RECOM_DATE_FOLLOWUP']     = 'GETDATE()';
            $this->db->where(array('RECOM_ID' => $iRecomId, 'INSPECTION_ID' => $iInspectionId));
            $this->db->updatet('TX_RECOM', $TxRecom);
            if($this->db->affected_rows() > 0)
            {
                $TlRecom = array(
                    'RECOM_ID'                  => $iRecomId,
                    'RECOM_LOG_DATE_CREATED'    => 'GETDATE()',
                    'RECOM_LOG_STATUS'          => '1',
                    'RECOM_LOG_ACTION'          => 'Insert Rekomendasi',
                    'RECOM_LOG_NOTE'            => 'Catatan Rekomendasi',
                    'RECOM_LOG_HISTORY'         => 'Log History',
                    'USER_ID'                   => $this->newsession->userdata('USER_ID')
                );
                $this->db->insert('TL_RECOM', $TlRecom);
                if($this->db->affected_rows() > 0)
                {
                    $respon = TRUE;
                }
                
            }
            if($respon)
            {
                return array(
                    'error' => '',
                    'message' => 'Data rekomendasi berhasil di kirim',
                    'returnurl' => site_url('v/recomendation/sent')
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

    public function storeupdateFollowUpRecomendation()
    {
        if($this->newsession->userdata('isLogin'))
		{
            $respon = FALSE;
            $TxRecom = $this->main->post_to_query($_POST['objRecom']);
            
            $iRecomId = $TxRecom['RECOM_ID'];
            $iInspectionId = $TxRecom['INSPECTION_ID'];
            $sRecomStatus = $TxRecom['RECOM_STATUS'];
            unset($TxRecom['RECOM_ID']);
            unset($TxRecom['INSPECTION_ID']);
            unset($TxRecom['RECOM_STATUS']);
            $getStatus = $this->main->get_uraian("SELECT RTRIM(LTRIM(RECOM_STATUS)) AS RECOM_STATUS FROM TX_RECOM WHERE RECOM_ID = ". $iRecomId, "RECOM_STATUS");
            
            if($this->newsession->userdata('GA_ID') == 1 AND trim($getStatus) == 'Draft')
            {
                $this->db->where('RECOM_ID', $iRecomId);
                $this->db->update('TX_RECOM', $TxRecom);
                if($this->db->affected_rows() == 1)
                {
                    $TlRecom = array(
                        'RECOM_ID'                  => $iRecomId,
                        'RECOM_LOG_DATE_CREATED'    => 'GETDATE()',
                        'RECOM_LOG_STATUS'          => 'Update Rekomendasi',
                        'RECOM_LOG_ACTION'          => 'Update Data Rekomendasi',
                        'RECOM_LOG_NOTE'            =>  $this->input->post('comments'),
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
            else
            {
                $TxRecom['RECOM_STATUS'] = 'Proses Tindak Lanjut';
                $this->db->where('RECOM_ID', $iRecomId);
                $this->db->update('TX_RECOM', $TxRecom);
                if($this->db->affected_rows() == 1)
                {
                    $TmInspection = array('INSPECTION_STATUS' => 'Proses Tindak Lanjut');
                    $this->db->where('INSPECTION_ID', $iInspectionId);
                    $this->db->update('TM_INSPECTION', $TmInspection);
                    if($this->db->affected_rows() == 1)
                    {
                         $TlRecom = array(
                            'RECOM_ID'                  => $iRecomId,
                            'RECOM_LOG_DATE_CREATED'    => 'GETDATE()',
                            'RECOM_LOG_STATUS'          => 'Kirim Rekomendasi',
                            'RECOM_LOG_ACTION'          => 'Update Kirim Rekomendasi',
                            'RECOM_LOG_NOTE'            =>  $this->input->post('comments'),
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
            }

            if($respon)
            {
                if($this->newsession->userdata('GA_ID') == 1)
                {
                    return array(
                        'error' => '',
                        'message' => 'Data rekomendasi berhasil diupdate',
                        'returnurl' => site_url('v/recomendation/new')
                    );
                }
                else
                {
                    return array(
                        'error' => '',
                        'message' => 'Data rekomendasi berhasil di kirim',
                        'returnurl' => site_url('v/followup')
                    );
                }
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