<?php

class Monitoring_model extends CI_Model{

	public function lstMonitoring($agency, $timeline)
	{
		if($this->newsession->userdata('isLogin'))
		{
			$table = $this->newtable;
			if($agency == "99")
			{
				$agency = " AND A.OFFICE_ID IS NOT NULL ";
			}
			else
			{
				$agency = " AND A.GA_ID = ". $agency;
			}

			if($timeline == "under")
			{
				$selisih = " <= 30 ";
			}
			else if($timeline == "between")
			{
				$selisih = " BETWEEN 30 AND 90";
			}
			else if($timeline == "upper")
			{
				$selisih = " > 90 ";
			}

			$query = "SELECT RECOM_ID, RECOM_NUMBER AS 'Nomor Rekomendasi', TRADER_NAME AS 'Nama Sarana',
					  GOVERNMENT AS 'Kementrian', OFFICE AS 'Kantor', RECOM_STATUS AS 'Status', 
					  RECOM_ENTRY AS 'Tanggal Entry', SELISIH
					  FROM (SELECT A.RECOM_ID,
					  A.RECOM_NUMBER + '<div>' + CONVERT(VARCHAR(10), A.RECOM_DATE, 120) + '</div>' AS RECOM_NUMBER,
					  E.TRADER_NAME + '<div>' + E.TRADER_ADDRESS_1  + '</div><div>' + E.TRADER_ADDRESS_2 + '</div>' AS TRADER_NAME,
					  B.GA_NAME AS GOVERNMENT, C.OFFICE_NAME AS OFFICE,
					  A.RECOM_STATUS AS RECOM_STATUS,
					  CONVERT(VARCHAR(10), A.RECOM_DATE_CREATED, 120) AS RECOM_ENTRY, 
					  DATEDIFF(day, A.RECOM_DATE, A.FOLLOWUP_DATE) as SELISIH
					  FROM TX_RECOM A
					  LEFT JOIN TR_GA B ON A.GA_ID = B.GA_ID
					  LEFT JOIN TR_OFFICE C ON A.OFFICE_ID = C.OFFICE_ID
					  LEFT JOIN TM_INSPECTION D ON A.INSPECTION_ID = D.INSPECTION_ID 
					  LEFT JOIN TM_TRADER E ON D.TRADER_ID = E.TRADER_ID
					  WHERE A.FOLLOWUP_DATE IS NOT NULL $agency) AS DATA WHERE SELISIH $selisih";
			$table->action(site_url('v/monitoring/'. $agency . '/' . $timeline));
			$table->menu(array(
								 'Preview' => array('GET', site_url().'recomendation/preview', '1', 'mdi-action-open-in-new', 'blue darken-1')
                              )
                        );
			$table->columns(array("RECOM_ID", 
								  "RECOM_NUMBER",
								  "TRADER_NAME",
								  "GOVERNMENT", 
								  "OFFICE",
								  "RECOM_STATUS",
								  "RECOM_ENTRY",
								  "SELISIH"));
			$this->newtable->width(array('Nomor Rekomendasi' => 150,
										 'Tanggal Rekomendasi' => 100,
										 'Kementerian' => 250,
										 'Instansi' => 300,
										 'Status' => 100,
										 'Tanggal Entry' => 110));
			$this->newtable->search(array(array("RECOM_NUMBER", 'Nomor Rekomendasi'),
										  array("TRADER_NAME", 'Nama Sarana'),
										  array("GOVERNMENT", 'Kementerian'),
										  array("OFFICE", 'Instasi'),
										  array("RECOM_STATUS", 'Status')
										  ));
			$table->keys(array("RECOM_ID"));
			$table->hiddens(array("RECOM_ID","SELISIH")); 
			$table->cidb($this->db);
			$table->ciuri($this->uri->segment_array());
			$table->orderby(1);
			$table->sortby("DESC");
			$table->show_search(TRUE);
			$table->show_chk(TRUE);
			$table->single(FALSE);
			$table->expandrow(TRUE);
			$table->postmethod(TRUE);
			$table->tbtarget("listMonitoringRecomendation");
			$table->judul('Data Rekomendasi Pemeriksaan Sarana');
			$arrdata = array('table' => $table->generate($query));
			if($this->input->post("data-post")) return $table->generate($query);
			else return $arrdata;
		}
	}

}