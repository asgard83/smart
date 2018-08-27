<?php

class Inbox_model extends CI_Model{

	public function lstInbox()
	{
		if($this->newsession->userdata('isLogin'))
		{
			$arrInbox['actionCompose'] = site_url('post/set_compose_message');
			$arrInbox['selectGroupUser'] = $this->main->set_combobox("SELECT USER_ID, USER_NIP + ' - ' + USER_NAME AS USER_NAME FROM TM_USER WHERE USER_STATUS = 'Active' AND USER_ID NOT IN ('1') ORDER BY 2 ASC", "USER_ID", "USER_NAME");
			$TxMesssage = "SELECT A.MESSAGE_ID, A.MESSAGE, A.MESSAGE_REPLY, A.USER_ID, A.MESSAGE_RECEIVER,
						   CONVERT(CHAR(10), A.MESSAGE_DATE_CREATED,126) AS MESSAGE_DATE_CREATED,
						   CONVERT(CHAR(10), A.MESSAGE_DATE_REPLY,126) AS MESSAGE_DATE_REPLY,
						   CONVERT(CHAR(10), A.MESSAGE_DATE_CREATED,108) AS MESSAGE_DATE_CREATED_TIME,
						   CONVERT(CHAR(10), A.MESSAGE_DATE_REPLY,108) AS MESSAGE_DATE_REPLY_TIME,
						   CONVERT(CHAR(19), A.MESSAGE_DATE_CREATED,120) AS MESSAGE_DATE_CREATED_AGO, 
						   CONVERT(CHAR(19), A.MESSAGE_DATE_REPLY,120) AS MESSAGE_DATE_REPLY_AGO, 
						   B.USER_NAME AS SENDER, C.USER_NAME AS RECEIVER
						   FROM TX_MESSAGE A 
						   LEFT JOIN TM_USER B ON A.USER_ID = B.USER_ID
						   LEFT JOIN TM_USER C ON A.MESSAGE_RECEIVER = C.USER_ID
						   WHERE A.MESSAGE_RECEIVER = " . $this->newsession->userdata('USER_ID')." OR A.USER_ID = " . $this->newsession->userdata('USER_ID');
			$arrInbox['listMessage'] = $this->db->query($TxMesssage)->result_array();

			return $arrInbox;
		}
	}
	
}