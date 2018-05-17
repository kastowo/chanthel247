<?php

class Um_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getUserData($userid = 0, $pageoffset = 0, $perPage = 10) {
        $this->db->select("UI_USERS.*,UI_GROUPS.GROUP_NAME")->from("UI_USERS")
                ->join("UI_GROUPS", "UI_USERS.GROUP_ID = UI_GROUPS.GROUP_ID", "left");
		$this->db->where("UI_USERS.IS_DELETED",'N');
        $q = $this->db->get();
        return $q->result_array();
    }

    function getGroupData() {
        $this->db->select("*")->from("UI_GROUPS");
        $q = $this->db->get();
        return $q;
    }


    function insert($data) {
        $username = $this->session->userdata("userid");
        $this->db->select("*")->from('UI_USERS')->where("USERNAME = '" . $data['USERNAME'] . "'");
		$this->db->where("IS_DELETED","N");
        $q = $this->db->get();
        $num = $q->num_rows();
        $salt = generateSalt();
        $data['SALT'] = $salt;
        $data['PASSWORD'] = md5(md5($data['PASSWORD']) . $salt);
        if (empty($num)) {
			$this->db->select("*")->from('UI_USERS')->where("EMAIL = '" . $data['EMAIL'] . "'");
			$q_mail = $this->db->get();
			$num_mail = $q_mail->num_rows();
			
			if(empty($num_mail)){
				//$this->db->trans_start();
				unset($data['USER_ID']);
				$data['LAST_LOGIN'] = date('Y-m-d H:i:s');
				$data['IS_DELETED'] = 'N';
				$data['LAST_ACTIVITY'] = date('Y-m-d H:i:s');
				$data['CREATED_DATE'] = date('Y-m-d H:i:s');
				$data['CREATED_BY'] = $username;
				$this->db->insert('UI_USERS', $data);
				$insert_id = $this->db->insert_id();
				
				//$this->db->trans_complete();
				/*
				write_log('INSERT INTO `UI_USERS` (`USER_ID`, `USERNAME`, `GROUP_ID`, 
					`FULLNAME`, `IS_LOGIN`, `PASSWORD`, `IS_BLOCK`, 
					`DEPARTMENT_NAME`, `USER_TYPE`, `CP_NAME`, `MOBILE`, 
					`EMAIL`, `SKYPE_ID`, `GOOGLE_ID`, `SALT`, `LAST_LOGIN`, `LAST_ACTIVITY`, `CREATED_DATE`,`CREATED_BY` ) 
					VALUES (' . $insert_id . ', ' . $data['USERNAME'] . ', ' . $data['GROUP_ID'] . ', ' . $data['FULLNAME'] . ', ' . $data['IS_LOGIN'] . ', ' . $data['PASSWORD'] . ', 
					' . $data['IS_BLOCK'] . ', ' . $data['DEPARTMENT_NAME'] . ', ' . $data['MOBILE'] . ', 
					' . $data['EMAIL'] . ', ' . $data['SKYPE_ID'] . ', ' . $data['GOOGLE_ID'] . ', ' . $data['SALT'] . ', 
					' . $data['LAST_LOGIN'] . ', ' . $data['LAST_ACTIVITY'] . ',' . $data['CREATED_DATE'] . ',' . $data['CREATED_BY'] . ')');
					*/
				$result = "ok";
			}
			else{
				$result = "mail_exists";
			}
        } else {
            $result = "exists";
        }
        return $result;
    }

    function update($data, $id) {
        $username = $this->session->userdata("userid");
        if (!empty($id)) {
            $cur_username = get_name("UI_USERS", "USERNAME", "USER_ID", $id);
            $cur_email = get_name("UI_USERS", "EMAIL", "USER_ID", $id);
            $cur_password = get_name("UI_USERS", "PASSWORD", "USER_ID", $id);
            $salt = get_name("UI_USERS", "SALT", "USER_ID", $id);
            $num = 0;
            if ($data['USERNAME'] != $cur_username) {
                $this->db->select("*")->from('UI_USERS')->where("USERNAME = '" . $data['USERNAME'] . "' AND USERNAME NOT IN('" . $cur_username . "')");
                $this->db->where("IS_DELETED","N");
				$q = $this->db->get();
                $num = $q->num_rows();
            }
            if (empty($num)) {
                $num_mail = 0;
                if ($data['EMAIL'] != $cur_email) {
                    $this->db->select("*")->from('UI_USERS')->where("EMAIL = '" . $data['EMAIL'] . "' AND EMAIL NOT IN('" . $cur_email . "')");
                    $this->db->where("IS_DELETED","N");
					$q = $this->db->get();
                    $num_mail = $q->num_rows();
                }
				
				if(empty($num_mail)){
					if ($cur_password != $data['PASSWORD']) {
						if (!empty($salt)) {
							$data['PASSWORD'] = md5(md5($data['PASSWORD']) . $salt);
						} else {
							$salt = generateSalt();
							$data['PASSWORD'] = md5(md5($data['PASSWORD']) . $salt);
							$data['SALT'] = $salt;
						}
					}
					$data['UPDATED_DATE'] = date('Y-m-d H:i:s');
					$data['UPDATED_BY'] = $username;
					$this->db->where("USER_ID", $id);
					$this->db->update('UI_USERS', $data);
					$err_msg = $this->db->error();
					if (!empty($err_msg["message"])) {
						 $result = "Username <strong>".$cur_username."</strong> is used in some transaction and cannot be updated or deleted";
					} else {
						 $result = "ok";
					} 
					write_log('UPDATE UI_USERS');
				}
				else{
					$result = "mail_exists";
				}
            } else {
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
                $user_name = get_name("UI_USERS", "USERNAME", "USER_ID", $id);
                $this->db->where('USER_ID', $id);
				$data["IS_BLOCK"] = "Y";
				$data["IS_DELETED"] = "Y";
                $this->db->update("UI_USERS",$data);

                $err_msg = $this->db->error();
               

                if ($err_msg["message"]) {
                    $result = "failed";
                } else {
                    $result = "ok";
                }

                write_log('DELETE FROM `UI_USERS` WHERE `USER_ID` = ' . $id . '');
            }
        }
        return $result;
    }

}

?>