<?php

class Inspections_model extends CI_Model{

    public function lstInspection()
    {
        if($this->newsession->userdata('isLogin'))
		{
            if($this->newsession->userdata('GA_ID')=='1' && $this->newsession->userdata('OFFICE_ID')=='0'){
				$qOffice = "AND A.BBPOM_ID = '" . $this->newsession->userdata('BBPOM_ID') . "'";
			}elseif($this->newsession->userdata('GA_ID')!='1' && $this->newsession->userdata('OFFICE_ID')=='0'){
				$qOffice = "";
			}else{
				$qOffice = "";
			}
			$table = $this->newtable;
			$query = "SELECT A.INSPECTION_ID, B.TRADER_NAME AS 'Nama Sarana',
					  B.TRADER_ADDRESS_1 + '<div>' + B.TRADER_ADDRESS_2 +  '</div><div> ' + D.REGION_NAME + ' ' + E.REGION_NAME + ' </div>' AS 'Alamat',
					  CONVERT(VARCHAR(10), A.INSPECTION_DATE_START, 120) + '<div> Sampai Dengan </div>' + CONVERT(VARCHAR(10), A.INSPECTION_DATE_END, 120) AS 'Tanggal Periksa',
                      A.INSPECTION_RESULT AS 'Hasil Balai', A.INSPECTION_BPOM_RESULT AS 'Hasil Pusat',
					  CASE
					  WHEN A.INSPECTION_STATUS = '60010' THEN 'Baru'
					  ELSE A.INSPECTION_STATUS END
					  AS 'Status'
					  FROM TM_INSPECTION A 
                      LEFT JOIN TM_TRADER B ON A.TRADER_ID = B.TRADER_ID
                      LEFT JOIN TR_BBPOM C ON A.BBPOM_ID = C.BBPOM_ID
					  LEFT JOIN TR_REGION D ON B.REGION_ID = D.REGION_ID
					  LEFT JOIN TR_REGION E ON B.PROVINCE_ID = E.REGION_ID
					  WHERE A.TRADER_TYPE_ID IN ('02LL', '02MM', '02TF', '03AA', '03BB', '03RS', '03WW', '03TR') 
					  AND A.INSPECTION_RESULT IN ('TMK', 'TTP') AND A.INSPECTION_STATUS NOT IN ('Rekomendasi', 'Proses Tindak Lanjut', 'Selesai') $qOffice";
			$table->columns(array("A.INSPECTION_ID",
								  "B.TRADER_ADDRESS_1 + '<div>' + B.TRADER_ADDRESS_2 +  '</div><div> ' + D.REGION_NAME + ' ' + E.REGION_NAME + ' </div>'",
								  "CONVERT(VARCHAR(10), A.INSPECTION_DATE_START, 120) + '<div> Sampai Dengan </div>' + CONVERT(VARCHAR(10), A.INSPECTION_DATE_END, 120)",
								  "A.INSPECTION_RESULT", "A.INSPECTION_BPOM_RESULT"),
								  "CASE WHEN A.INSPECTION_STATUS = '60010' THEN 'Baru' ELSE A.INSPECTION_STATUS END");
			$this->newtable->width(array('Nama Sarana' => 200,
										 'Alamat' => 250,
										 'Tanggal Periksa' => 110,
										 'Hasil Balai' => 75,
										 'Hasil Pusat' => 75,
										 'Status' => 100)); 
			$this->newtable->search(array(
										  array('{IN}A.INSPECTION_ID IN (SELECT Y.INSPECTION_ID FROM TM_LETTER_INSPECTION Y WHERE Y.LETTER_ID IN(SELECT LETTER_ID FROM TM_LETTER WHERE LETTER_ID = Y.LETTER_ID AND LETTER_NUMBER {LIKE}))', 'Nomor Surat Tugas'),
										  array("B.TRADER_NAME", 'Nama Sarana'),
										  array("E.REGION_NAME", 'Provinsi'),
										  array("A.INSPECTION_RESULT", 'Hasil Balai'),
										  array("A.INSPECTION_BPOM_RESULT", 'Hasil Pusat'),
										  array("CONVERT(VARCHAR(10), A.INSPECTION_DATE_START, 120)", "Tanggal Pemeriksaan", array('DATERANGE', array('TRUE', 'data-date-format', 'YYYY-MM-DD')))
										  ));
			$table->keys(array("INSPECTION_ID"));
			$table->hiddens(array("INSPECTION_ID")); 
			$table->menu(array(
								 'Preview' => array('MULTIPLEGET', site_url().'inspection/preview', 'N', 'mdi-action-open-in-new', 'blue darken-1')
                              )
                        );

			$table->cidb($this->db);
			$table->ciuri($this->uri->segment_array());
			$table->action(site_url('v/inspection'));
			$table->orderby("CONVERT(VARCHAR(8), A.INSPECTION_DATE_START, 112)");
			$table->sortby("DESC");
			$table->show_search(TRUE);
			$table->show_chk(TRUE);
			$table->single(FALSE);
			$table->expandrow(TRUE);
			$table->postmethod(TRUE);
			$table->tbtarget("listInspection");
			$table->judul('Data Pemeriksaan Sarana');
			$arrdata = array('table' => $table->generate($query));
			if($this->input->post("data-post")) return $table->generate($query);
			else return $arrdata;
        }
    }
}