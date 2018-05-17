<!-- Row begin -->
<div class="row">
  <div class="col-12"  style="padding-left:0 !important;">
    <nav>
      <ul class="text-left">
        <li class="menu-horizontal">
          <a  href="<?php echo base_url();?>Modulemanager/add" class="button-primary" id="add" style="font-size: 14px;padding: 3px;width: 100px;">Add Menu</a>
        </li>
      </ul>
    </nav>
  </div>
</div>
<!-- Row end -->

<!-- Row begin-->
<div class="row">
  <div class="col-12  margin-y no-padding">
    <table id="list-view" class="hover" style="width:100%">
      <thead>
        <tr>
          <th>Module Name </th>
          <th>UI var name </th>
          <th>Description</th>
          <th>Config</th>
          <th>Options</th>
        </tr>
      </thead>
      <tbody>
        <tr class="star">
          <?php foreach($table_data as $row){?>
            <td><?php echo $row['MODULE_NAME']?></td>
            <td><?php echo $row['MODULE_VAR']?></td>
            <td><?php echo $row['MODULE_DESCRIPTION']?></td>
            <td><?php echo $row['MODULE_CONFIG']?></td>
            <td nowrap class="table-button">
              <a title="Edit" href="<?php echo base_url();?>Modulemanager/add /<?php echo $row['MODULE_ID']?>"  class="button-secondary button-radius"><i class="fa fa-pencil"></i></a>
              <a title="Delete" href="<?php echo base_url();?>Modulemanager/delete/<?php echo $row['MODULE_ID']?>" onclick="return confirm('Delete <?php echo $row['MODULE_NAME']?>');" class="button-danger button-radius"><i class="fa fa-trash-o"></i></a></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>

    </div>
  </div>
</div>
<!-- Row end -->

  <script type="text/javascript">
    //Manipulating top header menu
    document.getElementById('menu-title').style.display ="block";
    document.getElementById('menu-add').style.display ="none";
    document.getElementById('title').innerHTML="Menu Management";

    //Manipulating sidebar menu by adding class active
    $('#Administration').addClass("active");
  </script>
