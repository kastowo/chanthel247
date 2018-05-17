<style>
* {
  box-sizing: border-box;
}

input[type=text], select, textarea {
  width: 100%;
  border: 1px solid #ccc;
  border-radius: 4px;
  resize: vertical;
}

label {
  padding: 12px 12px 12px 0;
  display: inline-block;
}

input[type=submit] {
  background-color: #4CAF50;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  float: right;
}

input[type=submit]:hover {
  background-color: #45a049;
}

.container {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}

.col-25 {
  float: left;
  width: 25%;
  margin-top: 6px;
}
.col-25 button, .col-30 button{
  margin-right: 10px;
}
.col-30 button{
  margin-top: 8px;
}

.col-75 {
  float: left;
  width: 75%;
  margin-top: 6px;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

/* Responsive layout - when the screen is less than 600px wide, make the two columns stack on top of each other instead of next to each other */
@media screen and (max-width: 600px) {
  .col-25, .col-75, input[type=submit] {
    width: 100%;
    margin-top: 0;
  }
}
</style>


<?php
if ($type == "Add") {
  $command = "insert";
}
?>
<?php
if ($type == "Edit") {
  $command = "update";
}
?>

<div class="content">
  <form action="<?php echo base_url();?>Modulemanager/<?php echo $command; ?>" id="module_form" class="smart-form" novalidate="novalidate" method="POST">
    <input type="hidden" id="MODULE_ID" name="MODULE_ID" value="<?php echo @$d['MODULE_VAR'] ?>">
    <div class="row">
      <div class="col-25">
        <input type="text" class="form-control" name="MODULE_VAR" id="MODULE_VAR" placeholder="Nama Folder" value="<?php echo @$d['MODULE_VAR'] ?>">
      </div>

      <div class="col-25" data-toggle="buttons-radio">
        <button type="button" style="padding:5px;" class="button-secondary" id="br_enable" name="MODULE_STATUS" onclick="$('#MODULE_STATUS').val(1);cStyle('br_disable');return false;">Aktif</button>
        <button type="button" style="padding:5px;" class="button-default" id="br_disable" name="MODULE_STATUS" onclick="$('#MODULE_STATUS').val(0);cStyle('br_enable');return false;">NonAktif</button>
        <input type="hidden" id="MODULE_STATUS" name="MODULE_STATUS" class="input-xlarge required" value="<?php echo @$d['MODULE_STATUS']==0 ? @$d['MODULE_STATUS'] : "1";?>" />
        <?php
        if (@$d['MODULE_TYPE'] == 'module') {
        echo "checked='checked'";
      } if (empty($d['MODULE_TYPE'])) {
      echo "checked='checked'";
    } ?>
    <?php echo $this->lang->line('module_modulemanager_type_modules') ?>

</div>
</div>

<div class="row">
  <div class="col-25">
    <input type="text" class="form-control" name="MODULE_NAME" id="MODULE_NAME" placeholder="Modul / nama menu" value="<?php echo @$d['MODULE_NAME'] ?>">
  </div>
  <div class="col-30">
    <button type="button" style="padding:5px;" class="button-secondary" id="btn_cfg_VIEW" onclick="buildConfig('VIEW',this.id);return false;">VIEW</button>
    <button type="button" style="padding:5px;" class="button-default" id="btn_cfg_INSERT" onclick="buildConfig('INSERT',this.id);return false;">INSERT</button>
    <button type="button" style="padding:5px;" class="button-default" id="btn_cfg_UPDATE" onclick="buildConfig('UPDATE',this.id);return false;">UPDATE</button>
    <button type="button" style="padding:5px;" class="button-default" id="btn_cfg_DELETE" onclick="buildConfig('DELETE',this.id);return false;">DELETE</button>
    <input type="hidden" id="MODULE_CONFIG" name="MODULE_CONFIG" class="input-xlarge" value="<?php echo @$d['MODULE_CONFIG'] ? $d['MODULE_CONFIG'] : "VIEW,"; ?>">
  </div>
</div>

<div class="row">
  <div class="col-25">
    <select name="MODULE_PARENT" id="MODULE_PARENT" class="form-control">
      <option disabled="" <?php
      if (empty($d['MODULE_PARENT'])) {
        echo "selected='selected'";
      }
      ?> value="">Choose Module Parent</option>
      <option value="0" <?php
      if (@$d['MODULE_PARENT'] == 0) {
        echo "selected='selected'";
      }
      ?>>Top Level</option>
      <?php
      $selected = "";
      foreach ($module_list->result() as $row) {
        if ($d['MODULE_PARENT'] == $row->MODULE_ID) {
          $selected = "selected='selected'";
        }
        ?>
        <option value="<?php echo $row->MODULE_ID ?>" <?php echo $selected; ?>><?php echo $row->MODULE_NAME ?></option>
        <?php
        $selected = "";
      }
      ?>
    </select>
  </div>
  <div class="col-25">
    <input type="text" class="form-control" name="SORT_INDEX" id="SORT_INDEX" placeholder="SORT"
    value="<?php $data = @$d['SORT_INDEX'];
    $sort_index = substr($data,-1);
    echo $sort_index; ?>">
  </div>
</div>

<div class="row">
  <div class="col-25">
    <input type="text" class="form-control" name="MODULE_DESCRIPTION" id="MODULE_DESCRIPTION" placeholder="module_descrption" value="<?php echo @$d['MODULE_DESCRIPTION'] ?>">
  </div>
  <div class="col-25">
    <input type="text" class="form-control" name="MODULE_ICON" id="MODULE_ICON" placeholder="icon" value="<?php echo $row->MODULE_ICON ?>">
  </div>
</div>
<div>
  <br>
  <footer>
    <button class="button-primary" type="submit" id="moduleSaveBtn"> SAVE </button>
  </footer>
</div>
</form>
</div>
<script type="text/javascript">
    $('#Administration').addClass("active");
document.getElementById('menu-title').style.display ="block";
document.getElementById('menu-add').style.display ="none";
document.getElementById('title').innerHTML="Add Menu";
function buildConfig(name,id){
  var current_value = $("#MODULE_CONFIG").val();
  if($("#"+id).hasClass("button-secondary")){
    $("#"+id).removeClass("active");
    $("#"+id).removeClass("button-secondary");
    $("#"+id).addClass("button-default");
    current_value = current_value.replace(name+",","");
  }else{
    $("#"+id).addClass("active");
    $("#"+id).removeClass("button-default");
    $("#"+id).addClass("button-secondary");
    current_value = current_value + name+",";
  }
  $("#MODULE_CONFIG").val(current_value);
  return false;
}

function cStyle(id){
  if(id=="br_enable"){
    $('#'+id).removeClass();
    $('#'+id).addClass('btn');
    $('#'+id).addClass('btn-danger');
    $('#br_disable').removeClass();
    $('#br_disable').addClass('btn');
    $('#br_disable').addClass('btn-success');
    $('#br_disable').addClass('active');
  }
  else{
    $('#'+id).removeClass();
    $('#'+id).addClass('btn');
    $('#'+id).addClass('btn-danger');
    $('#br_enable').removeClass();
    $('#br_enable').addClass('btn');
    $('#br_enable').addClass('btn-success');
    $('#br_enable').addClass('active');
  }
  return false;
}

</script>
