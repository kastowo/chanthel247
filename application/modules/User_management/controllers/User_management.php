<?php
class User_management extends MX_Controller {
	/*function __construct()
	{
	    parent::__construct();
	    $this->load->library('template');     
	}
*/
	function index(){
        $user = $this->session->userdata("user");
        $pass = $this->session->userdata("pass");
        $this->template->write('title', 'Baciro Gateway', TRUE);
        //$this->template->add_css('assets/css/page.css');
        $data['list_user'] = json_decode(getlogin('index.php?u=' . $user . '&p=' . $pass . '&act=get_all_user','', 'url_chantel'), true);
        $this->template->write('breadcrumb', 'User Management', TRUE);
        $this->template->write_view('content', 'user_management_view', $data, TRUE);
        $this->template->render();
        
    }

	function add() {
		
        $edit_id = $this->uri->segment(3);
        $data = array();
        $this->load->model('um_model');

        // $lang = $this->session->userdata("lang") ? $this->session->userdata("lang") : getPref('_DEFAULT_LANG');
        // $this->lang->load('system', $lang);

        if (!empty($edit_id)) {
			$priv = "_update";
            $this->db->select("*")->from("UI_USERS")->where("USER_ID", $edit_id, false);
            $q = $this->db->get();
            $d = $q->result_array();
            $data['d'] = $d[0];
            $data['type'] = "Edit";
        } else {
			$priv = "_insert";
            $data['type'] = "Add";
        }

            $username = $this->session->userdata("user");
            $pass = $this->session->userdata("pass");
            $this->session->unset_userdata('id');
            $this->load->model('um_model');
            $this->template->write('title', 'Baciro Gateway', TRUE);
            $data["group_list"] = $this->um_model->getGroupData();
            $this->template->write('breadcrumb', 'Task', TRUE);
            $this->template->write_view('content', 'um_add', $data, TRUE);
            $this->template->render();
    }

    function insert() {
    	//echo json_encode($_POST);die();
    	$user = $this->session->userdata("user");
        $pass = $this->session->userdata("pass");
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];

        $save = json_decode(getlogin('index.php?u=' . $user . '&p=' . $pass . '&act=create_user&u_param=' . $username . '&email=' . $email . '&p_param=' . $password, '', 'url_chantel'), true);
       	print_r($save);
        if ($save['error_code'] == 0) {
            redirect('User_management');
        }

    }
	
}
?>
