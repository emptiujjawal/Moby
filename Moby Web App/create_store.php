<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo APP_NAME." | Create Brand Account"; ?></title>
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
							<h1>Create Brand Account</h1>
						</div><!-- /.page-header -->
						<div class="row">
							<div class="col-md-10 col-sm-10 col-md-offset-1 col-sm-offset-1">
								<form action="" method="POST" class="form-horizontal" enctype="multipart/form-data">
									<h2><center><strong>Enter Brand Details</strong></center></h2>
									<hr>
									
									<div class="form-group">
										<label class="col-xs-12 col-sm-3 control-label no-padding-right">Brand Name</label>

										<div class="col-xs-12 col-sm-5">
											<span class="block input-icon input-icon-right">
												<input type="text" class="width-100" placeholder="" name="store_name" required/>
											</span>
										</div>
										<div class="col-xs-12 col-sm-3 form-text text-muted">Name of the Brand</div>
									</div>

									<div class="form-group">
										<label class="col-xs-12 col-sm-3 control-label no-padding-right">Brand Website Url</label>

										<div class="col-xs-12 col-sm-5">
											<span class="block input-icon input-icon-right">
												<input type="text" class="width-100" placeholder="" name="store_website"/>
											</span>
										</div>
										<div class="col-xs-12 col-sm-3 form-text text-muted">Url of the brand online website.</div>
									</div>
									
									<div class="form-group">
										<label class="col-xs-12 col-sm-3 control-label no-padding-right">Logo</label>

										<div class="col-xs-12 col-sm-5">
											<span class="block input-icon input-icon-right">
												<input type="file" class="width-100" placeholder="" name="user_photo"/>
											</span>
										</div>
										<div class="col-xs-12 col-sm-3 form-text text-muted">Logo will be used for Account.</div>
									</div>

									<div class="form-group">
										<label class="col-xs-12 col-sm-3 control-label no-padding-right">Brand Image</label>

										<div class="col-xs-12 col-sm-5">
											<span class="block input-icon input-icon-right">
												<input type="file" class="width-100" placeholder="" name="store_image"/>
											</span>
										</div>
										<div class="col-xs-12 col-sm-3 form-text text-muted">Picture of the Brand.</div>
									</div>

									<div class="form-group">
										<label class="col-xs-12 col-sm-3 control-label no-padding-right">Brand Contact</label>

										<div class="col-xs-12 col-sm-5">
											<span class="block input-icon input-icon-right">
												<input type="text" class="width-100" placeholder="" name="store_contact" required/>
											</span>
										</div>
										<div class="col-xs-12 col-sm-3 form-text text-muted">Contact number of the account holder.</div>
									</div>

									<div class="form-group">
										<label class="col-xs-12 col-sm-3 control-label no-padding-right">Corporate Identity Number</label>

										<div class="col-xs-12 col-sm-5">
											<span class="block input-icon input-icon-right">
												<input type="text" class="width-100" placeholder="" name="company_cin" required/>
											</span>
										</div>
										<div class="col-xs-12 col-sm-3 form-text text-muted">Corporate Identity Number as specified on the Certificate of Incorporation</div>
									</div>
									
									<div class="form-group">
										<label class="col-xs-12 col-sm-3 control-label no-padding-right">Company Incorporation Date</label>

										<div class="col-xs-12 col-sm-5">
											<span class="block input-icon input-icon-right">
												<input type="date" class="width-100" placeholder="" name="incorporation_date" required/>
											</span>
										</div>
										<div class="col-xs-12 col-sm-3 form-text text-muted">Incorporation date of the company as specified on Certificate of Incorporation</div>
									</div>

									<div class="form-group">
										<label class="col-xs-12 col-sm-3 control-label no-padding-right">GST Number</label>

										<div class="col-xs-12 col-sm-5">
											<span class="block input-icon input-icon-right">
												<input type="text" class="width-100" placeholder="" name="company_gst" required/>
											</span>
										</div>
										<div class="col-xs-12 col-sm-3 form-text text-muted">GST number of the company</div>
									</div>

									<hr>
									<h5>Address</h5>
									<hr>
									<div class="form-group">
										<label class="col-xs-12 col-sm-3 control-label no-padding-right"> Location</label>

										<div class="col-xs-12 col-sm-5">
											<span class="block input-icon input-icon-right">
												<input type="text" class="width-100" placeholder="" name="store_address"/>
											</span>
										</div>
										<div class="col-xs-12 col-sm-3 form-text text-muted">Address of the store</div>
									</div>

									<div class="form-group">
										<label class="col-xs-12 col-sm-3 control-label no-padding-right"> City</label>

										<div class="col-xs-12 col-sm-5">
											<span class="block input-icon input-icon-right">
												<input type="text" class="width-100" placeholder="" name="store_city"/>
											</span>
										</div>
										<div class="col-xs-12 col-sm-3 form-text text-muted">City in the company is registered</div>
									</div>

									<div class="form-group">
										<label class="col-xs-12 col-sm-3 control-label no-padding-right"> State</label>

										<div class="col-xs-12 col-sm-5">
											<span class="block input-icon input-icon-right">
												<input type="text" class="width-100" placeholder="" name="store_state"/>
											</span>
										</div>
										<div class="col-xs-12 col-sm-3 form-text text-muted">Enter the State</div>
									</div>

									<div class="form-group">
										<label class="col-xs-12 col-sm-3 control-label no-padding-right"> Pincode</label>

										<div class="col-xs-12 col-sm-5">
											<span class="block input-icon input-icon-right">
												<input type="text" class="width-100" placeholder="" name="store_pincode"/>
											</span>
										</div>
										<div class="col-xs-12 col-sm-3 form-text text-muted">Six digit numeric pincode.</div>
									</div>

									<hr>
									<h5>Login Credential</h5>
									<hr>

									<div class="form-group">
										<label class="col-xs-12 col-sm-3 control-label no-padding-right">Email Id</label>

										<div class="col-xs-12 col-sm-5">
											<span class="block input-icon input-icon-right">
												<input type="text" class="width-100" placeholder="" name="user_email" required />
											</span>
										</div>
										<div class="col-xs-12 col-sm-3 form-text text-muted">Store will use email as the login id.</div>
									</div>

									<div class="form-group">	
										<label class="col-xs-12 col-sm-3 control-label no-padding-right">Enter Password</label>

										<div class="col-xs-12 col-sm-5">
											<span class="block input-icon input-icon-right">
												<input type="text" class="width-100" placeholder="" name="user_password" required/>
											</span>
										</div>
										<div class="col-xs-12 col-sm-3 form-text text-muted">Enter the password</div>
									</div>

									<div class="form-group">
										<label class="col-xs-12 col-sm-3 control-label no-padding-right">Confirm Password</label>

										<div class="col-xs-12 col-sm-5">
											<span class="block input-icon input-icon-right">
												<input type="text" class="width-100" placeholder="" name="confirm_password" required/>
											</span>
										</div>
										<div class="col-xs-12 col-sm-3 form-text text-muted">Enter same password as above.</div>
									</div>

									<div class="form-group">
										<label class="col-xs-12 col-sm-3 control-label no-padding-right">Contact number of responsible person.</label>

										<div class="col-xs-12 col-sm-5">
											<span class="block input-icon input-icon-right">
												<input type="number" min="0000000000" class="width-100" placeholder="" name="owner_contact" required/>
											</span>
										</div>
										<div class="col-xs-12 col-sm-3 form-text text-muted">Enter a contact number of person who will be responsible for handling the admin panel.</div>
									</div>

									<hr>
									<h5>Paytm Wallet Details</h5>
									<hr>
									<div class="form-group">
										<label class="col-xs-12 col-sm-3 control-label no-padding-right">Paytm Sub-Wallet Id</label>

										<div class="col-xs-12 col-sm-5">
											<span class="block input-icon input-icon-right">
												<input type="text" class="width-100" placeholder="" name="wallet_guid"/>
											</span>
										</div>
										<div class="col-xs-12 col-sm-3 form-text text-muted">Enter the sub-wallet Guid obtained from Paytm.</div>
									</div>

									<div class="form-group">
										<label class="col-xs-12 col-sm-3 control-label no-padding-right">Amount in the Sub-Wallet</label>

										<div class="col-xs-12 col-sm-5">
											<span class="block input-icon input-icon-right">
												<input type="number" class="width-100" min="0" placeholder="" name="wallet_amount"/>
											</span>
										</div>
										<div class="col-xs-12 col-sm-3 form-text text-muted">Enter the amount tranfered from the paytm main wallet to the sub-wallet.</div>
									</div>
									<hr>
									<h5>Subscription Taken</h5>
									<hr>
									<div class="form-group">
										<label class="col-xs-12 col-sm-3 control-label no-padding-right">Can see customer details</label>
										<div class="col-xs-12 col-sm-5">
											<span class="block input-icon input-icon-right">
												<input name="subscribed" class="ace ace-switch ace-switch-6" type="checkbox" />
												<span class="lbl"></span>
											</span>
										</div>
										<div class="col-xs-12 col-sm-3 form-text text-muted">Enable this will allow the store to see the contact and personal details of the customer.</div>
									</div>
									<hr>
									<center>
										<button type="submit" name="CREATE_SUB_WALLET" class="btn btn-primary" >Create Account</button>
									</center>
								</form>
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