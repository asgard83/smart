<?php

class Settings_model extends CI_Model{
    
    public function lstUser()
    {
        if($this->newsession->userdata('isLogin'))
		{
            $table = $this->newtable;
			$query = "SELECT A.USER_ID, A.USER_NIP AS 'NIP', A.USER_NAME AS 'NAMA', A.USER_EMAIL AS 'EMAIL', 
                      A.USER_PHONE AS 'TELPON', A.USER_ROLE AS 'ROLE', A.USER_STATUS AS 'STATUS'
                      FROM TM_USER A";
			$table->columns(array("A.USER_ID", "A.USER_NIP", "A.USER_NAME", "A.USER_EMAIL",
                                  "A.USER_PHONE", "A.USER_ROLE", "A.USER_STATUS"));
			$this->newtable->width(array('NIP' => 75,
										 'NAMA' => 250,
										 'EMAIL' => 75,
										 'TELPON' => 75,
										 'ROLE' => 100,
                                         'STATUS' => 75));
			$this->newtable->search(array(array("A.USER_NIP", 'Nomor Induk Pegawai'),
										  array("A.USER_NAME", 'Nama'),
										  array("A.USER_EMAIL", 'Email'),
										  array("A.USER_ROLE", 'Role'),
										  array("A.USER_STATUS", 'Status')
										  ));
			$table->keys(array("USER_ID"));
			$table->hiddens(array("USER_ID")); 
			$table->menu(array(
                                 'Tambah' => array('GET', site_url('users/create'), '0', 'home'),
								 'Hapus' => array('POST', site_url().'users/delete', 'N', 'mdi-action-delete', 'red darken-1', 'isngajax')
                              )
                        );
			$table->cidb($this->db);
			$table->ciuri($this->uri->segment_array());
			$table->action(site_url('settings/manages/user'));
			//$table->detail(site_url().'get/history');
			$table->orderby(1);
			$table->sortby("ASC");
			$table->show_search(TRUE);
			$table->show_chk(TRUE);
			$table->single(FALSE);
			$table->expandrow(TRUE);
			$table->postmethod(TRUE);
			$table->tbtarget("listUser");
			$table->judul('Daftar Pengguna Smart BPOM');
			$arrdata = array('table' => $table->generate($query));
			if($this->input->post("data-post")) return $table->generate($query);
			else return $arrdata;
        }
    }
	
	
}