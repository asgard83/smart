<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Main extends CI_Model
{
	
	function get_uraian($query, $select)
	{
		$data = $this->db->query($query);
		if ($data->num_rows() > 0) {
			$row = $data->row();
			return $row->$select;
		} else {
			return "";
		}
		return 1;
	}
	
	function get_result(&$query)
	{
		$data = $this->db->query($query);		
		if ($data->num_rows() > 0) {
			$query = $data;
		} else {
			return false;
		}
		return true;
	}
	
	function get_row_array(&$query, $db = "")
	{
		$result = array();
		if ($db != "") {
			$dbnya = $this->load->database($db, TRUE);
			$data  = $dbnya->query($query);
		} else {
			$data = $this->db->query($query);
		}
		if ($data->num_rows() > 0) {
			foreach ($data->result_array() as $row) {
				$result[] = $row;
			}
		}
		return $result;
	}
	
	function array_cb($query, $key, $value)
	{
		$data    = $this->db->query($query);
		$arraycb = array();
		if ($data->num_rows() > 0) {
			foreach ($data->result_array() as $row) {
				if (!array_key_exists($row[$key], $arraycb))
					$arraycb[$row[$key]] = $row[$value];
			}
		} else {
			return false;
		}
		return $arraycb;
	}
	
	function set_combobox($query, $key, $value, $empty = FALSE, &$disable = "")
	{
		$combobox = array();
		$data     = $this->db->query($query);
		if ($empty)
			$combobox[""] = "&nbsp;";
		if ($data->num_rows() > 0) {
			$kodedis = "";
			$arrdis  = array();
			foreach ($data->result_array() as $row) {
				if (is_array($disable)) {
					if ($kodedis == $row[$disable[0]]) {
						if (!array_key_exists($row[$key], $combobox))
							$combobox[$row[$key]] = "&nbsp; &nbsp;&nbsp;&nbsp;" . $row[$value];
					} else {
						if (!array_key_exists($row[$disable[0]], $combobox))
							$combobox[$row[$disable[0]]] = $row[$disable[1]];
						if (!array_key_exists($row[$key], $combobox))
							$combobox[$row[$key]] = "&nbsp; &nbsp;&nbsp;&nbsp;" . $row[$value];
					}
					$kodedis = $row[$disable[0]];
					if (!in_array($kodedis, $arrdis))
						$arrdis[] = $kodedis;
				} else {
					$combobox[$row[$key]] = str_replace("'", "\'", $row[$value]);
				}
			}
			$disable = $arrdis;
		}
		return $combobox;
	}
	
	function post_to_query($array, $except = "")
	{
		$data = array();
		foreach ($array as $a => $b) {
			if (is_array($except)) {
				if (!in_array($a, $except))
					$data[$a] = $b;
			} else {
				$data[$a] = $b;
			}
		}
		return $data;
	}
	
	function get_result_array(&$query, $db = "")
	{
		$result = array();
		if ($db != "") {
			$dbnya = $this->load->database($db, TRUE);
			$data  = $dbnya->query($query);
		} else {
			$data = $this->db->query($query);
		}
		if ($data->num_rows() > 0) {
			foreach ($data->result_array() as $row) {
				$result = $row;
			}
		}
		return $result;
	}
	
	
	function find_where($query)
	{
		if (strpos($query, "WHERE") === FALSE) {
			$query = " WHERE ";
		} else {
			$query = " AND ";
		}
		return $query;
	}
	
	function allowed($ext)
	{
		for ($i = -1; $i > -(strlen($ext)); $i--) {
			if (substr($ext, $i, 1) == '.')
				return (substr($ext, $i));
		}
	}
	
	function set_menu($role)
	{
		$query = "SELECT LTRIM(RTRIM(a.MENU_ID)) AS MENU_ID, a.MENU_NAME AS MENU_NAME, a.MENU_CLASS AS MENU_CLASS, a.MENU_URL AS MENU_URL, 
		(SELECT COUNT(*) FROM TM_MENU WHERE LEFT(TM_MENU.MENU_ID, LEN(RTRIM(LTRIM(a.MENU_ID)))) = RTRIM(LTRIM(a.MENU_ID)) AND TM_MENU.MENU_FOR = '0') AS SUB_MENU
		FROM TM_MENU a 
		LEFT JOIN TM_MENU_ROLE b ON a.MENU_ID = b.MENU_ID
		WHERE b.MENU_ROLE_ID = '" . $role . "' AND a.MENU_STATUS = 1 
		ORDER BY 1 ASC";
		if ($this->get_result($query)) {
			foreach ($query->result_array() as $row) {
				$result[$row['menu_id']] = array($row['SUB_MENU'],
												 $row['MENU_NAME'],
												 $row['MENU_CLASS'],
												 str_replace('{routes}#', '', site_url($row['MENU_URL']))
				);
			}
		}
		return $result;
	}
	
	function set_content($priv, $content)
	{
		$appname = 'SMARTBPOM';
		if ($priv == "signin") {
			$header = $this->load->view('header/signin', '', true);
		} else if ($priv == "dashboard") {
			$header = $this->load->view('header/dashboard', '', true);
		}
		$navmenu = ($priv == "dashboard" ? $this->set_menu($this->newsession->userdata('user_role')) : '');
		if ($breadcumbs == "")
			$breadcumbs = "";
		$data = array(
			'_appname_' => $appname,
			'_header_' => $header,
			'_navmenu_' => $navmenu,
			'_content_' => $content
		);
		return $data;
	}
	
	function gen_password()
	{
		$alphabet    = '!@#$%^&*()_+abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass        = array();
		$alphaLength = strlen($alphabet) - 1;
		for ($i = 0; $i < 8; $i++) {
			$n      = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass);
	}
	
}
?>