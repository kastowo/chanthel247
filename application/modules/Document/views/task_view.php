<?php
$CIobj = &get_instance();
$user = $this->session->userdata("user");
$pass = $this->session->userdata("pass");
$ip = $CIobj->config->item('url_chantel');
$api = $CIobj->config->item('api_key');
$folderid = $this->session->userdata('id');
?>
<!-- row begin -->
<div class="row">
  <div class="col-6 no-padding-y">
    <ul class=" breadcrumb">
      <li class="header">Documents</li>
    </ul>
  </div>
</div>
<!-- row end -->

<!-- row begin -->
<div class="row">
  <div class="col-12 margin-y no-padding">
    <table id="list-view" class="hover" style="width:100%">
      <thead>
        <tr>
          <th class="adjust-width md">Name</th>
          <th>Size</th>
          <th class="adjust-width md">Create Date</th>
          <th class="adjust-width md">Last Modified</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php
        // For formating file size
        function formatbytes($bytes)
        {
            if ($bytes == 0) {
                return '0 Bytes';
            }

            $k = 1024;
            $sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
            $i = floor(log($bytes) / log($k));
            echo round(($bytes / pow($k, $i))) + " ";
            echo " ";
            return $sizes[$i];

        } ?>

        <?php
        if ($tree['error_code'] == 0) {
          $v = $tree['data'];
          for ($i = 0; $i < sizeof($v); $i++) {
            $size = $v[$i]['size'];
            ?>
            <tr class="star">
              <?php if (($v[$i]['template_id'] == 6) && ($v[$i]['ext'] == "xlsx" || $v[$i]['ext'] == "xls")) { ?>
                <td onclick="previewclick('<?php echo $v[$i]['id']; ?>','<?php echo $v[$i]['ext']; ?>','<?php echo $v[$i]['name']; ?>')"  class="clickable">
                  <img src="<?php echo base_url(); ?>/assets/SVG_dark/xls.svg" alt="" width="30px"
                  height="30px" style="margin-right:20px; float: left">
                  <p><?php echo substr($v[$i]['name'], 0, 15) . '...'; ?></p>
                </td>
              <?php } elseif ($v[$i]['template_id'] == 5) { ?>
                <td onclick="openFolder('<?php echo $v[$i]['id']; ?>')" class="clickable">
                  <img onclick="openFolder('<?php echo $v[$i]['id']; ?>')"
                  src="<?php echo base_url(); ?>/assets/SVG_dark/blue_folder.svg" alt="" width="30px"
                  height="30px" style="margin-right:20px; float: left">
                  <p><?php echo $v[$i]['name']; ?></p>
                </td>
              <?php } elseif (($v[$i]['template_id'] == 6) && ($v[$i]['ext'] == "pdf")) { ?>
                <td  onclick="previewclick('<?php echo $v[$i]['id']; ?>','<?php echo $v[$i]['ext']; ?>','<?php echo $v[$i]['name']; ?>')" class="clickable">
                  <img src="<?php echo base_url(); ?>/assets/SVG_dark/pdf.svg" alt="" width="30px"
                  height="30px" style="margin-right:20px; float: left">
                  <p><?php echo substr($v[$i]['name'], 0, 15) . '...'; ?></p>
                </td>
              <?php } elseif (($v[$i]['template_id'] == 6) && ($v[$i]['ext'] == "doc" || $v[$i]['ext'] == "docx" || $v[$i]['ext'] == "odt")) { ?>
                <td  onclick="previewclick('<?php echo $v[$i]['id']; ?>','<?php echo $v[$i]['ext']; ?>','<?php echo $v[$i]['name']; ?>')" class="clickable">
                  <img src="<?php echo base_url(); ?>/assets/SVG_dark/doc.svg" alt="" width="30px"
                  height="30px" style="margin-right:20px; float: left">
                  <p><?php echo substr($v[$i]['name'], 0, 15) . '...'; ?></p>
                </td>
              <?php } elseif (($v[$i]['template_id'] == 6) && ($v[$i]['ext'] == "ppt" || $v[$i]['ext'] == "pptx")) { ?>
                <td onclick="previewclick('<?php echo $v[$i]['id']; ?>','<?php echo $v[$i]['ext']; ?>','<?php echo $v[$i]['name']; ?>')"  class="clickable">
                  <img src="<?php echo base_url(); ?>/assets/SVG_dark/file-ppt.svg" alt="" width="30px"
                  height="30px" style="margin-right:20px; float: left">
                  <p><?php echo substr($v[$i]['name'], 0, 15) . '...'; ?></p>
                </td>
              <?php } elseif (($v[$i]['template_id'] == 6) && ($v[$i]['ext'] == "mp4" || $v[$i]['ext'] == "avi" || $v[$i]['ext'] == "mov" || $v[$i]['ext'] == "mpeg" || $v[$i]['ext'] == "3gp" || $v[$i]['ext'] == "flv" || $v[$i]['ext'] == "swf")) { ?>
                <td onclick="previewclick('<?php echo $v[$i]['id']; ?>','<?php echo $v[$i]['ext']; ?>','<?php echo $v[$i]['name']; ?>')" class="clickable">
                  <img src="<?php echo base_url(); ?>/assets/SVG_dark/file-video.svg" alt="" width="30px"
                  height="30px" style="margin-right:20px; float: left">
                  <p><?php echo substr($v[$i]['name'], 0, 15) . '...'; ?></p>
                </td>
              <?php } elseif (($v[$i]['template_id'] == 6) && ($v[$i]['ext'] == "jpg" || $v[$i]['ext'] == "png" || $v[$i]['ext'] == "gif" || $v[$i]['ext'] == "bmp" || $v[$i]['ext'] == "tiff")) { ?>
                <td onclick="previewclick('<?php echo $v[$i]['id']; ?>','<?php echo $v[$i]['ext']; ?>','<?php echo $v[$i]['name']; ?>')" class="clickable">
                  <img src="<?php echo base_url(); ?>/assets/SVG_dark/file-image.svg" alt="" width="30px"
                  height="30px" style="margin-right:20px; float: left">
                  <p><?php echo substr($v[$i]['name'], 0, 15) . '...'; ?></p>
                </td>
              <?php } elseif (($v[$i]['template_id'] == 6) && ($v[$i]['ext'] == "zip" || $v[$i]['ext'] == "rar" || $v[$i]['ext'] == "tar.gz")) { ?>
                <td onclick="previewclick('<?php echo $v[$i]['id']; ?>','<?php echo $v[$i]['ext']; ?>','<?php echo $v[$i]['name']; ?>')" class="clickable">
                  <img src="<?php echo base_url(); ?>/assets/SVG_dark/archieved.svg" alt="" width="30px"
                  height="30px" style="margin-right:20px; float: left">
                  <p><?php echo substr($v[$i]['name'], 0, 15) . '...'; ?></p>
                </td>
              <?php } else { ?>
                <td onclick="previewclick('<?php echo $v[$i]['id']; ?>','<?php echo $v[$i]['ext']; ?>','<?php echo $v[$i]['name']; ?>')"class="clickable">
                  <img src="<?php echo base_url(); ?>/assets/SVG_dark/file-txt.svg" alt="" width="30px"
                  height="30px" style="margin-right:20px; float: left">
                  <p><?php echo substr($v[$i]['name'], 0, 15) . '...'; ?></p>
                </td>
              <?php } ?>

              <?php if ($v[$i]['template_id'] == 5) { ?>
                <td></td>
              <?php } else { ?>
                <td><?php echo formatbytes($size); ?></td>
              <?php } ?>
                <td><?php echo $v[$i]['cdate']; ?></td>
                <td><?php echo $v[$i]['udate']; ?></td>
              <?php if ($v[$i]['template_id'] == 5) { ?>
                <td class="morevert">
                  <img id="Option<?php echo $i;?>" onclick="getName('<?php echo $v[$i]['id']; ?>,<?php echo $v[$i]['name']; ?>'); toggleMenu('Option<?php echo $i;?>' , '<?php echo $i;?>');"  src="<?php echo base_url(); ?>/assets/SVG_dark/more_vert.svg" alt="" width="12px" height="13px">
                  <div class="option-container" id="menuOption<?php echo $i;?>">
                    <ul>
                      <li>Bookmark</li>
                      <li onclick="renameContent('<?php echo $v[$i]['id']; ?>', 'folder', '<?php echo $v[$i]['name']; ?>')"><a href="#" id="rename">Rename</a></li>
                      <li onclick="deleteclick()">Delete</li>
                      <li>Version History</li>
                    </ul>
                  </div>
                </td>
              <?php }
              else { ?>
                <td class="morevert">
                  <img onclick="getName('<?php echo $v[$i]['id']; ?>,<?php echo $v[$i]['name']; ?>,<?php echo $user; ?>,<?php echo $pass; ?>,file'); toggleMenu('Option<?php echo $i; ?>','<?php echo $i; ?>');"
                  id="Option<?php echo $i; ?>" src="<?php echo base_url(); ?>/assets/SVG_dark/more_vert.svg" alt="" width="12px"height="13px">
                  <div class="option-container" id="menuOption<?php echo $i; ?>">
                    <ul>
                      <li onclick="previewclick('<?php echo $v[$i]['id']; ?>','<?php echo $v[$i]['ext']; ?>')"><a href="#" id="preview"></a>Preview</li>
                      <li>
                        <a href="<?php echo $ip; ?>/<?php echo $api; ?>/index.php?u=<?php echo $user; ?>&p=<?php echo $pass; ?>&act=download&fid=<?php echo $v[$i]['id']; ?>"
                          download="<?php echo $v[$i]['name']; ?>">Download</a>
                      </li>
                      <li onclick="shareContent()"><a href="#" id="share">Share</a></li>
                      <li>Copy</li>
                      <li>Paste</li>
                      <li onclick="renameContent('<?php echo $v[$i]['id']; ?>', 'folder', '<?php echo $v[$i]['name']; ?>')"><a href="#" id="rename">Rename</a></li>
                      <li onclick="deleteclick()">Delete</li>
                      <li>Version History</li>
                    </ul>
                  </div>
                </td>
                  <?php } ?>
            </tr>
              <?php }
            } ?>
      </tbody>

    </table>

  </div>
</div>
<!-- row end -->

<script type="text/javascript">
// manipulate menu by adding active class
$('#Document').addClass("active");

// For get name and id file/folder
function getName(obj) {
  var str = obj.toString();
  var res = str.split(",");

  $id = res[0];
  $name = res[1];
}

// For rename
function renamesclick() {
  renameContent($id, 'folder', $name);
}

// For delete
function deleteclick() {
  $('#containerDelete').toggleClass('shown');
  if ($('#containerDelete').hasClass('shown')) {
    $(".create-new-container").removeClass("shown");
    $("#cover").css("display", "block");
    $('#delete-info').append("<b>Are you absolutely sure you want to delete " + $name + "?</b>");
  } else {
    $("#cover").css("display", "none");
  }
}

// Delete confirmation
function confirmDelete() {
  $('#delete-info').html("");
  $(".create-newitem-container").removeClass("shown");
  $("#cover").css("display", "none");
  var data = 'id=' + $id ;
  $.ajax({
    type: "POST",
    url: "<?php echo base_url();?>Document/deletefolder/",
    data: data,
    success: function (data) {
      window.location.reload(true);

    },
    error: function () {
      alert("Delete file is failed");
    }
  });
}

// For preview
function previewclick(id, ext, name) {
  if (ext == "mp4" || ext == "mp3" || ext == "png" || ext == "jpg" ){
    var data = 'id='+id+'&ext='+ext;
    $.ajax({
      type:"POST",
      url:"<?php echo base_url();?>Document/getpreviewi/",
      data:data,
      success:function(data){
        console.log(JSON.parse(data));
        $('.preview-container').toggleClass('shown');
        if ($('.preview-container').hasClass('shown'))
        {
          $("#downloadprev").attr("href", '<?php echo $ip; ?>/<?php echo $api; ?>/index.php?u=<?php echo $user; ?>&p=<?php echo $pass; ?>&act=download&fid='+id);
          $("#cover").css("display", "block");
          $(".option-container").removeClass("shown");
          if(ext == "mp4") {
            $("#reader-content").html("<video width='100%' height='auto' controls ><source src="+data+" type='video/mp4'></video>");
          }
          else if (ext == "png" || ext == "jpg"){
            $("#reader-content").html("<img src="+data+">");
          }
          else {
            $("#reader-content").html("<audio controls><source src="+data+" type='audio/mpeg'> </audio>");
          }

        }
        else {
          $("#cover").css("display", "none");
        }
      },
      error:function(){
        alert("Video failed load");
      }
    });
  }
  else {
    $('.preview-container').toggleClass('shown');
    if ($('.preview-container').hasClass('shown'))
    {
      $("#downloadprev").attr("href", '<?php echo $ip; ?>/<?php echo $api; ?>/index.php?u=<?php echo $user; ?>&p=<?php echo $pass; ?>&act=download&fid='+id);
      $("#cover").css("display", "block");
      $(".option-container").removeClass("shown");
      $("#reader-content").html('<embed id="embeded" type="application/pdf" src="<?php echo base_url();?>Document/preview/'+id+'" width="100%" height="600px" alt="pdf" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html" background-color="0xFF525659" top-toolbar-height="56">')
    }
    else {
      $("#cover").css("display", "none");
    }
  }
}

// For get link when share content
function getlink() {
  var dates = new Date($('#date-expiration').val());
  var dataEnd = dates.getTime() / 1000;
  var linkup = "<?php echo $ip; ?>" + "/" +  "<?php echo $api; ?>" + "/index.php?u=" +  "<?php echo $user; ?>" + "&p=" +  "<?php echo $pass; ?>" + "&act=share_up&fid=" + $id + "&endtime=" + dataEnd;
  var link = document.getElementById('share-link');
  link.setAttribute("value", linkup);
  $('.sharable-link').css("display", "block");
}

// For share link
function sharelink() {
  $url = "<?php echo base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/' . $this->uri->segment(3) . '/' . $this->uri->segment(4); ?>";
  var dates = new Date($('#date-expiration').val());
  var dataEnd = dates.getTime() / 1000;
  var data = 'fid=' + $id + '&endtime=' + dataEnd;
  $.ajax({
    type: "POST",
    url: "<?php echo base_url();?>Document/share/",
    data: data,
    success: function (data) {
      alert(data);
      window.location = $url;
    },
    error: function () {
      alert("Video failed load");
    }
  });
}
</script>
