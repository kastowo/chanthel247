<!-- Row begin -->
<div class="row">
	<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
		<h6 class="page-title txt-color-blueDark">
			<i class="fa fa-table fa-cog "></i>
				<a href="#Groups"><?php echo $this->lang->line('module_groups_title');?></a>
			<span>&gt;
				<small><?php echo $type?></small>
			</span>
		</h6>
	</div>
</div>
<!-- Row end -->

<section id="widget-grid" class="">
	<div class="row">
		<article class="col-sm-12 col-md-12 col-lg-12">
			<div class="jarviswidget" id="wid-id-8" data-widget-editbutton="false" data-widget-custombutton="false">

				<header>
					<span class="widget-icon"> <i class="fa fa-group"></i> </span>
					<h2><?php echo @$type;?> <?php echo $this->lang->line('module_groups_group');?> <?php echo @$groupname;?></h2>
				</header>
				<div>

					<div class="jarviswidget-editbox">

					</div>
					<div class="widget-body no-padding">
						<form action="Groups/insert" id="group_form" class="smart-form" novalidate="novalidate" method="POST">
						<input type="hidden" id="GROUP_ID" name="GROUP_ID" value="<?php echo @$group_id?>" />
								<fieldset>
									<div class="row">
										<section class="col col-3">
											<label class="input"> <i class="icon-prepend fa fa-group"></i>
												<input type="text" name="GROUP_NAME" maxlength="20" id="GROUP_NAME" placeholder="<?php echo $this->lang->line('module_groups_ph_group_name')?>" value="<?php echo @$group_name?>">
												<b class="tooltip tooltip-bottom-left"><?php echo $this->lang->line('module_groups_tooltip_group_name')?></b>
											</label>
										</section>
									</div>



								</fieldset>
								<footer>
									<button class="btn btn-primary" type="submit" id="moduleSaveBtn">
										<i class="fa fa-save"></i>
										<?php echo $this->lang->line('module_groups_save');?>
									</button>
									<a class="btn btn-default" id="cancel" href="#Groups">
										<i class="fa fa-rotate-left"></i>
										<?php echo $this->lang->line('module_groups_back_to_list');?>
									</a>

								</footer>
						</form>
					</div>
				</div>
			</div>
		</article>
	</div>
</section>

<input type="hidden" id="hiddenElement" value="true"/>
<script type="text/javascript">
    $('#Administration').addClass("active");
	pageSetUp();

	loadScript("<?php echo ASSETS_URL.TEMPLATE?>/js/plugin/jquery-form/jquery-form.min.js", runFormValidation);

	function runFormValidation() {
		var $checkoutForm = $('#group_form').validate({
			rules : {
				GROUP_NAME : {
					required : true
				}
			},
			messages : {
				GROUP_NAME : {
					required : 'Group name is required'
				}
			},
			submitHandler : function(form) {
				var once = $("#hiddenElement").val();
				if (once == "true") {
					$(form).ajaxSubmit({
						beforeSubmit: function() {
							$("#hiddenElement").val("false");
							$("#cancel").attr("disabled","disabled");
							$("#moduleSaveBtn").attr("disabled","disabled");
							$("#moduleSaveBtn").append('<i class="fa fa-gear fa-1x fa-spin"></i>');
						},
						dataType: 'json',
						success : function(msg) {
							if (msg.msg == "noauth") {
								window.location = base_url;
							}
							else if (msg.error == true) {
								write_error_html(msg.field)
								$("#hiddenElement").val("true");
								$(".fa-spin").remove();
								$("#cancel").removeAttr("disabled");
								$("moduleSaveBtn").removeAttr("disabled");
							} else {
								window.location.hash = base_url + 'Groups/';
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

	function getList(parent_field,parent,field_id,field_name,selected_id,all,id_name){
		$.ajax({
			type:"POST",
			url: "<?php echo BASE_URL?>Groups/getList/",
			data: "parent="+parent+"&parent_field="+parent_field+"&field_id="+field_id+"&field_name="+field_name+"&selected_id="+selected_id+"&all="+all,
			success:function(msg){
				$("#"+id_name).html(msg);
			},
			error:function(){
				alert("Search failed");
			}
		});
	}
</script>
