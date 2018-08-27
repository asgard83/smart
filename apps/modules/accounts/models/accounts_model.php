<?php

class Accounts_model extends CI_Model{
    
    public function get_Register()
    {
        $arrRegister = array();
        $arrRegister['action'] = site_url('post/set_register_user');
        $arrRegister['selectGroupAgency']   = array(
                                                    ''  => 'Pilih Instansi',
                                                    '1' => 'Instansi Pusat',
                                                    '2' => 'Instansi Daerah'
                                              );
        $arrRegister['selectGroupAgencyId'] = array('' => '');
        return $arrRegister;   
    }


    public function createRegisterUser()
    {
        if($this->newsession->userdata('isLogin') && $this->newsession->userdata('USER_ROLE') == 'Administrator')
		{
            $TmUser = $this->main->post_to_query($_POST['objRegister']);
            
            $iUserNip = (int)$this->main->get_uraian("SELECT COUNT(*) AS EXIST FROM TM_USER WHERE USER_NIP = '". $TmUser['USER_NIP']."'", "EXIST");
            if($iUserNip > 0)
            {
                return array('error' => 'User dengan ' . $TmUser['USER_NIP'] . ', sudah terdaftar.');
                die();
            }
            
            $TmUser['USER_ID']          = (int)$this->main->get_uraian("SELECT MAX(USER_ID) AS SEQ FROM TM_USER", "SEQ") + 1;
            $TmUser['USER_PASSWORD']    = md5($TmUser['USER_PASSWORD']);
            $TmUser['BBPOM_ID']         = '00';
            $TmUser['USER_STATUS']      = 'Active';
            $this->db->insert('TM_USER', $TmUser);
            if($this->db->affected_rows() > 0)
            {
                return array(
                    'error' => '',
                    'message' => 'Registrasi user berhasil',
                    'returnurl' => site_url('settings/manages/user')
                );
            }
            else
            {
                return array(
                    'error' => 'Registrasi user gagal.'
                );
            }

        }
    }
	
	
}