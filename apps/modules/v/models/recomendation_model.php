<?php

class Recomendation_model extends CI_Model{

    public function lstRecomendation($menu)
    {
        if($this->newsession->userdata('isLogin'))
		{
            $table = $this->newtable;
			if($this->newsession->userdata('GA_ID') == '1')
			{
				if($menu == "new")
				{
					$query = "SELECT A.RECOM_ID,
					  A.RECOM_NUMBER + '<div>' + CONVERT(VARCHAR(10), A.RECOM_DATE, 120) + '</div>' AS 'Nomor Rekomendasi',
					  E.TRADER_NAME + '<div>' + E.TRADER_ADDRESS_1  + '</div><div>' + E.TRADER_ADDRESS_2 + '</div>' AS 'Nama Sarana',
					  B.GA_NAME AS 'Kementerian', C.OFFICE_NAME AS 'Kantor',
					  A.RECOM_STATUS AS 'Status',
					  CONVERT(VARCHAR(10), A.RECOM_DATE_CREATED, 120) AS 'Tanggal Entry'
					  FROM TX_RECOM A
					  LEFT JOIN TR_GA B ON A.GA_ID = B.GA_ID
					  LEFT JOIN TR_OFFICE C ON A.OFFICE_ID = C.OFFICE_ID
					  LEFT JOIN TM_INSPECTION D ON A.INSPECTION_ID = D.INSPECTION_ID 
					  LEFT JOIN TM_TRADER E ON D.TRADER_ID = E.TRADER_ID
					  WHERE A.RECOM_STATUS = 'Draft'
					  AND D.BBPOM_ID = '" .$this->newsession->userdata('BBPOM_ID'). "'";
				}
				else if($menu == "sent")
				{
					$query = "SELECT A.RECOM_ID,
					  A.RECOM_NUMBER + '<div>' + CONVERT(VARCHAR(10), A.RECOM_DATE, 120) + '</div>' AS 'Nomor Rekomendasi',
					  E.TRADER_NAME + '<div>' + E.TRADER_ADDRESS_1  + '</div><div>' + E.TRADER_ADDRESS_2 + '</div>' AS 'Nama Sarana',
					  B.GA_NAME AS 'Kementerian', C.OFFICE_NAME AS 'Kantor',
					  A.RECOM_STATUS AS 'Status',
					  CONVERT(VARCHAR(10), A.RECOM_DATE_CREATED, 120) AS 'Tanggal Entry'
					  FROM TX_RECOM A
					  LEFT JOIN TR_GA B ON A.GA_ID = B.GA_ID
					  LEFT JOIN TR_OFFICE C ON A.OFFICE_ID = C.OFFICE_ID
					  LEFT JOIN TM_INSPECTION D ON A.INSPECTION_ID = D.INSPECTION_ID 
					  LEFT JOIN TM_TRADER E ON D.TRADER_ID = E.TRADER_ID
					  WHERE A.RECOM_STATUS IN ('Proses Tindak Lanjut', 'Selesai')
					  AND D.BBPOM_ID = '" .$this->newsession->userdata('BBPOM_ID'). "'";
				}
				$table->action(site_url('v/recomendation/'. $menu));
				$table->menu(array(
									'Preview' => array('GET', site_url().'recomendation/preview', '1', 'mdi-action-open-in-new', 'blue darken-1'),
									'Kirim Rekomendasi' => array('POST', site_url('post/set_send_recom'), 'N', 'mdi-content-send', 'orange darken-1', 'isngajax')
								)
							);
			}
			else
			{
				if($this->newsession->userdata('GA_ID')=='2'){
					$qOffice = "";
				}elseif($this->newsession->userdata('OFFICE_ID')=='0'){
					$qOffice = "AND A.GA_ID = '" . $this->newsession->userdata('GA_ID') . "'";
				}else{
					$qOffice = "AND A.OFFICE_ID = '" . $this->newsession->userdata('OFFICE_ID') . "'";
				}
				$query = "SELECT A.RECOM_ID,
					  A.RECOM_NUMBER + '<div>' + CONVERT(VARCHAR(10), A.RECOM_DATE, 120) + '</div>' AS 'Nomor Rekomendasi',
					  E.TRADER_NAME + '<div>' + E.TRADER_ADDRESS_1  + '</div><div>' + E.TRADER_ADDRESS_2 + '</div>' AS 'Nama Sarana',
					  B.GA_NAME AS 'Kementerian', C.OFFICE_NAME AS 'Kantor',
					  A.RECOM_STATUS AS 'Status',
					  CONVERT(VARCHAR(10), A.RECOM_DATE_CREATED, 120) AS 'Tanggal Entry'
					  FROM TX_RECOM A
					  LEFT JOIN TR_GA B ON A.GA_ID = B.GA_ID
					  LEFT JOIN TR_OFFICE C ON A.OFFICE_ID = C.OFFICE_ID
					  LEFT JOIN TM_INSPECTION D ON A.INSPECTION_ID = D.INSPECTION_ID 
					  LEFT JOIN TM_TRADER E ON D.TRADER_ID = E.TRADER_ID
					  WHERE A.RECOM_STATUS IN ('Baru') $qOffice";
				$table->action(site_url('v/recomendation'));	  
				$table->menu(array(
								 'Preview' => array('GET', site_url().'recomendation/preview', '1', 'mdi-action-open-in-new', 'blue darken-1')
                              )
                        );
			}
			
			$table->columns(array("A.RECOM_ID", 
								  "A.RECOM_NUMBER + '<div>' + CONVERT(VARCHAR(10), A.RECOM_DATE, 120) + '</div>'",
								  "E.TRADER_NAME + '<div>' + E.TRADER_ADDRESS_1  + '</div><div>' + E.TRADER_ADDRESS_2 + '</div>'",
								  "B.GA_NAME", 
								  "C.OFFICE_NAME",
								  "A.RECOM_STATUS",
								  "CONVERT(VARCHAR(10), A.RECOM_DATE_CREATED, 120)"));
			$this->newtable->width(array('Nomor Rekomendasi' => 150,
										 'Tanggal Rekomendasi' => 100,
										 'Kementerian' => 250,
										 'Instansi' => 300,
										 'Status' => 100,
										 'Tanggal Entry' => 110));
			$this->newtable->search(array(array("A.RECOM_NUMBER", 'Nomor Rekomendasi'),
										  array("E.TRADER_NAME", 'Nama Sarana'),
										  array("B.GA_NAME", 'Kementerian'),
										  array("C.OFFICE_NAME", 'Instasi'),
										  array("A.RECOM_STATUS", 'Status')
										  ));
			$table->keys(array("RECOM_ID"));
			$table->hiddens(array("RECOM_ID")); 
			$table->cidb($this->db);
			$table->ciuri($this->uri->segment_array());
			$table->orderby(1);
			$table->sortby("ASC");
			$table->show_search(TRUE);
			$table->show_chk(TRUE);
			$table->single(FALSE);
			$table->expandrow(TRUE);
			$table->postmethod(TRUE);
			$table->tbtarget("listRecomendation");
			$table->judul('Data Rekomendasi Pemeriksaan Sarana');
			$arrdata = array('table' => $table->generate($query));
			if($this->input->post("data-post")) return $table->generate($query);
			else return $arrdata;
        }
    }
}