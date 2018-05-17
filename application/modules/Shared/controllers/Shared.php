<?php

class Shared extends MX_Controller
{

    function index()
    {
        $user = $this->session->userdata("user");
        $pass = $this->session->userdata("pass");
        $this->session->unset_userdata('id');

        $this->template->write('title', 'Baciro Gateway', TRUE);
        $data['tree'] = json_decode(getlogin('index.php?u=' . $user . '&p=' . $pass . '&act=share_list', '', 'url_chantel'), true);
        $this->template->write('breadcrumb', 'Shared', TRUE);
        $this->template->write_view('content', 'shared_view', $data, TRUE);
        $this->template->render();

    }

    function openfolder($id)
    {
        $user = $this->session->userdata("user");
        $pass = $this->session->userdata("pass");
        $data['id'] = $id;
        //echo getlogin('index.php?u='.$user.'&p='.$pass.'&act=list_files&pid='.$id, '','url_chantel');die();
        $this->session->set_userdata('id', $id);
        $this->template->write('title', 'Baciro Gateway', TRUE);
//        $data['task'] = json_decode(getlogin('index.php?u=' . $user . '&p=' . $pass . '&act=list_files&pid=' . $id, '', 'url_chantel'), true);
//        $data['folder'] = json_decode(getlogin('index.php?u=' . $user . '&p=' . $pass . '&act=list_directory', '', 'url_chantel'), true);
        $data['tree'] = json_decode(getlogin('index.php?u=' . $user . '&p=' . $pass . '&act=tree_directory&pid=' . $id, '', 'url_chantel'), true);
        $this->template->write('breadcrumb', 'Group', TRUE);
        $this->template->write_view('content', 'open_folder', $data, TRUE);
        $this->template->render();

    }

    function create_parent()
    {
        //echo json_encode($_POST);die();
        $user = $this->session->userdata("user");
        $pass = $this->session->userdata("pass");
        $folder = $_POST["folder_name"];
        $pid = $_POST["pid"];
//        $folder = str_replace(' ', '_', $folder);
        $folder = urlencode($folder);
        //echo json_encode($_POST);die();
        //echo post('user', 'url_user', json_encode($_POST));die();
        if ($pid == '') {
            $save = json_decode(getlogin('index.php?u=' . $user . '&p=' . $pass . '&act=create_directory&pid=1&dname=' . $folder, '', 'url_chantel'), true);
            redirect('Shared');
//           echo json_decode(getlogin('index.php?u='.$user.'&p='.$pass.'&act=create_directory&pid=1&dname="' . $folder.'"', '','url_chantel'), true);
            /*if ($save['id'] != 0){
            redirect('Task');
          }*/
        } else {
            $save = json_decode(getlogin('index.php?u=' . $user . '&p=' . $pass . '&act=create_directory&pid=' . $pid . '&dname=' . $folder, '', 'url_chantel'), true);
            if ($save['id'] != 0) {
                redirect('Shared/openfolder/' . $pid);
            }
        }
    }

    function create_child()
    {
        $user = $this->session->userdata("user");
        $pass = $this->session->userdata("pass");
        $folder = $_POST["folder_name"];
        $pid = $_POST["pid"];
        //echo json_encode($_POST);die();
        //echo post('user', 'url_user', json_encode($_POST));die();
        $save = json_decode(getlogin('index.php?u=' . $user . '&p=' . $pass . '&act=create_directory&pid=' . $pid . '&dname=' . $folder, '', 'url_chantel'), true);
        if ($save['id'] != 0) {
            redirect('Shared');
        }
    }

    function upload()
    {
        $CIobj = &get_instance();
        $user = $this->session->userdata("user");
        $pass = $this->session->userdata("pass");
        $ip = $CIobj->config->item('url_chantel');
        $api = $CIobj->config->item('api_key');

        if (isset($_FILES['filetoupload']['name']) && $_FILES['filetoupload']['name'] != "" && $_FILES['filetoupload']['error'] != "4") {

            $extension = pathinfo(basename($_FILES['filetoupload']['name']), PATHINFO_EXTENSION);
            $unique_name = uniqid() . "." . $extension;
            $target_file = tempnam(sys_get_temp_dir(), 'chanthelapi-') . $unique_name;

            if (file_exists($target_file)) {
                $msg = json_encode(array("error_code" => "1", "message" => "Sorry, file already exists."));
                //echo "hey1__".$msg;
            } else if ($_FILES['filetoupload']['size'] == 0) {
                $msg = json_encode(array("error_code" => "1", "message" => "Sorry, file is empty."));
                //echo "hey2__".$msg;
            } else {
                if (move_uploaded_file($_FILES['filetoupload']['tmp_name'], $target_file)) {
                    //chmod($target_file, 0777);
                    $url_api_upload = $ip . "/" . $api . "/index.php";
                    $user = $user;
                    $password = $pass;
                    $filename = $_FILES['filetoupload']['name'];

                    if ($_POST['pid'] != "") {
                        $pid = $_POST['pid'];
                        $msg = $this->curl_upload($url_api_upload, $user, $password, $target_file, $filename, $pid, "");
                        //echo "hey4__".$msg;
                        redirect('Shared/openfolder/' . $pid);

                    } else {
//                        $msg = json_encode(array("error_code" => "1", "message" => "PID not found"));
                        $msg = $this->curl_upload($url_api_upload, $user, $password, $target_file, $filename, "1", "");
//                        echo "hey5__".$msg;
                        redirect('Shared');
                    }

                    //echo "hey3__".$msg;
                } else {
                    $msg = json_encode(array("error_code" => "1", "message" => "Sorry, there was an error uploading your file." . $target_file));
                    //echo "hey6__".$msg;
                }
            }
//            echo "hey__".$msg;


        } else {
            echo "else";
        }
    }

    function curl_upload($url_api_upload = "", $user = "", $password = "", $target_file = "", $filename = "", $pid = "", $msg_result = "")
    {
//        $filename = urlencode($filename);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url_api_upload);

        curl_setopt($curl, CURLOPT_VERBOSE, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);

        // download image to temp file for upload
        $tmp = tempnam(sys_get_temp_dir(), 'php');
        file_put_contents($tmp, file_get_contents($target_file));
        // send a file
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS,
            array(
                'filedata' => new CURLFile($tmp),
                'u' => $user,
                'p' => $password,
                'act' => 'upload',
                'fname' => $filename, // "dhiar-wf14.txt"
                'pid' => $pid // 212
            ));

        curl_setopt($curl, CURLOPT_TIMEOUT, 240);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        // output the response
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);

        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            $msg = $err;
            //echo "cURL Error #:" . $err;
        } else {
            $msg = $result;
            //echo 'success';
        }

        return $msg;
    }

    function delete($id)
    {
        // echo $id;die();
        $user = $this->session->userdata("user");
        $pass = $this->session->userdata("pass");
        $folderid = $this->session->userdata('id');
        $save = json_decode(getlogin('index.php?u=' . $user . '&p=' . $pass . '&act=delete_permanent&id=' . $id, '', 'url_chantel'), true);
        //print_r(json_decode(getlogin('index.php?u='.$user.'&p='.$pass.'&act=delete_directory&id=240', '','url_chantel'), true));die();
        redirect('Shared/openfolder/' . $folderid);
    }

    function deletefolder($id)
    {
        // echo $id;die();
        $user = $this->session->userdata("user");
        $pass = $this->session->userdata("pass");
        $save = json_decode(getlogin('index.php?u=' . $user . '&p=' . $pass . '&act=delete_permanent&id=' . $id, '', 'url_chantel'), true);
        //print_r(json_decode(getlogin('index.php?u='.$user.'&p='.$pass.'&act=delete_directory&id=240', '','url_chantel'), true));die();
        redirect('Shared');
    }

    function share()
    {
        // echo $id;die();
        $CIobj = &get_instance();
        $user = $this->session->userdata("user");
        $pass = $this->session->userdata("pass");
        $ip = $CIobj->config->item('url_chantel');
        $api = $CIobj->config->item('api_key');

        $id = $_POST['fid'];
        $dataEnd = $_POST['endtime'];

        $save = json_decode(getlogin('/index.php?u=' . $user . '&p=' . $pass . '&act=share_up&fid=' . $id . '&endtime=' . $dataEnd, '', 'url_chantel'), true);
        echo json_encode($save['message']);
//        redirect('Document');
    }

    function renamefile()
    {
        $id = $_POST["pid"];
        // $name = $_POST["filename"];
        $name = urlencode($_POST["filename"]);
        $folder = $_POST["folder"];

//        echo $folder.$id.$name;die();
        $CIobj = &get_instance();
        $user = $this->session->userdata("user");
        $pass = $this->session->userdata("pass");
        $solr = $CIobj->config->item('url_solr');

        if ($folder == "folder") {
            $save = json_decode(getlogin('index.php?u=' . $user . '&p=' . $pass . '&act=rename_directory&id=' . $id . '&newname=' . $name . '&solr=' . $solr . '', '', 'url_chantel'), true);
            $folderid = $this->session->userdata('id');
            //echo $folderid;die();
            if ($folderid != "") {
                if ($save['error_code'] == 0) {
                    $this->session->set_flashdata("document", "<script>  setTimeout( function() {
                    // create the notification
                    var notification = new NotificationFx({
                        message : '<p>Rename succesfull</p>',
                        layout : 'growl',
                        effect : 'slide',
                        type : 'notice', // notice, warning or error
                      });

                      // show the notification
                      notification.show();

                }, 1200 );</script>");
                    redirect('Document/openfolder/' . $folderid);
                }

            } else {
                if ($save['error_code'] == 0) {
                    $this->session->set_flashdata("document", "<script>  setTimeout( function() {
                    // create the notification
                    var notification = new NotificationFx({
                        message : '<p>Rename succesfull</p>',
                        layout : 'growl',
                        effect : 'slide',
                        type : 'notice', // notice, warning or error
                      });

                      // show the notification
                      notification.show();

                }, 1200 );</script>");
                    redirect('Document');
                }

            }
        } else {
            $folderid = $this->session->userdata('id');
            $save = json_decode(getlogin('index.php?u=' . $user . '&p=' . $pass . '&act=rename_file&fid=' . $id . '&newname=' . $name, '', 'url_chantel'), true);
            if ($save['error_code'] == 0) {
                $this->session->set_flashdata("document", "<script>  setTimeout( function() {
                  // create the notification
                  var notification = new NotificationFx({
                      message : '<p>Rename succesfull</p>',
                      layout : 'growl',
                      effect : 'slide',
                      type : 'notice', // notice, warning or error
                    });

                    // show the notification
                    notification.show();

              }, 1200 );</script>");
                redirect('Document/openfolder/' . $folderid);
            }

        }
        //print_r(json_decode(getlogin('index.php?u='.$user.'&p='.$pass.'&act=delete_directory&id=240', '','url_chantel'), true));die();
    }

    function search()
    {
        $name = $_POST["search"];
        //echo $id."_name_".$name;die();
        $user = $this->session->userdata("user");
        $pass = $this->session->userdata("pass");
//        $save = json_decode(getlogin('index.php?u='.$user.'&p='.$pass.'&act=search&sname='.$name, '','url_chantel'), true);
        //print_r($save);die();
        //$this->session->set_userdata('id', $id);
        $this->template->write('title', 'Baciro Gateway', TRUE);
        $data['folder'] = json_decode(getlogin('index.php?u=' . $user . '&p=' . $pass . '&act=list_directory', '', 'url_chantel'), true);
        $data['tree'] = json_decode(getlogin('index.php?u=' . $user . '&p=' . $pass . '&act=search&sname=' . $name, '', 'url_chantel'), true);
//        $data['task'] = json_decode(getlogin('index.php?u='.$user.'&p='.$pass.'&act=search&sname='.$name, '','url_chantel'), true);
        $this->template->write('breadcrumb', 'Group', TRUE);
        $this->template->write_view('content', 'open_folder', $data, TRUE);
        $this->template->render();
        //redirect('Task'); 
    }

    function preview($id)
    {
        $user = $this->session->userdata("user");
        $pass = $this->session->userdata("pass");
        
        $prev = json_decode(getlogin('index.php?u='.$user.'&p='.$pass.'&act=preview_file&fid='.$id, '','url_chantel'), true);

        header("Content-type:application/pdf; charset=UTF-8");
        header("Content-Disposition:inline;filename=".$id);
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        ob_clean();
        flush();
        ob_end_clean();
        readfile($prev['url']);
    }
}

//}
?>
