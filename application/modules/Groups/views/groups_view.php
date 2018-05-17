<!-- Row begin -->
<div class="row">
  <div class="col-12" style="padding-left:0 !important;">
    <nav>
      <ul class="text-left">
        <li class="menu-horizontal">
          <button class="button-primary" id="add" onclick="toggleContainer('AddGroups');  addGroups();">Add Group</button>
        </li>
      </ul>
    </nav>
  </div>
</div>
<!-- Row end -->

<!-- Row begin -->
<div class="row">
  <div class="col-12  margin-y no-padding">
    <table id="list-view"  style="width:100%">
      <thead>
        <tr>
          <th>Group Name</th>
          <th>Options</th>
        </tr>
      </thead>
      <tbody>
        <tr class="star">
          <?php
          foreach ($table_data as $k => $v) { ?>
            <td><?php echo $table_data[$k]['GROUP_NAME']; ?></td>
            <td class="table-button">
              <a title="Edit" class="button-secondary button-radius" onclick="toggleContainer('EditGroups'); editGroups('<?php echo $table_data[$k]['GROUP_ID']; ?>','<?php echo $table_data[$k]['GROUP_NAME']; ?>')"><i class="fa fa-pencil"></i></a>
              <a title="Set Privileges" class="button-primary button-radius" href="<?php echo base_url();?>Privilege/view_prev/<?php echo $table_data[$k]['GROUP_ID']; ?>" > <?php echo $this->lang->line('module_groups_privilege_settings'); ?><i class="fa fa-lock"></i></a>
              <a title="Delete" class="button-danger button-radius" href="<?php echo base_url();?>Groups/delete/<?php echo $table_data[$k]['GROUP_ID']; ?>" onclick="return confirm('Delete group <?php echo $table_data[$k]['GROUP_NAME'] ?>?');" ><?php echo $this->lang->line('module_groups_delete'); ?><i class="fa fa-trash"></i></a>
            </td>
          </tr>
          <?php
        }
        ?>
      </tbody>
    </table>
  </div>
</div>
<!-- Row end -->

<script type="text/javascript">
// manipulate top header menu
  document.getElementById('menu-title').style.display ="block";
  document.getElementById('menu-add').style.display ="none";
  document.getElementById('title').innerHTML="Role Management";

  // manipulate menu by adding active class
  $('#Administration').addClass("active");
</script>
