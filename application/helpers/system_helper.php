<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


function geturl($function, $modul)
{
    $CIobj = &get_instance();
    if ($function == 'login' || $function == 'user') {
        $api_key = $CIobj->config->item('api_key');

    } else {

        $api_key = $CIobj->config->item('api_key');
    }
    $url = $CIobj->config->item($modul);
    //echo $CIobj->config->item($modul);die();
    return $url . '/' . $api_key . '/' . $function;
}

function get($url, $modul)
{
    $CIobj = &get_instance();
//$ip = $CIobj->session->userdata("ip_client");

    $url = geturl($url, $modul);
    $curl = curl_init();
//echo $url;die();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_VERBOSE => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTPHEADER => array(
            "Host: 192.168.1.150",
            "HTTP_CLIENT_IP : 192.168.1.150",
            "HTTP_X_FORWARDED_FOR : 192.168.1.150",
            "REMOTE_ADDR : 192.168.1.150"
        ),
    ));

    $response = curl_exec($curl);
    /*echo 'Curl error: ' . curl_error($curl);
          echo $response;die();*/
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        return "cURL Error #:" . $err;
    } else {
        return $response;
    }
}

function getlogin($url, $data, $modul)
{

    $url = geturl($url, $modul);
    $curl = curl_init();
    //echo $url;die();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            "content-type: application/json",
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) {
        return "cURL Error #:" . $err;
    } else {
        return $response;
    }
}

function post($url, $data, $modul)
{

    $url = geturl($url, $modul);
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            "content-type: application/json",
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) {
        return "cURL Error #:" . $err;
    } else {
        return $response;
    }
}


function put($url, $modul, $data)
{
    $url = geturl($url, $modul);
    $curl = curl_init();

    // echo $url;die();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "PUT",
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            "content-type: application/json",
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        echo $response;
    }
}

function del($url, $modul, $data)
{

    $url = geturl($url, $modul);
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "DELETE",
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            "content-type: application/json",
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        echo $response;
    }

}


function delete($url, $modul)
{
    $url = geturl($url, $modul);
    //echo $url;die();
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "DELETE",
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        echo $response;
    }

}

function get_name($table, $field, $find, $value, $add_where = "")
{
    $CIobj = &get_instance();
    if (!empty($value)) {
        //echo "select ".$field." as result from ".$table." where ".$find."='".$value."' ".$add_where;
        $q = $CIobj->db->query("select " . $field . " as RESULT from " . $table . " where " . $find . "='" . $value . "' " . $add_where);
        $rows = $q->result_array();

        if (@$rows[0]) {
            return @$rows[0]['RESULT'];
        } else {
            //write_log("parse error/empty result for : select " . $field . " as result from " . $table . " where " . $find . "=" . $value . " " . $add_where);
        }
    } else {
        return 0;
    }
}

function getPref($param_id)
{
    $ci = &get_instance();
    $ci->db = $ci->load->database('default', TRUE);
    $ci->db->select("PARAM as RESULT")->from("UI_PARAM")->where("PARAM_ID = '" . $param_id . "'");
    $q = $ci->db->get();
    //echo $ci->db->last_query();
    $rows = $q->result_array();
    if (!empty($rows)) {
        return $rows[0]['RESULT'];
    } else {
        echo $param_id . " not exists";
    }
}

function getMenuList($active_var = "")
{
    $ci = &get_instance();
    $program_id = $ci->session->userdata("program_id") ? $ci->session->userdata("program_id") : 1;
    $username = $ci->session->userdata("username");
    $cauth = $ci->session->userdata("cauth");
    // $groupid = $ci->session->userdata("groupid");
    $user = $ci->session->userdata("user");
    //echo $user;die();
    if($user != "root"){
       $groupid = 9;
    } else {
       $groupid = 1;
    }
    $baseurl = base_url();

    /*$lang = $ci->session->userdata("lang") ? $ci->session->userdata("lang") : getPref('_DEFAULT_LANG');
    $ci->lang->load('system', $lang);*/
    $ci->db->select("UI_PRIVILEGE.*,UI_MODULES.MODULE_ID,
                        UI_MODULES.MODULE_VAR,
                        UI_MODULES.MODULE_NAME,
                        UI_MODULES.MODULE_URL,
                        UI_MODULES.MODULE_PARENT,
                        UI_MODULES.MODULE_TYPE,
                        UI_MODULES.MODULE_ICON")->from("UI_PRIVILEGE,UI_MODULES")
        ->where("UI_PRIVILEGE.MODULE_ID = UI_MODULES.MODULE_ID")
        ->where("UI_MODULES.MODULE_PARENT", 0)
        ->where("UI_MODULES.MODULE_STATUS", 1)
        ->where("UI_PRIVILEGE.GROUP_ID", $groupid)
        ->order_by("UI_MODULES.SORT_INDEX asc");

    //
    $data = $ci->db->get();
    //echo $ci->db->last_query();
    $text = "";

    foreach ($data->result() as $row) {
        if ($row->HAS_VIEW == 1) {
            //get child
            //
            $ci->db->select("UI_PRIVILEGE.*,UI_MODULES.MODULE_ID,
                        UI_MODULES.MODULE_VAR,
                        UI_MODULES.MODULE_NAME,
                        UI_MODULES.MODULE_URL,
                        UI_MODULES.MODULE_PARENT,
                        UI_MODULES.MODULE_TYPE,
                        UI_MODULES.MODULE_ICON")->from("UI_PRIVILEGE,UI_MODULES")
                ->where("UI_PRIVILEGE.MODULE_ID = UI_MODULES.MODULE_ID")
                ->where("UI_MODULES.MODULE_PARENT", $row->MODULE_ID)
                ->where("UI_MODULES.MODULE_STATUS", 1)
                ->where("UI_PRIVILEGE.GROUP_ID", $groupid)
                ->order_by("UI_MODULES.SORT_INDEX asc");


            $data_child = $ci->db->get();
            //echo $ci->db->last_query();die();
            $row_child = $data_child->num_rows();
            $menu_child = "";
            $index = 0;
            if (!empty($row_child)) {
                $embeded_child = "";
                foreach ($data_child->result() as $row_child) {
                    if ($row_child->HAS_VIEW == 1) {
                        if ($row_child->MODULE_TYPE == "module") {
                            $var_child = $row_child->MODULE_VAR;
                        } else {
                            $var_child = "content/index/" . $row_child->MODULE_ID;
                        }

                        $embeded_child .= "<li  id='" . $row_child->MODULE_NAME . "' class='tree'><a href='" . $baseurl . $var_child . "' title='" . $row_child->MODULE_NAME . "'><i class='fa " . $row_child->MODULE_ICON . "'></i> " . $row_child->MODULE_NAME . "</a></li>";
                        $index++;
                    }
                }
                if ($index > 0) {
                    $menu_child .= "<ul class='treeview'>";
                    $menu_child .= $embeded_child;
                    $menu_child .= "</ul>";
                }
            }

            if ($index > 0) {
                $parent_var = "#";
            } else {
                if ($row->MODULE_TYPE == "module") {
                    $parent_var = $row->MODULE_VAR;
                } else {
                    $parent_var = "content/index/" . $row->MODULE_ID;
                }
            }
            if ($row->MODULE_NAME == "Administration") {
                $text .= "<li class='menu-vertical treeview-menu' id='" . $row->MODULE_NAME . "'><a  title='" . $row->MODULE_NAME . "' ><i class='fa fa-user'></i>" . $row->MODULE_NAME . "</a></li>" . $menu_child . "";
            } else {
                $text .= "<li class='menu-vertical'  id='" . $row->MODULE_NAME . "'><a href='" . $baseurl . $parent_var . "' title='" . $row->MODULE_NAME . "' ><i class='fa " . $row->MODULE_ICON . "'></i>" . $row->MODULE_NAME . "</a></li>" . $menu_child . "";
            }
        }
    }

    /*$text.='<li>
                <a href="#" onclick="handleLogout();" style="text-decoration:none;color: #637282;"><i class="fa fa-lg fa-fw fa-sign-out"></i> <span class="menu-item-parent">Sign Out</span></a>
            </li>';*/
    //print_r($text);die();
    return $text;
}


function has_privilege($username, $module_name, $priv = "_view")
{

    if (empty($username) or empty($module_name)) {
        echo "<script>window.location =  '" . base_url() . "Login';</script>Your session has been expired, click <a href='" . base_url() . "Login'>here</a> to relogin <br /> ";
        exit;
        return false;
    }

    $CIobj = &get_instance();

    $priv = strtoupper("HAS" . $priv);

    //$CIobj->db->query("alter session set nls_date_format='yyyy-mm-dd hh24:mi:ss'");
    $module_id = get_name("UI_MODULES", "MODULE_ID", "MODULE_VAR", $module_name);
    //write_log("Accessing module ".$module_name." (".$priv.")");
    $userid = $CIobj->session->userdata('userid');

    $CIobj->db->select("IS_LOGIN,LOGIN_TOKEN,LAST_ACTIVITY,IS_BLOCK")->from("UI_USERS")->where("USER_ID", $userid);
    $qc = $CIobj->db->get();
    //echo $CIobj->db->last_query();
    $dc = $qc->result_array();

    $last_activity = @$dc[0]['LAST_ACTIVITY'];
    //echo $last_activity;
    $is_block = @$dc[0]['IS_BLOCK'];
    $now = date("Y-m-d H:i:s");
    $seconds = strtotime($now) - strtotime($last_activity);
    $minute = floor($seconds / 60);
    $idle_time = getPref('_SESSION_IDLE_TIME');
    //echo "idle for : ".$minute;
    if ($minute >= $idle_time) {
        $CIobj->db->trans_start();
        //echo "masuk idle time ".$minute." ".$idle_time;
        $CIobj->db->query("update UI_USERS set IS_LOGIN = 'N' where USER_ID='" . $userid . "'");
        $CIobj->db->trans_complete();
        write_log("user session has been expired ");
        $CIobj->session->sess_destroy();
        $data['error_msg'] = "Your session has been expired";

        echo "Your session has been expired, click <a href='" . base_url() . "Login'>here</a> to relogin <br /> " . $last_activity . " " . $minute . " " . $idle_time;
        return false;
    }


    if ($is_block == "Y") {
        //echo "masuk block";
        //$CIobj->db->query("update UI_USERS set IS_LOGIN = 'N' where USER_ID='".$userid."'");
        write_log("user session has been terminated");
        $CIobj->session->sess_destroy();
        $data['error_msg'] = "Your account has been blocked";
        //redirect('login');
        //$CIobj->load->view("login/login_temp",$data);
        return false;
        exit;
    }

    $groupid = $CIobj->session->userdata('groupid');
    $userid = $CIobj->session->userdata('userid');
    $token = $CIobj->session->userdata('login_token');

    if (empty($userid)) {
        //echo "masuk session gak ke save";
        $data['error_msg'] = "Your session has been expired";
        return false;
        exit;
    }


    //check login
    //print_r($dc);
    if (@$dc[0]["IS_LOGIN"] == "N" or $token != @$dc[0]["LOGIN_TOKEN"]) {
        //destroy session
        echo "masuk login token sama is login = n";
        $CIobj->session->sess_destroy();
        $data['error_msg'] = "Your session has been expired";
        $CIobj->load->view("Login/login_temp", $data);
        return false;
        exit;
    } else {

        $CIobj->db->select("*")->from("UI_PRIVILEGE")->where("GROUP_ID", $groupid)->where("MODULE_ID", $module_id)->where($priv, 1);
        $q = $CIobj->db->get();
        //echo $CIobj->db->last_query();
        //echo "select * from UI_PRIVILEGE where GROUP_ID = '".$groupid."' and MODULE_ID = '".$module_id."' and ".$priv."=1";
        $num = $q->num_rows();

        if (!empty($num)) {
            //update last activity
            //echo $priv;
            if ($priv == "is_view") {
                //echo "test";
                $access_module = get_name("UI_MODULES", "MODULE_NAME", "MODULE_VAR", $module_name);
                write_log("Access " . $access_module);
            }
            $CIobj->db->trans_start();
            $CIobj->db->query("update UI_USERS set LAST_ACTIVITY = '" . date("Y-m-d H:i:s") . "', LAST_MODULE='" . $module_name . "', IS_LOGIN='Y' where USER_ID = '" . $userid . "'");
            $CIobj->db->trans_complete();
            return true;
        } else {
            //echo "You don't have permission to access this feature";
            return false;
        }
    }
}

?>
