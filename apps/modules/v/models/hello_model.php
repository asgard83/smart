<?php

class Hello_model extends CI_Model{

    public function lstHello()
    {
        if($this->newsession->userdata('isLogin'))
		{
            $table = $this->newtable;
			
			$query = "SELECT A.tiket_id [ID Tiket],
					  CONVERT(VARCHAR(10), A.tanggal_pertanyaan, 120) [Waktu],
					  A.klasifikasi [Klasifikasi],
					  A.pertanyaan [Pertanyaan],
					  A.jawaban [Jawaban],
					  A.status [Status]
					  FROM V_HALOBPOM A";
			
			$table->columns(array( 
								  "A.tiket_id", 
								  "A.tanggal_pertanyaan",
								  "A.klasifikasi",
								  "A.pertanyaan", 
								  "A.jawaban",
								  "A.status"));
			$this->newtable->search(array(array("A.klasifikasi", 'Klasifikasi'),
										  array("A.tiket_id", 'ID Tiket'),
										  array("A.pertanyaan", 'Pertanyaan'),
										  array("A.jawaban", 'Jawaban'),
										  array("A.status", 'Status')
										  ));

			$table->keys(array("tiket_id"));
			$table->hiddens(array("tiket_id")); 
			$table->cidb($this->db);
			$table->ciuri($this->uri->segment_array());
			$table->action(site_url('v/hello'));
			$table->orderby(1);
			$table->sortby("DESC");
			$table->show_search(TRUE);
			$table->show_chk(FALSE);
			$table->single(FALSE);
			$table->expandrow(FALSE);
			$table->postmethod(TRUE);
			$table->tbtarget("listHelloBpom");
			$table->judul('Data Halo BPOM');
			$this->db->simple_query('SET ANSI_NULLS ON');
			$this->db->simple_query('SET ANSI_WARNINGS ON');
			$table->selectView(TRUE);
			$arrdata = array('table' => $table->generate($query));
			if($this->input->post("data-post")) return $table->generate($query);
			else return $arrdata;
        }
    }
}