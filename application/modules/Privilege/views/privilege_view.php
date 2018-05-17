<script type="text/javascript">

  var module_name = '<?php echo $this->uri->segment(1)?>';

  $(function(){
    $(".btn-Save").click(function(){
      var vpriv_id = $(this).attr('priv_id');
      var ins = $('#'+vpriv_id+'HAS_INSERT').val();
      var upd = $('#'+vpriv_id+'HAS_UPDATE').val();
      var del = $('#'+vpriv_id+'HAS_DELETE').val();
      var view = $('#'+vpriv_id+'HAS_VIEW').val();
      var app = $('#'+vpriv_id+'HAS_APPROVAL').val();
      var data = 'privilege_id='+vpriv_id+'&HAS_INSERT='+ins+'&HAS_UPDATE='+upd+'&HAS_DELETE='+del+'&HAS_VIEW='+view+'&HAS_APPROVAL='+app;
      $.ajax({
      type:"POST",
      url:"<?php echo base_url();?>privilege/update/",
      data:data,
        success:function(msg){
          if(msg=="ok"){
            alert("Data succesfully updated");
          }
          else{
            if(msg=="no_priv"){
              alert("You dont have a privilege to update data");
            }
            else{
              alert(msg);
            }
          }
        },
        error:function(){
          alert("Insert data failed");
        }
      });

      return false;
    });
  });

  function buildConfig(val,isi,idPriv,idBut){
    var current_value = $("#"+idPriv+val).val();

    if($("#"+idBut).hasClass("button-secondary") || $("#"+idBut).hasClass("button-default")){
      if(current_value==1){
        $("#"+idBut).removeClass("button-secondary");
        $("#"+idBut).addClass("button-default");
        current_value = current_value.replace('1','0');
      }else {
        $("#"+idBut).removeClass("button-default");
        $("#"+idBut).addClass("button-secondary");
        current_value = current_value.replace('0','1');
      }

    }
    else{
      alert("Privilege disabled, please activate it from module manager");
    }
    //alert()
     $("#"+idPriv+val).val(current_value);
  }


  function reFetch(id,ins,upd,del,view,app){
    var config = $('#module_config'+id).val();
    var conf_list = config.split(",");

    for(var i=0;i<conf_list.length;i++){
      $("#"+id+"btn_cfgHAS_"+conf_list[i]).removeClass("btn-xs");
      $("#"+id+"btn_cfgHAS_"+conf_list[i]).addClass("button-default");
      $("#"+id+"btn_cfgHAS_"+conf_list[i]).prop("disabled", false);
      if(ins==1){
        $("#"+id+"btn_cfgHAS_INSERT").removeClass("button-default");
        $("#"+id+"btn_cfgHAS_INSERT").addClass("button-secondary");
        $("#"+id+"btn_cfgHAS_INSERT").prop("disabled", false);
      }
      if(upd==1){
        $("#"+id+"btn_cfgHAS_UPDATE").removeClass("button-default");
        $("#"+id+"btn_cfgHAS_UPDATE").addClass("button-secondary");
        $("#"+id+"btn_cfgHAS_UPDATE").prop("disabled", false);
      }
      if(del==1){
        $("#"+id+"btn_cfgHAS_DELETE").removeClass("button-default");
        $("#"+id+"btn_cfgHAS_DELETE").addClass("button-secondary");
        $("#"+id+"btn_cfgHAS_DELETE").prop("disabled", false);
      }
      if(view==1){
        $("#"+id+"btn_cfgHAS_VIEW").removeClass("button-default");
        $("#"+id+"btn_cfgHAS_VIEW").addClass("button-secondary");
        $("#"+id+"btn_cfgHAS_VIEW").prop("disabled", false);
      }
      if(app==1){
        $("#"+id+"btn_cfgHAS_APPROVAL").removeClass("button-default");
        $("#"+id+"btn_cfgHAS_APPROVAL").addClass("button-secondary");
        $("#"+id+"btn_cfgHAS_APPROVAL").prop("disabled", false);
      }
      else{

      }
    }
  }

  function saveAll(){

    $.ajax({
      type:"POST",
      url:"<?php echo base_url();?>"+module_name+"/save_all/",
      data:$("#priv_form").serialize(),
      dataType:"html",
      success:function(msg){

        alert("Privilege updated");
      }
    });
  }
</script>
<div class="row">
  <div class="col-6 no-padding-y">
    <ul class=" breadcrumb">
      <li class="header"></li>

    </ul>
  </div>
<input type="hidden" id="module_config">
<div class="row">
  <div class="col-12 margin-y no-padding">
    <form name="priv_form" id="priv_form" class="smart-form" novalidate="novalidate" action="" method="post" onsubmit="return false;">
      <input type="hidden" name="GROUP_ID" id="GROUP_ID" value="1" />
      <table id="list-view"  style="width:100%">
        <thead>
          <tr>
            <th>Module Name</th>
            <th>Program</th>
            <th>Module Config</th>
            <th>Insert</th>
            <th>Update</th>
            <th>Delete</th>
            <th>View</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach($table_data as $row){
            if($row['HAS_INSERT']==''){
              $row['HAS_INSERT']=0;
            }
            if($row['HAS_UPDATE']==''){
              $row['HAS_UPDATE']=0;
            }
            if($row['HAS_DELETE']==''){
              $row['HAS_DELETE']=0;
            }
            if($row['HAS_VIEW']==''){
              $row['HAS_VIEW']=0;
            }
            if($row['HAS_APPROVAL']==''){
              $row['HAS_APPROVAL']=0;
            }
            error_reporting(0);
            ?>

            <tr class="privileges">
              <td><?php echo $row['MODULE_NAME']?></td>
              <td><?php echo $row['PROGRAM_NAME']?$row['PROGRAM_NAME']:"All Program";?></td>
              <td><?php echo $row['MODULE_CONFIG']?><input type=hidden name="<?php echo $row['PRIVILEGE_ID']?>module_config" id="module_config<?php echo $row['PRIVILEGE_ID']?>" value=<?php echo $row['MODULE_CONFIG']?>></td>
              <td><input type="hidden" name="<?php echo $row['PRIVILEGE_ID']?>HAS_INSERT" id="<?php echo $row['PRIVILEGE_ID']?>HAS_INSERT" value=<?php echo $row['HAS_INSERT']?>> <button class="button-default" id="<?php echo $row['PRIVILEGE_ID']?>btn_cfgHAS_INSERT" onclick="buildConfig('HAS_INSERT',<?php echo $row['HAS_INSERT']?>,<?php echo $row['PRIVILEGE_ID']?>,this.id)" disabled>Insert</button></td>
              <td><input type=hidden name="<?php echo $row['PRIVILEGE_ID']?>HAS_UPDATE" id="<?php echo $row['PRIVILEGE_ID']?>HAS_UPDATE" value=<?php echo $row['HAS_UPDATE']?>> <button class="button-default" id="<?php echo $row['PRIVILEGE_ID']?>btn_cfgHAS_UPDATE" onclick="buildConfig('HAS_UPDATE',<?php echo $row['HAS_UPDATE']?>,<?php echo $row['PRIVILEGE_ID']?>,this.id)" disabled>Update</button></td>
              <td><input type=hidden name="<?php echo $row['PRIVILEGE_ID']?>HAS_DELETE" id="<?php echo $row['PRIVILEGE_ID']?>HAS_DELETE" value=<?php echo $row['HAS_DELETE']?>> <button class="button-default" id="<?php echo $row['PRIVILEGE_ID']?>btn_cfgHAS_DELETE" onclick="buildConfig('HAS_DELETE',<?php echo $row['HAS_DELETE']?>,<?php echo $row['PRIVILEGE_ID']?>,this.id)" disabled>Delete</button></td>
              <td><input type=hidden name="<?php echo $row['PRIVILEGE_ID']?>HAS_VIEW" id="<?php echo $row['PRIVILEGE_ID']?>HAS_VIEW" value=<?php echo $row['HAS_VIEW']?>> <button class="button-default" id="<?php echo $row['PRIVILEGE_ID']?>btn_cfgHAS_VIEW" onclick="buildConfig('HAS_VIEW',<?php echo $row['HAS_VIEW']?>,<?php echo $row['PRIVILEGE_ID']?>,this.id)" disabled>View</button></td>
            </tr>
            <script>reFetch (<?php echo $row['PRIVILEGE_ID']?>,<?php echo $row['HAS_INSERT']?>,<?php echo $row['HAS_UPDATE']?>,<?php echo $row['HAS_DELETE']?>,<?php echo $row['HAS_VIEW']?>,<?php echo $row['HAS_APPROVAL']?>);</script>
            <?php
            $i++;
          }
          ?>
        </tbody>
      </table>
      <footer>

        <button type="reset" class="button-default" id="moduleResetBtn" onclick="resetAll(<?php echo $group_id?>)" style="margin-right:20px"> Reset </button>
        <button type="submit" class="button-primary" id="moduleSaveBtn" onclick="saveAll();">Save</button>
        <?php echo $this->lang->line('module_groups_back_to_list');?>
      </a>

    </footer>
  </form>
  </div>
</div>
<script type="text/javascript">
  document.getElementById('menu-title').style.display ="block";
  document.getElementById('menu-add').style.display ="none";
  document.getElementById('title').innerHTML="Privileges Management"
</script>
