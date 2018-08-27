<?php

class Sla_model extends CI_Model{

    public function lstSla()
    {
        if($this->newsession->userdata('isLogin'))
		{
            $table = $this->newtable;

            $query = "SELECT A.RECOM_ID, B.USER_NAME AS 'Nama User',
                      CONVERT(CHAR(10), A.RECOM_LOG_DATE_CREATED,120)
                      + '<div>' + CONVERT(CHAR(10), A.RECOM_LOG_DATE_CREATED,108) + '</div>' AS 'Waktu',
                      A.RECOM_LOG_STATUS AS 'Status', A.RECOM_LOG_ACTION AS 'Action', A.RECOM_LOG_NOTE AS 'Catatan'
                      FROM TL_RECOM A 
                      LEFT JOIN TM_USER B ON A.USER_ID = B.USER_ID";
			$table->columns(array("A.RECOM_ID",     
                                  "B.USER_NAME",
                                  "CONVERT(CHAR(10), A.RECOM_LOG_DATE_CREATED,120) + '<div>' + CONVERT(CHAR(10), A.RECOM_LOG_DATE_CREATED,108) + '</div>'",
                                  "A.RECOM_LOG_STATUS", 
                                  "A.RECOM_LOG_ACTION", 
                                  "A.RECOM_LOG_NOTE"));
			$this->newtable->width(array('Nama User' => 110,
										 'Waktu' => 120,
										 'Status' => 150,
										 'Action' => 150,
										 'Catatan' => 250));
			$this->newtable->search(array(array("B.USER_NAME", "Nama User"),
										  array("A.RECOM_LOG_STATUS", "Status"),
										  array("A.RECOM_LOG_ACTION", "Action")
										  ));

			$table->keys(array("RECOM_ID"));
			$table->hiddens(array("RECOM_ID")); 
			$table->cidb($this->db);
			$table->ciuri($this->uri->segment_array());
			$table->action(site_url('v/sla'));
			$table->orderby(1);
			$table->sortby("ASC");
			$table->show_search(TRUE);
			$table->show_chk(TRUE);
			$table->single(FALSE);
			$table->expandrow(TRUE);
			$table->postmethod(TRUE);
			$table->tbtarget("listSla");
			$table->judul('Data Service Level Agreement (SLA)');
			$arrdata = array('table' => $table->generate($query));
			if($this->input->post("data-post")) return $table->generate($query);
			else return $arrdata;
        }
    }
}