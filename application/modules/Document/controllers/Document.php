<?php

class Document extends MX_Controller
{

    function index()
    {
        $user = $this->session->userdata("user");
        $pass = $this->session->userdata("pass");
        $this->session->unset_userdata('id');
        $this->template->write('title', 'Baciro Gateway', TRUE);
        $data['task'] = json_decode(getlogin('index.php?u=' . $user . '&p=' . $pass . '&act=list_directory', '', 'url_chantel'), true);
	      $data['tree'] = json_decode(getlogin('index.php?u=' . $user . '&p=' . $pass . '&act=tree_directory&pid=' . 1, '', 'url_chantel'), true);
        $this->template->write('breadcrumb', 'Document', TRUE);
        $this->template->write_view('content', 'task_view', $data, TRUE);
        $this->template->render();
    }

    function openfolder($id)
    {
        $user = $this->session->userdata("user");
        $pass = $this->session->userdata("pass");
        $data['id'] = $id;
        $this->session->set_userdata('id', $id);
        $this->template->write('title', 'Baciro Gateway', TRUE);
        $data['tree'] = json_decode(getlogin('index.php?u='.$user.'&p='.$pass.'&act=tree_directory&pid='.$id, '','url_chantel'), true);
        $this->template->write('breadcrumb', 'Group', TRUE);
        $this->template->write_view('content', 'open_folder', $data, TRUE);
        $this->template->render();

    }

    function create_parent() {
        $user = $this->session->userdata("user");
        $pass = $this->session->userdata("pass");
        $folder = $_POST["folder_name"];
        $pid = $_POST["pid"];
        $folder = urlencode($folder);
        if ($pid == '') {
            $save = json_decode(getlogin('index.php?u=' . $user . '&p=' . $pass . '&act=create_directory&pid=1&dname=' . $folder, '', 'url_chantel'), true);
            if ($save['error_code'] == 0) {
                $this->session->set_flashdata("document", "<script>  setTimeout( function() {
                  // create the notification
                  var notification = new NotificationFx({
                      message : '<p>Folder has been created</p>',
                      layout : 'growl',
                      effect : 'slide',
                      type : 'notice', // notice, warning or error
                    });

                    // show the notification
                    notification.show();

              }, 1200 );</script>");
              redirect('Document');
          }
          else {
              $this->session->set_flashdata("document", "<script>  setTimeout( function() {
                // create the notification
                var notification = new NotificationFx({
                    message : '<p>Failed</p>',
                    layout : 'growl',
                    effect : 'slide',
                    type : 'error', // notice, warning or error
                  });

                  // show the notification
                  notification.show();

            }, 1200 );</script>");
            redirect('Document');
          }

        } else {
            $save = json_decode(getlogin('index.php?u=' . $user . '&p=' . $pass . '&act=create_directory&pid=' . $pid . '&dname=' . $folder, '', 'url_chantel'), true);
            if ($save['error_code'] == 0) {
              $this->session->set_flashdata("document", "<script>  setTimeout( function() {
                  // create the notification
                  var notification = new NotificationFx({
                      message : '<p>Folder has been created</p>',
                      layout : 'growl',
                      effect : 'slide',
                      type : 'notice', // notice, warning or error
                    });

                    // show the notification
                    notification.show();

              }, 1200 );</script>");
                redirect('Document/openfolder/' . $pid);
            }

            else {
              $this->session->set_flashdata("document", "<script>  setTimeout( function() {
                  // create the notification
                  var notification = new NotificationFx({
                      message : '<p>Failed. Duplicated folder name</p>',
                      layout : 'growl',
                      effect : 'slide',
                      type : 'error', // notice, warning or error
                    });

                    // show the notification
                    notification.show();

              }, 1200 );</script>");
                redirect('Document/openfolder/' . $pid);
            }
        }
    }

    function create_child()
    {
        $user = $this->session->userdata("user");
        $pass = $this->session->userdata("pass");
        $folder = $_POST["folder_name"];
        $pid = $_POST["pid"];
        $save = json_decode(getlogin('index.php?u=' . $user . '&p=' . $pass . '&act=create_directory&pid=' . $pid . '&dname=' . $folder, '', 'url_chantel'), true);
        if ($save['id'] != 0) {
            redirect('Document');
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
            } else if ($_FILES['filetoupload']['size'] == 0) {
                $msg = json_encode(array("error_code" => "1", "message" => "Sorry, file is empty."));
            } else {
                if (move_uploaded_file($_FILES['filetoupload']['tmp_name'], $target_file)) {
                    $url_api_upload = $ip . "/" . $api . "/index.php";
                    $user = $user;
                    $password = $pass;
                    $filename = $_FILES['filetoupload']['name'];

                    if ($_POST['pid'] != "") {
                        $pid = $_POST['pid'];
                        $msg = $this->curl_upload($url_api_upload, $user, $password, $target_file, $filename, $pid, "");
			                  if ($save['error_code'] == 0) {
                          $this->session->set_flashdata("document", "<script>  setTimeout( function() {
                              // create the notification
                              var notification = new NotificationFx({
                                  message : '<p>Upload succesfull</p>',
                                  layout : 'growl',
                                  effect : 'slide',
                                  type : 'notice', // notice, warning or error
                                });

                                // show the notification
                                notification.show();

                          }, 1200 );</script>");
                            redirect('Document/openfolder/' . $pid);
                        }

                    } else {
                        $msg = $this->curl_upload($url_api_upload, $user, $password, $target_file, $filename, "1", "");
			                     if ($save['error_code'] == 0) {
                          $this->session->set_flashdata("document", "<script>  setTimeout( function() {
                              // create the notification
                              var notification = new NotificationFx({
                                  message : '<p>Upload succesfull</p>',
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
                    $msg = json_encode(array("error_code" => "1", "message" => "Sorry, there was an error uploading your file." . $target_file));
                }
            }
            echo "hey__".$msg;


        } else {
            echo "else";
        }
    }

    function curl_upload($url_api_upload = "", $user = "", $password = "", $target_file = "", $filename = "", $pid = "", $msg_result = "")
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url_api_upload);

        curl_setopt($curl, CURLOPT_VERBOSE, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);

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
                'fname' => $filename,
                'pid' => $pid
            ));

        curl_setopt($curl, CURLOPT_TIMEOUT, 1000);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 180);
        // output the response
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);

	echo $result;

        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            $msg = $err;
        } else {
            $msg = $result;
        }
        return $msg;
    }

    function delete()
    {
        $user = $this->session->userdata("user");
        $pass = $this->session->userdata("pass");
        $folderid = $this->session->userdata('id');
 	      $id = $_POST['id'];
        $save = json_decode(getlogin('index.php?u=' . $user . '&p=' . $pass . '&act=delete_permanent&id=' . $id, '', 'url_chantel'), true);
        if ($save['error_code'] == 0) {
          $this->session->set_flashdata("document", "<script>  setTimeout( function() {
              // create the notification
              var notification = new NotificationFx({
                  message : '<p>File has been deleted</p>',
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

    function deletefolder()
    {
        $user = $this->session->userdata("user");
        $pass = $this->session->userdata("pass");
 	      $id = $_POST['id'];
        $save = json_decode(getlogin('index.php?u=' . $user . '&p=' . $pass . '&act=delete_permanent&id=' . $id, '', 'url_chantel'), true);
        if ($save['error_code'] == 0) {
          $this->session->set_flashdata("document", "<script>  setTimeout( function() {
              // create the notification
              var notification = new NotificationFx({
                  message : '<p>Delete succesfull</p>',
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

    function renamefile()
    {
        $id = $_POST["pid"];
        $name = urlencode($_POST["filename"]);
        $folder = $_POST["folder"];

        $CIobj = & get_instance();
        $user = $this->session->userdata("user");
        $pass = $this->session->userdata("pass");
        $solr = $CIobj->config->item('url_solr');

        if ($folder == "folder") {
            $save = json_decode(getlogin('index.php?u=' . $user . '&p=' . $pass . '&act=rename_directory&id=' . $id . '&newname=' . $name . '&solr='. $solr .'', '', 'url_chantel'), true);
             $folderid = $this->session->userdata('id');
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
    }

    function search(){
        $name = $_POST["search"];
        $user = $this->session->userdata("user");
        $pass = $this->session->userdata("pass");
        $save = json_decode(getlogin('index.php?u='.$user.'&p='.$pass.'&act=search&sname='.$name, '','url_chantel'), true);
        $this->template->write('title', 'Baciro Gateway', TRUE);
        $data['folder'] = json_decode(getlogin('index.php?u=' . $user . '&p=' . $pass . '&act=list_directory', '', 'url_chantel'), true);
        $data['tree'] = json_decode(getlogin('index.php?u='.$user.'&p='.$pass.'&act=search&sname='.$name, '','url_chantel'), true);
        $data['task'] = json_decode(getlogin('index.php?u='.$user.'&p='.$pass.'&act=search&sname='.$name, '','url_chantel'), true);
        $this->template->write('breadcrumb', 'Group', TRUE);
        $this->template->write_view('content', 'open_folder', $data, TRUE);
        $this->template->render();
    }

    function getpreview($id) {
        $user = $this->session->userdata("user");
        $pass = $this->session->userdata("pass");
        $prev = json_decode(getlogin('index.php?u='.$user.'&p='.$pass.'&act=preview_file&fid='.$id, '','url_chantel'), true);
        echo json_encode($prev);

    }

    function getpreview1($id) {
        $user = $this->session->userdata("user");
        $pass = $this->session->userdata("pass");

        $prev = json_decode(getlogin('index.php?u='.$user.'&p='.$pass.'&act=preview_file&fid='.$id, '','url_chantel'), true);
        header("Content-type:application/pdf; charset=UTF-8");
        header("Content-Disposition:inline;filename='157.pdf'");
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        ob_clean();
        flush();
        ob_end_clean();
        readfile($prev['url']);

    }

    function getpreviewi() {
        $id = $_POST['id'];
        $user = $this->session->userdata("user");
        $pass = $this->session->userdata("pass");

        $prev = json_decode(getlogin('index.php?u='.$user.'&p='.$pass.'&act=preview_file&fid='.$id, '','url_chantel'), true);
        echo json_encode($prev['url'], JSON_UNESCAPED_SLASHES);

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
  function share()
    {
        $CIobj = &get_instance();
        $user = $this->session->userdata("user");
        $pass = $this->session->userdata("pass");
        $ip = $CIobj->config->item('url_chantel');
        $api = $CIobj->config->item('api_key');

        $id = $_POST['fid'];
        $dataEnd = $_POST['endtime'];

        $save = json_decode(getlogin('/index.php?u=' . $user . '&p=' . $pass . '&act=share_up&fid=' . $id . '&endtime=' . $dataEnd, '', 'url_chantel'), true);
        echo json_encode($save['message']);
    }
}
?>
