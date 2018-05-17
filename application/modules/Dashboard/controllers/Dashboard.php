<?php
// created by : dhiar

class Dashboard extends MX_Controller {

  function index()
  {
    $this->template->write('title', 'Baciro Gateway', TRUE);
    $data['tes'] = json_encode(getMenuList(''), true);
    $this->template->write('breadcrumb', 'Dashboard', TRUE);
    $this->template->write_view('content', 'dashboard_view', $data, TRUE);
    $this->template->render();
  }

  function data_1()
  {
    $CIobj = & get_instance();
    $url_chantel = $CIobj->config->item('url_chantel');
    $api_key = $CIobj->config->item('api_key');
    $url_api_key = $url_chantel."/".$api_key;

    $user = $_SESSION['user'];
    $pass = $_SESSION['pass'];

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => $url_api_key."/index.php?u=".$user."&p=".$pass."&act=grafik1",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "postman-token: ae4e3370-9c81-b57f-3736-59d3e3de923e"
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      echo "cURL Error #:" . $err;
      //    return "{}";
    } else {
      echo $response;
    }
  }

  function data_2()
  {
    $CIobj = & get_instance();
    $url_chantel = $CIobj->config->item('url_chantel');
    $api_key = $CIobj->config->item('api_key');
    $url_api_key = $url_chantel."/".$api_key;

    $user = $_SESSION['user'];
    $pass = $_SESSION['pass'];
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => $url_api_key."/index.php?u=".$user."&p=".$pass."&act=grafik2",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "postman-token: ae4e3370-9c81-b57f-3736-59d3e3de923e"
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      echo "cURL Error #:" . $err;
      //    return "{}";
    } else {
      echo $response;
    }
  }

  function data_3()
  {
    $CIobj = & get_instance();
    $url_chantel = $CIobj->config->item('url_chantel');
    $api_key = $CIobj->config->item('api_key');
    $url_api_key = $url_chantel."/".$api_key;

    $user = $_SESSION['user'];
    $pass = $_SESSION['pass'];
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => $url_api_key."/index.php?u=".$user."&p=".$pass."&act=grafik3",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "postman-token: ae4e3370-9c81-b57f-3736-59d3e3de923e"
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      echo "cURL Error #:" . $err;
      //    return "{}";
    } else {
      echo $response;
    }
  }

  function data_4()
  {
    $user = $_SESSION['user'];
    $pass = $_SESSION['pass'];
    $curl = curl_init();

    $CIobj = & get_instance();
    $url_chantel = $CIobj->config->item('url_chantel');
    $api_key = $CIobj->config->item('api_key');
    $url_api_key = $url_chantel."/".$api_key;

    curl_setopt_array($curl, array(
      CURLOPT_URL => $url_api_key."/index.php?u=".$user."&p=".$pass."&act=grafik4",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "postman-token: ae4e3370-9c81-b57f-3736-59d3e3de923e"
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      echo "cURL Error #:" . $err;
      //    return "{}";
    } else {
      echo $response;
    }
  }

  function data_5()
  {
    $user = $_SESSION['user'];
    $pass = $_SESSION['pass'];
    $curl = curl_init();

    $CIobj = & get_instance();
    $url_chantel = $CIobj->config->item('url_chantel');
    $api_key = $CIobj->config->item('api_key');
    $url_api_key = $url_chantel."/".$api_key;

    curl_setopt_array($curl, array(
      CURLOPT_URL => $url_api_key."/index.php?u=".$user."&p=".$pass."&act=grafik5",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "postman-token: ae4e3370-9c81-b57f-3736-59d3e3de923e"
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
}
?>
