<?php
$user = $this->session->userdata("user");
$id = $this->session->userdata("id");
if (!isset($user)) {
    redirect('Login');
echo $username;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable= no">
    <title>Chantel - DMS</title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assetsnew/css/chanthel.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assetsnew/css/normalize.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assetsnew/css/ns-default.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assetsnew/css/ns-style-growl.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assetsnew/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assetsnew/plugins/datatables/jquery.dataTables.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assetsnew/plugins/datatables/responsive.dataTables.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assetsnew/plugins/icheck/skins/square/_all.css" rel="stylesheet">
    <link rel="icon" href="<?php echo base_url(); ?>assetsnew/ico/PACS_favicon11.png" type="image/x-icon">
    <link rel='stylesheet' href='<?php echo base_url(); ?>assetsnew/plugins/fullcalendar/fullcalendar.min.css' />
    <link rel='stylesheet' href='<?php echo base_url(); ?>assetsnew/plugins/fullcalendar/style.css' />
    <link rel='stylesheet' media='print' href='<?php echo base_url(); ?>assetsnew/plugins/fullcalendar/fullcalendar.print.min.css' />
    <script type="text/javascript" src="<?php echo base_url(); ?>assetsnew/js/modernizr.custom.js"></script>
</head>
<body id="body">
  <div class="wrapper">

    <!-- Cover when popup show -->
    <div id="cover"></div>

    <!-- For new folder -->
    <div class="create-newitem-container" id="containerNewFolder">
      <div class="create-newitem-header">
        <p>Create New Folder</p>
      </div>
      <div class="create-newitem-content">
        <form action="<?php echo base_url(); ?>Document/create_parent" method="POST">
          <div class="form-group">
            <label for="">Folder Name</label>
            <input class="form-control" type="text" name="folder_name" value="" placeholder="Folder Name" id="new-folder">
            <input type="hidden" name="pid" value="<?php echo $id; ?>" placeholder="Folder Name">
          </div>

        </div>
        <div class="create-newitem-footer">
          <button type="button" name="button" class="button-default" onclick="closeContainer()" style="margin-right:20px">Cancel</button>
          <button type="submit" name="button" class="button-primary create" onclick="closeContainer()" id="checkCreateFolder">Create</button>
        </div>
      </form>
    </div>

    <!-- For new workflow -->
    <div class="create-newitem-container" id="containerNewWorkflow">
      <div class="create-newitem-header">
        <p>Create New Workflow</p>
      </div>
      <div class="create-newitem-content">
        <!--<form action="<?php echo base_url(); ?>Document/create_parent" method="POST">-->
          <div class="form-group">
            <label for="">Workflow Name</label>
            <input class="form-control" type="text" name="workflow_name" value="" placeholder="Workflow Name" id="workflow-name">
          </div>
          <div class="form-group">
            <label for="">Category</label>
            <select class="form-control" name="">
              <option value="" style="padding:10px">Category 1</option>
              <option value="" style="padding:10px">Category 2</option>
              <option value="" style="padding:10px">Category 3</option>
            </select>
          </div>
        </div>
        <div class="create-newitem-footer">
          <button type="button" name="button" class="button-default" onclick="closeContainer()" style="margin-right:20px">Cancel</button>
          <button type="submit" name="button" class="button-primary create" onclick="closeContainer(); goToWorkflowDesigner();" id="checkCreateWorkflow">Create</button>
        </div>
      <!--</form>-->
    </div>

    <!-- For delete -->
    <div class="create-newitem-container" id="containerDelete">
        <div class="create-newitem-header">
            <p>Delete</p>
        </div>
        <div class="create-newitem-content">
            <div class="form-group">
                <p id="delete-info"></p>
            </div>
        </div>
        <div class="create-newitem-footer">
            <button type="button" name="button" class="button-danger create" onclick="confirmDelete()" id="checkDelete"
                    style="margin-right:20px">Delete
            </button>
            <button type="button" name="button" class="button-default" onclick="closeContainer()">Cancel</button>
        </div>
    </div>

    <!-- For rename folder -->
    <div class="create-newitem-container" id="containerRenameFolder">
      <div class="create-newitem-header">
        <p>Rename Content</p>
      </div>
      <div class="create-newitem-content">
        <form action="<?php echo base_url(); ?>Document/renamefile" method="POST">
          <div class="form-group">
            <label for="">New Name</label>
            <input class="form-control" type="text" name="filename" id="name" placeholder="Folder Name" >
            <input class="form-control" id="idrename" type="hidden" name="pid">
            <input class="form-control" id="folder" type="hidden" name="folder">
          </div>
        </div>
        <div class="create-newitem-footer">
          <button type="button" name="button" class="button-default" onclick="closeContainer()" style="margin-right:20px">Cancel</button>
          <button type="submit" name="button" class="button-primary create" onclick="closeContainer()" id="checkRename">Rename</button>
        </div>
      </form>
    </div>

    <!-- For preview -->
    <div class="preview-container">
      <div class="preview-header">
        <ul class="pull-left">
          <li>
            <img src="<?php echo base_url(); ?>/assets/SVG_dark/back_arrow_dark.svg" alt="" height="auto"
            width="18" onclick="closePreview()">
          </li>
          <li><a>Back to Document Folder</a></li>
        </ul>
        <ul class="pull-right">
          <li>
            <!-- <button type="button" class="share button-primary">Share</button> -->
          </li>
          <li>
            <a type="button" class="button-default" id="downloadprev" download="filename">Download</a>
          </li>
          <li style="margin-right:0">
            <img src="<?php echo base_url(); ?>/assets/SVG_dark/comment.svg" alt=""
              height="auto" width="24" onclick="openComment()">
          </li>
        </ul>
      </div>
      <div class="preview-content" id="preview-content">
        <div class="reader" id="reader-content">
        </div>
      </div>
      <!-- For preview comment -->
      <div class="preview-comment" id="preview-comment">
        <!-- Tab menu for Comment column -->
        <div class="tab">
          <button class="tablinks" onclick="openTab(event, 'Comment')" id="defaultOpen">Comment</button>
          <button class="tablinks" onclick="openTab(event, 'History')">Details</button>
          <a href="javascript:void(0)" class="closebtn" onclick="closeComment()">&times;</a>
        </div>

        <!-- Tab content for tab menu content -->
        <div id="Comment" class="tabcontent">
          <div class="comment-container">
            <ul>
              <li class="message-item">
                <div class="profile-img">
                  <img src="<?php echo base_url(); ?>assetsnew/img/user1.jpg" alt="" width="40"
                  height="auto" class="img-circle">
                </div>
                <div class="message-info">
                  <p class="sender">Dhika</p><span class="time">04 Apr | 09:00</span>
                  <p class="message-description">Nanti ini tolong untuk dikerjakan</p>
                </div>
              </li>

              <li class="message-item">
                <div class="profile-img">
                  <img src="<?php echo base_url(); ?>assetsnew/img/user6.jpg" alt="" width="40"
                  height="auto" class="img-circle">
                </div>
                <div class="message-info">
                  <p class="sender">Diar</p><span class="time">04 Apr | 09:05</span>
                  <p class="message-description">Siap</p>
                </div>
              </li>

              <li class="message-item">
                <div class="profile-img">
                  <img src="<?php echo base_url(); ?>assetsnew/img/user8.jpg" alt="" width="40"
                  height="auto" class="img-circle">
                </div>
                <div class="message-info">
                  <p class="sender">Guntur</p><span class="time">04 Apr | 09:07</span>
                  <p class="message-description">Untuk file terbaru sudah saya push di git. Silahkan untuk
                    di cek.</p>
                </div>
              </li>

              <li class="message-item">
                <div class="profile-img">
                    <img src="<?php echo base_url(); ?>assets/SVG_dark/user.svg" alt="" width="40"
                    height="auto" class="img-circle">
                </div>
                <div class="message-info">
                    <p class="sender">Mas Bit</p><span class="time">04 Apr | 09:10</span>
                    <p class="message-description">Mantap</p>
                </div>
              </li>

            </ul>
          </div>
          <div class="send-comment">
              <textarea name="comment" form="usrform" placeholder="Type message here"></textarea>
              <button type="button" name="button" class="button-secondary pull-right">Send</button>
          </div>
        </div>

        <div id="History" class="tabcontent">
          <p>Ganti dengan isi konten</p>
        </div>
      </div>
    </div>

    <!--for add group-->
    <div class="create-newitem-container" id="containerAddGroups">
      <div class="create-newitem-header">
        <p>Add Group</p>
      </div>
      <div class="create-newitem-content">
        <form class="form-vertical" action="<?php echo base_url();?>Groups/insert" method="POST">
          <div class="form-group">
            <label for="">Group  Name</label>
            <input class="form-control" type="text" name="GROUP_NAME" maxlength="20" id="GROUP_NAME" placeholder="Groups Name">
          </div>
        </div>
        <div class="create-newitem-footer">
          <button type="button"  class="button-default" onclick="closeContainer()" style="margin-right:20px">Cancel</button>
          <button type="submit"  class="button-primary create" onclick="closeContainer()" id="addgroup-button-create">Create</button>
        </div>
      </form>
    </div>

    <!--for edit group-->
    <div class="create-newitem-container" id="containerEditGroups">
      <div class="create-newitem-header">
        <p>Edit Group</p>
      </div>
      <div class="create-newitem-content">
        <form class="form-vertical" action="<?php echo base_url();?>Groups/insert" method="POST">
          <div class="form-group">
            <label for="">Group Name</label>
            <input class="form-control" type="text" name="GROUP_NAME" maxlength="20" id="GROUP_editNAME" placeholder="Groups Name">
            <input class="form-control" type="hidden" name="GROUP_ID" maxlength="20" id="GROUP_ID" placeholder="Groups Name">
          </div>
        </div>
        <div class="create-newitem-footer">
          <button type="button"  class="button-default" onclick="closeContainer()" style="margin-right:20px">Cancel</button>
          <button type="submit"  class="button-primary create" onclick="closeContainer()" id="editgroup-button-create">Create</button>
        </div>
      </form>
    </div>

    <!--for share-->
    <div class="create-newitem-container" id="containerShare">
      <div class="create-newitem-header">
        <p>Share</p>
      </div>
      <div class="create-newitem-content">
        <div class="form-group">
          <label for="">Set Link Expiration</label>
          <input type="datetime-local" name="" value="" id="date-expiration" class="form-control">
        </div>
        <div class="form-group">
          <p class="share-link" id="get-link" onclick="getlink()">Get Sharable link</p><span class="sharable-icon"><i class="fa fa-link"></i></span>
        </div>
        <div class="form-group" id="link-share">
          <label for="">Link for sharing</label>
          <input type="text" name="" value="" class="form-control" id="share-link">
          <p class="no-padding-x share-link">Copy Link</p>
        </div>
      </div>
      <div class="create-newitem-footer">
        <button type="button" name="button" class="button-default" onclick="closeContainer()" style="margin-right:20px">Cancel</button>
        <button type="submit" name="button" class="button-primary create" onclick="sharelink()">Done</button>
      </div>
    </div>

    <!-- Side wrapper for menu container -->
    <div class="side-wrapper">
      <div class="logo">
        <img src="<?php echo base_url(); ?>/assets/img/logo-01.svg" alt="" height="auto" width="130">
      </div>
      <div class="sidebar-menu">
        <nav>
          <ul class="no-padding">
            <?php echo getMenuList(); ?>
          </ul>
        </nav>
      </div>
    </div>

    <!-- Content wrapper for main container -->
    <div class="content-wrapper">
      <header class="header-content">
        <div class="row">
          <nav>
            <div class="col-8">
              <ul id="menu-title">
                <li>
                  <p id="title"></p>
                </li>
              </ul>
              <ul id="menu-add">
                <li class="menu-horizontal "id="uploadHide">
                  <form id="myform" class="form-horizontal" action="<?php echo base_url(); ?>Document/upload" method="POST" enctype="multipart/form-data">
                    <label for="file-upload" class="button-primary button-radius">Upload</label>
                    <input type="text" name="pid" id="pid" style='display: none' value="<?php echo $id; ?>">
                    <input id="file-upload" type="file" name="filetoupload" onchange='uploadfile()'/>
                  </form>
                </li>
                <li class="menu-horizontal" style="position:relative">
                  <button type="button" name="button" class="button-secondary button-radius" id="CreateNew">Create New</button>
                  <div class="menu-container">
                    <ul>
                      <li onclick="toggleContainer('NewFolder')">Folder</li>
                      <!--<a href="<?php echo base_url('Workflow/create_workflow')?>"><li id="create_wf" onclick="create_workflow()">Workflow</li></a>-->
                      <li onclick="toggleContainer('NewWorkflow')">Workflow</li>
		                </ul>
                  </div>
                </li>
                <li class="menu-horizontal" style="width:350px">
                  <div id="myProgress" class="div_hide" style="display: none;">
                        <div id="myBar">0%</div>
                    </div>
                </li>
              </ul>
            </div>

            <div class="col-4">
              <ul class="text-right no-padding">
                <li class="menu-horizontal">
                  <a href="#" title="Notifikasi"><i class="fa fa-bell-o" aria-hidden="true" id="notif"></i></a>
                </li>
                <li class="menu-horizontal">
                  <a href="#" title="User Profile"><i class="fa fa-user-circle-o" aria-hidden="true" id="user"></i></a>
                </li>
                <li class="menu-horizontal">
                  <a href="<?php echo base_url(); ?>Login/logmeout" title="Log Out"><i class="fa fa-sign-out" aria-hidden="true"></i></a>
                </li>
              </ul>
            </div>
          </nav>
        </div>
      </header>
      <script type="text/javascript" src="<?php echo base_url(); ?>assetsnew/js/jquery-1.12.4.js"></script>
      <script src="<?php echo base_url();?>assets/assets/js/workflow.js"></script>
      <div class="main-content" id="main">
        {content}
      </div>
    </div>
  </div>
</body>
<script type="text/javascript" src="<?php echo base_url(); ?>assetsnew/js/classie.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assetsnew/js/notificationFx.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assetsnew/plugins/datatables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assetsnew/plugins/datatables/js/responsive.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assetsnew/plugins/icheck/icheck.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assetsnew/js/pdfobject.js"></script>
<script type="text/javascript" src='<?php echo base_url(); ?>assetsnew/plugins/fullcalendar/lib/moment.min.js'></script>
<script type="text/javascript" src='<?php echo base_url(); ?>assetsnew/plugins/fullcalendar/fullcalendar.min.js'></script>
<script type="text/javascript" src='<?php echo base_url(); ?>assetsnew/plugins/fullcalendar/data.js'></script>
<script type="text/javascript">

//For change the page to workflow designer
function goToWorkflowDesigner(){
  window.location = "<?php echo base_url('Workflow/create_workflow')?>"
};

// For add group
function addGroups($id, $folder, $name) {
    $("#name").attr("value", $name);
}

// For edit group
function editGroups($id, $name) {
    $("#GROUP_editNAME").attr("value", $name);
    $("#GROUP_ID").attr("value", $id);
}

// Share click to toggle share container
function shareClick(){
  $('.share-container').toggleClass('shown');
  if ($('.share-container').hasClass('shown')) {
      $(".option-container").removeClass("shown");
      $("#cover").css("display", "block");
      $("#cover").css("z-index", "6");
      document.getElementById('share-target').focus();
  }
  else {
      $("#cover").css("display", "none");
      $("#cover").css("z-index", "4");
  }
}

// For close share container
function closeShare() {
    $(".share-container").removeClass("shown");
    $("#cover").css("display", "none");
    $("#cover").css("z-index", "4");
}


// Initialize dataTable
$('#list-view').DataTable({
"responsive": true,
"paging": true,
"bLengthChange": false,
"ordering": false,
"searching": true,
"info": true,
"pageLength": 20,
});

// For treeviemenu toggle
var treeview = document.getElementsByClassName("treeview-menu");
  var x;

  for (x = 0; x < treeview.length; x++) {
    treeview[x].addEventListener("click", function () {
      this.classList.toggle("expand");
      var tree = this.nextElementSibling;
      if (tree.style.maxHeight) {
        tree.style.maxHeight = null;
      } else {
        tree.style.maxHeight = tree.scrollHeight + "px";
      }
    });
  }

// For open folder
function openFolder(id) {
window.location = "<?php echo base_url();?>Document/openfolder/" + id;
}

//For toggle rename container
function renameContent($id, $folder, $name) {

  $('#containerRenameFolder').toggleClass('shown');
  $("#idrename").attr("value", $id);
  $("#folder").attr("value", $folder);
  $("#name").attr("value", $name);
  if ($('#containerRenameFolder').hasClass('shown')) {
    $("#cover").css("display", "block");
    document.getElementById('name').focus();
    $(".create-new-container").removeClass("shown");
  } else {
    $("#cover").css("display", "none");
  }
}

//For toggle share container
function deleteContent($id, $folder, $name) {
  $('#containerDelete').toggleClass('shown');
  if ($('#containerDelete').hasClass('shown')) {
    $(".create-new-container").removeClass("shown");
    $("#cover").css("display", "block");
  } else {
    $("#cover").css("display", "none");
  }
}

//For toggle share container
function shareContent() {
  $('#containerShare').toggleClass('shown');
  if ($('#containerShare').hasClass('shown')) {
    $("#cover").css("display", "block");
    $(".create-new-container").removeClass("shown");
  } else {
    $("#cover").css("display", "none");
  }
}

//For toggle container menu (new folder, rename, addgroup, edit group, etc.)
function toggleContainer(id){
  $('#container'+id+'').toggleClass('shown');
  if ($('#container'+id+'').hasClass('shown')) {
    $("#cover").css("display","block");
    $(".menu-container").removeClass("shown");
    if (id === "NewFolder") {
      if($('#new-folder').val().length !=0){
        $('#checkCreateFolder').attr('disabled', false);
      }
      else{
        $('#checkCreateFolder').attr('disabled',true);
      }
    }
    else if (id === "RenameFolder") {
      if($('#name').val().length !=0){
        $('#checkRename').attr('disabled', false);
      }
      else{
        $('#checkRename').attr('disabled',true);
      }
    }
    else if (id === "NewWorkflow") {
      if($('#workflow-name').val().length !=0){
        $('#checkCreateWorkflow').attr('disabled', false);
      }
      else{
        $('#checkCreateWorkflow').attr('disabled',true);
      }
    }
    else if (id == "AddGroups") {
      if($('#GROUP_NAME').val().length !=0){
        $('#addgroup-button-create').attr('disabled', false);
      }
      else{
        $('#addgroup-button-create').attr('disabled',true);
      }
    }
    else if (id == "EditGroups") {
      if($('#GROUP_editNAME').val().length !=0){
        $('#editgroup-button-create').attr('disabled', false);
      }
      else{
        $('#editgroup-button-create').attr('disabled',true);
      }
    }
  }
  else {
    $("#cover").css("display","none");
  }
};

//For close container menu
function closeContainer(){
  $(".create-newitem-container").removeClass("shown");
  $("#cover").css("display","none");
  $('#delete-info').html("");
};

//For toogle more option menu
function toggleMenu(id,number){

  $('#menu'+id+'').toggleClass('shown');
  if ($('#menu'+id+"").hasClass('shown')) {
    $("#Option"+number+"").css("background-color","#f3f3f3");
  }
  else {
    $("#Option"+number+"").css("background-color","transparent");
  }
};

// Close all active toggled container when clicking anywhere in document
$(document).click(function (e) {
  if (!$(e.target).parents().andSelf().is('.morevert')) {
    $(".option-container").removeClass("shown");
    $(".morevert img").css("background-color","transparent");
  }
});

$(".option-container").click(function (e) {
  e.stopPropagation();
});

// For upload file
  function uploadfile() {
      upload(buildFormData());
  }
  function upload(data) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "<?php echo base_url(); ?>Document/upload", true);
    if (xhr.upload) {
      xhr.upload.onprogress = function (e) {
        if (e.lengthComputable) {

          var progressBar = document.getElementById("myBar");
          var progress = 0;
          var id = setInterval(frame, 10);

          function frame() {
            if (progress >= 100) {
              clearInterval(id);
            } else {
              progress++;
              progressBar.style.width = progress + '%';
              progressBar.innerHTML = progress * 1 + '%';
            }
          }
        }
      };

      xhr.upload.onloadstart = function (e) {
        $('#myProgress').show();
      };

      xhr.upload.onloadend = function (e) {
        document.forms.myform.submit();
      }
    }

    xhr.send(data);
  }

  function buildFormData() {
    var fd = new FormData();
    for (var i = 0; i < 3000; i += 1) {
      fd.append('data[]', Math.floor(Math.random() * 999999));
    }

    return fd;
  }

  function closePreview() {
    $(".preview-container").removeClass("shown");
    $("#cover").css("display", "none");
    //$('#video').stopVideo();
}

// For open comment container in preview file
  function openComment() {
    document.getElementById('preview-comment').style.width = "330px";
    document.getElementById('preview-comment').style.right = "0";
    document.getElementById('preview-content').style.width = "69.51%";
}

// For close comment container in preview file
function closeComment() {
    document.getElementById('preview-comment').style.width = "0px";
    document.getElementById('preview-comment').style.right = "-20px";
    document.getElementById('preview-content').style.width = "96.85%";
}

// For toggling tab menu in preview file
function openTab(evt, target) {
// Declare all variables
var i, tabcontent, tablinks;

// Get all elements with class="tabcontent" and hide them
tabcontent = document.getElementsByClassName("tabcontent");
for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
}

// Get all elements with class="tablinks" and remove the class "active"
tablinks = document.getElementsByClassName("tablinks");
for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
}

// Show the current tab, and add an "active" class to the button that opened the tab
document.getElementById(target).style.display = "block";
evt.currentTarget.className += " active";
}

$(document).ready(function(){

  // Get link when sahre file
  $('#get-link').click(function(){
    $('#link-share').css('display','block');
  });

  // Check if folder name text field is empty or not and disabled button save
  $('#new-folder').keyup(function(){
      if($(this).val().length !=0)
          $('#checkCreateFolder').attr('disabled', false);
      else
          $('#checkCreateFolder').attr('disabled',true);
  });
  $('#workflow-name').keyup(function(){
      if($(this).val().length !=0)
          $('#checkCreateWorkflow').attr('disabled', false);
      else
          $('#checkCreateWorkflow').attr('disabled',true);
  });
  $('#name').keyup(function(){
      if($(this).val().length !=0)
          $('#checkRename').attr('disabled', false);
      else
          $('#checkRename').attr('disabled',true);
  });
  $('#GROUP_NAME').keyup(function(){
      if($(this).val().length !=0)
          $('#addgroup-button-create').attr('disabled', false);
      else
        $('#addgroup-button-create').attr('disabled', true);
  });
  $('#GROUP_editNAME').keyup(function(){
      if($(this).val().length !=0)
          $('#editgroup-button-create').attr('disabled', false);
      else
        $('#editgroup-button-create').attr('disabled', true);
  });

  //share target on text Change
  $('#share-target').keypress(function () {
      $('#add-note').css("display", "block");
  });
  $('#share-target').blur(function () {
      if (!$(this).val()) {
          $('#add-note').css("display", "none");
      }
  });

  //For toggle create new container
$('#CreateNew').click(function(){
  $('.menu-container').toggleClass('shown');
})
$(document).click(function (e) {
  if (!$(e.target).parents().andSelf().is('#CreateNew')) {
    $(".menu-container").removeClass("shown");
  }
});
$(".menu-container").click(function (e) {
  e.stopPropagation();
});
});

</script>
  <?php echo $this->session->flashdata('document');?>
</html>
