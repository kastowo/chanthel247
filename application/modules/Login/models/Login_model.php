<?php

class Login_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function loginData($username, $password) {
        $password = md5($password);
        $this->db->select("*")
                ->from("UI_USERS")
                ->where("UI_USERS.IS_DELETED = 'N' and UI_USERS.USERNAME = '" . addslashes($username) . "' and UI_USERS.PASSWORD = '" . addslashes($password) . "'");
        $q = $this->db->get();

        $data = $q->result();

        if (!empty($data)) {
            $session_arr = array("userid" => $data[0]->USER_ID,
                "username" => $data[0]->USERNAME,
                
                "usertype" => $data[0]->USER_TYPE,
               
                "email" => $data[0]->EMAIL,
            );

            $this->session->set_userdata($session_arr);
        }
        return $data;
    }

}

?>
