<?php

class Followup_model extends CI_Model{

    public function lstFollowUp($menu="")
    {
        if($this->newsession->userdata('isLogin'))
		{
            $table = $this->newtable;
			$paramsStatus = "";
			switch ($menu) {
				case "done";
						$paramsStatus = " A.RECOM_STATUS = 'Selesai'";
					break;
				case "incoming";
						$paramsStatus = " A.RECOM_STATUS = 'Baru'";
					break;
				case "process";
						$paramsStatus = " A.RECOM_STATUS = 'Proses Tindak Lanjut'";
					break;
				default:
					$paramsStatus = "";
			}
			if($this->newsession->userdata('GA_ID') == '1')
			{
				$query = "SELECT A.RECOM_ID,
					  REPLACE(REPLACE(F.BBPOM_NAME, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS 'BPOM',
					  A.RECOM_NUMBER + '<div>' + CONVERT(VARCHAR(10), A.RECOM_DATE, 120) + '</div>' AS 'Nomor Rekomendasi',
					  E.TRADER_NAME + '<div>' + E.TRADER_ADDRESS_1  + '</div><div>' + E.TRADER_ADDRESS_2 + '</div>' AS 'Nama Sarana',
					  B.GA_NAME + '<div>' + C.OFFICE_NAME + '</div>' AS 'Kementerian/Lembaga/Daerah',
					  A.FOLLOWUP_NUMBER + '<div>' + CONVERT(VARCHAR(10), A.FOLLOWUP_DATE, 120) + '</div>' AS 'Tindak Lanjut',
					  A.RECOM_STATUS AS 'Status',
					  CONVERT(VARCHAR(10), A.RECOM_DATE_CREATED, 120) AS 'Tanggal Entry'
					  FROM TX_RECOM A
					  LEFT JOIN TR_GA B ON A.GA_ID = B.GA_ID
					  LEFT JOIN TR_OFFICE C ON A.OFFICE_ID = C.OFFICE_ID
					  LEFT JOIN TM_INSPECTION D ON A.INSPECTION_ID = D.INSPECTION_ID 
					  LEFT JOIN TM_TRADER E ON D.TRADER_ID = E.TRADER_ID
					  LEFT JOIN TR_BBPOM F ON D.BBPOM_ID = F.BBPOM_ID
					  WHERE D.BBPOM_ID = '" .$this->newsession->userdata('BBPOM_ID'). "'";
				$query .= $this->main->find_where($query);	  
				$query .= ($paramsStatus == "" ? " A.RECOM_STATUS IN ('Proses Tindak Lanjut','Selesai')" : $paramsStatus);
			}
			else
			{
				if($this->newsession->userdata('GA_ID')=='2'){
					$qOffice = "";
				}elseif($this->newsession->userdata('OFFICE_ID')=='0'){
					$qOffice = " AND A.GA_ID = '" . $this->newsession->userdata('GA_ID') . "'";
				}else{
					$qOffice = " AND A.OFFICE_ID = '" . $this->newsession->userdata('OFFICE_ID') . "'";
				}
				$query = "SELECT A.RECOM_ID,
					  REPLACE(REPLACE(F.BBPOM_NAME, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','') AS 'BPOM',
					  A.RECOM_NUMBER + '<div>' + CONVERT(VARCHAR(10), A.RECOM_DATE, 120) + '</div>' AS 'Nomor Rekomendasi',
					  E.TRADER_NAME + '<div>' + E.TRADER_ADDRESS_1  + '</div><div>' + E.TRADER_ADDRESS_2 + '</div>' AS 'Nama Sarana',
					  B.GA_NAME + '<div>' + C.OFFICE_NAME + '</div>' AS 'Kementerian/Lembaga/Daerah',
					  A.FOLLOWUP_NUMBER + '<div>' + CONVERT(VARCHAR(10), A.FOLLOWUP_DATE, 120) + '</div>' AS 'Tindak Lanjut',
					  A.RECOM_STATUS AS 'Status',
					  CONVERT(VARCHAR(10), A.RECOM_DATE_CREATED, 120) AS 'Tanggal Entry'
					  FROM TX_RECOM A
					  LEFT JOIN TR_GA B ON A.GA_ID = B.GA_ID
					  LEFT JOIN TR_OFFICE C ON A.OFFICE_ID = C.OFFICE_ID
					  LEFT JOIN TM_INSPECTION D ON A.INSPECTION_ID = D.INSPECTION_ID 
					  LEFT JOIN TM_TRADER E ON D.TRADER_ID = E.TRADER_ID
					  LEFT JOIN TR_BBPOM F ON D.BBPOM_ID = F.BBPOM_ID";
				$query .= $this->main->find_where($query);	  
				$query .= ($paramsStatus == "" ? " A.RECOM_STATUS IN ('Proses Tindak Lanjut', 'Selesai') " : $paramsStatus);
				$query .= $qOffice;
			}
			$table->columns(array("A.RECOM_ID", 
								  "REPLACE(REPLACE(F.BBPOM_NAME, 'BALAI POM DI ', ''), 'BALAI BESAR POM DI ','')",
								  "A.RECOM_NUMBER + '<div>' + CONVERT(VARCHAR(10), A.RECOM_DATE, 120) + '</div>'",
								  "E.TRADER_NAME + '<div>' + E.TRADER_ADDRESS_1  + '</div><div>' + E.TRADER_ADDRESS_2 + '</div>'",
								  "B.GA_NAME + '<div>' + C.OFFICE_NAME + '</div>'",
								  "A.FOLLOWUP_NUMBER + '<div>' + CONVERT(VARCHAR(10), A.FOLLOWUP_DATE, 120) + '</div>'",
								  "A.RECOM_STATUS",
								  "CONVERT(VARCHAR(10), A.RECOM_DATE_CREATED, 120)"));
			$this->newtable->width(array('BPOM' => 110,
										 'Nomor Rekomendasi' => 120,
										 'Nama Sarana' => 200,
										 'Kementerian/Lembaga/Daerah' => 250,
										 'Tindak Lanjut' => 120,
										 'Status' => 100,
										 'Tanggal Entry' => 110));
			$this->newtable->search(array(array("A.RECOM_NUMBER", 'Nomor Rekomendasi'),
										  array("F.BBPOM_NAME", 'BBPOM / BPOM'),
										  array("E.TRADER_NAME", 'Nama Sarana'),
										  array("B.GA_NAME", 'Kementerian'),
										  array("C.OFFICE_NAME", 'Instasi'),
										  array("A.RECOM_STATUS", 'Status')
										  ));

			$table->keys(array("RECOM_ID"));
			$table->hiddens(array("RECOM_ID")); 
			$table->menu(array(
								 'Preview' => array('GET', site_url().'followup/preview', '1', 'mdi-action-open-in-new', 'blue darken-1')
                              )
                        );
			$table->cidb($this->db);
			$table->ciuri($this->uri->segment_array());
			$paramsStatus = "" ? $table->action(site_url('v/followup')) : $table->action(site_url('v/followup/'.$menu));
			$table->orderby(1);
			$table->sortby("ASC");
			$table->show_search(TRUE);
			$table->show_chk(TRUE);
			$table->single(FALSE);
			$table->expandrow(TRUE);
			$table->postmethod(TRUE);
			$table->tbtarget("listFollowUp");
			$table->judul('Data Tindak Lanjut Pemeriksaan Sarana');
			$arrdata = array('table' => $table->generate($query));
			if($this->input->post("data-post")) return $table->generate($query);
			else return $arrdata;
        }
    }
}