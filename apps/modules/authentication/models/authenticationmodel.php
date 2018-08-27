<?php
class AuthenticationModel extends CI_Model{

	
	public function attempt()
	{
		if ($this->newsession->userdata('keycode_ses') != str_replace(' ', '', $this->input->post('cpth')))
		{
			return array('error' => 'Kode Verifikasi Tidak Sesuai');
			exit();
		}

		$pwd = md5($this->input->post('pwd'));
		$match = FALSE;
		$next = FALSE;
		
		$sTm_User = "SELECT A.USER_ID, A.USER_NIP, A.USER_NAME, A.USER_EMAIL, A.USER_PHONE, 
					 A.USER_ROLE, A.GA_ID, A.BBPOM_ID, A.OFFICE_ID, A.USER_STATUS, B.GA_LOGO, C.OFFICE_NAME, 
					 (LEFT(C.REGION_ID, 2) + '00') PROVINCE_ID, CONVERT(VARCHAR, A.USER_DATE_LOGIN, 120) USER_DATE_LOGIN
					 FROM TM_USER A LEFT JOIN TR_GA B ON B.GA_ID = A.GA_ID 
					 LEFT JOIN TR_OFFICE C ON C.OFFICE_ID = A.OFFICE_ID 
					 WHERE A.USER_NIP = '". $this->input->post('uid') ."' AND A.USER_STATUS = 'Active'";
		$blData = $this->main->get_result($sTm_User);
		if($blData){
			foreach($sTm_User->result_array() as $row)
			{
				$arrSess = $row;
			}
			$next = TRUE;
		}
		
		if($next)
		{
			$storepwd = $this->main->get_uraian("SELECT USER_PASSWORD FROM TM_USER WHERE USER_NIP = '". $this->input->post('uid') ."' AND USER_STATUS = 'Active'","USER_PASSWORD");
			if($storepwd == $pwd)
			{
				$match = TRUE;
			}
		}
		
		if($match)
		{
			$data = array('USER_DATE_LOGIN' => 'GETDATE()');
			$this->db->where('USER_NIP', $this->input->post('uid'));
			$this->db->where('USER_PASSWORD', $storepwd);
			$this->db->update('TM_USER', $data);
			if($this->db->affected_rows() == 1)
			{
				$arrSess['isLogin'] = TRUE;
				$this->newsession->set_userdata($arrSess);
				return array('message' => 'Otentikasi pengguna sesuai',
							'returnurl' => site_url('dashboard'),
							'error' => '');
			}
			else
			{
				return array('error' => 'Proses otentikasi pengguna gagal.');
			}
		}
		else
		{
			return array('error' => 'Otentikasi pengguna tidak sesuai.');
		}
	}
}
?>