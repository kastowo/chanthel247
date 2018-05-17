    
<?php

class Workflow extends MX_Controller {
  
  function __construct(){ //stroke $fullpath = $_SERVER['DOCUMENT_ROOT']
  parent::__construct();
  $this->load->database();
  $this->load->library('session');
  }
  function index(){
  					 $this->db->select('workflow_id');
  					 $this->db->select('workflow_name');
  					 $this->db->select('workflow_created_date');
  					 $this->db->select('workflow_template');
  		$get_temps = $this->db->get('workflow_templates');
  		if($get_temps){
  			$check_point=$get_temps->num_rows();
  			if($check_point<=0){
  				$data['jml_data'] = 0;
  			}else{
  				$i=0;
  				foreach ($get_temps->result() as $value) { $i++;
  					$data['wf_id'][$i] = $value->workflow_id;
  					$data['wf_name'][$i] = $value->workflow_name;
  					$data['wf_created_dt'][$i] = date('d-F-Y', strtotime($value->workflow_created_date));
  					//$data['workflow_id'][$i] = $value->workflow_template;
  				}	$data['jml_data'] = $i;
  			}

  		}

  		$this->template->write_view('content', 'index_workflow', $data, TRUE);
	    $this->template->render();
  		
  	}
  	//New mode with GoJs
  	function create_workflow(){
  		$this->template->write_view('content', 'go_createwf', TRUE);
	    $this->template->render();
  	}

  	

  	function save_new_wf(){

  		$wf_name = $this->input->post('wf_name');
  		$wf_temp = $this->input->post('wf_temp');
  		$creator = 1;
  		$created_date = date('Y-m-d H:i:s');

  		$insert_new_wf = $this->db->query("INSERT INTO workflow_templates (workflow_name, workflow_created_date, workflow_creator, workflow_template) values('$wf_name','$created_date','$creator','$wf_temp')");
  		if($insert_new_wf){
  			$data['confirm'] = $this->db->insert_id($insert_new_wf);
  		}else {
  			$data['confirm'] = 0;
  		}
  		echo json_encode($data);

  	}

  	function save_change_wf(){
  		$wf_id = $this->input->post('id');
  		$wf_name = $this->input->post('wf_name');
  		$wf_temp = $this->input->post('wf_temp');

  		$update_new_wf = $this->db->query("UPDATE workflow_templates SET workflow_name='$wf_name', workflow_template='$wf_temp' WHERE workflow_id=$wf_id ");

  		if($update_new_wf){
  			$data['confirm'] = $wf_id; //this->db->insert_id($insert_new_wf);
  		}else {
  			$data['confirm'] = 0;
  		}
  		echo json_encode($data);
  	}


  	function open_go_wf($id){
  		$select_wf = $this->db->query("SELECT workflow_name,workflow_created_date,workflow_template 
  										FROM workflow_templates WHERE workflow_id=$id")->result();
  		foreach($select_wf as $val){
  			$data['wf_id']= $id;
  			$data['wf_name']= $val->workflow_name;
  			$data['wf_created_date']= date('d-F-Y', strtotime($val->workflow_created_date));
  			$data['wf_templ']= $val->workflow_template;
  		}

  		$this->template->write_view('content', 'open_workflow', $data, TRUE);
	    $this->template->render();
  	}

    function open_edit_wf($id){
      $select_wf = $this->db->query("SELECT workflow_name,workflow_created_date,workflow_template 
                      FROM workflow_templates WHERE workflow_id=$id")->result();
      foreach($select_wf as $val){
        $data['wf_id']= $id;
        $data['wf_name']= $val->workflow_name;
        $data['wf_created_date']= date('d-F-Y', strtotime($val->workflow_created_date));
        $data['wf_templ']= $val->workflow_template;
      }

      $this->template->write_view('content', 'edit_workflow', $data, TRUE);
      $this->template->render();
    }

  	function delete_wf(){
  		$wf_id = $this->input->post('id');
			$action_delete = $this->db->query("DELETE FROM workflow_templates WHERE workflow_id='$wf_id' ");
			if($action_delete){
				$data['feedback'] = 1; // 1 for feedback indication if delete successfuly
			}else {
				$data['feedback'] = 2; // 2 for feedback indication if delete failure 
			}

		echo json_encode($data);
  	}

  	function open_used_wf(){
  		$id=10;
  		$select_wf = $this->db->query("SELECT workflow_name,workflow_created_date,workflow_template 
  										FROM workflow_templates WHERE workflow_id=$id")->result();
  		foreach($select_wf as $val){
  			$data['wf_id']= $id;
  			$data['wf_name']= $val->workflow_name;
  			$data['wf_created_date']= date('d-F-Y', strtotime($val->workflow_created_date));
  			$data['wf_templ']= $val->workflow_template;
  		}

  		$this->template->write_view('content', 'open_usd_workflowtm', $data, TRUE);
	    $this->template->render();
  	}
 
  	function set_file_list(){
  		$files_path = $this->input->post('dir_url');//'/chantel-civ2/assets/file/';
  		//$basepath = $_SERVER['DOCUMENT_ROOT'] ; $basepath.'/'.
  		$i=0; 
  		$data['file'] ='';
  		if ($handle = opendir($files_path)) {
			    while (false !== ($entry = readdir($handle))) { 
 			        if ($entry != "." && $entry != ".." ) { $i++;
			            $data['file'].='<p><input type="checkbox" name="files['.$i.']" class="files" value="'.$entry.'" ><label for="files"> &nbsp;'.$entry.'</label></p>';
			        }
			    }
			    closedir($handle);
			}
		if($i<=0){
			$data['file'] ='<p>No File Exists</p>';
		}
		echo json_encode($data);
  	}

  	function set_file_node(){
  		$key = $this->input->post('it_key');//'/chantel-civ2/assets/file/';

  		/*
  		if($key=='Actor2'){
  			$files_path = 'chantel-civ2/workflow_dir/fathul/';
  		}
  		else if($key=='Actor3'){
  			$files_path = 'chantel-civ2/workflow_dir/galang/';
  		}
  		else if($key=='Actor4'){
  			$files_path = 'chantel-civ2/workflow_dir/danang/';
  		}
  		else */

  		if($key=='Actor5'){
  			$files_path = 'chanthel/workflow_dir/hire/';
  		}
  		else if($key=='Actor6'){
  			$files_path = 'chanthel/workflow_dir/notinerested/';
  		}
  		else if($key=='Document5'){
  			$files_path = 'chanthel/workflow_dir/arsip/';
  		}
  		else if($key=='Storage'){
  			$files_path = 'chanthel/workflow_dir/marketing/';
  		}
  		else if($key=='Storage2'){
  			$files_path = 'chanthel/workflow_dir/accounting/';
  		}
  		else if($key=='Storage3'){
  			$files_path = 'chanthel/workflow_dir/it/';
  		}
  		else if($key=='Delete'){
  			$files_path = 'chanthel/workflow_dir/trash/';
  		}


  		$basepath = $_SERVER['DOCUMENT_ROOT'] ;
  		$i=0; 
  		$data['file'] ='';
  		if ($handle = opendir($basepath.'/'.$files_path)) {
			    while (false !== ($entry = readdir($handle))) { 
 			        if ($entry != "." && $entry != ".." ) { $i++;
 			        	$data['file'].='<p>';
	 			          if($key!=='Delete' && $key!='Storage' && $key!='Storage2' && $key!='Storage3') {  
	 			          		$data['file'].='<input type="checkbox" name="files['.$i.']" class="files" value="'.$entry.'" >'; 
	 			          	}
			           $data['file'].='<label for="files"> &nbsp;'.$entry.'</label></p>';
			        }
			    }
			    closedir($handle);
			}
		if($i<=0){
			$data['file'] ='<p>No File Exists</p>';
		}
		echo json_encode($data);
  	}



  	function set_file_node2(){
   		$files_path = $this->input->post('dir_url');//'/chantel-civ2/assets/file/';
  		//$basepath = $_SERVER['DOCUMENT_ROOT'] ; $basepath.'/'.
  		$it_key = $this->input->post('it_key');
      		//chmod($files_path, 0777);
		/*
  		if($it_key=='Actor2'){
  			$validate_1='Marketing';
  			$validate_2='marketing';
  			$validate_3='MARKETING';
  		}else if($it_key=='Actor3'){
  			$validate_1='Accounting';
  			$validate_2='accounting';
  			$validate_3='ACCOUNTING';
  		}else if($it_key=='Actor4'){
  			$validate_1='It';
  			$validate_2='it';
  			$validate_3='IT';
  		}
		*/
  		$i=0; 
  		$data['file'] ='';
		//print_r(opendir($files_path)); exit;
  		if ($handle = opendir($files_path)) {
			 
			    while (false !== ($entry = readdir($handle))) { 
				//print_r(opendir(readdir($handle))); exit;
 			        if ($entry != "." && $entry != ".." ) { 
					/*$midle_mane=explode("_",$entry);
					  if($midle_mane[1]==$validate_1 || $midle_mane[1]==$validate_2 || $midle_mane[1]==$validate_3){*/
					 $i++;
			            $data['file'].='<p><input type="checkbox" name="files['.$i.']" class="files" value="'.$entry.'" ><label for="files" >&nbsp; <a href="#" class="'.$it_key.'" onclick="preview_f(this)">'.$entry.'</a></label></p>';
					  //}

			        }
			    }
			    closedir($handle);
			}
		if($i<=0){
			$data['file'] ='<p>No File Exists</p>';
		}
		echo json_encode($data);
  	}










  	function approve_actor(){
  		$file_path = $this->input->post('dir_pth');
  		$files = $this->input->post('files');
  		$choice = $this->input->post('Actor_chc');
		$basepath = $_SERVER['DOCUMENT_ROOT'] ;
		$x=count($files);
		
  		if($choice=='Marketing'){
  			$files_path2 = '/chanthel/workflow_dir/fathul/';
  		}
  		else if($choice=='Accounting'){
  			$files_path2 = '/chanthel/workflow_dir/galang/';
  		}
  		else if($choice=='IT'){
  			$files_path2 = '/chanthel/workflow_dir/danang/';
  		}
  		$i=0;
  		foreach ($files as $value) { $i++;
  			rename($basepath.'/'.$file_path.'/'.$value, $basepath.$files_path2.$value);
  		}
  		$data['n']=$i;// $file_path.$choice.$basepath.$x; 
  		echo json_encode($data);

  	}


  	function approve_actor2(){
  		$file_path = $this->input->post('dir_pth');
  		$files = $this->input->post('files');
  		$choice = $this->input->post('choice');
  		$it_key = $this->input->post('it_key');
		$basepath = $_SERVER['DOCUMENT_ROOT'] ;
		$x=count($files);
		
		if($it_key=='Actor2'){
  			$files_path='/chanthel/workflow_dir/fathul/';
  			$files_path4='/chanthel/workflow_dir/marketing/';
  			$by='Fathul';
  		}
  		else if($it_key=='Actor3'){
  			$files_path='/chanthel/workflow_dir/galang/';
  			$files_path4='/chanthel/workflow_dir/accounting/';
  			$by='Galang';
  		}
  		else if($it_key=='Actor4'){
  			$files_path='/chanthel/workflow_dir/danang/';
  			$files_path4='/chanthel/workflow_dir/it/';
  			$by='Danang';
  		}
		

  		if($choice=='Interest'){
  			$files_path2='/chanthel/workflow_dir/hire/';
  			$files_path3='/chanthel/workflow_dir/arsip/';
  			foreach ($files as $value) {  
  					copy($basepath.$files_path.$value, $basepath.$files_path3.$by.'_'.$value);
  					copy($basepath.$files_path.$value, $basepath.$files_path4.$by.'_'.$value);
  			} 
  		}
  		else if($choice=='Not'){
  			$files_path2='/chanthel/workflow_dir/notinerested/';
  		}
  		 $i=0;
  		foreach ($files as $value) { $i++;  
  		    rename($basepath.$files_path.$value, $basepath.$files_path2.$by.'_'.$value);
  		}
  		$data['n']=$i;//$choice.$basepath.$it_key.$x.$by.$files_path.$files_path4.$files_path2.$files_path3; 
  		echo json_encode($data);

  	}



  	function go_move_approve(){
  		$files_path = $this->input->post('dir_pth');
  		$files = $this->input->post('files');
  		//$choice = $this->input->post('choice');
  		$it_key = $this->input->post('it_key');
		$basepath = $_SERVER['DOCUMENT_ROOT'] ;
		$x=count($files);
		
		if($it_key=='Actor2'){
  			$files_path4='/chanthel/workflow_dir/marketing/';
  			$by='Fathul';
  		}
  		else if($it_key=='Actor3'){
  			$files_path4='/chanthel/workflow_dir/accounting/';
  			$by='Galang';
  		}
  		else if($it_key=='Actor4'){
  			$files_path4='/chanthel/workflow_dir/it/';
  			$by='Danang';
  		}
		
  		$files_path2='/chanthel/workflow_dir/hire/';
  		$files_path3='/chanthel/workflow_dir/arsip/';
  			
  		$i=0;
  		foreach ($files as $value) { $i++;  
  			copy($files_path.'/'.$value, $basepath.$files_path2.$by.'_'.$value);
  		    copy($files_path.'/'.$value, $basepath.$files_path3.$by.'_'.$value);
  		    rename($files_path.'/'.$value, $basepath.$files_path4.$by.'_'.$value);
  		}
  		$data['n']=$i;//$choice.$basepath.$it_key.$x.$by.$files_path.$files_path2.$files_path3;// 
  		echo json_encode($data);

  	}

  	function go_move_reject(){
  		$files_path = $this->input->post('dir_pth');
  		$files = $this->input->post('files');
  		//$choice = $this->input->post('choice');
  		$it_key = $this->input->post('it_key');
		$basepath = $_SERVER['DOCUMENT_ROOT'] ;
		$x=count($files);
		$files_path2='/chanthel/workflow_dir/notinerested/';
		if($it_key=='Actor2'){
  			$by='Fathul';
  		}
  		else if($it_key=='Actor3'){
  			$by='Galang';
  		}
  		else if($it_key=='Actor4'){
  			$by='Danang';
  		}
		$i=0;
  		foreach ($files as $value) { $i++; 
  		    rename($files_path.'/'.$value, $basepath.$files_path2.$by.'_'.$value);
  		}
  		$data['n']=$i;//$choice.$basepath.$it_key.$x.$by.$files_path.$files_path2.$files_path3;// 
  		echo json_encode($data);
  	}




  	function approve_actor3(){
  		//$file_path = $this->input->post('dir_pth');
  		$files = $this->input->post('files');
  		//$choice = $this->input->post('Actor_chc');
  		$it_key = $this->input->post('it_key');
		$basepath = $_SERVER['DOCUMENT_ROOT'] ;
		$x=count($files);
		$files_path='/chanthel/workflow_dir/notinerested/';
		$files_path2='/chanthel/workflow_dir/trash/';
		$i=0;
  		foreach ($files as $value) { $i++;  
  		    rename($basepath.$files_path.$value, $basepath.$files_path2.$by.$value);
  		}
  		$data['n']=$i;//$choice.$basepath.$it_key.$x.$by.$files_path.$files_path4.$files_path2.$files_path3; 
  		echo json_encode($data);

	}







 	function test()
 	{
 		//$basepath = $_SERVER['DOCUMENT_ROOT'] ;
 		///rename($basepath.'/chantel-civ2/assets/file/Hire_Document.pdf', $basepath.'/chantel-civ2/assets/css/Hire_Document.pdf');
		//$path = fopen('C:/xampp/htdocs/chantel-civ2/assets/file/_test_fly_20180426_0933.pdf');
		//header("Content-type:application/pdf; charset=UTF-8");
        //header("Content-Disposition:inline;filename=".$id);
        //header('Content-Transfer-Encoding: binary');
        //header('Expires: 0');
        //header('Cache-Control: must-revalidate');
        //header('Pragma: public');
        //ob_clean();
       //flush();
       // ob_end_clean();
        //$path = 'http://192.168.1.163/chantel-civ2/assets/file/Danang_danang_fly_20180426_0928.pdf';//'C:/xampp/htdocs/chantel-civ2/assets/file/_test_fly_20180426_0933.pdf'; //readfile();
        //header('Content-Type: application/pdf');
		//header('Content-Disposition: inline; filename='.$path);
		//header('Content-Transfer-Encoding: binary');
		//header('Accept-Ranges: bytes'); $data, 

		//readfile($path);
		$this->template->write_view('content', 'teting', TRUE);
	    $this->template->render();

 	}


 	function set_preview(){
 			$files = $this->input->post('file');
 			$dir_url = $this->input->post('dir_url');
 			$fullpath= $dir_url.'/'.$files;
 			$this->session->set_userdata('file_url',$fullpath);
 			$data['feed']=$this->session->userdata('file_url');
 			echo json_encode($data);
 	}

 	function frame(){

 		$path=$this->session->userdata('file_url');
 		//$path = 'C:/xampp/htdocs/chantel-civ2/assets/file/_test_fly_20180426_0933.pdf';
        header('Content-Type: application/pdf');
		//header('Content-Disposition: inline; filename='.$path);
		//header('Content-Transfer-Encoding: binary');
		//header('Accept-Ranges: bytes'); $data, 

		readfile($path);
 	}
 	

}