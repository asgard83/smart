<?php

class Users_model extends CI_Model{
    
    public function getUser()
    {
        $arrRegister = array();
        $arrRegister['action'] = site_url('post/set_register_user');
        $arrRegister['selectGroupAgency']   = array(
                                                    ''  => 'Pilih Instansi',
                                                    '0' => 'Instansi Pusat',
                                                    '1' => 'Instansi Daerah'
                                              );
		$arrRegister['selectRole']   = array(
                                             'Administrator' => 'Administrator',
                                             'User' => 'User'
                                              );
        $arrRegister['selectGroupAgencyId'] = array('' => '');
        return $arrRegister;   
    }


    public function createRegisterUser()
    {
        
    }
	
	
}