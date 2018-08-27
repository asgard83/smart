<?php
class DashboardModel extends CI_Model{

	public function get_arr_dashboard()
	{
		if($this->newsession->userdata('isLogin'))
		{
			$arrDashboard = array();
			$TxMesssage = "SELECT TOP 3 A.MESSAGE_ID, A.MESSAGE, A.MESSAGE_REPLY, A.USER_ID, A.MESSAGE_RECEIVER,
						   CONVERT(CHAR(10), A.MESSAGE_DATE_CREATED,126) AS MESSAGE_DATE_CREATED,
						   CONVERT(CHAR(10), A.MESSAGE_DATE_CREATED,108) AS MESSAGE_DATE_CREATED_TIME,
						   CONVERT(CHAR(19), A.MESSAGE_DATE_CREATED,120) AS MESSAGE_DATE_CREATED_AGO, 
						   B.USER_NAME AS SENDER, C.USER_NAME AS RECEIVER
						   FROM TX_MESSAGE A 
						   LEFT JOIN TM_USER B ON A.USER_ID = B.USER_ID
						   LEFT JOIN TM_USER C ON A.MESSAGE_RECEIVER = C.USER_ID
						   WHERE A.MESSAGE_RECEIVER = " . $this->newsession->userdata('USER_ID') . " ORDER BY A.MESSAGE_ID DESC";
			$arrDashboard['privateMessage'] = $this->db->query($TxMesssage)->result_array();
			return $arrDashboard;
		}
	}

	public function getCountingDashboardTimeline($agency, $time)
	{
		if($this->newsession->userdata('isLogin'))
		{
			$iTimeLine = 0;
			if($agency != 99)
			{
				if($time == "under")
				{
					$TxRecom = "SELECT COUNT(*) AS JML FROM (SELECT RECOM_DATE, FOLLOWUP_DATE, DATEDIFF(day, RECOM_DATE, FOLLOWUP_DATE) AS SELISIH
											   FROM TX_RECOM WHERE GA_ID = " . $agency . "
											   AND FOLLOWUP_DATE IS NOT NULL) AS DATA
											   WHERE SELISIH <= 30";
				}
				else if($time == "between")
				{
					$TxRecom = "SELECT COUNT(*) AS JML FROM (SELECT RECOM_DATE, FOLLOWUP_DATE, DATEDIFF(day, RECOM_DATE, FOLLOWUP_DATE) AS SELISIH
											   FROM TX_RECOM WHERE GA_ID = " . $agency . "
											   AND FOLLOWUP_DATE IS NOT NULL) AS DATA
											   WHERE SELISIH BETWEEN 30 AND 90";
				}
				else if($time == "upper")
				{
					$TxRecom = "SELECT COUNT(*) AS JML FROM (SELECT RECOM_DATE, FOLLOWUP_DATE, DATEDIFF(day, RECOM_DATE, FOLLOWUP_DATE) AS SELISIH
											   FROM TX_RECOM WHERE GA_ID = " . $agency . "
											   AND FOLLOWUP_DATE IS NOT NULL) AS DATA
											   WHERE SELISIH > 90";
				}
			}
			else
			{
				if($time == "under")
				{
					$TxRecom = "SELECT COUNT(*) AS JML FROM (SELECT RECOM_DATE, FOLLOWUP_DATE, DATEDIFF(day, RECOM_DATE, FOLLOWUP_DATE) AS SELISIH
												FROM TX_RECOM
												WHERE OFFICE_ID IS NOT NULL AND FOLLOWUP_DATE IS NOT NULL) AS DATA
												WHERE SELISIH <= 30";
				}
				else if($time == "between")
				{
					$TxRecom = "SELECT COUNT(*) AS JML FROM (SELECT RECOM_DATE, FOLLOWUP_DATE, DATEDIFF(day, RECOM_DATE, FOLLOWUP_DATE) AS SELISIH
												FROM TX_RECOM
												WHERE OFFICE_ID IS NOT NULL AND FOLLOWUP_DATE IS NOT NULL) AS DATA
												WHERE SELISIH BETWEEN 30 AND 90";
				}
				else if($time == "upper")
				{
					$TxRecom = "SELECT COUNT(*) AS JML FROM (SELECT RECOM_DATE, FOLLOWUP_DATE, DATEDIFF(day, RECOM_DATE, FOLLOWUP_DATE) AS SELISIH
												FROM TX_RECOM
												WHERE OFFICE_ID IS NOT NULL AND FOLLOWUP_DATE IS NOT NULL) AS DATA
												WHERE SELISIH > 90";
				}
			}
			$iTimeLine = (int)$this->main->get_uraian($TxRecom, "JML");
			return $iTimeLine;
		}
	}

}
?>