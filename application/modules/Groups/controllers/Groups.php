<?php

class Groups extends MX_Controller {

    protected $dir_list;

    function index() {
          $username = $this->session->userdata("user");
          $pass = $this->session->userdata("pass");
          $this->session->unset_userdata('id');
          $this->load->model('groups_model');
          $this->template->write('title', 'Baciro Gateway', TRUE);
          $data["table_data"] = $this->groups_model->getUserData(0, 0, 0);
          $this->template->write('breadcrumb', 'Task', TRUE);
          $this->template->write_view('content', 'groups_view', $data, TRUE);
          $this->template->render();

    }

    function setSearch() {
        $this->session->set_userdata('groupSearchUser', $_POST['user']);
        echo "ok";
    }

    function get_user_data() {
        $this->load->model('groups_model');
        $data = $this->groups_model->getUserData($_POST['group_id']);
        echo json_encode($data[0]);
    }

    function add() {
        $edit_id = $this->uri->segment(3);
        $data = array();

        $lang = $this->session->userdata("lang") ? $this->session->userdata("lang") : getPref('_DEFAULT_LANG');
        $this->lang->load('system', $lang);

        if (!empty($edit_id)) {
            $this->db->select("*")->from("UI_GROUPS")->where("GROUP_ID", $edit_id, false);
            $q = $this->db->get();
            $d = $q->result_array();
            $data['group_name'] = $d[0]['GROUP_NAME'];
            $data['group_id'] = $d[0]['GROUP_ID'];
            $data['type'] = "Edit";
        } else {
            $sterritory_id = 0;
            $data['type'] = "Add";
        }
        $this->load->view("groups_add", $data);

    }

    function getList() {
        $_POST = array_map('clear_html', $_POST);
        $list = getGeoList($_POST['parent'], $_POST['parent_field'], $_POST['field_id'], $_POST['field_name'], $_POST['selected_id'], $_POST['all']);
        echo $list;
    }

    function insert() {
        $username = $this->session->userdata("user");
            $this->load->model('groups_model');
            if (empty($_POST['GROUP_ID'])) {
                $result = $this->groups_model->insert($_POST);
                $msg = "Data <strong>" . $_POST['GROUP_NAME'] . "</strong> succesfully inserted";
            } else {
                $result = $this->groups_model->update($_POST);
                $msg = "Data <strong>#" . $_POST['GROUP_ID'] . "</strong> succesfully updated";
            }
            if ($result == "exists") {
                $data['error'] = true;
                $data['field'][0]["name"] = "GROUP_NAME";
                $data['field'][0]["message"] = "Group name already exists";
            } else {
                $this->session->set_userdata("act_msg", $msg);
                $data['error'] = false;
            }
            redirect('Groups');
    }

    function delete() {
            $username = $this->session->userdata("user");
            $id = $this->uri->segment(3);
            $groupname = get_name("UI_GROUPS", "GROUP_NAME", "GROUP_ID", $id);
			      $this->load->model('groups_model');
            $result = $this->groups_model->delete($id);

            if ($result == "ok") {
                $this->session->set_userdata("act_msg", "Data <strong>#" . $groupname . "</strong> sucessfully deleted");
                $data['error'] = false;
            } else {
                $data['error'] = true;
                $this->session->set_userdata("del_msg", "Can't deleted! Data <strong>#" . $groupname . "</strong> is used by user!");
            } 
        $this->index();
    }

    function setSort() {
        $prefix = $this->uri->segment(1);
        $this->session->set_userdata($prefix . "searchSort", $_POST['sort']);
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
