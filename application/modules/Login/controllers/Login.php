<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        require_once APPPATH . 'third_party/src/Google_Client.php';
        require_once APPPATH . 'third_party/src/contrib/Google_Oauth2Service.php';
    }

    public function index()
    {
        $this->load->view('login');
    }

    public function google_login()
    {
        $clientId = '833780695313-qega27a76lseg2fd7htq5r6ku7jgstd0.apps.googleusercontent.com'; //Google client ID
        $clientSecret = 'nYpn8-T2AlOKhQC5OxkiueJl'; //Google client secret
        //$redirectURL = base_url() . 'Login/google_login/';
        $redirectURL = 'http://yava-228.solusi247.com/chantel-civ2/Login/google_login';

        //Call Google API
        $gClient = new Google_Client();
        $gClient->setApplicationName('Login');
        $gClient->setClientId($clientId);
        $gClient->setClientSecret($clientSecret);
        $gClient->setRedirectUri($redirectURL);
        $google_oauthV2 = new Google_Oauth2Service($gClient);

        if (isset($_GET['code'])) {
            $gClient->authenticate($_GET['code']);
            $_SESSION['token'] = $gClient->getAccessToken();
            header('Location: ' . filter_var($redirectURL, FILTER_SANITIZE_URL));
        }

        if (isset($_SESSION['token'])) {
            $gClient->setAccessToken($_SESSION['token']);
        }

        if ($gClient->getAccessToken()) {
            $userProfile = $google_oauthV2->userinfo->get();
            echo "<pre>";
            $email = $userProfile['email'];
            $save = json_decode(getlogin('index.php?&act=checkEmail&email=' . $email, '', 'url_chantel'), true);
            $data = $save['data'];
            if (count($data) > 0){
              $name = $data[0]['name'];
              $pass = $data[0]['password'];
              $this->session->set_userdata('user', $name);
              $this->session->set_userdata('pass', $pass);
              redirect('Dashboard');
            } else {
              redirect('Login');
            }

            die;
        } else {
            $url = $gClient->createAuthUrl();
            //echo $url;
            header("Location: $url");
            exit;
        }
    }


    function logmein()
    {
        $user = $_POST["username"];
        $pass = $_POST["password"];

        $save = json_decode(getlogin('index.php?u=' . $user . '&p=' . $pass . '&act=login', '', 'url_chantel'), true);

        if ($save['error_code'] == 0) {
            $this->session->set_userdata('user', $user);
            $this->session->set_userdata('pass', $pass);
            redirect('Dashboard', 'refresh');
        } else {
            $this->session->set_userdata('status_login', $save['err_msg']);
            $this->session->set_flashdata("login", "<div class='alert alert-danger' style='margin:0px;' role='alert'>Username and password doesn't match</div>");
            redirect('Login');
        }

    }

    function logmeout()
    {
        $this->session->sess_destroy();
        redirect('Login');
    }

    private function get_google_client()
    {
        $client = new Google_Client();
        $client->setAuthConfigFile(APPPATH . 'client_secret.json'); //rename file ini supaya lebih aman nanti
        $client->setRedirectUri("http://localhost/chantel-ci/index.php/Login");
        $client->setScopes(array(
            "https://www.googleapis.com/auth/plus.login",
            "https://www.googleapis.com/auth/userinfo.email",
            "https://www.googleapis.com/auth/userinfo.profile",
            "https://www.googleapis.com/auth/plus.me",
        ));

        return $client;
    }

}
