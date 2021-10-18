<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo APP_NAME." | ".$store_detail->store_name; ?></title>
	<?php 
	include("header.php");
	include("nav_bar.php");
	include("sidebar.php");
	?>

			<div class="main-content">
				<div class="main-content-inner">
					<?php include("statusMessage.php"); ?>
					<div class="page-content">
						<div class="page-header">
							<h1>Store Detail</h1>
						</div><!-- /.page-header -->
						<div class="row">
							<div class="col-md-8 col-sm-8 col-xs-12">
								<form action="" method="POST" class="form-horizontal" enctype="multipart/form-data">
									<div class="form-group">
										<label class="col-xs-12 col-sm-3 col-sm-offset-1 control-label no-padding-right">Store Name</label>

										<div class="col-xs-12 col-sm-7">
											<span class="block input-icon input-icon-right">
												<input type="text" class="width-100" name="store_name" value="<?php echo $store_detail->store_name; ?>" required/>
												<input type="hidden" name="store_id" value="<?php echo $store_detail->store_id; ?>">
												<i class="ace-icon fa fa-info-circle tooltip-primary" data-rel="tooltip" data-placement="right" title="Name of the Store" ></i>
											</span>
										</div>
									</div>

									<div class="form-group">
										<label class="col-xs-12 col-sm-3 col-sm-offset-1 control-label no-padding-right">Store Website Url</label>

										<div class="col-xs-12 col-sm-7">
											<span class="block input-icon input-icon-right">
												<input type="text" class="width-100" placeholder="" name="store_website" value="<?php echo $store_detail->store_website; ?>"/>
												<i class="ace-icon fa fa-info-circle tooltip-primary" data-rel="tooltip" data-placement="right" title="Url of the store online website." ></i>
											</span>
										</div>
									</div>

									<div class="form-group">
										<label class="col-xs-12 col-sm-3 col-sm-offset-1 control-label no-padding-right">Store Contact</label>

										<div class="col-xs-12 col-sm-7">
											<span class="block input-icon input-icon-right">
												<input type="text" class="width-100" name="store_contact" value="<?php echo $store_detail->store_contact; ?>" required/>
												<i class="ace-icon fa fa-info-circle tooltip-primary" data-rel="tooltip" data-placement="right" title="Contact number of the store." ></i>
											</span>
										</div>
									</div>
									<div class="form-group">
										<label class="col-xs-12 col-sm-3 col-sm-offset-1 control-label no-padding-right">Email Id</label>
										<div class="col-xs-12 col-sm-7">
											<span class="block input-icon input-icon-right">
												<label class="control-label"><strong><?php echo $owner_detail->user_email; ?></strong></label>
											</span>
										</div>
									</div>
									<hr>
									<h5>Store Address</h5>
									<hr>
										<div class="form-group">
										<label class="col-xs-12 col-sm-3 col-sm-offset-1 control-label no-padding-right">Store Pincode</label>

										<div class="col-xs-12 col-sm-7">
											<span class="block input-icon input-icon-right">
												<input type="text" class="width-100" value="<?php echo $store_detail->store_pincode; ?>" name="store_pincode"/>
												<i class="ace-icon fa fa-info-circle tooltip-primary" data-rel="tooltip" data-placement="right" title="Six digit numeric pincode." ></i>
											</span>
										</div>
									</div>
									<div class="form-group">
										<label class="col-xs-12 col-sm-3 col-sm-offset-1 control-label no-padding-right">Store Location</label>

										<div class="col-xs-12 col-sm-7">
											<span class="block input-icon input-icon-right">
												<input type="text" class="width-100" value="<?php echo $store_detail->store_address; ?>" name="store_address"/>
												<i class="ace-icon fa fa-info-circle tooltip-primary" data-rel="tooltip" data-placement="right" title="Address of the store" ></i>
											</span>
										</div>
									</div>

									<div class="form-group">
										<label class="col-xs-12 col-sm-3 col-sm-offset-1 control-label no-padding-right">Store City</label>

										<div class="col-xs-12 col-sm-7">
											<span class="block input-icon input-icon-right">
												<input type="text" class="width-100" value="<?php echo $store_detail->store_city; ?>" name="store_city"/>
												<i class="ace-icon fa fa-info-circle tooltip-primary" data-rel="tooltip" data-placement="right" title="" ></i>
											</span>
										</div>
									</div>

									<div class="form-group">
										<label class="col-xs-12 col-sm-3 col-sm-offset-1 control-label no-padding-right">Store State</label>

										<div class="col-xs-12 col-sm-7">
											<span class="block input-icon input-icon-right">
												<input type="text" class="width-100" value="<?php echo $store_detail->store_state; ?>" name="store_state"/>
												<i class="ace-icon fa fa-info-circle tooltip-primary" data-rel="tooltip" data-placement="right" title="Select the State from the listing." ></i>
											</span>
										</div>
									</div>

								

									<hr>
									<h5>Paytm Wallet Details</h5>
									<hr>
									<div class="form-group">
										<label class="col-xs-12 col-sm-3 col-sm-offset-1 control-label no-padding-right">Paytm Sub-Wallet Id</label>

										<div class="col-xs-12 col-sm-7">
											<span class="block input-icon input-icon-right">
												<input type="text" class="width-100" value="<?php echo $store_detail->wallet_guid; ?>" name="wallet_guid"/>
												<i class="ace-icon fa fa-info-circle tooltip-primary" data-rel="tooltip" data-placement="right" title="Enter the sub-wallet Guid obtained from Paytm." ></i>
											</span>
										</div>
									</div>

									<div class="form-group">
										<label class="col-xs-12 col-sm-3 col-sm-offset-1 control-label no-padding-right">Amount in the Sub-Wallet</label>

										<div class="col-xs-12 col-sm-7">
											<span class="block input-icon input-icon-right">
												<input type="number" class="width-100" min="0" value="<?php echo $store_detail->wallet_amount; ?>" name="wallet_amount"/>
												<i class="ace-icon fa fa-info-circle tooltip-primary" data-rel="tooltip" data-placement="right" title="Enter the amount tranfered from the paytm main wallet to the sub-wallet." ></i>
											</span>
										</div>
									</div>
									<hr>
									<h5>Subscription Taken</h5>
									<hr>
									<div class="form-group">
										<label class="col-xs-12 col-sm-3 col-sm-offset-1 control-label no-padding-right">Can see customer details</label>
										<div class="col-xs-12 col-sm-7">
											<span class="block input-icon input-icon-right">
												<input name="subscribed" class="ace ace-switch ace-switch-6" type="checkbox" <?php if($store_detail->subscribed == "yes") {echo 'checked=""';} ?>/>
												<span class="lbl"></span>
												<i class="ace-icon fa fa-info-circle tooltip-primary right" data-rel="tooltip" data-placement="right" title="Enabling this will allow the store to see the contact and personal details of the customer." ></i>
											</span>
										</div>
									</div>
									<hr>
									<center>
										<button type="submit" name="UPDATE_SUB_WALLET" class="btn btn-primary" >Update Store</button>
									</center>
								</form>
								<form action="" method="POST" class="form-horizontal" enctype="multipart/form-data">

									<hr class="hr hr-double">
									<h5>Login Credential</h5>
									<hr>

									<div class="form-group">
										<label class="col-xs-12 col-sm-3 col-sm-offset-1 control-label no-padding-right">Email Id</label>

										<div class="col-xs-12 col-sm-7">
											<span class="block input-icon input-icon-right">
												<input type="hidden" class="width-100" value="<?php echo $owner_detail->user_id; ?>" name="user_id" required />
												<label class="control-label"><strong><?php echo $owner_detail->user_email; ?></strong></label>
												<i class="ace-icon fa fa-info-circle tooltip-primary" data-rel="tooltip" data-placement="right" title="Store will use email as the login id." ></i>
											</span>
										</div>
									</div>

									<div class="form-group">	
										<label class="col-xs-12 col-sm-3 col-sm-offset-1 control-label no-padding-right">Enter Password</label>

										<div class="col-xs-12 col-sm-7">
											<span class="block input-icon input-icon-right">
												<input type="text" class="width-100" placeholder="" name="user_password" required/>
												<i class="ace-icon fa fa-info-circle tooltip-primary" data-rel="tooltip" data-placement="right" title="" ></i>
											</span>
										</div>
									</div>

									<div class="form-group">
										<label class="col-xs-12 col-sm-3 col-sm-offset-1 control-label no-padding-right">Confirm Password</label>

										<div class="col-xs-12 col-sm-7">
											<span class="block input-icon input-icon-right">
												<input type="text" class="width-100" placeholder="" name="confirm_password" required/>
												<i class="ace-icon fa fa-info-circle tooltip-primary" data-rel="tooltip" data-placement="right" title="" ></i>
											</span>
										</div>
									</div>
									<hr>
									<center>
										<button type="submit" name="UPDATE_SUB_WALLET_LOGIN" class="btn btn-primary" >Reset Password</button>
									</center>
								</form>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-12">
								<div class="row">
									<div class="center">
										<span class="btn btn-app btn-lg btn-yellow no-hover">
											<span class="line-height-1 bigger-170 blue"> <?php  echo $store_detail->wallet_amount; ?> </span>
											<br />
											<span class="line-height-1 smaller-80"> Amount in<br> wallet </span>
										</span>
									</div>
									<br>
								</div>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-12 well">
								
								<div class="row">
									<form action="" method="POST" class="form-horizontal" enctype="multipart/form-data">
										<center><img class="col-xs-10 col-xs-offset-1" src="images/profile/<?php echo $owner_detail->user_id; ?>.png" alt=""></center>
										<div class="form-group">
											<label class="col-xs-12 col-sm-3 col-sm-offset-1  control-label no-padding-right">Update Store Logo</label>

											<div class="col-xs-12 col-sm-7">
												<span class="block input-icon input-icon-right">
													<input type="file" class="width-100" placeholder="" name="user_photo" max-size="32154"/>
													<input type="hidden" class="width-100" value="<?php echo $owner_detail->user_id; ?>" name="user_id" required />
													<i class="ace-icon fa fa-info-circle tooltip-primary" data-rel="tooltip" data-placement="right" title="Logo of the store." ></i>
												</span>
											</div>
										</div>
										<center>
											<button type="submit" name="UPDATE_SUB_WALLET_LOGO" class="btn btn-primary" >Update Logo</button>
										</center>
									</form>
									<hr class="hr hr-double">
									<form action="" method="POST" class="form-horizontal" enctype="multipart/form-data">
										<center><img class="col-xs-10 col-xs-offset-1" src="images/store/<?php echo $store_detail->store_id; ?>.png" alt=""></center>
										<div class="form-group">
											<label class="col-xs-12 col-sm-3 col-sm-offset-1  control-label no-padding-right">Update Store Image</label>

											<div class="col-xs-12 col-sm-7">
												<span class="block input-icon input-icon-right">
													<input type="file" class="width-100" placeholder="" name="store_image"/><input type="hidden" class="width-100" value="<?php echo $store_detail->store_id; ?>" name="store_id" required />
													<i class="ace-icon fa fa-info-circle tooltip-primary" data-rel="tooltip" data-placement="right" title="Picture of the store." ></i>
												</span>
											</div>
										</div>
										<center>
											<button type="submit" name="UPDATE_SUB_WALLET_IMAGE" class="btn btn-primary" >Update Image</button>
										</center>
									</form>
									<hr class="hr hr-double">
									<form action="" method="POST" class="form-horizontal" enctype="multipart/form-data">
										<center><img class="col-xs-10 col-xs-offset-1" src="images/store/<?php echo $store_detail->store_id; ?>.png" alt=""></center>
										<div class="form-group">
											<label class="col-xs-12 col-sm-6 col-sm-offset-1  control-label no-padding-right">Download costumer details</label>

											
										</div>
										<center>
											<button type="submit" name="UPDATE_SUB_WALLET_IMAGE" class="btn btn-primary" >Download costumer details</button>
										</center>
									</form>
								</div>
							</div>
						</div><!-- /.row -->
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
			<?php
			include("footer.php");
			?>
		</div><!-- /.main-container -->




		<script src="assets/js/jquery-2.1.4.min.js"></script>

		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="assets/js/bootstrap.min.js"></script>

		<!-- page specific plugin scripts -->
		<script src="assets/js/wizard.min.js"></script>
		<script src="assets/js/jquery.validate.min.js"></script>
		<script src="assets/js/jquery-additional-methods.min.js"></script>
		<script src="assets/js/bootbox.js"></script>
		<script src="assets/js/jquery.maskedinput.min.js"></script>
		<script src="assets/js/select2.min.js"></script>

		<!-- ace scripts -->
		<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>
		<!-- inline scripts related to this page -->
		<script src="assets/js/jquery-ui.custom.min.js"></script>
		<script src="assets/js/jquery.ui.touch-punch.min.js"></script>
		<script src="assets/js/jquery.easypiechart.min.js"></script>
		<script src="assets/js/jquery.sparkline.index.min.js"></script>
		<script src="assets/js/jquery.flot.min.js"></script>
		<script src="assets/js/jquery.flot.pie.min.js"></script>
		<script src="assets/js/jquery.flot.resize.min.js"></script>

		<!-- ace scripts -->
		<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>

		<script type="text/javascript">
			$(function(){
				$('form').submit(function(){
					var isOk = true;
					$('input[type=file][max-size]').each(function(){
						if(typeof this.files[0] !== 'undefined'){
							var maxSize = parseInt($(this).attr('max-size'),10),
							size = this.files[0].fileSize;
							isOk = maxSize > size;
							return isOk;
						}
					});
					return isOk;
				});
			});
			
			jQuery(function($) {
			
				$('[data-rel=tooltip]').tooltip();
			
				$('.select2').css('width','200px').select2({allowClear:true})
				.on('change', function(){
					$(this).closest('form').validate().element($(this));
				}); 
				
				
				var $validation = false;
				$('#fuelux-wizard-container')
				.ace_wizard({
					//step: 2 //optional argument. wizard will jump to step "2" at first
					//buttons: '.wizard-actions:eq(0)'
				})
				.on('actionclicked.fu.wizard' , function(e, info){
					if(info.step == 1 && $validation) {
						if(!$('#validation-form').valid()) e.preventDefault();
					}
				})
				//.on('changed.fu.wizard', function() {
				//})
				.on('finished.fu.wizard', function(e) {
					bootbox.dialog({
						message: "Thank you! Your information was successfully saved!", 
						buttons: {
							"success" : {
								"label" : "OK",
								"className" : "btn-sm btn-primary"
							}
						}
					});
				}).on('stepclick.fu.wizard', function(e){
					//e.preventDefault();//this will prevent clicking and selecting steps
				});
			
				//hide or show the other form which requires validation
				//this is for demo only, you usullay want just one form in your application
				$('#skip-validation').removeAttr('checked').on('click', function(){
					$validation = this.checked;
					if(this.checked) {
						$('#sample-form').hide();
						$('#validation-form').removeClass('hide');
					}
					else {
						$('#validation-form').addClass('hide');
						$('#sample-form').show();
					}
				})
			
				$.mask.definitions['~']='[+-]';
				$('#phone').mask('(999) 999-9999');
			
				jQuery.validator.addMethod("phone", function (value, element) {
					return this.optional(element) || /^\(\d{3}\) \d{3}\-\d{4}( x\d{1,6})?$/.test(value);
				}, "Enter a valid phone number.");
			
				$('#validation-form').validate({
					errorElement: 'div',
					errorClass: 'help-block',
					focusInvalid: false,
					ignore: "",
					rules: {
						email: {
							required: true,
							email:true
						},
						password: {
							required: true,
							minlength: 5
						},
						password2: {
							required: true,
							minlength: 5,
							equalTo: "#password"
						},
						name: {
							required: true
						},
						phone: {
							required: true,
							phone: 'required'
						},
						url: {
							required: true,
							url: true
						},
						comment: {
							required: true
						},
						state: {
							required: true
						},
						platform: {
							required: true
						},
						subscription: {
							required: true
						},
						gender: {
							required: true,
						},
						agree: {
							required: true,
						}
					},
			
					messages: {
						email: {
							required: "Please provide a valid email.",
							email: "Please provide a valid email."
						},
						password: {
							required: "Please specify a password.",
							minlength: "Please specify a secure password."
						},
						state: "Please choose state",
						subscription: "Please choose at least one option",
						gender: "Please choose gender",
						agree: "Please accept our policy"
					},
					
					highlight: function (e) {
						$(e).closest('.form-group').removeClass('has-info').addClass('has-error');
					},
					
					success: function (e) {
						$(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
						$(e).remove();
					},
					
					errorPlacement: function (error, element) {
						if(element.is('input[type=checkbox]') || element.is('input[type=radio]')) {
							var controls = element.closest('div[class*="col-"]');
							if(controls.find(':checkbox,:radio').length > 1) controls.append(error);
							else error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
						}
						else if(element.is('.select2')) {
							error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));
						}
						else if(element.is('.chosen-select')) {
							error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
						}
						else error.insertAfter(element.parent());
					},
			
					submitHandler: function (form) {
					},
					invalidHandler: function (form) {
					}
				});
			
				$('#modal-wizard-container').ace_wizard();
				$('#modal-wizard .wizard-actions .btn[data-dismiss=modal]').removeAttr('disabled');
				
				$(document).one('ajaxloadstart.page', function(e) {
					//in ajax mode, remove remaining elements before leaving page
					$('[class*=select2]').remove();
				});
			})
		</script>
	</body>
</html>