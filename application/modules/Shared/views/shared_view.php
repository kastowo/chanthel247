<?php
$CIobj = &get_instance();
$user = $this->session->userdata("user");
$pass = $this->session->userdata("pass");
$ip = $CIobj->config->item('url_chantel');
$api = $CIobj->config->item('api_key');
$folderid = $this->session->userdata('id');
?>

<div class="row">
  <div class="col-6 no-padding-y">
    <ul class=" breadcrumb">
      <li class="header">Shared</li>

    </ul>
  </div>
</div>
<div class="row">
  <div class="col-12 margin-y no-padding">
    <table id="list-view" class="hover" style="width:100%">
      <thead>
        <tr>
          <th class="adjust-width md">Name</th>
          <th>Size</th>
          <th></th>
        </tr>
      </thead>
      <tbody>

        <?php
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
          //            print_r($tree['data']);die();
          $v = $tree['data'];//print_r($tree['data']);die(); //foreach ($tree as $k => $v) {
            for ($i = 0; $i < sizeof($v); $i++) {
              $size = $v[$i]['size'];
              ?>
              <tr class="star">
                <?php if (($v[$i]['template_id'] == 6) && ($v[$i]['ext'] == "xlsx" || $v[$i]['ext'] == "xls")) { ?>
                  <td class="name" onclick="previewclick('<?php echo $v[$i]['id']; ?>')" style="cursor:pointer">
                    <img src="<?php echo base_url(); ?>/assets/SVG_dark/xls.svg" alt="" width="30px"
                    height="30px" style="margin-right:20px; float: left">
                    <p><?php echo substr($v[$i]['name'], 0, 15) . '...'; ?></p>
                  </td>
                <?php } elseif ($v[$i]['template_id'] == 5) { ?>
                  <td ondblclick="openFolder('<?php echo $v[$i]['id']; ?>')" style="cursor:pointer">
                    <img ondblclick="openFolder('<?php echo $v[$i]['id']; ?>')"
                    src="<?php echo base_url(); ?>/assets/SVG_dark/blue_folder.svg" alt="" width="30px"
                    height="30px" style="margin-right:20px; float: left">
                    <p><?php echo $v[$i]['name']; ?></p>
                  </td>
                <?php } elseif (($v[$i]['template_id'] == 6) && ($v[$i]['ext'] == "pdf")) { ?>
                  <td class="name" onclick="previewclick('<?php echo $v[$i]['id']; ?>')" style="cursor:pointer">
                    <img src="<?php echo base_url(); ?>/assets/SVG_dark/pdf.svg" alt="" width="30px"
                    height="30px" style="margin-right:20px; float: left">
                    <p><?php echo substr($v[$i]['name'], 0, 15) . '...'; ?></p>
                  </td>
                <?php } elseif (($v[$i]['template_id'] == 6) && ($v[$i]['ext'] == "doc" || $v[$i]['ext'] == "docx" || $v[$i]['ext'] == "odt")) { ?>
                  <td class="name" onclick="previewclick('<?php echo $v[$i]['id']; ?>')" style="cursor:pointer">
                    <img src="<?php echo base_url(); ?>/assets/SVG_dark/doc.svg" alt="" width="30px"
                    height="30px" style="margin-right:20px; float: left">
                    <p><?php echo substr($v[$i]['name'], 0, 15) . '...'; ?></p>
                  </td>
                <?php } elseif (($v[$i]['template_id'] == 6) && ($v[$i]['ext'] == "ppt" || $v[$i]['ext'] == "pptx")) { ?>
                  <td class="name" onclick="previewclick('<?php echo $v[$i]['id']; ?>')" style="cursor:pointer">
                    <img src="<?php echo base_url(); ?>/assets/SVG_dark/file-ppt.svg" alt="" width="30px"
                    height="30px" style="margin-right:20px; float: left">
                    <p><?php echo substr($v[$i]['name'], 0, 15) . '...'; ?></p>
                  </td>
                <?php } elseif (($v[$i]['template_id'] == 6) && ($v[$i]['ext'] == "mp4" || $v[$i]['ext'] == "avi" || $v[$i]['ext'] == "mov" || $v[$i]['ext'] == "mpeg" || $v[$i]['ext'] == "3gp" || $v[$i]['ext'] == "flv" || $v[$i]['ext'] == "swf")) { ?>
                  <td class="name" onclick="previewclick('<?php echo $v[$i]['id']; ?>')" style="cursor:pointer">
                    <img src="<?php echo base_url(); ?>/assets/SVG_dark/file-video.svg" alt="" width="30px"
                    height="30px" style="margin-right:20px; float: left">
                    <p><?php echo substr($v[$i]['name'], 0, 15) . '...'; ?></p>
                  </td>
                <?php } elseif (($v[$i]['template_id'] == 6) && ($v[$i]['ext'] == "jpg" || $v[$i]['ext'] == "png" || $v[$i]['ext'] == "gif" || $v[$i]['ext'] == "bmp" || $v[$i]['ext'] == "tiff")) { ?>
                  <td class="name" onclick="previewclick('<?php echo $v[$i]['id']; ?>')" style="cursor:pointer">
                    <img src="<?php echo base_url(); ?>/assets/SVG_dark/file-image.svg" alt="" width="30px"
                    height="30px" style="margin-right:20px; float: left">
                    <p><?php echo substr($v[$i]['name'], 0, 15) . '...'; ?></p>
                  </td>
                <?php } elseif (($v[$i]['template_id'] == 6) && ($v[$i]['ext'] == "zip" || $v[$i]['ext'] == "rar" || $v[$i]['ext'] == "tar.gz")) { ?>
                  <td class="name" onclick="previewclick('<?php echo $v[$i]['id']; ?>')" style="cursor:pointer">
                    <img src="<?php echo base_url(); ?>/assets/SVG_dark/archieved.svg" alt="" width="30px"
                    height="30px" style="margin-right:20px; float: left">
                    <p><?php echo substr($v[$i]['name'], 0, 15) . '...'; ?></p>
                  </td>
                <?php } else { ?>
                  <td class="name" onclick="previewclick('<?php echo $v[$i]['id']; ?>')" style="cursor:pointer">
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
                <?php if ($v[$i]['template_id'] == 5) { ?>
                  <td class="morevert">
                    <img id="Option<?php echo $i;?>" onclick="getName('<?php echo $v[$i]['id']; ?>,<?php echo $v[$i]['name']; ?>'); toggleMenu('Option<?php echo $i;?>' , '<?php echo $i;?>');"  src="<?php echo base_url(); ?>/assets/SVG_dark/more_vert.svg" alt="" width="12px" height="13px">
                    <div class="option-container" id="menuOption<?php echo $i;?>">
                      <ul>
                        <!--  <li>Preview</li>
                        <li onclick="shareClick()"><a href="#" id="share">Share</a></li> -->
                        <li>Bookmark</li>
                        <!-- <li onclick="downloadclick()"><a href="#" id="download">Download</a></li> -->
                        <!-- <li>Copy</li>
                        <li>Paste</li> -->
                        <li onclick="renamesclick()"><a href="#" id="rename">Rename</a></li>
                        <li><a href="<?php echo base_url(); ?>Shared/deletefolder/<?php echo $v[$i]['id']; ?>" onclick = "if(!confirm('Are you absolutely sure you want to delete <?php echo $v[$i]['name']; ?> ? ')) return false;"  id="delete">Delete</a></li>
                        <li>Version History</li>
                      </ul>
                    </div>
                  </td>
                <?php } else { ?>
                  <td class="morevert">
                    <img
                    onclick="getName('<?php echo $v[$i]['id']; ?>,<?php echo $v[$i]['name']; ?>,<?php echo $user; ?>,<?php echo $pass; ?>,file'); toggleMenu('Option<?php echo $i; ?>','<?php echo $i; ?>');"
                    id="Option<?php echo $i; ?>"
                    src="<?php echo base_url(); ?>/assets/SVG_dark/more_vert.svg" alt="" width="12px"
                    height="13px">
                    <div class="option-container" id="menuOption<?php echo $i; ?>">
                      <ul>
                        <li onclick="previewclick('<?php echo $v[$i]['id']; ?>')"><a href="#"
                          id="preview"></a>Preview
                        </li>
                        <li>
                          <a href="<?php echo $ip; ?>/<?php echo $api; ?>/index.php?u=<?php echo $user; ?>&p=<?php echo $pass; ?>&act=download&fid=<?php echo $v[$i]['id']; ?>"
                            download="<?php echo $v[$i]['name']; ?>">Download</a></li>
                            <li>Copy</li>
                            <li>Paste</li>
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

      <script type="text/javascript">

      $('#Public\\ Folder').addClass("active");

      function getName(obj) {
        var str = obj.toString();
        var res = str.split(",");

        $id = res[0];
        $name = res[1];
      }

      function renamesclick() {
        renameContent($id, 'folder', $name);
      }

      function deleteclick() {
        $('#containerDelete').toggleClass('shown');
        if ($('#containerDelete').hasClass('shown')) {
          $("#cover").css("display", "block");
          $('#delete-info').append("<b>Are you absolutely sure you want to delete " + $name + "?</b>");
        } else {
          $("#cover").css("display", "none");
        }
      }

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

      function previewclick(id) {
        $('.preview-container').toggleClass('shown');
        if ($('.preview-container').hasClass('shown')) {
          $("#cover").css("display", "block");
          $(".option-container").removeClass("shown");

          $("#reader-content").html('<embed id="embeded" type="application/pdf" src="<?php echo base_url();?>Shared/preview/' + id + '" width="100%" height="600px" alt="pdf" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html" background-color="0xFF525659" top-toolbar-height="56">')
        }
        else {
          $("#cover").css("display", "none");
        }
      }
      document.getElementById('menu-title').style.display ="block";
      document.getElementById('menu-add').style.display ="none";
      document.getElementById('title').innerHTML="Public Folder";

      $(document).ready(function(){
        $("li").removeClass("active");
        $("#Shared").addClass("active");
      });

    </script>
