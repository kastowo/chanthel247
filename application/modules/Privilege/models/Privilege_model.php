<?php

class Privilege_model extends CI_Model {

    function __construct() {
        parent::__construct();

    }

    function getPrivData($group_id, $pageoffset, $perPage = 10) {     
    //echo $group_id;die();   
        $q = $this->db->query("SELECT CONCAT(REPEAT('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', level - 1), 
                                CAST(hi.MODULE_NAME AS CHAR)) AS MODULE_NAME,hi.SORT_INDEX,hi.MODULE_CONFIG,hi.MODULE_ID,level,GROUP_NAME,UI_PRIVILEGE.*
                                FROM    (
                                        SELECT  hierarchy_connect_by_parent_eq_prior_id(MODULE_ID) AS id, @level AS level
                                        FROM    (
                                                SELECT  @start_with := 0,
                                                        @id := @start_with,
                                                        @level := 0
                                                ) vars, UI_MODULES
                                        WHERE @id IS NOT NULL
                                        ) ho
                                JOIN   UI_MODULES hi ON hi.MODULE_ID = ho.id 
                            INNER JOIN UI_PRIVILEGE ON hi.MODULE_ID = UI_PRIVILEGE.MODULE_ID
                            INNER JOIN UI_GROUPS ON UI_GROUPS.GROUP_ID = UI_PRIVILEGE.GROUP_ID
                            WHERE UI_PRIVILEGE.GROUP_ID = $group_id;
            ");
        //print_r($q);die();

        return $q->result_array();
    }

    function TotalRec() {
        $this->db->select('ui_privilege.*, ui_groups.group_name, ui_modules.module_name, ui_modules.module_config')->from('ui_privilege')->join('ui_modules', 'ui_modules.module_id=ui_privilege.module_id', 'inner')->join('ui_groups', 'ui_groups.group_id = ui_privilege.group_id', 'inner');
        $keyword = $this->session->userdata('privSearchKeyword');
        $sel_groupid = $this->session->userdata("privGroupId");
        if (!empty($keyword)) {
            $keyword_list = explode(" ", $keyword);
            foreach ($keyword_list as $k => $v) {
                $this->db->like('group_name', $v);
                $this->db->or_like('module_name', $v);
                $this->db->or_like('module_config', $v);
            }
        }
        if (!empty($sel_groupid)) {
            $this->db->where("ui_privilege.group_id", $sel_groupid);
        }
        $prefix = $this->uri->segment(1);
        $sort = $this->session->userdata($prefix . "searchSort");
        $list = $this->session->userdata($prefix . "sortList");
        if (!empty($sort)) {
            if (empty($list)) {
                $list = "asc";
            }
            $this->db->order_by($sort, $list);
        } else {
            $this->db->order_by("privilege_id asc");
        }
        $q = $this->db->get();
        return $q->num_rows();
    }

    function update($data, $id) {
        $module_id = get_name("UI_PRIVILEGE", "MODULE_ID", "PRIVILEGE_ID", $id);
        $group_id = get_name("UI_PRIVILEGE", "GROUP_ID", "PRIVILEGE_ID", $id);
        $module_name = get_name("UI_MODULES", "MODULE_NAME", "MODULE_ID", $module_id);
        $group_name = get_name("UI_GROUPS", "GROUP_NAME", "GROUP_ID", $group_id);
        unset($data['privilege_id']);
        $this->db->where("PRIVILEGE_ID", $id, false);
        $this->db->update('UI_PRIVILEGE', $data);
        write_log("update privilege module " . $module_name . " for group " . $group_name);
        $result = "ok";
        return $result;
    }

    function update_all($data) {
        //print_r($data);die();
        foreach ($data as $k => $v) {
            $data = explode("HAS_", $k);
            $data['value'] = $v;
            if (is_numeric($data[0])) {
                $data_update[$data[0]]['HAS_' . $data[1]] = $v;
                //$data_update[$data[0]]['HAS_' . $data[1]] = $v;
            }
        }
        //print_r($data_update);die();
        foreach ($data_update as $k => $v) {
            $module_id = get_name("UI_PRIVILEGE", "MODULE_ID", "PRIVILEGE_ID", $k);
            $group_id = get_name("UI_PRIVILEGE", "GROUP_ID", "PRIVILEGE_ID", $k);
            $module_name = get_name("UI_MODULES", "MODULE_NAME", "MODULE_ID", $module_id);
            $group_name = get_name("UI_GROUPS", "GROUP_NAME", "GROUP_ID", $group_id);
            $this->db->where("PRIVILEGE_ID", $k);
            $this->db->update('UI_PRIVILEGE', $v);
            //write_log("update privilege module " . $module_name . " for group " . $group_name);
        }
        $result = "ok";
        //echo $this->db->last_query();die();
        return $result;
    }
    function reset_all($group_id){
        if($group_id == 1){
            $has_insert = 1;
            $has_update = 1;
            $has_delete = 1;
        }else{
            $has_insert = 0;
            $has_update = 0;
            $has_delete = 0;
        }

        $q = $this->db->query("UPDATE UI_PRIVILEGE SET HAS_INSERT = $has_insert, HAS_UPDATE = $has_update, HAS_DELETE = $has_delete, HAS_VIEW = 1
                              WHERE GROUP_ID = $group_id ;");  
        
        return $q;
    }
}

?>