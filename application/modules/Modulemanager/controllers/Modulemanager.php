<?php

class Modulemanager extends MX_Controller {

    function index() {

        $username = $this->session->userdata("user");
        $pass = $this->session->userdata("pass");
        $this->session->unset_userdata('id');
        $this->load->model('mm_model');
        $this->template->write('title', 'Baciro Gateway', TRUE);
        $data["table_data"] = $this->mm_model->getVpData(0, 0, 0);
        $this->template->write('breadcrumb', 'Task', TRUE);
        $this->template->write_view('content', 'mm_view', $data, TRUE);
        $this->template->render();
    }

    function add() {
        $edit_id = $this->uri->segment(3);
        $data = array();
        $this->load->model('mm_model');

        if (!empty($edit_id)) {
            $this->db->select("*")->from("UI_MODULES")->where("MODULE_ID", $edit_id, false);
            $q = $this->db->get();
            $d = $q->result_array();
            $data['d'] = $d[0];
            $data['type'] = "Edit";
			      $priv = "_update";
        } else {
            $data['type'] = "Add";
            $data['d']['MODULE_PARENT'] = "";
            $data['d']['MODULE_TYPE'] = "";
            $data['d']['MODULE_CONTENT'] = "";
			      $priv = "_insert";
        }

            $username = $this->session->userdata("user");
            $pass = $this->session->userdata("pass");
            $this->session->unset_userdata('id');
            $this->load->model('mm_model');
            $this->template->write('title', 'Baciro Gateway', TRUE);
            $data["module_list"] = $this->mm_model->getParentList();
            $this->template->write('breadcrumb', 'Task', TRUE);
            $this->template->write_view('content', 'mm_add', $data, TRUE);
            $this->template->render();
    }

    function setSearch() {
            $prefix = $this->uri->segment(1);
            $this->session->set_userdata($prefix . 'Search', $_REQUEST['search']);
            echo "ok";
    }

    function getVp() {
          $this->load->model('mm_model');
          $data = $this->mm_model->getVpData($_REQUEST['module_var']);
          echo json_encode($data[0]);
    }

    function insert() {
            $this->load->model('mm_model');
            $result = $this->mm_model->insert($_POST);
            if ($result == "exists") {
                $data['error'] = true;
                $data['field'][0]["name"] = "MODULE_VAR";
                $data['field'][0]["message"] = "Module folder <strong>" . $_POST['MODULE_VAR'] . "</strong> already exists";
            } else {
                $data['error'] = false;
                $msg = "Data <strong>" . $_POST['MODULE_NAME'] . "</strong> succesfully inserted";
                $this->session->set_userdata("act_msg", $msg);
            }
        redirect('Modulemanager');
    }

    function update() {
            $this->load->model('mm_model');
            $result = $this->mm_model->update($_POST, $_POST['MODULE_ID']);
            if ($result == "exists") {
                $data['error'] = true;
                $data['field'][0]["name"] = "MODULE_VAR";
                $data['field'][0]["message"] = "Module folder <strong>" . $_POST['MODULE_VAR'] . "</strong> already exists";
            } else {
                $data['error'] = false;
                $msg = "Data <strong>" . $_POST['MODULE_NAME'] . "</strong> succesfully updated";
                $this->session->set_userdata("act_msg", $msg);
            }
        redirect('Modulemanager');
    }

    function delete() {
			     $param_id = $this->uri->segment(3);
			      $module_name = get_name("UI_MODULES", "MODULE_NAME", "MODULE_ID", $param_id);
            $this->load->model('mm_model');
            $result = $this->mm_model->delete($param_id);

            $msg = "Data <strong>#" . $module_name . "</strong> succesfully deleted";
            $this->session->set_userdata("act_msg", $msg);
            $this->index();
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

}

?>
