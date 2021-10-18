<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo APP_NAME." | Add new message"; ?></title>

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
							<h1>Create Messages</h1>
						</div><!-- /.page-header -->
						<form method="POST" action="" class="form-horizontal" >
							<div class="row">
								<div class="col-xs-6 col-xs-offset-3">
									<textarea name="message_title" class="form-control" rows="2" required placeholder="Message title here"></textarea>
									<br>
									<textarea name="message_content" class="form-control" rows="5" required placeholder="Message content here"></textarea>
									<hr>
									<h3><center>Select Audience type</center></h3>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-xs-6">
									<div class="form-group">
										<label class="col-xs-12 col-sm-3 control-label no-padding-right">Age Group</label>
										<div class="col-xs-8 col-sm-8 col-sm-offset-1">
											<br>
											<div id="slider-range"></div>
											<input type="hidden" name="min_entry_age" id="min_age">
											<input type="hidden" name="max_entry_age" id="max_age">
										</div>
									</div>
									
									<div class="form-group">
										<label class="control-label  col-xs-12 col-sm-3 no-padding-right">Gender</label>
										<div class="col-xs-12 col-sm-9">
											<div>
												<label class="line-height-1">
													<input name="entry_gender" value="all" type="radio" id="all_gender" class="ace" checked />
													<span class="lbl"> All</span>
												</label>
											</div>
											<div>
												<label class="line-height-1">
													<input name="entry_gender" value="male" type="radio" id="male_gender" class="ace"/>
													<span class="lbl"> Male</span>
												</label>
											</div>
											<div>
												<label class="line-height-1">
													<input name="entry_gender" value="female" type="radio" id="female_gender" class="ace"/>
													<span class="lbl"> Female</span>
												</label>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-xs-12 col-sm-3 no-padding-right">Salary Group</label>

										<div class="col-xs-12 col-sm-6">
											<select name="salary_group" class="form-control">
												<option value="">All</option>
												<?php 
													foreach ($code_type["salary_group"] as $key => $value) {
														?>
															<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
														<?php
													}
												?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-xs-12 col-sm-3 no-padding-right">Work Type</label>
										<div class="col-xs-12 col-sm-6">
											<select name="work_type" class="form-control">
												<option value="">All</option>
												<?php 
													foreach ($code_type["work_type"] as $key => $value) {
														?>
															<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
														<?php
													}
												?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-xs-12 col-sm-3 no-padding-right">Residence</label>
										<div class="col-xs-12 col-sm-6">
											<select name="residence_type" class="form-control">
												<option value="">All</option>
												<?php 
													foreach ($code_type["residence_type"] as $key => $value) {
														?>
															<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
														<?php
													}
												?>
											</select>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-xs-12 col-sm-3 no-padding-right">Transport</label>
										<div class="col-xs-12 col-sm-6">
											<select name="transport_type" class="form-control">
												<option value="">All</option>
												<?php 
													foreach ($code_type["transport_type"] as $key => $value) {
														?>
															<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
														<?php
													}
												?>
											</select>
										</div>
									</div>
								</div>
								<div class="col-xs-6">
									<div class="form-group">
										<label class="control-label col-xs-12 col-sm-3 no-padding-right">Club Membership</label>

										<div class="col-xs-12 col-sm-6">
											<select name="club_type" class="form-control">
												<option value="">All</option>
												<?php 
													foreach ($code_type["club_type"] as $key => $value) {
														?>
															<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
														<?php
													}
												?>
											</select>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-xs-12 col-sm-3 no-padding-right">Defence Service</label>
										<div class="col-xs-12 col-sm-6">
											<select name="defence_service" class="form-control">
												<option value="">All</option>
												<?php 
													foreach ($code_type["defence_group"] as $key => $value) {
														?>
															<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
														<?php
													}
												?>
											</select>
										</div>
									</div>

									

									<div class="form-group">
										<label class="control-label col-xs-12 col-sm-3 no-padding-right">Watch Brand</label>
										<div class="col-xs-12 col-sm-6">
											<select name="watch_brand" class="form-control">
												<option value="">All</option>
												<?php 
													foreach ($code_type["watch_brand"] as $key => $value) {
														?>
															<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
														<?php
													}
												?>
											</select>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-xs-12 col-sm-3 no-padding-right">Car</label>
										<div class="col-xs-12 col-sm-6">
											<select name="car_brand" class="form-control">
												<option value="">All</option>
												<?php 
													foreach ($code_type["car_brand"] as $key => $value) {
														?>
															<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
														<?php
													}
												?>
											</select>
										</div>
									</div>

									

									<div class="form-group">
										<label class="control-label col-xs-12 col-sm-3 no-padding-right">Miles Card</label>
										<div class="col-xs-12 col-sm-6">
											<select name="miles_card" class="form-control">
												<option value="">All</option>
												<?php 
													foreach ($code_type["miles_card"] as $key => $value) {
														?>
															<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
														<?php
													}
												?>
											</select>
										</div>
									</div>
									
									<div class="form-group">
										<label class="control-label col-xs-12 col-sm-3 no-padding-right">Credit Card</label>
										<div class="col-xs-12 col-sm-6">
											<select name="credit_card" class="form-control">
												<option value="">All</option>
												<?php 
													foreach ($code_type["credit_card"] as $key => $value) {
														?>
															<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
														<?php
													}
												?>
											</select>
										</div>
										
									</div>
									
								</div>
								
							</div>
							<center>
							<div class="col-sm-6">
																<button type="button" class="btn btn-primary" onclick="takeAudienceType();">Refresh Audience</button>
																<div id="targeted_audience"></div>
															</div>
							<button type="submit" name="SAVE_MESSAGE" class="btn btn-primary">Create Message</button></center>
						</form>
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->
			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
			
		</div><!-- /.main-container -->
		<?php
			include("footer.php");
		?>
		<!-- basic scripts -->

		<!--[if !IE]> -->
		<script src="assets/js/jquery-2.1.4.min.js"></script>

		<!-- <![endif]-->

		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="assets/js/bootstrap.min.js"></script>

		<script src="assets/js/wizard.min.js"></script>
		<script src="assets/js/jquery.validate.min.js"></script>
		<script src="assets/js/jquery-additional-methods.min.js"></script>
		<script src="assets/js/bootbox.js"></script>
		<script src="assets/js/jquery.maskedinput.min.js"></script>
		<script src="assets/js/select2.min.js"></script>
		<script src="assets/js/bootstrap-datepicker.min.js"></script>
		<script src="assets/js/bootstrap-timepicker.min.js"></script>
		<script src="assets/js/moment.min.js"></script>
		<script src="assets/js/daterangepicker.min.js"></script>
		<script src="assets/js/bootstrap-datetimepicker.min.js"></script>
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
				//range slider tooltip example
				$( "#slider-range" ).css('width','200px').slider({
					orientation: "horizontal",
					range: true,
					min: 0,
					max: 100,
					values: [0, 100],
					slide: function( event, ui ) {
						var val = ui.values[$(ui.handle).index()-1] + "";
						
						if($(ui.handle).index() == "1") {
							$("#min_age").val(val);
						} else {
							$("#max_age").val(val);
						}
						if( !ui.handle.firstChild ) {
							$("<div class='tooltip right in' style='display:none;left:16px;top:-6px;'><div class='tooltip-arrow'></div><div class='tooltip-inner'></div></div>")
							.prependTo(ui.handle);
						}
						$(ui.handle.firstChild).show().children().eq(1).text(val);
					}
				}).find('span.ui-slider-handle').on('blur', function(){
					$(this.firstChild).hide();
				});
				//alert("HELLO");
				$( "#slider-range-max").slider({
					range: "max",
					min: 1,
					max: 10,
					value: 2
				});
			});
		</script>
	</body>
</html>
