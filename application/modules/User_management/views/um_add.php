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

input[type=password], select, textarea {
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

<?php if($type=="Add"){$command="insert";}?>
<?php if($type=="Edit"){$command="update";}?>
<div class="content">
  <form action="<?php echo base_url();?>User_management/<?php echo $command; ?>" id="module_form" class="smart-form" novalidate="novalidate" method="POST">
  <!-- <input type="hidden" id="USER_ID" name="USER_ID" value="<?php echo @$d['USER_ID']?>" />
  <input type="hidden" id="USERNAME_ID" name="USERNAME_ID" value="<?php echo @$d['USERNAME']?>" /> -->
  <div class="row">
  	 <div class="col-25">
    <input type="text" class="form-control" name="username" maxlength="100" id = "username" placeholder="Username" />
    </div>
  </div>
  <div class="row">
   <div class="col-25">
    <input type="text" class="form-control" name="email" maxlength="100" id = "email" placeholder="Email" />
    </div>
  </div>
  <div class="row">
   <div class="col-25">
    <input type="password" class="form-control" name="password" maxlength="100" id = "password" placeholder="Password" />
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
document.getElementById('menu-title').style.display ="block";
document.getElementById('menu-add').style.display ="none";
document.getElementById('title').innerHTML="Add User";
</script>

<!-- <section id="widget-grid" class="">
	<div class="row">
		<article class="col-sm-12 col-md-12 col-lg-12">
			<div class="jarviswidget" id="wid-id-8" data-widget-editbutton="false" data-widget-custombutton="false">
				<header>
					<span class="widget-icon"> <i class="fa fa-folder"></i> </span>
					<h2><?php echo $type?> User</h2>
				</header>
				<div>
					<div class="jarviswidget-editbox">

					</div>
					<div class="widget-body no-padding">
							<?php if($type=="Add"){$command="insert";}?>
							<?php if($type=="Edit"){$command="update";}?>
							<form action="User_management/<?php echo $command;?>" id="newUser" class="smart-form" novalidate="novalidate" method="POST" name="newUser">
							<input type="hidden" id="USER_ID" name="USER_ID" value="<?php echo @$d['USER_ID']?>" />
							<input type="hidden" id="USERNAME_ID" name="USERNAME_ID" value="<?php echo @$d['USERNAME']?>" />
							<fieldset>
								<legend>User Information</legend>
								<div class="row">
									<section class="col col-5">
										<label class="input">
											<i class="icon-prepend fa fa-font"></i>
											<input type="text" name="NIK" maxlength="100" id = "NIK" placeholder="Nomor Induk Kepegawaian" value="<?php echo @$d['NIK']?>" />
											<b class="tooltip tooltip-bottom-left">Write NIK (Nomor Induk Kepegawaian)</b>
										</label>
										<div class="note">
											Write NIK (Nomor Induk Kepegawaian)
										</div>
										<div class="note">
											<i>*harus diisi</i>
										</div>
									</section>
									<section class="col col-5">
										<label class="input">
											<i class="icon-prepend fa fa-font"></i>
											<input type="text" name="FULLNAME" maxlength="100" id = "FULLNAME" placeholder="Fullname" value="<?php echo @$d['FULLNAME']?>" />
											<b class="tooltip tooltip-bottom-left">Write user fullname</b>
										</label>
										<div class="note">
											Write user fullname
										</div>
										<div class="note">
											<i>*harus diisi</i>
										</div>
									</section>
								</div>
								<div class="row">
									<section class="col col-5">
										<label class="input">
											<i class="icon-prepend fa fa-building"></i>
											<input type="text" name="DEPARTMENT_NAME" maxlength="100" id = "DEPARTMENT_NAME" placeholder="<?php echo $this->lang->line('module_user_management_ph_departement_name');?>" value="<?php echo @$d['DEPARTMENT_NAME']?>" />
											<b class="tooltip tooltip-bottom-left"><?php echo $this->lang->line('module_user_management_tooltip_departement_name');?></b>
										</label>
										<div class="note">
												<?php echo $this->lang->line('module_user_management_tooltip_departement_name');?>
										</div>
									</section>
								</div>
							</fieldset>
							<fieldset>

								<legend>User Account Data</legend>
								<div class="row">
									<section class="col col-5">
										<label class="input">
											<i class="icon-prepend fa fa-user"></i>
											<input type="text" name="USERNAME" maxlength="15" id = "USERNAME" autocomplete="off" placeholder="<?php echo $this->lang->line('module_user_management_ph_username');?>" value="<?php echo @$d['USERNAME']?>" />

											<b class="tooltip tooltip-bottom-left"><?php echo $this->lang->line('module_user_management_tooltip_username');?></b>
										</label>
										<div class="note">
											Write user login account
										</div>
										<div class="note">
											<i>*harus diisi</i>
										</div>
									</section>
									<section class="col col-5">
										<label class="select">
											<select id="GROUP_ID" name="GROUP_ID">
											<option disabled="" >Group Role</option>
											<?php
												foreach($group_list->result() as $row){
													if ($row->GROUP_ID == @$d['GROUP_ID']){
														$sel = ' selected="selected"';
													} else {
														$sel = '';
													}
													?>
													<option value="<?php echo $row->GROUP_ID?>"<?php echo $sel;?>><?php echo $row->GROUP_NAME?></option>
													<?php
												}
												?>
											</select>
											<i></i>
										</label>
										<div class="note">
											Select user workgroup
										</div>
									</section>
								</div>
								<div class="row">
									<section class="col col-5">
										<label class="input">
											<i class="icon-prepend fa fa-lock"></i>
											<input type="password" name="PASSWORD" maxlength="40" id = "PASSWORD" placeholder="Password" value="<?php echo @$d['PASSWORD']?>" />
											<b class="tooltip tooltip-bottom-left"><?php echo $this->lang->line('module_user_management_tooltip_password');?></b>
										</label>
										<div class="note">
												Set user password <strong><?php echo $this->lang->line('module_user_management_tooltip_password');?></strong>
										</div>
										<div class="note">
											<i>*harus diisi</i>
										</div>
									</section>
									<section class="col col-5">
										<label class="select">
											<select name="IS_LOGIN" id="IS_LOGIN">
													<option disabled="" <?php if(empty($d['IS_LOGIN'])){echo "selected='selected'";}?> value="">Login Status</option>
													<option value="N" <?php if(@$d['IS_LOGIN']=="N"){echo "selected='selected'";} ?>>No</option>
													<option value="Y" <?php if(@$d['IS_LOGIN']=="Y"){echo "selected='selected'";} ?>>Yes</option>
											</select>
											<i></i>
										</label>
										<div class="note">
											Set user login status manually, set to <strong>N</strong> to clear user session
										</div>
										<div class="note">
											<i>*harus diisi</i>
										</div>
									</section>
								</div>
							  <div class="row">

									<section class="col col-5">
										<label class="select">
											<select name="IS_BLOCK" id="IS_BLOCK">
													<option disabled="" <?php if(empty($d['IS_BLOCK'])){echo "selected='selected'";}?> value="">Block Status</option>
													<option value="N" <?php if(@$d['IS_BLOCK']=="N"){echo "selected='selected'";} ?>>No</option>
													<option value="Y" <?php if(@$d['IS_BLOCK']=="Y"){echo "selected='selected'";} ?>>Yes</option>
											</select>
											<i></i>
										</label>
										<div class="note">
												Set user block status
										</div>
										<div class="note">
											<i>*harus diisi</i>
										</div>
									</section>
									<section class="col col-5">
										<label class="select">
											<select name="FIRST_LOGIN" id="FIRST_LOGIN">
													<option disabled="" <?php if(empty($d['FIRST_LOGIN'])){echo "selected='selected'";}?> value="Y">Push Change Password</option>
													<option value="N" <?php if(@$d['FIRST_LOGIN']=="N"){echo "selected='selected'";} ?>>No</option>
													<option value="Y" <?php if(@$d['FIRST_LOGIN']=="Y"){echo "selected='selected'";} ?>>Yes</option>
											</select>
											<i></i>
										</label>
										<div class="note">
											Force user to change password
										</div>
									</section>
							  </div>
							  </fieldset>
							  <fieldset>
							  <legend><?php echo $this->lang->line('module_user_management_connectivity');?></legend>
							  <div class="row">
									<section class="col col-5">
										<label class="input">
											<i class="icon-prepend fa fa-phone"></i>
											<input type="text" name="MOBILE" maxlength="20" id = "MOBILE" placeholder="<?php echo $this->lang->line('module_user_management_ph_mobile_number');?>" value="<?php echo @$d['MOBILE']?>" />
											<b class="tooltip tooltip-bottom-left"><?php echo $this->lang->line('module_user_management_tooltip_mobile_number');?></b>
										</label>
										<div class="note">
											Write user mobile phone
										</div>
										<div class="note">
											<i>*harus diisi</i>
										</div>
									</section>
									<section class="col col-5">
										<label class="input">
											<i class="icon-prepend fa fa-envelope-o"></i>
											<input type="text" name="EMAIL" maxlength="100" id = "EMAIL" placeholder="E-Mail" value="<?php echo @$d['EMAIL']?>" />
											<b class="tooltip tooltip-bottom-left"><?php echo $this->lang->line('module_user_management_tooltip_email');?></b>
										</label>
										<div class="note">
											Write user email account
										</div>
										<div class="note">
											<i>*harus diisi</i>
										</div>
									</section>
							  </div>
							  <div class="row">
									<section class="col col-5">
										<label class="input">
											<i class="icon-prepend fa fa-skype"></i>
											<input type="text" name="SKYPE_ID" maxlength="100" id = "SKYPE_ID" placeholder="Skype ID" value="<?php echo @$d['SKYPE_ID']?>" />
											<b class="tooltip tooltip-bottom-left"><?php echo $this->lang->line('module_user_management_tooltip_skypeID');?></b>
										</label>
										<div class="note">
											Write user skype ID/account
										</div>
									</section>
									<section class="col col-5">
										<label class="input">
											<i class="icon-prepend fa fa-google-plus"></i>
											<input type="text" name="GOOGLE_ID" maxlength="100" id = "GOOGLE_ID" placeholder="Google ID" value="<?php echo @$d['GOOGLE_ID']?>" />
											<b class="tooltip tooltip-bottom-left"><?php echo $this->lang->line('module_user_management_tooltip_googleID');?></b>
										</label>
										<div class="note">
											Write user Google account
										</div>
									</section>
							  </div>
							</fieldset>
							<footer>
									<button class="btn btn-primary" type="submit" id="userSaveBtn">
										<i class="fa fa-save"></i>
										<?php echo $this->lang->line('module_user_management_save');?>
									</button>
									<a class="btn btn-default" id="cancel" href="#User_management">
										<i class="fa fa-rotate-left"></i>
										<?php echo $this->lang->line('module_user_management_back_to_list');?>
									</a>

							</footer>
						  </form>
					</div>
				</div>
			</div>
		</article>
	</div>
</section> -->
<input type="hidden" id="hiddenElement" value="true"/>
<script type="text/javascript">
    $('#Administration').addClass("active");
	pageSetUp();

	var module_name = '<?php echo $this->uri->segment(1)?>';
	var currEditId = 0;
	var editname = "";
	var min_password = 6;

	pageSetUp();

	loadScript("<?php echo ASSETS_URL.TEMPLATE?>/js/plugin/jquery-form/jquery-form.min.js", runFormValidation);


	function runFormValidation() {
		var $checkoutForm = $('#newUser').validate({
			rules : {
				NIK : {
					required : true
				},
				USERNAME : {
					required : true
				},
				FULLNAME : {
					required : true
				},
				PASSWORD : {
					required : true
				},
				EMAIL : {
					required : true,
					email : true
				},
				USER_TYPE : {
					required : true
				},
				IS_LOGIN : {
					required : true
				},
                MOBILE : {
					required : true
				},
				IS_BLOCK : {
					required : true
				}
			},
			messages : {
				NIK : {
					required : 'NIK is required'
				},
				USERNAME : {
					required : 'Username is required'
				},
				FULLNAME : {
					required : 'User fullname is required'
				},
				PASSWORD : {
					required : 'Password is required'
				},
				EMAIL : {
					required : 'Email is required',
					email : 'Please enter a VALID email address'
				},
				USER_TYPE : {
					required : 'User type is required'
				},
				IS_LOGIN : {
					required : 'choose login status'
				},
                MOBILE : {
					required : 'Mobile Number is required'
				},
				IS_BLOCK : {
					required : 'chooose block status'
				}
			},
			submitHandler : function(form) {
				var once = $("#hiddenElement").val();
				if (once == "true") {
					$(form).ajaxSubmit({
						beforeSubmit: function() {
							$("#hiddenElement").val("false");
							$("#cancel").attr("disabled","disabled");
							$("#userSaveBtn").attr("disabled","disabled");
							$("#userSaveBtn").append('<i class="fa fa-gear fa-1x fa-spin"></i>');
						},
						dataType: 'json',
						success : function(msg) {
							if (msg.msg == "noauth") {
								window.location = base_url;
							}
							else if (msg.error == true) {
								write_error_html(msg.field);

								$("#hiddenElement").val("true");
								$(".fa-spin").remove();
								$("#cancel").removeAttr("disabled");
								$("#userSaveBtn").removeAttr("disabled");
							} else {
								window.location.hash = base_url + 'User_management/';
							}
						}
					});
				}
			},
			errorPlacement : function(error, element) {
				error.insertAfter(element.parent());
			}
		});
	}

	function searchData(){
		$.ajax({
			type:"POST",
			url:"<?php echo BASE_URL?>"+module_name+"/setSearch/",
			data:$("#searchForm").serialize(),
			success:function(msg){
				if(msg=="ok"){
					loadPage(module_name);
				}
			},
			error:function(){
				alert("Search failed");
			}
		});
	}

	function numeralsOnly(evt) {
		    evt = (evt) ? evt : event;
		    var charCode = (evt.charCode) ? evt.charCode : ((evt.keyCode) ? evt.keyCode :
		        ((evt.which) ? evt.which : 0));
		    if(charCode==44){
				return true;
			}
			if(charCode==43){
				return true;
			}
			if (charCode > 31 && (charCode < 48 || charCode > 57)) {
		        return false;
		    }
		    return true;
	}

	function checkPassword(){


	}

    function showCP(){
    if( $("#USER_TYPE").val() == "CONTENT_PROVIDER")
        {
            $('label[for="CP_NAME"]').show();
            $("#CP_NAME").show();
        }
    else
        {

            $('label[for="CP_NAME"]').hide();
            $("#CP_NAME").hide();
        }
    }
	<?php if(@$d['USER_TYPE']=="CONTENT_PROVIDER"){echo "showCP()";} ?>
</script>
