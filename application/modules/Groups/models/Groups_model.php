<?php

class Groups_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function getUserData($groupid = 0, $pageoffset = 0, $perPage = 10) {
        $this->db->select("*")->from("UI_GROUPS"); 
        $q = $this->db->get();
        //print_r($q->result_array());die();
        return $q->result_array();
    }

    function getDataSource() {
        $this->db->select("*")->from("tb_data_source");
        $q = $this->db->get();
        return $q->result_array();
    }

    function insert($data) { 
        $this->db->select("*")->from('UI_GROUPS')->where("GROUP_NAME = '" . $data['GROUP_NAME'] . "'");
        $q = $this->db->get();
        $num = $q->num_rows();
        unset($data['group_id']);

        if (empty($num)) {
            $this->db->trans_start();
            //$data = array_map('clear_html', $data);
            $data = $data;
            $this->db->set($data);
            $this->db->insert('UI_GROUPS', $data); 
			$max_id = $this->db->insert_id();
            //write_log('INSERT INTO `UI_GROUPS` (`GROUP_ID`, `GROUP_NAME`) VALUES (' . $data['GROUP_ID'] . ', ' . $data['GROUP_NAME'] . ')'); 
            $this->db->select("MODULE_ID")->from("UI_MODULES");
            $qm = $this->db->get();
            foreach ($qm->result_array() as $row_module) { 
                //$priv_id = get_next_id("UI_PRIVILEGE");
                $data_priv = array('GROUP_ID' => $max_id,
                    'MODULE_ID' => $row_module['MODULE_ID'],
                    'HAS_INSERT' => 0,
                    'HAS_UPDATE' => 0,
                    'HAS_DELETE' => 0,
                    'HAS_VIEW' => 0,
                    'HAS_APPROVAL' => 0);
                $this->db->insert("UI_PRIVILEGE", $data_priv);
            }
 
            $this->db->select("*")->from("UI_MODULES")->where("MODULE_PARENT", 0);
            $qp = $this->db->get();
            foreach ($qp->result_array() as $row_qp) {
                $this->db->query("update UI_PRIVILEGE set HAS_VIEW = 1 where GROUP_ID='" . $max_id . "' and MODULE_ID = '" . $row_qp['MODULE_ID'] . "'");
            }
            $this->db->trans_complete();
            $result = "ok";
        } else {
            $result = "exists";
        } 
        return $result;
    }

    function update($data) {
        if (!empty($data['GROUP_ID'])) {
            $cur_groupname = get_name("UI_GROUPS", "GROUP_NAME", "GROUP_ID", $data['GROUP_ID']);
            $num = 0;
            if ($data['GROUP_NAME'] != $cur_groupname) { 
                $this->db->select("*")->from('UI_GROUPS')->where("GROUP_NAME = '" . $data['GROUP_NAME'] . "'");
                $q = $this->db->get();
                $num = $q->num_rows();
            }
            if (empty($num)) {
                $this->db->where("GROUP_ID", $data['GROUP_ID']);
                $this->db->update('UI_GROUPS', $data);
                //write_log('UPDATE `UI_GROUPS` SET `GROUP_ID` = ' . $data['GROUP_ID'] . ', `GROUP_NAME` = ' . $data['GROUP_NAME'] . ' WHERE `GROUP_ID` =  ' . $data['GROUP_ID'] . '');
                $result = "ok";
            }
            if (!empty($num)) {
                $result = "exists";
            }
        }
        return $result;
    }

    function delete($id) {
		
        if (!empty($id)) {
            if ($id == 1) {
                $result = "cant";
            } else {
                $groupname = get_name("UI_GROUPS", "GROUP_NAME", "GROUP_ID", $id);
				
                $this->db->trans_start();
                $this->db->where('GROUP_ID', $id);
                $this->db->delete("UI_PRIVILEGE");
                $this->db->where('GROUP_ID', $id, false);
                $this->db->delete("UI_GROUPS");
				
                $err_msg = $this->db->error();
               
                $this->db->trans_complete();

                if ($err_msg["message"]) {
                    $result = "failed";
                } else {
                    $result = "ok";
                    //write_log('DELETE FROM `UI_GROUPS` WHERE `GROUP_ID` =  ' . $id . '');
                }
            }
        }
        return $result;
    }

}

?>