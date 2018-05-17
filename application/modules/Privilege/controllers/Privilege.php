<?php

class Privilege extends MX_Controller {

    function index() {
        /*$username = $this->session->userdata("username");
        $this->load->model('privilege_model');
        $has_privilege = has_privilege($username, $this->uri->segment(1));


        $lang = $this->session->userdata("lang") ? $this->session->userdata("lang") : getPref('_DEFAULT_LANG');
        $this->lang->load('system', $lang);*/


        // if (!empty($username) and $has_privilege === true) {
            $group_id = $this->uri->segment(3);
            /*$data["table_data"] = $this->privilege_model->getPrivData($group_id, 0, 0);
            $data["group_name"] = get_name("UI_GROUPS", "GROUP_NAME", "GROUP_ID", $group_id);
            $data["group_id"] = $group_id;
            $this->load->view("privilege_view", $data);*/

            $username = $this->session->userdata("user");
            $pass = $this->session->userdata("pass");
            $this->session->unset_userdata('id');
            $this->load->model('privilege_model');
            //$id = $this->session->userdata("id");
            //echo $user;die();
            $this->template->write('title', 'Baciro Gateway', TRUE);
            //print_r($this->groups_model->getUserData(0, 0, 0));die();
            $data["table_data"] = $this->privilege_model->getPrivData($group_id, 0, 0);
            $data["group_name"] = get_name("UI_GROUPS", "GROUP_NAME", "GROUP_ID", $group_id);
            $data["group_id"] = $group_id;
            $this->template->write('breadcrumb', 'Task', TRUE);
            $this->template->write_view('content', 'privilege_view', $data, TRUE);
            $this->template->render();

        // }
        // if (!$has_privilege) {
        //     echo "You don't have a privilege to access this module <script>document.location.replace('" . base_url() . "/login/logmeout')</script>";
        // }
    }

    function view_prev() {
        $group_id = $this->uri->segment(3);
        $username = $this->session->userdata("user");
        $pass = $this->session->userdata("pass");
        $this->session->unset_userdata('id');
        $this->load->model('privilege_model');
        //$id = $this->session->userdata("id");
        //echo $user;die();
        $this->template->write('title', 'Baciro Gateway', TRUE);
        //print_r($this->groups_model->getUserData(0, 0, 0));die();
        $data["table_data"] = $this->privilege_model->getPrivData($group_id, 0, 0);
        $data["group_name"] = get_name("UI_GROUPS", "GROUP_NAME", "GROUP_ID", $group_id);
        $data["group_id"] = $group_id;
        $this->template->write('breadcrumb', 'Task', TRUE);
        $this->template->write_view('content', 'privilege_view', $data, TRUE);
        $this->template->render();
    }

    function setSearch() {
        $this->session->set_userdata('privSearchKeyword', $_REQUEST['user']);
        $this->session->set_userdata('privGroupId', $_REQUEST['group_id']);
        echo "ok";
    }

    function setSort() {
        $prefix = $this->uri->segment(1);
        $this->session->set_userdata($prefix . "searchSort", $_REQUEST['sort']);
        $sort_list = $this->session->userdata($prefix . "sortList");
        if ($sort_list == "asc") {
            $this->session->set_userdata($prefix . "sortList", "desc");
        } else {
            $this->session->set_userdata($prefix . "sortList", "asc");
        }
        echo "ok";
    }

    function update() {
        $username = $this->session->userdata("username");
        $has_privilege = has_privilege($username, $this->uri->segment(1), "_update");
        if ($has_privilege) {
            $this->load->model('privilege_model');
            $result = $this->privilege_model->update($_POST, $_POST['privilege_id']);
            $result = "ok";
        } else {
            $result = "";
        }
        echo $result;
    }

    function get_priv_data() {
        $this->load->model('privilege_model');
        $data = $this->privilege_model->getPrivData($_POST['module_id']);
        echo json_encode($data[0]);
    }

    function save_all() {
        //print_r($_POST);die();
        /*$username = '$this->session->userdata("user")';
        $has_privilege = has_privilege($username, $this->uri->segment(1), "_update");*/
        if (!empty($_POST)) {
            $this->load->model('privilege_model');
            $result = $this->privilege_model->update_all($_POST);
            $result = "ok";
        } else {
            $result = "";
        }
        echo $result;
    }

   function reset_privilege(){
        $this->load->model('privilege_model');
        $data = $this->privilege_model->reset_all($_POST['group_id']);
        echo json_encode($data);
    }

}

?>