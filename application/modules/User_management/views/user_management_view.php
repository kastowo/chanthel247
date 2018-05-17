<div class="row">
  <div class="col-12">
    <nav>
      <ul class="text-left">
        <li class="menu-horizontal">
          <a  href="<?php echo base_url();?>User_management/add" class="button-primary" id="add" style="font-size: 14px;padding: 3px;width: 100px;">Add User</a>
        </li>
      </ul>
    </nav>
  </div>
</div>
<div class="row">
  <div class="col-12">
    <table id="list-view" class="hover" style="width:100%">
      <div class="option-container">
        <ul>
          <li>Atur Hak Akses</li>
          <li>Ubah</li>
          <li>Hapus</li>
        </ul>
      </div>
      <thead>
        <tr>
          <th>Username </th>
          <th>Email</th>
          <!-- <th>Description</th>
          <th>Config</th> -->
          <th>Options</th>
        </tr>
      </thead>
     <tbody>
      <tr class="star">
        <?php for ($i = 0; $i < sizeof($list_user); $i++) {?>
          <td><?php echo $list_user[$i]['name']?></td>
          <td><?php echo $list_user[$i]['email']?></td>
          <!-- <td><?php echo $list_user[$i]['name']?></td>
          <td><?php echo $list_user[$i]['name']?></td> -->
          <td nowrap class="table-button">
            <a title="Edit" href="<?php echo base_url();?>Modulemanager/add/<?php echo $list_user[$i]['id']?>"  class="button-secondary button-radius"><i class="fa fa-pencil"></i></a>
            <a title="Delete" href="<?php echo base_url();?>Modulemanager/delete/<?php echo $list_user[$i]['id']?>" onclick="return confirm('Delete <?php echo $list_user[$i]['id']?>');" class="button-danger button-radius"><i class="fa fa-trash-o"></i></a></td>
          </tr>
        <?php } ?>
      </tbody>
      </table>

    </div>
  </div>
</div>

  <!-- <div class="new-folder-container" id="addGroups">
    <div class="new-folder-header">
      <p>Add Group Name</p>
    </div>
    <div class="new-folder-content">
      <form class="form-vertical" action="<?php echo base_url();?>Groups/insert" method="POST">
        <div class="input-group">
          <label for="">Group Name</label><span class="required" style="  margin-left: 20px">*</span>
          <input type="text" name="GROUP_NAME" maxlength="20" id="GROUP_NAME" placeholder="Groups Name">
        </div>
        <div class="message">
          <p class="required">*</p><span style="margin-left:20px">required field must be fill out</span>
        </div>
      </div>
      <div class="new-folder-footer">
        <button type="button" name="button" class="" onclick="closeNewFolder()">Cancel</button>
        <button type="submit" class="button-primary create" style="float:right"  onclick="closeNewFolder()">Create</button>
      </div>
    </form>
  </div> -->

  <script type="text/javascript">
    document.getElementById('menu-title').style.display ="block";
    document.getElementById('menu-add').style.display ="none";
    document.getElementById('title').innerHTML="User Management";

    $('#Administration').addClass("active");
    $('#User\\ Management').addClass("active");

  </script>
