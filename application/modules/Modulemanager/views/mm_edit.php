<style>
* {
  box-sizing: border-box;
}

input[type=text], select, textarea {
  width: 100%;
  padding: 12px;
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

@media screen and (max-width: 600px) {
  .col-25, .col-75, input[type=submit] {
    width: 100%;
    margin-top: 0;
  }
}
</style>
<?php print_r($module_list); die(); ?>
<div class="menu">
  <ul class="pull-left">
    <li  class="tooltip"><a> <img src="<?php echo base_url();?>/assets/SVG_dark/list_view.svg" alt="" width="16" height="16" id="list"> User Management</a></li>
  </ul>
</div>

<div class="content">
  <form action="Modulemanager/update" id="module_form" class="smart-form" novalidate="novalidate" method="POST">
    <input type="hidden" id="MODULE_ID" name="MODULE_ID" value="<?php echo @$d['MODULE_VAR'] ?>">
    <div class="row">
      <div class="col-25">
        <input type="text"  name="MODULE_VAR" id="MODULE_VAR" value="<?php echo @$d['MODULE_VAR'] ?>" >
      </div>

      <div class="col-25">
        <section class="col col-5" >
          <div class="inline-group">
            <label class="radio" style="display:none">
              <input type="radio" <?php
              if (@$d['MODULE_TYPE'] == 'module') {
                echo "checked='checked'";
              } if (empty($d['MODULE_TYPE'])) {
                echo "checked='checked'";
              } ?> name="MODULE_TYPE" value="module" onclick="$('#MODULE_VAR').val('');$('#editor').hide();$('#uploader').hide();">
              <i></i><?php echo $this->lang->line('module_modulemanager_type_modules') ?>
            </label>
          </div>
        </section>
      </div>
    </div>

    <div class="row">
      <div class="col-25">
        <input type="text" name="MODULE_NAME" id="MODULE_NAME" value="<?php echo @$d['MODULE_NAME'] ?>">
      </div>
      <div class="col-30">
        <button type="button" style="padding:5px;" class="btn btn-success active" id="btn_cfg_VIEW" onclick="buildConfig('VIEW',this.id);return false;">VIEW</button>
        <button type="button" style="padding:5px;" class="btn btn-danger" id="btn_cfg_INSERT" onclick="buildConfig('INSERT',this.id);return false;">INSERT</button>
        <button type="button" style="padding:5px;" class="btn btn-danger" id="btn_cfg_UPDATE" onclick="buildConfig('UPDATE',this.id);return false;">UPDATE</button>
        <button type="button" style="padding:5px;" class="btn btn-danger" id="btn_cfg_DELETE" onclick="buildConfig('DELETE',this.id);return false;">DELETE</button>
        <input type="hidden" id="MODULE_CONFIG" name="MODULE_CONFIG" class="input-xlarge" value="<?php echo @$d['MODULE_CONFIG'] ? $d['MODULE_CONFIG'] : "VIEW,"; ?>">
      </div>
    </div>

    <div class="row">
      <div class="col-25">
        <select name="MODULE_PARENT" id="MODULE_PARENT">
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
        <input type="text" name="SORT_INDEX" id="SORT_INDEX" placeholder="SORT"
        value="<?php $data = @$d['SORT_INDEX'];
        $sort_index = substr($data,-1);
        echo $sort_index; ?>">
      </div>
    </div>

    <div class="row">
      <div class="col-25">
        <input type="text" name="MODULE_DESCRIPTION" id="MODULE_DESCRIPTION" placeholder="module_descrption" value="<?php echo @$d['MODULE_DESCRIPTION'] ?>">
      </div>
      <div class="col-25">
        <input type="text" name="MODULE_ICON" id="MODULE_ICON" placeholder="icon" value="<?php echo $row->MODULE_ICON ?>" >
      </div>
    </div>
    <div>
      <footer>
        <button class="btn btn-primary" type="submit" id="moduleSaveBtn"> SAVE </button>
      </footer>
    </div>
  </form>
</div>

<script type="text/javascript">
document.getElementById('menu-title').style.display ="block";
document.getElementById('menu-add').style.display ="none";
document.getElementById('title').innerHTML="Edit Menu";
$('#Administration').addClass("active");
</script>
