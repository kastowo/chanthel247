<div class="row">
  <div class="col-6 no-padding-y">
    <ul class=" breadcrumb">
      <button type="button" name="button" class="button-primary" onclick="toggleContainer('NewWorkflow')">Create New Workflow</button>
    </ul>
  </div>
</div>
<div class="row">
  <div class="col-12 margin-y no-padding">
    <table id="list-view" class="hover" style="width:100%">
      <thead>
        <tr>
          <th class="adjust-width md">Process Titile</th>
          <th>Type</th>
          <th>Category</th>
          <th>Status</th>
          <th>Date Created </th>
          <th>Assigned User</th>
          <!-- <th>Completed </th>
          <th>Canceled </th>
          <th>Total Case </th>
          <th>Date Update </th> -->
          <th>Option</th>
        </tr>
      </thead>
      <tbody>
        <?php
            if($jml_data>0){
               for($i=1;$i<=$jml_data;$i++) {
                    echo'<tr class="star row'.$wf_id[$i].'">
                          <td onclick="open_wf('.$wf_id[$i].')" class="wf_name'.$wf_id[$i].'" style="cursor:pointer">'.$wf_name[$i].'</td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td>'.$wf_created_dt[$i].'</td>
                          <td></td>

                          <td class="table-button">
                              <a title="View" onclick="open_wf('.$wf_id[$i].')" class="button-primary button-radius"><i class="fa fa-eye"></i></a>
                              <a title="Edit" onclick="edit_wf('.$wf_id[$i].')" class="button-secondary button-radius"><i class="fa fa-pencil"></i></a>
                              <a title="Delete" class="button-danger button-radius"><i class="fa fa-trash-o"></i></a></td>';
                ?>
            <?php echo'
                            </td>
                        </tr>';
                  }
            }else {
              echo '<tr class="star"><td></td></tr>';
            }
         ?>
        </tbody>

    </table>

  </div>
</div>
<script type="text/javascript">
  document.getElementById('menu-title').style.display ="block";
  document.getElementById('menu-add').style.display ="none";
  document.getElementById('title').innerHTML="Workflow";
  $('#Workflow').addClass("active");

  function open_wf(id){
      if(id==10){
        window.location = "<?php echo base_url('Workflow/open_used_wf');?>";
      }else {
         window.location = "<?php echo base_url('Workflow/open_go_wf/');?>"+String(id);
      }
  }
  function edit_wf(id){
      if(id==10){
        window.location = "<?php echo base_url('Workflow/open_used_wf');?>";
      }else {
         window.location = "<?php echo base_url('Workflow/open_edit_wf/');?>"+String(id);
      }
  }
</script>
