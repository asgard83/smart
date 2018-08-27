<?php

class Inbox_model extends CI_Model{

    public function storeComposeMessage()
    {
        if($this->newsession->userdata('isLogin'))
		{
            $respon = FALSE;
            $TxMessage = $this->input->post('objMessage');
            $TxMessage['MESSAGE_ID'] = (int)$this->main->get_uraian("SELECT MAX(MESSAGE_ID) AS SEQ FROM TX_MESSAGE", "SEQ") + 1;
            $TxMessage['USER_ID'] = $this->newsession->userdata('USER_ID');
            $TxMessage['MESSAGE_DATE_CREATED'] = 'GETDATE()';
            $this->db->insert('TX_MESSAGE', $TxMessage);
            if($this->db->affected_rows() > 0)
            {
                $respon = TRUE;
            }
            if($respon)
            {
                return array(
                    'error' => '',
                    'message' => 'Private Message berhasil dikirim',
                    'returnurl' => site_url('v/inbox')
                );
            }
            else
            {
                return array(
                    'error' => 'Private Message gagal dikirim'
                );
            }
        }
    }

    public function storeReplyMessage()
    {
        if($this->newsession->userdata('isLogin'))
		{
            $respon = FALSE;
            $TxMessage = $this->input->post('objMessage');
            $TxMessage['MESSAGE_DATE_REPLY'] = 'GETDATE()';
            $this->db->where(array('MESSAGE_ID' => $this->input->post('messageId')));
            $this->db->update('TX_MESSAGE', $TxMessage);
            if($this->db->affected_rows() > 0)
            {
                $respon = TRUE;
            }
            if($respon)
            {
                return array(
                    'error' => '',
                    'message' => 'Pesan berhasil dikirim',
                    'returnurl' => site_url('v/inbox')
                );
            }
            else
            {
                return array(
                    'error' => 'Pesan gagal dikirim'
                );
            }
        }
    }

    public function getMessageDetail($id)
	{
		if($this->newsession->userdata('isLogin'))
		{
			$TxMessage = "SELECT A.MESSAGE_ID, A.MESSAGE, A.MESSAGE_REPLY, A.USER_ID, A.MESSAGE_RECEIVER,
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
						   WHERE A.MESSAGE_ID = " . $id;
			$dataTxMessage = $this->main->get_result($TxMessage);
			if($dataTxMessage)
			{
				foreach($TxMessage->result_array() as $rowTxMessage)
				{
					$arrMessageDetail['messages'] = $rowTxMessage;
				}
                $arrMessageDetail['actionReply'] = site_url('post/set_reply_message');
			}
			return $arrMessageDetail;					   
		}
	}
    
}