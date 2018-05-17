<?php

class Mm_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function getVpData($module_var = 0, $pageoffset = 0, $perPage = 10) { 
        $q = $this->db->query("SELECT CONCAT(REPEAT('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', level - 1), 
                            CAST(hi.MODULE_NAME AS CHAR)) AS MODULE_NAME, MODULE_VAR,SORT_INDEX, MODULE_PARENT, MODULE_DESCRIPTION, 
                            MODULE_STATUS,MODULE_CONFIG,MODULE_ICON,MODULE_ID, level
                            FROM    (
                                    SELECT  hierarchy_connect_by_parent_eq_prior_id(MODULE_ID) AS id, @level AS level
                                    FROM    (
                                            SELECT  @start_with := 0,
                                                    @id := @start_with,
                                                    @level := 0
                                            ) vars, UI_MODULES
                                    WHERE @id IS NOT NULL
                                    ) ho
                            JOIN   UI_MODULES hi ON hi.MODULE_ID = ho.id ORDER BY SORT_INDEX ASC;"); 
        //print_r($q->result_array());die();
        return $q->result_array();
    }

    function insert($data) { 
        //$data = array_map('clear_html', $data); 
        $data = $data;
        $index = get_name('UI_MODULES', 'SORT_INDEX', 'MODULE_ID', $data['MODULE_PARENT']);
        $module_var = strtolower(str_replace(" ", "_", $data['MODULE_VAR']));
        $this->db->select("*")->from('UI_MODULES')->where("MODULE_VAR = '" . $module_var . "'");
        $q = $this->db->get();
        $num = $q->num_rows();
        if ( $data['SORT_INDEX'] == '') {
             $data['SORT_INDEX'] = 0;
        }
        if (empty($num)) {
            $this->db->trans_start();
            //$data['MODULE_ID'] = get_next_id("UI_MODULES"); 
            unset($data['MODULE_ID']);
            $data['MODULE_VAR'] = $module_var;
            if ($data['MODULE_PARENT'] == 0) {
                $data['SORT_INDEX'] = $data['SORT_INDEX'];
            } else {
                $data['SORT_INDEX'] = $index.'.'.$data['SORT_INDEX'];
            }
            $this->db->insert('UI_MODULES', $data); 
			$module_id = $this->db->insert_id();
			$str = $this->db->last_query();
            //write_log(htmlspecialchars($str,ENT_QUOTES));
            
 
            $this->db->select("*")->from("UI_GROUPS");
            $q = $this->db->get();
            foreach ($q->result() as $row) {
                //$data_priv['PRIVILEGE_ID'] = get_next_id("UI_PRIVILEGE");
                $data_priv['GROUP_ID'] = $row->GROUP_ID;
                $data_priv['MODULE_ID'] = $module_id;
                $data_priv['HAS_INSERT'] = 0;
                $data_priv['HAS_UPDATE'] = 0;
                $data_priv['HAS_DELETE'] = 0;
                $data_priv['HAS_VIEW'] = 0;
                $data_priv['HAS_APPROVAL'] = 0; 
                $this->db->insert('UI_PRIVILEGE', $data_priv, false);
            }
			
            $this->db->trans_complete();
            $result = "ok";
        } else {
            $result = "exists";
        }
        return $result;
    }

    function update($data, $id) { 
        $data = $data;
        $result = 0;
        $index = get_name('UI_MODULES', 'SORT_INDEX', 'MODULE_ID', $data['MODULE_PARENT']);
        
        if (!empty($id)) {
            $cur_module_id = $id;
            $num = 0;
            if ($data['MODULE_VAR'] != $cur_module_id) { 
                $this->db->select("*")->from('UI_MODULES')->where("MODULE_VAR = '" . $data['MODULE_VAR'] . "' and MODULE_VAR not in('" . $cur_module_id . "')");
                $q = $this->db->get();
                $num = $q->num_rows();
            }
            if (empty($num)) {
                if ($data['MODULE_PARENT'] == 0) {
                    $data['SORT_INDEX'] = $data['SORT_INDEX'];
                } else {
                    $data['SORT_INDEX'] = $index.'.'.$data['SORT_INDEX'];
                }
                $this->db->where("MODULE_VAR", $id);
                unset($data["MODULE_ID"]); 
                $this->db->update('UI_MODULES', $data);
                // write_log('UPDATE `UI_MODULES` SET `MODULE_TYPE` = ' . $data['MODULE_TYPE'] . ', `MODULE_VAR` = ' . $data['MODULE_VAR'] . ', 
                //     `MODULE_STATUS` = ' . $data['MODULE_STATUS'] . ', `MODULE_NAME` = ' . $data['MODULE_NAME'] . ', `MODULE_CONFIG` = ' . $data['MODULE_CONFIG'] . ', `MODULE_PARENT` = ' . $data['MODULE_PARENT'] . ', 
                //     `MODULE_URL` = ' . @$data['MODULE_URL'] . ', `SORT_INDEX` = ' . $data['SORT_INDEX'] . ', `MODULE_DESCRIPTION` = ' . $data['MODULE_DESCRIPTION'] . ', `MODULE_ICON` = ' . $data['MODULE_ICON'] . ' 
                //     WHERE `MODULE_VAR` =  ' . $id . '');
                $result = "ok";
            } else {
                $result = "exists";
            }
        }
        return $result;
    }

    function delete($id) {
        $result = 0;
        if (!empty($id)) {
            if ($id == 1) {
                $result = "cant";
            } else {
                $module_name = get_name("UI_MODULES", "MODULE_NAME", "MODULE_ID", $id);
                $this->db->where('MODULE_ID', $id);
                $this->db->delete("UI_MODULES"); 
                $this->db->where("MODULE_ID", $id);
                $this->db->delete("UI_PRIVILEGE");
                //write_log('DELETE FROM `UI_MODULES` WHERE `MODULE_ID` = ' . $id . ', MODULE_NAME = ' . $module_name . '');
                $result = "ok";
            }
        }
        return $result;
    }

    function getParentList() {
        $this->db->select("*")->from("UI_MODULES")->where("MODULE_PARENT", 0);
        $q = $this->db->get();
        return $q;
    }

}

?>