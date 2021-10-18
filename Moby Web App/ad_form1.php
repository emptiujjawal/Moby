

<!DOCTYPE html>

<html lang="en">
	<head>
		<title><?php echo APP_NAME." | Create Ad"; ?></title>
		<script type="text/javascript">
    function toggle_div_fun(id) {

       var divelement = document.getElementById(id);

       if(divelement.style.display == 'none')
          divelement.style.display = 'block';
       else
          divelement.style.display = 'none';
    }
	function myFunction() {
    var x = document.getElementById("myDIV");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}
</script>
	<?php 
	include("header.php");
	include("nav_bar.php");
	include("sidebar.php");
	$campaign = $CommonFunc->getAllCampaign();
	$bank = $CommonFunc->getAllBank();
	$type = $CommonFunc->getAllpaymenttype();
	?>
	
			<div class="main-content">
				<div class="main-content-inner">
					<div class="page-content">
						<div class="page-header">
							<h1>Create An Ad</h1>
						</div><!-- /.page-header -->
						<div class="row">
							<div class="col-xs-12">
								<?php include("statusMessage.php"); ?>
								<!-- PAGE CONTENT BEGINS -->
								<div class="widget-box">
									<div class="widget-body">
										<div class="widget-main">
											<div id="fuelux-wizard-container">
												<div>
													<ul class="steps">
														<li data-step="1" class="<?php echo $campaign_saved; ?>" >
															<span class="step" >1</span>
															<span class="title">Campaign</span>
														</li>
														<li data-step="2" class="<?php echo $ad_saved; ?>" >
															<span class="step">2</span>
															<span class="title">Create Ads</span>
														</li>
														
														<!--<li data-step="3" class="<?php echo $bank_saved; ?>" >
															<span class="step" >3</span>
															<span class="title">Bank Information</span>
														</li> -->
														<li data-step="3" class="<?php echo $audience_saved; ?>" >
															<span class="step">3</span>
															<span class="title">Audience</span>
														</li>
														<li data-step="4" class="<?php echo $locations_saved; ?>" >
															<span class="step">4</span>
															<span class="title">Location</span>
														</li>
														<li data-step="5" class="<?php echo $questions_saved; ?>" >
														<div id="myDIV">
															<span class="step">5</span>
															<span class="title">Add Question</span>
															</div>
														</li>
														</li>
														<!--<li data-step="6" class="<?php echo $preview_saved; ?>" >
															<span class="step">7</span>
															<span class="title">Add Preview</span>
														</li>-->
														<li data-step="6" class="<?php echo $final_confirmation; ?>" >
															<span class="step">6</span>
															<span class="title">Final Confirmation</span>
														</li>
													</ul>
												</div>
												<hr />

												<div class="step-content pos-rel">
													<div class="step-pane" data-step="1">
														
														<h4 class="lighter block green"><b>Create Campaign</b></h4>
														<form class="form-horizontal" id="sample-form" method="post" action="">
															<div class="row">
																<div class="col-sm-9">
																	<div class="form-group">
																		<label class="control-label col-xs-12 col-sm-3 no-padding-right">Select Campaign:</label>
																		<div class="col-xs-12 col-sm-7">
																			<span class="block input-icon input-icon-right">
																				<select class="col-xs-12 form-control " id="form-field-select-1" name="campaign_id">
																					<option value="">Select One Type</option>
																					<?php 
																						foreach ($campaign as $camp_key => $camp_value) {
																							if($campaign_id != "" && $campaign_id == $camp_value["campaign_id"]) {
																								echo '<option value="'.$camp_value["campaign_id"].'" selected>'.$camp_value["campaign_name"].'</option>';
																							} else {
																								echo '<option value="'.$camp_value["campaign_id"].'">'.$camp_value["campaign_name"].'</option>';
																							}
																						}
																					?>
																				</select>
																			</span>
																		</div>
																	</div>
																	<div class="center">
																		<button class="btn btn-primary" type="submit" name="SELECT_CAMPAIGN">Select Campaign</button>
																	</div>
																	<h3><center>OR</center></h3><br>
																	<div id="add_camaign">
																		
																	</div>
																	<div class="center">
																		<button class="btn btn-sm btn-primary" id="create_campaign_button" type="button" onClick="addTextBox(this.id);">Create New Campaign</button>
																		<button class="btn btn-sm btn-warning" id="remove_campaign_button" type="button" onClick="addTextBox(this.id);" style="display: none;">Cancel</button>
																		<button class="btn btn-sm btn-primary" id="save_campaign_button" type="submit" name="SAVE_CAMPAIGN" style="display: none;">Save Campaign</button>
																	</div>
																</div>
																<div class="col-sm-3"></div>
															</div>
														</form>

														<hr />
														<div class="row">
															<div class="pull-right">
																<form action="" method="POST">
																	<input type="hidden" name="FROM_CAMPAIGN">
																	<button class="btn" name="FORM_BACK" disabled="true">
																		<i class="ace-icon fa fa-arrow-left"></i>
																		Back
																	</button>
																	<button class="btn btn-success" name="FORM_NEXT">
																		Continue
																		<i class="ace-icon fa fa-arrow-right icon-on-right"></i>
																	</button>
																</form>
															</div>
														</div>
													</div>

													<div class="step-pane" data-step="2">
														
														<h4 class="lighter block green"><b>Create Ads</b></h3>
															<button onclick="toggle_div_fun('sectiontohide');myFunction();">Click Bank Details</button> 

<div class="step-pane" id="sectiontohide" >   
	
														
														<h4 class="lighter block green"><b>BANK DETAILS</b></h3>
														<form class="form-horizontal" id="sample-form" method="POST" action="" enctype="multipart/form-data">
															
															<div class="form-group">
																<label class="control-label col-xs-12 col-sm-3 no-padding-right">Select Bank</label>
																		<div class="col-xs-12 col-sm-7">
																			<span class="block input-icon input-icon-right">
																				<select class="col-xs-12 form-control " id="form-field-select-1" name="campaign_id">
																					<option value="">Select One Type</option>
																			<?php 
																						foreach ($bank as $bank_key => $bank_value) {
																							if($bank_id != "" && $bank_id == $bank_value["bank_id"]) {
																								echo '<option value="'.$bank_value["bank_id"].'" selected>'.$bank_value["bank_name"].'</option>';
																											} else {
																								echo '<option value="'.$bank_value["bank_id"].'">'.$bank_value["bank_name"].'</option>';
																							}
																						}
																					?>
																				</select>
																			</span>
																		</div>
</div>
															<div class="form-group">
																<label class="control-label col-xs-12 col-sm-3 no-padding-right">Card Type</label>
																		<div class="col-xs-12 col-sm-7">
																			<span class="block input-icon input-icon-right">
																				<select class="col-xs-12 form-control " id="form-field-select-1" name="campaign_id">
																					<option value="">Select One Type</option>
																					<?php 
																						foreach ($type as $type_key => $type_value) {
																							if($type_id != "" && $type_id == $type_value["type_id"]) {
																								echo '<option value="'.$type_value["type_id"].'" selected>'.$type_value["paymentype_name"].'</option>';
																											} else {
																								echo '<option value="'.$bank_value["type_id"].'">'.$bank_value["paymentype_name"].'</option>';
																							}
																						}
																					?>
																				</select>
																			</span>
																		</div>
															</div>

															<div class="form-group">
																<label class="col-xs-12 col-sm-3 control-label no-padding-right">Card Product Name<sup>*</sup></label>
																<div class="col-xs-12 col-sm-5">
																	<input type="text" id="product_url" name="product_url" class="width-100" placeholder="Name" value="<?php echo $saved_ad->product_url; ?>" required/>
																</div>
																<div class="col-xs-12 col-sm-3 form-text text-muted">Card product</div>
															</div>
															
															
															<div class="fowrm-group">
																<label for="inputInfo" class="col-xs-12 col-sm-3 control-label no-padding-right">TERMS & CONDITIONS URL <sup>*</sup></label>
																<div class="col-xs-12 col-sm-5">
																	<input type="text" id="product_url" name="product_url" class="width-100" placeholder="Name" value="<?php echo $saved_ad->product_url; ?>" required/>
																</div>
																<div class="col-xs-12 col-sm-12"></DIV> <BR> </div>

															
															
															
														</form>
														</div>
														<h4 class="lighter block green"></h3>
														<form class="form-horizontal" id="sample-form" method="POST" action="" enctype="multipart/form-data">
														
														
															<div class="form-group">
																<label class="col-xs-12 col-sm-3 control-label no-padding-right">Ad Name <sup>*</sup></label>
																<div class="col-xs-12 col-sm-5">
																	<input type="text" id="ad_name" name = "ad_name" class="width-100" placeholder="Ad Name" value="<?php echo $saved_ad->ad_name; ?>" required />
																	<input type="hidden" name="campaign_id" value="<?php echo $campaign_id; ?>">
																</div>
																<div class="col-xs-12 col-sm-3 form-text text-muted">Display Name of the AD</div>
															</div>

															<div class="form-group">
																<label class="col-xs-12 col-sm-3 control-label no-padding-right">Product Name <sup>*</sup></label>
																<div class="col-xs-12 col-sm-5">
																	<input type="text" id="product_name" class="width-100" placeholder="Product Name" name="product_name" value="<?php echo $saved_ad->product_name; ?>" required />
																</div>
																<div class="col-xs-12 col-sm-3 form-text text-muted">Name of the product which is advertised</div>
															</div>

															<div class="form-group">
																<label class="col-xs-12 col-sm-3 control-label no-padding-right">Product Url <sup>*</sup></label>
																<div class="col-xs-12 col-sm-5">
																	<input type="text" id="product_url" name="product_url" class="width-100" placeholder="Product Url" value="<?php echo $saved_ad->product_url; ?>" required/>
																</div>
																<div class="col-xs-12 col-sm-3 form-text text-muted">Link of the Product.</div>
															</div>
															
															<div class="form-group">
																<label class="col-xs-12 col-sm-3 control-label no-padding-right">Company Name <sup>*</sup></label>
																<div class="col-xs-12 col-sm-5">
																	<input type="text" id="company_name" name="company_name" class="width-100" placeholder="Company Name" value="<?php echo $saved_ad->company_name; ?>" required />
																</div>
																<div class="col-xs-12 col-sm-3 form-text text-muted">Name of brand from which product is associated</div>
															</div>
															
															<div class="form-group">
																<label for="inputInfo" class="col-xs-12 col-sm-3 control-label no-padding-right">Company Url <sup>*</sup></label>
																<div class="col-xs-12 col-sm-5">
																	<input type="text" id="inputInfo" name="company_url" class="width-100" placeholder="Company Url" value="<?php echo $saved_ad->company_url; ?>" required />
																</div>
																<div class="col-xs-12 col-sm-3 form-text text-muted">Website url of the Brand</div>
															</div>

															<div class="form-group">
																<label for="inputInfo" class="col-xs-12 col-sm-3 control-label no-padding-right">Company Logo <sup>*</sup></label>
																<div class="col-xs-12 col-sm-5">
																	<input type="file" name="logo" class="width-100" placeholder="Company Logo" size="200" accept=".png, .jpeg, .jpg" />
																</div>
																<div class="col-xs-12 col-sm-3 form-text text-muted">Logo of the Company. Supported Formats are .png, .jpeg, .jpg. Size should not be  greater than 200 KB.</div>
															</div>

															<div class="form-group">
																<label class="col-xs-12 col-sm-3 control-label no-padding-right">Coverage Radius (in meters) <sup>*</sup></label>
																<div class="col-xs-12 col-sm-5">
																	<input type="number" id="coverage_radius" name="coverage_radius" class="width-100" placeholder="Coverage Radius" value="300" min="0"  required/>
																</div>
																<div class="col-xs-12 col-sm-3 form-text text-muted">User should be in this radius for Check-in</div>
															</div>

															<div class="form-group">
																<label class="col-xs-12 col-sm-3 control-label no-padding-right">Reward Amount (in INR) <sup>*</sup></label>
																<div class="col-xs-12 col-sm-5">
																	<input type="number" id="reward_amount" name="reward_amount" class="width-100" placeholder="Reward Amount" value="<?php echo $saved_ad->reward_amount; ?>" min="0" required />
																</div>
																<div class="col-xs-12 col-sm-3 form-text text-muted">Reward provided to the user on successfull Check-in</div>
															</div>

															<div class="form-group">
																<label class="col-xs-12 col-sm-3 control-label no-padding-right">Ads banner <sup>*</sup></label>
																<div class="col-xs-12 col-sm-5">
																	<input type="file" name="banner" class="width-100" placeholder="Ads Banner" size="200"  accept=".png, .jpeg, .jpg"  />
																</div>
																<div class="col-xs-12 col-sm-3 form-text text-muted">Banner for Ad that will be shown on the Moby Application. Supported formats are png, jpeg, jpg. Size should not be  greater than 200 KB.</div>
															</div>

															<div class="form-group">
																<label class="col-xs-12 col-sm-3 control-label no-padding-right" for="id-date-range-picker-1">Start Date - End Date <sup>*</sup></label>
																<div class="col-xs-12 col-sm-2">																	<div class="input-group">
											

																		<input class="form-control" name="start_date" type="date" />
																	</div>
																</div>
																
																<div class="col-xs-12 col-sm-2">
																	<div class="input-group">
											

																		<input class="form-control" name="end_date"type="date" />
																	</div>
																</div>
																<div class="col-xs-12 col-sm-1">
																	
																	</div>
																<div class="col-xs-12 col-sm-3 form-text text-muted">Format:- MM/DD/YYYY. Between these dates the audience will be able to interact with the ad.</div>
															</div>
															
															<div class="form-group">
																<label class="col-xs-12 col-sm-3 control-label no-padding-right">Exclusion Days <sup>*</sup></label>
																<div class="col-xs-12 col-sm-5">
																	
																		
											<select multiple="" id="state" name="exclusion_days" class="select2" data-placeholder="Click to Choose...">
												<option value="1">MONDAY</option>
												<option value="2">TUESDAY</option>
												<option value="3">WEDNESDAY</option>
												<option value="4">THUSDAY</option>
												<option value="5">FRIDAY</option>
												<option value="6">SATURDAY</option>
												<option value="0">SUNDAY</option>
											</select>

																</div>
																<div class="col-xs-12 col-sm-3 form-text text-muted">Days on which the ad will not be visible to audience.</div>
															</div>

															<div class="form-group">
																<label class="col-xs-12 col-sm-3 control-label no-padding-right">Deal Offer</label>
																<div class="col-xs-12 col-sm-5">
																	<input type="text" name="off_deal" class="width-100" placeholder="Offer text" value="<?php echo $saved_ad->off_deal; ?>" />
																</div>
																<div class="col-xs-12 col-sm-3 form-text text-muted">Free text to define discount on a deal.</div>
															</div>
															
															<div class="form-group">
																<label class="col-xs-12 col-sm-3 control-label no-padding-right">Coupon Code</label>
																<div class="col-xs-12 col-sm-5">
																	<input type="text" name="coupon_code" class="width-100" placeholder="Coupon Code" value="<?php echo $saved_ad->coupon_code; ?>" />
																</div>
																<div class="col-xs-12 col-sm-3 form-text text-muted">Coupon Code to avail dicount at the stores.</div>
															</div>
															
															<div class="form-group">
																<label class="col-xs-12 col-sm-3 control-label no-padding-right">Deal Link</label>
																<div class="col-xs-12 col-sm-5">
																	<input type="text" name="deal_link" class="width-100" placeholder="Link of Deal" value="<?php echo $saved_ad->deal_link; ?>" />
																</div>
																<div class="col-xs-12 col-sm-3 form-text text-muted">Link of the page where this offer is advertised.</div>
															</div>
															
															<?php if(is_null($ad_id) || $ad_id == "") { ?>
																<center><button type="submit" class="btn btn-primary" name="CREATE_AD">CREATE AD</button></center>
															<?php } else {  ?>
																<center><button type="submit" class="btn btn-primary" name="UPDATE_AD">UPDATE AD</button></center>
															<?php } ?>
														</form>
														
														<hr />
														
	
														<hr />
														<div class="row">
															<div class="pull-right">
																<form action="" method="POST">
																	<input type="hidden" name="FROM_AD">
																	<button class="btn" name="FORM_BACK">
																		<i class="ace-icon fa fa-arrow-left"></i>
																		Back
																	</button>
																	<button class="btn btn-success" name="FORM_NEXT">
																		Continue
																		<i class="ace-icon fa fa-arrow-right icon-on-right"></i>
																	</button>
																</form>
															</div>
														</div>
													</div>
		<div class="step-pane" data-step="3">

														<h3 class="lighter block green"><b>Audience Type</b></h3>
														<div class="row">
															<div class="col-sm-7 col-sm-offset-2">
																<form class="form-horizontal" id="sample-form" method="POST" action="">
																	<div class="form-group">
																		<label class="col-xs-12 col-sm-3 control-label no-padding-right">Age Group</label>
																		<div class="col-xs-8 col-sm-5">
																			<input type="hidden" name="ad_id" value="<?php echo $ad_id; ?>">
																			<input type="hidden" name="campaign_id" value="<?php echo $campaign_id; ?>">
																			<div id="slider-range"></div>
																			<input type="hidden" name="min_entry_age" id="min_age" value="<?php echo $saved_ad->min_entry_age; ?>">
																			<input type="hidden" name="max_entry_age" id="max_age" value="<?php echo $saved_ad->max_entry_age; ?>">
																		</div>
																	</div>
																	
																	<div class="form-group">
																		<label class="control-label col-xs-12 col-sm-3 no-padding-right">Gender</label>
																		<div class="col-xs-12 col-sm-9">
																			<div>
																				<label class="line-height-1">
																					<input name="entry_gender" value="all" type="radio" id="all_gender" class="ace" <?php if($saved_ad->entry_gender == "all") {echo "checked";} ?> />
																					<span class="lbl"> All</span>
																				</label>
																			</div>
																			<div>
																				<label class="line-height-1">
																					<input name="entry_gender" value="male" type="radio" id="male_gender" class="ace" <?php if($saved_ad->entry_gender == "male") {echo 'checked="checked"';} ?> />
																					<span class="lbl"> Male</span>
																				</label>
																			</div>
																			<div>
																				<label class="line-height-1">
																					<input name="entry_gender" value="female" type="radio" id="female_gender" class="ace" <?php if($saved_ad->entry_gender == "female") {echo 'checked="checked"';} ?>/>
																					<span class="lbl"> Female</span>
																				</label>
																			</div>
																		</div>
																	</div>

																	<div class="form-group">
																		<label class="control-label col-xs-12 col-sm-3 no-padding-right">Salary Group</label>

																		<div class="col-xs-12 col-sm-6">
																			<select id="salary_group" name="salary_group" class="form-control">
																				<option value="">All</option>
																				<?php 
																					foreach ($code_type["salary_group"] as $key => $value) {
																						if($saved_ad->salary_group == $key) {
																						?>
																							<option value="<?php echo $key; ?>" selected><?php echo $value; ?></option>
																						<?php
																						} else {
																							?>
																							<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
																						<?php
																						} 
																					}
																				?>
																			</select>
																		</div>
																	</div>
																	
																	<div class="form-group">
																		<label class="control-label col-xs-12 col-sm-3 no-padding-right">Club Membership</label>
																		<div class="col-xs-12 col-sm-6">
																			<select id="club_membership" name="club_membership" class="form-control">
																				<option value="">All</option>
																				<?php 
																					foreach ($code_type["club_type"] as $key => $value) {
																						if($saved_ad->club_membership == $key) {
																						?>
																							<option value="<?php echo $key; ?>" selected><?php echo $value; ?></option>
																						<?php
																						} else {
																							?>
																							<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
																							<?php
																						}
																					}
																				?>
																			</select>
																		</div>
																	</div>

																	<div class="form-group">
																		<label class="control-label col-xs-12 col-sm-3 no-padding-right">Defence Service</label>
																		<div class="col-xs-12 col-sm-6">
																			<select id="defence_service" name="defence_service" class="form-control">
																				<option value="">All</option>
																				<?php 
																					foreach ($code_type["defence_group"] as $key => $value) {
																						if($saved_ad->defence_service == $key) {
																						?>
																							<option value="<?php echo $key; ?>" selected><?php echo $value; ?></option>
																						<?php
																						} else {
																							?>
																							<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
																							<?php
																						}
																					}
																				?>
																			</select>
																		</div>
																	</div>

																	<div class="form-group">
																		<label class="control-label col-xs-12 col-sm-3 no-padding-right">Work Type</label>
																		<div class="col-xs-12 col-sm-6">
																			<select id="work_type" name="work_type" class="form-control">
																				<option value="">All</option>
																				<?php 
																					foreach ($code_type["work_type"] as $key => $value) {
																						if($saved_ad->work_type == $key) {
																						?>
																							<option value="<?php echo $key; ?>" selected><?php echo $value; ?></option>
																						<?php
																						} else {
																							?>
																							<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
																							<?php
																						}
																					}
																				?>
																			</select>
																		</div>
																	</div>

																	<div class="form-group">
																		<label class="control-label col-xs-12 col-sm-3 no-padding-right">Watch Brand</label>
																		<div class="col-xs-12 col-sm-6">
																			<select id="watch_brand" name="watch_brand" class="form-control">
																				<option value="">All</option>
																				<?php 
																					foreach ($code_type["watch_brand"] as $key => $value) {
																						if($saved_ad->watch_brand == $key) {
																						?>
																							<option value="<?php echo $key; ?>" selected><?php echo $value; ?></option>
																						<?php
																						} else {
																							?>
																							<option value="<?php echo $key; ?>" ><?php echo $value; ?></option>
																							<?php
																						}
																					}
																				?>
																			</select>
																		</div>
																	</div>

																	<div class="form-group">
																		<label class="control-label col-xs-12 col-sm-3 no-padding-right">Car</label>
																		<div class="col-xs-12 col-sm-6">
																			<select id="car_brand" name="car_brand" class="form-control">
																				<option value="">All</option>
																				<?php 
																					foreach ($code_type["car_brand"] as $key => $value) {
																						if($saved_ad->car_brand == $key) {
																						?>
																							<option value="<?php echo $key; ?>" selected><?php echo $value; ?></option>
																						<?php
																						} else {
																							?>
																							<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
																							<?php
																						}
																					}
																				?>
																			</select>
																		</div>
																	</div>

																	<div class="form-group">
																		<label class="control-label col-xs-12 col-sm-3 no-padding-right">Residence</label>
																		<div class="col-xs-12 col-sm-6">
																			<select id="residence_type" name="residence_type" class="form-control">
																				<option value="">All</option>
																				<?php 
																					foreach ($code_type["residence_type"] as $key => $value) {
																						if($saved_ad->residence_type == $key) {
																						?>
																							<option value="<?php echo $key; ?>" selected><?php echo $value; ?></option>
																						<?php
																						} else {
																							?>
																							<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
																							<?php
																						}
																					}
																				?>
																			</select>
																		</div>
																	</div>

																	<div class="form-group">
																		<label class="control-label col-xs-12 col-sm-3 no-padding-right">Transport</label>
																		<div class="col-xs-12 col-sm-6">
																			<select id="transport_type" name="transport_type" class="form-control">
																				<option value="">All</option>
																				<?php 
																					foreach ($code_type["transport_type"] as $key => $value) {
																						if($saved_ad->transport_type == $key) {
																						?>
																							<option value="<?php echo $key; ?>" selected><?php echo $value; ?></option>
																						<?php
																					  } else {
																					  	?>
																								<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
																					  	<?php 
																					  }
																					}
																				?>
																			</select>
																		</div>
																	</div>

																	<div class="form-group">
																		<label class="control-label col-xs-12 col-sm-3 no-padding-right">Miles Card</label>
																		<div class="col-xs-12 col-sm-6">
																			<select id="miles_card" name="miles_card" class="form-control">
																				<option value="">All</option>
																				<?php 
																					foreach ($code_type["miles_card"] as $key => $value) {
																						if($saved_ad->miles_card == $key) {
																						?>
																							<option value="<?php echo $key; ?>" selected><?php echo $value; ?></option>
																						<?php
																						} else {
																							?>
																							<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
																							<?php
																						}
																					}
																				?>
																			</select>
																		</div>
																	</div>
																	
																	<div class="form-group">
																		<label class="control-label col-xs-12 col-sm-3 no-padding-right">Credit Card</label>
																		<div class="col-xs-12 col-sm-6">
																			<select id="credit_card" name="credit_card" class="form-control">
																				<option value="">All</option>
																				<?php 
																					foreach ($code_type["credit_card"] as $key => $value) {
																						if($saved_ad->credit_card == $key) {
																						?>
																							<option value="<?php echo $key; ?>" selected><?php echo $value; ?></option>
																						<?php
																						} else {
																							?>
																							<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
																							<?php
																						}
																					}
																				?>
																			</select>
																		</div>
																	</div>
																	<div class="form-group">
																		<label class="control-label col-xs-12 col-sm-3 no-padding-right">Use Mobi for loyality audience</label>
																		<div class="col-xs-12 col-sm-6">
																			<div>
																				<label class="line-height-1">
																					<input name="use_loyality" value="yes" type="radio" class="ace" onclick="openModyAudienceBlock();" />
																					<span class="lbl"> Yes</span>
																				</label>
																			</div>
																			<div>
																				<label class="line-height-1">
																					<input name="use_loyality" value="no" type="radio" class="ace" onclick ="closeMobyAudienceBlock();" checked="checked" />
																					<span class="lbl"> No</span>
																				</label>
																			</div>
																		</div>
																	</div>

																	<div id="moby_audience" style="display: none;">
																		<div class="form-group">
																			<label class="control-label  col-xs-12 col-sm-3 no-padding-right">Loyalty Audience</label>
																			<div class="col-xs-12 col-sm-9">
																				<div>
																					<label class="line-height-1">
																						<input name="loyalty_audience" value="private" type="radio" id="lay" class="ace" checked="checked"/>
																						<span class="lbl"> Private</span>
																					</label>
																				</div>
																				<div>
																					<label class="line-height-1">
																						<input name="loyalty_audience" value="public" type="radio" id="male_gender" class="ace"  />
																						<span class="lbl"> Public</span>
																					</label>
																				</div>
																			</div>
																		</div>
																		
																		<div class="form-group">
																			<label class="control-label  col-xs-12 col-sm-3 no-padding-right">Moby Audience</label>
																			<div class="col-xs-12 col-sm-9">
																				<div>
																					<label class="line-height-1">
																						<input name="moby_audience" value="on" type="radio" id="lay" class="ace" checked="checked"/>
																						<span class="lbl"> On</span>
																					</label>
																				</div>
																				<div>
																					<label class="line-height-1">
																						<input name="moby_audience" value="off" type="radio" id="male_gender" class="ace"  />
																						<span class="lbl"> Off</span>
																					</label>
																				</div>
																			</div>
																		</div>
																	</div>
																	<?php if (!$saved_ad->audience_saved) {
																		?>
																		<center><button class="btn btn-primary" type="submit" name="SAVE_AUDIENCE">SAVE AUDIENCE</button></center>
																		<?php
																	} else {
																		?>
																		<center><button class="btn btn-primary" type="submit" name="SAVE_AUDIENCE">UPDATE AUDIENCE</button></center>
																		<?php
																	}?>
																	
																</form>
															</div>
															<div class="col-sm-3">
																<button type="button" class="btn btn-primary" onclick="takeAudienceType();">Refresh Audience</button>
																<div id="targeted_audience"></div>
															</div>
														</div>
														<hr />
														<div class="row">
															<div class="pull-right">
																<form action="" method="POST">
																	<input type="hidden" name="FROM_AUDIENCE">
																	<button class="btn" name="FORM_BACK">
																		<i class="ace-icon fa fa-arrow-left"></i>
																		Back
																	</button>
																	<button class="btn btn-success" name="FORM_NEXT">
																		Continue
																		<i class="ace-icon fa fa-arrow-right icon-on-right"></i>
																	</button>
																</form>
															</div>
														</div>
													</div>

<div class="step-pane" data-step="4">

														<h3 class="bolder block green"><center>Location</center></h3>
														<h5 class="bold"><center>Click on map to set location of ad</center></h5><br>
														<div class="center">
															<input id="searchInput" style="width: 50%" class="controls" type="text" placeholder="Enter a location">
															<div id="map"></div>
															</br>
															<button class="btn btn-warning" onclick="goFullscreen('map'); return false">Click Me To Go Fullscreen</button>
															<div style="padding: 20px">
															
																<!-- <form method="post" action=""> -->
																	<?php 
																			if(isset($saved_ad->locations[0])) {
																				$lat1 = $saved_ad->locations[0]["lat"];
																				$long1 = $saved_ad->locations[0]["long"];
																				$address1 = $saved_ad->locations[0]["state"];
																				$landmark1 = $saved_ad->locations[0]["landmark"];
																				$contact1 = $saved_ad->locations[0]["contact"];
																				$email1 = $saved_ad->locations[0]["email"];
																				$block1 = "display";
																			} else {
																				$lat1 = "";
																				$long1 = "";
																				$address1 = "";
																				$landmark1 = "";
																				$contact1 = "";
																				$email1 = "";
																				$block1 = "none";
																			}
																			?>
																	<div id="location1" class="row" style="display: <?php echo $block1; ?>;">
																		<br>
																		<div class="col-xs-2">Location 1</div>
																		<div class="col-xs-10">
																			<form method="POST" action="">
																			<div class="row">
																				<div class="col-sm-7">
																					<input type="text" name ="location_state" id="address1" placeholder="Address" class="form-control" value="<?php echo $address1; ?>" >
																					<input type="hidden" name="lat" id="lat1" placeholder="Latitude" value="<?php echo $lat1; ?>">
																					<input type="hidden" name="long" id="long1" placeholder="Longitude" value="<?php echo $long1; ?>">

																				</div>
																				<div class="col-sm-5">
																					<input type="text" name="landmark" class="form-control" value="<?php echo $landmark1; ?>" placeholder="Landmark">
																				</div>
																			</div>
																			<br>
																			<div class="row">
																				<div class="col-sm-4">
																					<input type="text" name="email" class="form-control" value="<?php echo $email1; ?>" placeholder="Email">
																				</div>
																				<div class="col-xs-4">
																					<input type="text" name="contact" class="form-control" value="<?php echo $contact1; ?>" placeholder="Contact">
																				</div>
																				<div class="col-xs-4">
																					<input type="hidden" name="ad_id" value="<?php echo $ad_id; ?>">
																					<input type="hidden" name="location_counter" value="1">
																					<?php if($block1 == "display") { ?>
																					<button type="submit" name="DELETE_LOCATION" class="btn btn-warning btn-sm active">DELETE</button>
																					<button type="button" name="SAVE_LOCATION" class="btn btn-primary btn-sm disabled">SAVE</button>
																					<?php } else { ?>
																					<button type="button" name="DELETE_LOCATION" class="btn btn-warning btn-sm disabled">DELETE</button>
																					<button type="submit" name="SAVE_LOCATION" class="btn btn-primary btn-sm active">SAVE</button>
																					<?php } ?>
																				</div>
																			</div>
																		</form>
																		</div>
																	</div>
																	<?php 
																		if(isset($saved_ad->locations[1])) {
																			$lat2 = $saved_ad->locations[1]["lat"];
																			$long2 = $saved_ad->locations[1]["long"];
																			$address2 = $saved_ad->locations[1]["state"];
																			$landmark2 = $saved_ad->locations[1]["landmark"];
																			$contact2 = $saved_ad->locations[1]["contact"];
																			$email2 = $saved_ad->locations[1]["email"];
																			$block2 = "display";
																		} else {
																			$lat2 = "";
																			$long2 = "";
																			$address2 = "";
																			$landmark2 = "";
																			$contact2 = "";
																			$email2 = "";
																			$block2 = "none";
																		}
																		?>
																	<div id="location2" class="row" style="display: <?php echo $block2; ?>;">
																		<hr>
																		<div class="col-xs-2">Location 2</div>
																		<div class="col-xs-10">
																			<form method="POST" action="">
																			<div class="row">
																				<div class="col-sm-7">
																					<input type="text" name ="location_state" id="address2" placeholder="Address" class="form-control" value="<?php echo $address2; ?>" >
																					<input type="hidden" name="lat" id="lat2" placeholder="Latitude" value="<?php echo $lat2; ?>">
																					<input type="hidden" name="long" id="long2" placeholder="Longitude" value="<?php echo $long2; ?>">

																				</div>
																				<div class="col-sm-5">
																					<input type="text" name="landmark" class="form-control" value="<?php echo $landmark2; ?>" placeholder="Landmark">
																				</div>
																			</div>
																			<br>
																			<div class="row">
																				<div class="col-sm-4">
																					<input type="text" name="email" class="form-control" value="<?php echo $email2; ?>" placeholder="Email">
																				</div>
																				<div class="col-xs-4">
																					<input type="text" name="contact" class="form-control" value="<?php echo $contact2; ?>" placeholder="Contact">
																				</div>
																				<div class="col-xs-4">
																						<input type="hidden" name="ad_id" value="<?php echo $ad_id; ?>">
																						<input type="hidden" name="location_counter" value="2">
																						<?php if($block2 == "display") { ?>
																						<button type="submit" name="DELETE_LOCATION" class="btn btn-warning btn-sm active">DELETE</button>
																						<button type="button" name="SAVE_LOCATION" class="btn btn-primary btn-sm disabled">SAVE</button>
																						<?php } else { ?>
																						<button type="button" name="DELETE_LOCATION" class="btn btn-warning btn-sm disabled">DELETE</button>
																						<button type="submit" name="SAVE_LOCATION" class="btn btn-primary btn-sm active">SAVE</button>
																						<?php } ?>
																				</div>
																			</div>
																		</form>
																		</div>
																	</div>
																	<?php 
																		if(isset($saved_ad->locations[2])) {
																			$lat3 = $saved_ad->locations[2]["lat"];
																			$long3 = $saved_ad->locations[2]["long"];
																			$address3 = $saved_ad->locations[2]["state"];
																			$landmark3 = $saved_ad->locations[2]["landmark"];
																			$contact3 = $saved_ad->locations[2]["contact"];
																			$email3 = $saved_ad->locations[2]["email"];
																			$block3 = "display";
																		} else {
																			$lat3 = "";
																			$long3 = "";
																			$address3 = "";
																			$landmark3 = "";
																			$contact3 = "";
																			$email3 = "";
																			$block3 = "none";
																		}
																		?>
																	<div id="location3" class="row" style="display: <?php echo $block3; ?>;">
																		<hr>
																		<div class="col-xs-2">Location 3</div>
																		<div class="col-xs-10">
																			<form method="POST" action="">
																			<div class="row">
																				<div class="col-sm-7">
																					<input type="text" name ="location_state" id="address3" placeholder="Address" class="form-control" value="<?php echo $address3; ?>" >
																					<input type="hidden" name="lat" id="lat3" placeholder="Latitude" value="<?php echo $lat3; ?>">
																					<input type="hidden" name="long" id="long3" placeholder="Longitude" value="<?php echo $long3; ?>">

																				</div>
																				<div class="col-sm-5">
																					<input type="text" name="landmark" class="form-control" value="<?php echo $landmark3; ?>" placeholder="Landmark">
																				</div>
																			</div>
																			<br>
																			<div class="row">
																				<div class="col-sm-4">
																					<input type="text" name="email" class="form-control" value="<?php echo $email3; ?>" placeholder="Email">
																				</div>
																				<div class="col-xs-4">
																					<input type="text" name="contact" class="form-control" value="<?php echo $contact3; ?>" placeholder="Contact">
																				</div>
																				<div class="col-xs-4">
																					<input type="hidden" name="ad_id" value="<?php echo $ad_id; ?>">
																					<input type="hidden" name="location_counter" value="3">
																					<?php if($block3 == "display") { ?>
																					<button type="submit" name="DELETE_LOCATION" class="btn btn-warning btn-sm active active">DELETE</button>
																					<button type="button" name="SAVE_LOCATION" class="btn btn-primary btn-sm disabled">SAVE</button>
																					<?php } else { ?>
																					<button type="button" name="DELETE_LOCATION" class="btn btn-warning btn-sm disabled">DELETE</button>
																					<button type="submit" name="SAVE_LOCATION" class="btn btn-primary btn-sm active active">SAVE</button>
																					<?php } ?>
																				</div>
																			</div>
																		</form>
																		</div>
																	</div>
																	<?php 
																		if(isset($saved_ad->locations[3])) {
																			$lat4 = $saved_ad->locations[3]["lat"];
																			$long4 = $saved_ad->locations[3]["long"];
																			$address4 = $saved_ad->locations[3]["state"];
																			$landmark4 = $saved_ad->locations[3]["landmark"];
																			$contact4 = $saved_ad->locations[3]["contact"];
																			$email4 = $saved_ad->locations[3]["email"];
																			$block4 = "display";
																		} else {
																			$lat4 = "";
																			$long4 = "";
																			$address4 = "";
																			$landmark4 = "";
																			$contact4 = "";
																			$email4 = "";
																			$block4 = "none";
																		}
																		?>
																	<div id="location4" class="row" style="display: <?php echo $block4; ?>;">
																		<hr>
																		<div class="col-xs-2">Location 4</div>
																		<div class="col-xs-10">
																			<form method="POST" action="">
																			<div class="row">
																				<div class="col-sm-7">
																					<input type="text" name ="location_state" id="address4" placeholder="Address" class="form-control" value="<?php echo $address4; ?>" >
																					<input type="hidden" name="lat" id="lat4" placeholder="Latitude" value="<?php echo $lat4; ?>">
																					<input type="hidden" name="long" id="long4" placeholder="Longitude" value="<?php echo $long4; ?>">

																				</div>
																				<div class="col-sm-5">
																					<input type="text" name="landmark" class="form-control" value="<?php echo $landmark4; ?>" placeholder="Landmark">
																				</div>
																			</div>
																			<br>
																			<div class="row">
																				<div class="col-sm-4">
																					<input type="text" name="email" class="form-control" value="<?php echo $email4; ?>" placeholder="Email">
																				</div>
																				<div class="col-xs-4">
																					<input type="text" name="contact" class="form-control" value="<?php echo $contact4; ?>" placeholder="Contact">
																				</div>
																				<div class="col-xs-4">
																						<input type="hidden" name="ad_id" value="<?php echo $ad_id; ?>">
																						<input type="hidden" name="location_counter" value="4">
																						<?php if($block4 == "display") { ?>
																					<button type="submit" name="DELETE_LOCATION" class="btn btn-warning btn-sm active">DELETE</button>
																					<button type="button" name="SAVE_LOCATION" class="btn btn-info btn-sm disabled">SAVE</button>
																					<?php } else { ?>
																					<button type="button" name="DELETE_LOCATION" class="btn btn-warning btn-sm disabled">DELETE</button>
																					<button type="submit" name="SAVE_LOCATION" class="btn btn-primary btn-sm active">SAVE</button>
																					<?php } ?>
																				</div>
																			</div>
																		</form>
																		</div>
																	</div>
																	<?php 
																		if(isset($saved_ad->locations[4])) {
																			$lat5 = $saved_ad->locations[4]["lat"];
																			$long5 = $saved_ad->locations[4]["long"];
																			$address5 = $saved_ad->locations[4]["state"];
																			$landmark5 = $saved_ad->locations[4]["landmark"];
																			$contact5 = $saved_ad->locations[4]["contact"];
																			$email5 = $saved_ad->locations[4]["email"];
																			$block5 = "display";
																		} else {
																			$lat5 = "";
																			$long5 = "";
																			$address5 = "";
																			$landmark5 = "";
																			$contact5 = "";
																			$email5 = "";
																			$block5 = "none";
																		}
																		?>
																	<div id="location5" class="row" style="display: <?php echo $block5; ?>;">
																		<hr>
																		<div class="col-xs-2">Location 5</div>
																		<div class="col-xs-10">
																			<form method="POST" action="">
																			<div class="row">
																				<div class="col-sm-7">
																					<input type="text" name ="location_state" id="address5" placeholder="Address" class="form-control" value="<?php echo $address5; ?>" >
																					<input type="hidden" name="lat" id="lat5" placeholder="Latitude" value="<?php echo $lat5; ?>">
																					<input type="hidden" name="long" id="long5" placeholder="Longitude" value="<?php echo $long5; ?>">

																				</div>
																				<div class="col-sm-5">
																					<input type="text" name="landmark" class="form-control" value="<?php echo $landmark5; ?>" placeholder="Landmark">
																				</div>
																			</div>
																			<br>
																			<div class="row">
																				<div class="col-sm-4">
																					<input type="text" name="email" class="form-control" value="<?php echo $email5; ?>" placeholder="Email">
																				</div>
																				<div class="col-xs-4">
																					<input type="text" name="contact" class="form-control" value="<?php echo $contact5; ?>" placeholder="Contact">
																				</div>
																				<div class="col-xs-4">
																						<input type="hidden" name="ad_id" value="<?php echo $ad_id; ?>">
																						<input type="hidden" name="location_counter" value="5">
																						<?php if($block5 == "display") { ?>
																					<button type="submit" name="DELETE_LOCATION" class="btn btn-warning btn-sm active">DELETE</button>
																					<button type="button" name="SAVE_LOCATION" class="btn btn-info btn-sm disabled">SAVE</button>
																					<?php } else { ?>
																					<button type="button" name="DELETE_LOCATION" class="btn btn-warning btn-sm disabled">DELETE</button>
																					<button type="submit" name="SAVE_LOCATION" class="btn btn-primary btn-sm active">SAVE</button>
																					<?php } ?>
																				</div>
																			</div>
																		</form>
																		</div>
																	</div>
																	<?php 
																		if(isset($saved_ad->locations[5])) {
																			$lat6 = $saved_ad->locations[5]["lat"];
																			$long6 = $saved_ad->locations[5]["long"];
																			$address6 = $saved_ad->locations[5]["state"];
																			$landmark6 = $saved_ad->locations[5]["landmark"];
																			$contact6 = $saved_ad->locations[5]["contact"];
																			$email6 = $saved_ad->locations[5]["email"];
																			$block6 = "display";
																		} else {
																			$lat6 = "";
																			$long6 = "";
																			$address6 = "";
																			$landmark6 = "";
																			$contact6 = "";
																			$email6 = "";
																			$block6 = "none";
																		}
																		?>
																	<div id="location6" class="row" style="display: <?php echo $block6; ?>;">
																		<hr>
																		<div class="col-xs-2">Location 6</div>
																		<div class="col-xs-10">
																			<form method="POST" action="">
																			<div class="row">
																				<div class="col-sm-7">
																					<input type="text" name ="location_state" id="address6" placeholder="Address" class="form-control" value="<?php echo $address6; ?>" >
																					<input type="hidden" name="lat" id="lat6" placeholder="Latitude" value="<?php echo $lat6; ?>">
																					<input type="hidden" name="long" id="long6" placeholder="Longitude" value="<?php echo $long6; ?>">

																				</div>
																				<div class="col-sm-5">
																					<input type="text" name="landmark" class="form-control" value="<?php echo $landmark6; ?>" placeholder="Landmark">
																				</div>
																			</div>
																			<br>
																			<div class="row">
																				<div class="col-sm-4">
																					<input type="text" name="email" class="form-control" value="<?php echo $email6; ?>" placeholder="Email">
																				</div>
																				<div class="col-xs-4">
																					<input type="text" name="contact" class="form-control" value="<?php echo $contact6; ?>" placeholder="Contact">
																				</div>
																				<div class="col-xs-4">
																						<input type="hidden" name="ad_id" value="<?php echo $ad_id; ?>">
																						<input type="hidden" name="location_counter" value="6">
																						<?php if($block6 == "display") { ?>
																					<button type="submit" name="DELETE_LOCATION" class="btn btn-warning btn-sm active">DELETE</button>
																					<button type="button" name="SAVE_LOCATION" class="btn btn-info btn-sm disabled">SAVE</button>
																					<?php } else { ?>
																					<button type="button" name="DELETE_LOCATION" class="btn btn-warning btn-sm disabled">DELETE</button>
																					<button type="submit" name="SAVE_LOCATION" class="btn btn-primary btn-sm active">SAVE</button>
																					<?php } ?>
																				</div>
																			</div>
																		</form>
																		</div>
																	</div>
																	<?php 
																		if(isset($saved_ad->locations[6])) {
																			$lat7 = $saved_ad->locations[6]["lat"];
																			$long7 = $saved_ad->locations[6]["long"];
																			$address7 = $saved_ad->locations[6]["state"];
																			$landmark7 = $saved_ad->locations[6]["landmark"];
																			$contact7 = $saved_ad->locations[6]["contact"];
																			$email7 = $saved_ad->locations[6]["email"];
																			$block7 = "display";
																		} else {
																			$lat7 = "";
																			$long7 = "";
																			$address7 = "";
																			$landmark7 = "";
																			$contact7 = "";
																			$email7 = "";
																			$block7 = "none";
																		}
																		?>
																	<div id="location7" class="row" style="display: <?php echo $block7; ?>;">
																		<hr>
																		<div class="col-xs-2">Location 7</div>
																		<div class="col-xs-10">
																			<form method="POST" action="">
																			<div class="row">
																				<div class="col-sm-7">
																					<input type="text" name ="location_state" id="address7" placeholder="Address" class="form-control" value="<?php echo $address7; ?>" >
																					<input type="hidden" name="lat" id="lat7" placeholder="Latitude" value="<?php echo $lat7; ?>">
																					<input type="hidden" name="long" id="long7" placeholder="Longitude" value="<?php echo $long7; ?>">

																				</div>
																				<div class="col-sm-5">
																					<input type="text" name="landmark" class="form-control" value="<?php echo $landmark7; ?>" placeholder="Landmark">
																				</div>
																			</div>
																			<br>
																			<div class="row">
																				<div class="col-sm-4">
																					<input type="text" name="email" class="form-control" value="<?php echo $email7; ?>" placeholder="Email">
																				</div>
																				<div class="col-xs-4">
																					<input type="text" name="contact" class="form-control" value="<?php echo $contact7; ?>" placeholder="Contact">
																				</div>
																				<div class="col-xs-4">
																						<input type="hidden" name="ad_id" value="<?php echo $ad_id; ?>">
																						<input type="hidden" name="location_counter" value="7">
																						<?php if($block7 == "display") { ?>
																					<button type="submit" name="DELETE_LOCATION" class="btn btn-warning btn-sm active">DELETE</button>
																					<button type="button" name="SAVE_LOCATION" class="btn btn-info btn-sm disabled">SAVE</button>
																					<?php } else { ?>
																					<button type="button" name="DELETE_LOCATION" class="btn btn-warning btn-sm disabled">DELETE</button>
																					<button type="submit" name="SAVE_LOCATION" class="btn btn-primary btn-sm active">SAVE</button>
																					<?php } ?>
																				</div>
																			</div>
																		</form>
																		</div>
																	</div>
																	<?php 
																		if(isset($saved_ad->locations[7])) {
																			$lat8 = $saved_ad->locations[7]["lat"];
																			$long8 = $saved_ad->locations[7]["long"];
																			$address8 = $saved_ad->locations[7]["state"];
																			$landmark8 = $saved_ad->locations[7]["landmark"];
																			$contact8 = $saved_ad->locations[7]["contact"];
																			$email8 = $saved_ad->locations[7]["email"];
																			$block8 = "display";
																		} else {
																			$lat8 = "";
																			$long8 = "";
																			$address8 = "";
																			$landmark8 = "";
																			$contact8 = "";
																			$email8 = "";
																			$block8 = "none";
																		}
																		?>
																	<div id="location8" class="row" style="display: <?php echo $block8; ?>;">
																		<hr>
																		<div class="col-xs-2">Location 8</div>
																		<div class="col-xs-10">
																			<form method="POST" action="">
																			<div class="row">
																				<div class="col-sm-7">
																					<input type="text" name ="location_state" id="address8" placeholder="Address" class="form-control" value="<?php echo $address8; ?>" >
																					<input type="hidden" name="lat" id="lat8" placeholder="Latitude" value="<?php echo $lat8; ?>">
																					<input type="hidden" name="long" id="long8" placeholder="Longitude" value="<?php echo $long8; ?>">
																				</div>
																				<div class="col-sm-5">
																					<input type="text" name="landmark" class="form-control" value="<?php echo $landmark8; ?>" placeholder="Landmark">
																				</div>
																			</div>
																			<br>
																			<div class="row">
																				<div class="col-sm-4">
																					<input type="text" name="email" class="form-control" value="<?php echo $email8; ?>" placeholder="Email">
																				</div>
																				<div class="col-xs-4">
																					<input type="text" name="contact" class="form-control" value="<?php echo $contact8; ?>" placeholder="Contact">
																				</div>
																				<div class="col-xs-4">
																						<input type="hidden" name="ad_id" value="<?php echo $ad_id; ?>">
																						<input type="hidden" name="location_counter" value="8">
																						<?php if($block8 == "display") { ?>
																					<button type="submit" name="DELETE_LOCATION" class="btn btn-warning btn-sm active">DELETE</button>
																					<button type="button" name="SAVE_LOCATION" class="btn btn-info btn-sm disabled">SAVE</button>
																					<?php } else { ?>
																					<button type="button" name="DELETE_LOCATION" class="btn btn-warning btn-sm disabled">DELETE</button>
																					<button type="submit" name="SAVE_LOCATION" class="btn btn-primary btn-sm active">SAVE</button>
																					<?php } ?>
																				</div>
																			</div>
																			<form method="POST" action="">
																		</div>
																	</div>
																	<?php 
																		if(isset($saved_ad->locations[8])) {
																			$lat9 = $saved_ad->locations[8]["lat"];
																			$long9 = $saved_ad->locations[8]["long"];
																			$address9 = $saved_ad->locations[8]["state"];
																			$landmark9 = $saved_ad->locations[8]["landmark"];
																			$contact9 = $saved_ad->locations[8]["contact"];
																			$email9 = $saved_ad->locations[8]["email"];
																			$block9 = "display";
																		} else {
																			$lat9 = "";
																			$long9 = "";
																			$address9 = "";
																			$landmark9 = "";
																			$contact9 = "";
																			$email9 = "";
																			$block9 = "none";
																		}
																		?>
																	<div id="location9" class="row" style="display: <?php echo $block9; ?>;">
																		<hr>
																		<div class="col-xs-2">Location 9</div>
																		<div class="col-xs-10">
																			<form method="POST" action="">
																			<div class="row">
																				<div class="col-sm-7">
																					<input type="text" name ="location_state" id="address9" placeholder="Address" class="form-control" value="<?php echo $address9; ?>" >
																					<input type="hidden" name="lat" id="lat9" placeholder="Latitude" value="<?php echo $lat9; ?>">
																					<input type="hidden" name="long" id="long9" placeholder="Longitude" value="<?php echo $long9; ?>">
																				</div>
																				<div class="col-sm-5">
																					<input type="text" name="landmark" class="form-control" value="<?php echo $landmark9; ?>" placeholder="Landmark">
																				</div>
																			</div>
																			<br>
																			<div class="row">
																				<div class="col-sm-4">
																					<input type="text" name="email" class="form-control" value="<?php echo $email9; ?>" placeholder="Email">
																				</div>
																				<div class="col-xs-4">
																					<input type="text" name="contact" class="form-control" value="<?php echo $contact9; ?>" placeholder="Contact">
																				</div>
																				<div class="col-xs-4">
																						<input type="hidden" name="ad_id" value="<?php echo $ad_id; ?>">
																						<input type="hidden" name="location_counter" value="9">
																						<?php if($block9 == "display") { ?>
																					<button type="submit" name="DELETE_LOCATION" class="btn btn-warning btn-sm active">DELETE</button>
																					<button type="button" name="SAVE_LOCATION" class="btn btn-info btn-sm disabled">SAVE</button>
																					<?php } else { ?>
																					<button type="button" name="DELETE_LOCATION" class="btn btn-warning btn-sm disabled">DELETE</button>
																					<button type="submit" name="SAVE_LOCATION" class="btn btn-primary btn-sm active">SAVE</button>
																					<?php } ?>
																				</div>
																			</div>
																		</form>
																		</div>
																	</div>
																	<?php 
																		if(isset($saved_ad->locations[9])) {
																			$lat10 = $saved_ad->locations[9]["lat"];
																			$long10 = $saved_ad->locations[9]["long"];
																			$address10 = $saved_ad->locations[9]["state"];
																			$landmark10 = $saved_ad->locations[9]["landmark"];
																			$contact10 = $saved_ad->locations[9]["contact"];
																			$email10 = $saved_ad->locations[9]["email"];
																			$block10 = "display";
																		} else {
																			$lat10 = "";
																			$long10 = "";
																			$address10 = "";
																			$landmark10 = "";
																			$contact10 = "";
																			$email10 = "";
																			$block10 = "none";
																		}
																		?>
																	<div id="location10" class="row" style="display: <?php echo $block10; ?>;">
																		<hr>
																		<div class="col-xs-2">Location 10</div>
																		<div class="col-xs-10">
																			<form method="POST" action="">
																			<div class="row">
																				<div class="col-sm-7">
																					<input type="text" name ="location_state" id="address10" placeholder="Address" class="form-control" value="<?php echo $address10; ?>" >
																					<input type="hidden" name="lat" id="lat10" placeholder="Latitude" value="<?php echo $lat10; ?>">
																					<input type="hidden" name="long" id="long10" placeholder="Longitude" value="<?php echo $long10; ?>">
																				</div>
																				<div class="col-sm-5">
																					<input type="text" name="landmark" class="form-control" value="<?php echo $landmark10; ?>" placeholder="Landmark">
																				</div>
																			</div>
																			<br>
																			<div class="row">
																				<div class="col-sm-4">
																					<input type="text" name="email" class="form-control" value="<?php echo $email10; ?>" placeholder="Email">
																				</div>
																				<div class="col-xs-4">
																					<input type="text" name="contact" class="form-control" value="<?php echo $contact10; ?>" placeholder="Contact">
																				</div>
																				<div class="col-xs-4">
																					<input type="hidden" name="ad_id" value="<?php echo $ad_id; ?>">
																					<input type="hidden" name="location_counter" value="10">
																					<?php if($block10 == "display") { ?>
																					<button type="submit" name="DELETE_LOCATION" class="btn btn-warning btn-sm active">DELETE</button>
																					<button type="button" name="SAVE_LOCATION" class="btn btn-primary btn-sm disabled">SAVE</button>
																					<?php } else { ?>
																					<button type="button" name="DELETE_LOCATION" class="btn btn-warning btn-sm disabled">DELETE</button>
																					<button type="submit" name="SAVE_LOCATION" class="btn btn-primary btn-sm active">SAVE</button>
																					<?php } ?>
																				</div>
																			</div>
																		</form>
																		</div>
																	</div>
																	<br>
																	<!-- <?php if(empty($saved_ad->locations)) {
																		?>
																		<center><button id="save_location_button" class="btn btn-primary" type="submit" name="SAVE_AD_LOCATIONS" style="display: none;">SAVE AD LOCATIONS</button></center>
																		<?php
																	} else {
																		?>
																		<center><button id="save_location_button" class="btn btn-primary" type="submit" name="UPDATE_AD_LOCATIONS" style="">UPDATE AD LOCATIONS</button></center>
																		<?php
																	} ?>
															  </form> -->
															</div>

															<hr />
															<div class="row">
																<div class="pull-right">
																	<form action="" method="POST">
																		<input type="hidden" name="FROM_LOCATION">
																		<button class="btn" name="FORM_BACK">
																			<i class="ace-icon fa fa-arrow-left"></i>
																			Back
																		</button>
																		<button class="btn btn-success" name="FORM_NEXT">
																			Continue
																			<i class="ace-icon fa fa-arrow-right icon-on-right"></i>
																		</button>
																	</form>
																</div>
															</div>

														</div>
													</div>

<div class="step-pane" data-step="5">
<div id="myDIV">
														<h4 class="lighter block green"><b>Question</b></h3>
														<form class="form-horizontal" id="sample-form" action="" method="post">
															<h5>Question 1</h5>
															<?php if(isset($saved_ad->questions[0])) {
																$saved_question1 = $saved_ad->questions[0]["question"];
																$options = explode("*,*", $saved_ad->questions[0]["options"]);
																$saved_option11 = $options[0];
																$saved_option12 = $options[1];
																$saved_option13 = $options[2];
																$saved_option14 = $options[3];
																$correct_option1 = $saved_ad->questions[0]["answer"];
															} else {
																$saved_question1 = "";
																$saved_option11 = "";
																$saved_option12 = "";
																$saved_option13 = "";
																$saved_option14 = "";
																$correct_option1 = "";
															} ?>
															<div class="control-group">
																<input type="hidden" name="ad_id" value="<?php echo $ad_id; ?>">
																<input type="hidden" name="campaign_id" value="<?php echo $campaign_id; ?>">
																<input type="text" name="question[]" class="width-50" placeholder="Enter question 1" required value="<?php echo $saved_question1; ?>" />
																<input type="hidden" name="price1" class="width-5" value="0">
																<div class="control-group">
																	<label class="line-height-1">
																		<input name="radio1" type="radio" class="ace" value="1" checked />
																		<span class="lbl"><input type="text" name="option1[]" placeholder="First Option" value="<?php echo $saved_option11; ?>" required/></span>
																	</label>
																</div>

																<div class="control-group">
																	<label class="line-height-1">
																		<input name="radio1" type="radio" class="ace" value="2" <?php if($correct_option1 == "2") {echo "checked";} ?>/>
																		<span class="lbl"><input type="text" name="option1[]" placeholder="Second Option" value="<?php echo $saved_option12; ?>" required/></span>
																	</label>
																</div>

																<div class="control-group">
																	<label class="line-height-1">
																		<input name="radio1" type="radio" class="ace" value="3" <?php if($correct_option1 == "3") {echo "checked";} ?>/>
																		<span class="lbl"><input type="text" name="option1[]" placeholder="Third Option" value="<?php echo $saved_option13; ?>" required/></span>
																	</label>
																</div>

																<div class="control-group">
																	<label class="line-height-1">
																		<input name="radio1" type="radio" class="ace" value="4" <?php if($correct_option1 == "4") {echo "checked";} ?>/>
																		<span class="lbl"><input type="text" name="option1[]" placeholder="Fourth Option" value="<?php echo $saved_option14; ?>" required/></span>
																	</label>
																</div>
															</div>
															<h5>Question 2</h5>
															<?php if(isset($saved_ad->questions[1])) {
																$saved_question2 = $saved_ad->questions[1]["question"];
																$options = explode("*,*", $saved_ad->questions[1]["options"]);
																$saved_option21 = $options[0];
																$saved_option22 = $options[1];
																$saved_option23 = $options[2];
																$saved_option24 = $options[3];
																$correct_option2 = $saved_ad->questions[1]["answer"];
															} else {
																$saved_question2 = "";
																$saved_option21 = "";
																$saved_option22 = "";
																$saved_option23 = "";
																$saved_option24 = "";
																$correct_option2 = "";
															} ?>
															<div class="control-group">
																<input type="text" name = "question[]" class="width-50" placeholder="Enter question 2" value="<?php echo $saved_question2; ?>" />
																<input type="hidden" name="price2" class="width-5" value="0">
																<div class="control-group">
																	<label class="line-height-1">
																		<input name="radio2" type="radio" class="ace" value="1" checked />
																		<span class="lbl"><input type="text" name="option2[]"  placeholder="First Option" value="<?php echo $saved_option21; ?>" required/></span>
																	</label>
																</div>

																<div class="control-group">
																	<label class="line-height-1">
																		<input name="radio2" type="radio" class="ace" value="2" <?php if($correct_option2 == "2") {echo "checked";} ?> />
																		<span class="lbl"><input type="text" name="option2[]" placeholder="Second Option" value="<?php echo $saved_option22; ?>" required/></span>
																	</label>
																</div>

																<div class="control-group">
																	<label class="line-height-1">
																		<input name="radio2" type="radio" class="ace" value="3"  <?php if($correct_option2 == "3") {echo "checked";} ?>/>
																		<span class="lbl"><input type="text" name="option2[]" placeholder="Third Option" value="<?php echo $saved_option23; ?>" required/></span>
																	</label>
																</div>

																<div class="control-group">
																	<label class="line-height-1">
																		<input name="radio2" type="radio" class="ace" value="4"  <?php if($correct_option2 == "4") {echo "checked";} ?>/>
																		<span class="lbl"><input type="text" name="option2[]" placeholder="Fourth Option" value="<?php echo $saved_option24; ?>" required/></span>
																	</label>
																</div>
															</div>
															<h5>Question 3</h5>
															<?php if(isset($saved_ad->questions[2])) {
																$saved_question3 = $saved_ad->questions[2]["question"];
																$options = explode("*,*", $saved_ad->questions[2]["options"]);
																$saved_option31 = $options[0];
																$saved_option32 = $options[1];
																$saved_option33 = $options[2];
																$saved_option34 = $options[3];
																$correct_option3 = $saved_ad->questions[2]["answer"];
															} else {
																$saved_question3 = "";
																$saved_option31 = "";
																$saved_option32 = "";
																$saved_option33 = "";
																$saved_option34 = "";
																$correct_option3 = "";
															} ?>
															<div class="control-group">
																<input type="text" name = "question[]" class="width-50" placeholder="Enter question 3" value="<?php echo $saved_question3; ?>" />
																<input type="hidden" name="price3" class="width-5" value="0">
																<div class="control-group">
																	<label class="line-height-1">
																		<input name="radio3" type="radio" class="ace" value="1" checked/>
																		<span class="lbl"><input type="text" name="option3[]" placeholder="First Option" value="<?php echo $saved_option31; ?>" required/></span>
																	</label>
																</div>

																<div class="control-group">
																	<label class="line-height-1">
																		<input name="radio3" type="radio" class="ace" value="2" <?php if($correct_option3 == "2") {echo "checked";} ?>/>
																		<span class="lbl"><input type="text" name="option3[]" placeholder="Second Option" value="<?php echo $saved_option32; ?>" required/></span>
																	</label>
																</div>

																<div class="control-group">
																	<label class="line-height-1">
																		<input name="radio3" type="radio" class="ace" value="3" <?php if($correct_option3 == "3") {echo "checked";} ?>/>
																		<span class="lbl"><input type="text" name="option3[]" placeholder="Third Option" value="<?php echo $saved_option33; ?>" required/></span>
																	</label>
																</div>

																<div class="control-group">
																	<label class="line-height-1">
																		<input name="radio3" type="radio" class="ace" value="4" <?php if($correct_option3 == "4") {echo "checked";} ?>/>
															</div>
															</div>
															<?php if(empty($saved_ad->questions)) { ?>
															<center><button type="submit" class="btn btn-primary" name="SAVE_AD_QUESTIONS">SAVE QUESTION</button></center>
															<?php } else { ?>
															<center><button type="submit" class="btn btn-primary" name="UPDATE_AD_QUESTIONS">UPDATE QUESTION</button></center>
															<?php } ?>
														</form>
																
														<hr /></DIV>
														<div class="row">
															<div class="pull-right">
																<form action="" method="POST">
																	<input type="hidden" name="FROM_QUESTION">
																	<button class="btn" name="FORM_BACK">
																		<i class="ace-icon fa fa-arrow-left"></i>
																		Back
																	</button>
																	<button class="btn btn-success" name="FORM_NEXT">
																		Continue
																		<i class="ace-icon fa fa-arrow-right icon-on-right"></i>
																	</button>
																</form>
															</div>
														</div>
													</div>
	<div class="step-pane" data-step="7">

														<h3 class="bolder block green"><center>Preview</center></h3>
														<h5 class="bold"><center>Click on map to set location of ad</center></h5><br>
														<div class="center">
															<input id="searchInput" style="width: 50%" class="controls" type="text" placeholder="Enter a location">
															<div id="map"></div>
															</br>
															<button class="btn btn-warning" onclick="goFullscreen('map'); return false">Click Me To Go Fullscreen</button>
															<div style="padding: 20px">
															
																<!-- <form method="post" action=""> -->
																	<?php 
																			if(isset($saved_ad->locations[0])) {
																				$lat1 = $saved_ad->locations[0]["lat"];
																				$long1 = $saved_ad->locations[0]["long"];
																				$address1 = $saved_ad->locations[0]["state"];
																				$landmark1 = $saved_ad->locations[0]["landmark"];
																				$contact1 = $saved_ad->locations[0]["contact"];
																				$email1 = $saved_ad->locations[0]["email"];
																				$block1 = "display";
																			} else {
																				$lat1 = "";
																				$long1 = "";
																				$address1 = "";
																				$landmark1 = "";
																				$contact1 = "";
																				$email1 = "";
																				$block1 = "none";
																			}
																			?>
																	<div id="location1" class="row" style="display: <?php echo $block1; ?>;">
																		<br>
																		<div class="col-xs-2">Location 1</div>
																		<div class="col-xs-10">
																			<form method="POST" action="">
																			<div class="row">
																				<div class="col-sm-7">
																					<input type="text" name ="location_state" id="address1" placeholder="Address" class="form-control" value="<?php echo $address1; ?>" >
																					<input type="hidden" name="lat" id="lat1" placeholder="Latitude" value="<?php echo $lat1; ?>">
																					<input type="hidden" name="long" id="long1" placeholder="Longitude" value="<?php echo $long1; ?>">

																				</div>
																				<div class="col-sm-5">
																					<input type="text" name="landmark" class="form-control" value="<?php echo $landmark1; ?>" placeholder="Landmark">
																				</div>
																			</div>
																			<br>
																			<div class="row">
																				<div class="col-sm-4">
																					<input type="text" name="email" class="form-control" value="<?php echo $email1; ?>" placeholder="Email">
																				</div>
																				<div class="col-xs-4">
																					<input type="text" name="contact" class="form-control" value="<?php echo $contact1; ?>" placeholder="Contact">
																				</div>
																				<div class="col-xs-4">
																					<input type="hidden" name="ad_id" value="<?php echo $ad_id; ?>">
																					<input type="hidden" name="location_counter" value="1">
																					<?php if($block1 == "display") { ?>
																					<button type="submit" name="DELETE_LOCATION" class="btn btn-warning btn-sm active">DELETE</button>
																					<button type="button" name="SAVE_LOCATION" class="btn btn-primary btn-sm disabled">SAVE</button>
																					<?php } else { ?>
																					<button type="button" name="DELETE_LOCATION" class="btn btn-warning btn-sm disabled">DELETE</button>
																					<button type="submit" name="SAVE_LOCATION" class="btn btn-primary btn-sm active">SAVE</button>
																					<?php } ?>
																				</div>
																			</div>
																		</form>
																		</div>
																	</div>
																	<?php 
																		if(isset($saved_ad->locations[1])) {
																			$lat2 = $saved_ad->locations[1]["lat"];
																			$long2 = $saved_ad->locations[1]["long"];
																			$address2 = $saved_ad->locations[1]["state"];
																			$landmark2 = $saved_ad->locations[1]["landmark"];
																			$contact2 = $saved_ad->locations[1]["contact"];
																			$email2 = $saved_ad->locations[1]["email"];
																			$block2 = "display";
																		} else {
																			$lat2 = "";
																			$long2 = "";
																			$address2 = "";
																			$landmark2 = "";
																			$contact2 = "";
																			$email2 = "";
																			$block2 = "none";
																		}
																		?>
																	<div id="location2" class="row" style="display: <?php echo $block2; ?>;">
																		<hr>
																		<div class="col-xs-2">Location 2</div>
																		<div class="col-xs-10">
																			<form method="POST" action="">
																			<div class="row">
																				<div class="col-sm-7">
																					<input type="text" name ="location_state" id="address2" placeholder="Address" class="form-control" value="<?php echo $address2; ?>" >
																					<input type="hidden" name="lat" id="lat2" placeholder="Latitude" value="<?php echo $lat2; ?>">
																					<input type="hidden" name="long" id="long2" placeholder="Longitude" value="<?php echo $long2; ?>">

																				</div>
																				<div class="col-sm-5">
																					<input type="text" name="landmark" class="form-control" value="<?php echo $landmark2; ?>" placeholder="Landmark">
																				</div>
																			</div>
																			<br>
																			<div class="row">
																				<div class="col-sm-4">
																					<input type="text" name="email" class="form-control" value="<?php echo $email2; ?>" placeholder="Email">
																				</div>
																				<div class="col-xs-4">
																					<input type="text" name="contact" class="form-control" value="<?php echo $contact2; ?>" placeholder="Contact">
																				</div>
																				<div class="col-xs-4">
																						<input type="hidden" name="ad_id" value="<?php echo $ad_id; ?>">
																						<input type="hidden" name="location_counter" value="2">
																						<?php if($block2 == "display") { ?>
																						<button type="submit" name="DELETE_LOCATION" class="btn btn-warning btn-sm active">DELETE</button>
																						<button type="button" name="SAVE_LOCATION" class="btn btn-primary btn-sm disabled">SAVE</button>
																						<?php } else { ?>
																						<button type="button" name="DELETE_LOCATION" class="btn btn-warning btn-sm disabled">DELETE</button>
																						<button type="submit" name="SAVE_LOCATION" class="btn btn-primary btn-sm active">SAVE</button>
																						<?php } ?>
																				</div>
																			</div>
																		</form>
																		</div>
																	</div>
																	<?php 
																		if(isset($saved_ad->locations[2])) {
																			$lat3 = $saved_ad->locations[2]["lat"];
																			$long3 = $saved_ad->locations[2]["long"];
																			$address3 = $saved_ad->locations[2]["state"];
																			$landmark3 = $saved_ad->locations[2]["landmark"];
																			$contact3 = $saved_ad->locations[2]["contact"];
																			$email3 = $saved_ad->locations[2]["email"];
																			$block3 = "display";
																		} else {
																			$lat3 = "";
																			$long3 = "";
																			$address3 = "";
																			$landmark3 = "";
																			$contact3 = "";
																			$email3 = "";
																			$block3 = "none";
																		}
																		?>
																	<div id="location3" class="row" style="display: <?php echo $block3; ?>;">
																		<hr>
																		<div class="col-xs-2">Location 3</div>
																		<div class="col-xs-10">
																			<form method="POST" action="">
																			<div class="row">
																				<div class="col-sm-7">
																					<input type="text" name ="location_state" id="address3" placeholder="Address" class="form-control" value="<?php echo $address3; ?>" >
																					<input type="hidden" name="lat" id="lat3" placeholder="Latitude" value="<?php echo $lat3; ?>">
																					<input type="hidden" name="long" id="long3" placeholder="Longitude" value="<?php echo $long3; ?>">

																				</div>
																				<div class="col-sm-5">
																					<input type="text" name="landmark" class="form-control" value="<?php echo $landmark3; ?>" placeholder="Landmark">
																				</div>
																			</div>
																			<br>
																			<div class="row">
																				<div class="col-sm-4">
																					<input type="text" name="email" class="form-control" value="<?php echo $email3; ?>" placeholder="Email">
																				</div>
																				<div class="col-xs-4">
																					<input type="text" name="contact" class="form-control" value="<?php echo $contact3; ?>" placeholder="Contact">
																				</div>
																				<div class="col-xs-4">
																					<input type="hidden" name="ad_id" value="<?php echo $ad_id; ?>">
																					<input type="hidden" name="location_counter" value="3">
																					<?php if($block3 == "display") { ?>
																					<button type="submit" name="DELETE_LOCATION" class="btn btn-warning btn-sm active active">DELETE</button>
																					<button type="button" name="SAVE_LOCATION" class="btn btn-primary btn-sm disabled">SAVE</button>
																					<?php } else { ?>
																					<button type="button" name="DELETE_LOCATION" class="btn btn-warning btn-sm disabled">DELETE</button>
																					<button type="submit" name="SAVE_LOCATION" class="btn btn-primary btn-sm active active">SAVE</button>
																					<?php } ?>
																				</div>
																			</div>
																		</form>
																		</div>
																	</div>
																	<?php 
																		if(isset($saved_ad->locations[3])) {
																			$lat4 = $saved_ad->locations[3]["lat"];
																			$long4 = $saved_ad->locations[3]["long"];
																			$address4 = $saved_ad->locations[3]["state"];
																			$landmark4 = $saved_ad->locations[3]["landmark"];
																			$contact4 = $saved_ad->locations[3]["contact"];
																			$email4 = $saved_ad->locations[3]["email"];
																			$block4 = "display";
																		} else {
																			$lat4 = "";
																			$long4 = "";
																			$address4 = "";
																			$landmark4 = "";
																			$contact4 = "";
																			$email4 = "";
																			$block4 = "none";
																		}
																		?>
																	<div id="location4" class="row" style="display: <?php echo $block4; ?>;">
																		<hr>
																		<div class="col-xs-2">Location 4</div>
																		<div class="col-xs-10">
																			<form method="POST" action="">
																			<div class="row">
																				<div class="col-sm-7">
																					<input type="text" name ="location_state" id="address4" placeholder="Address" class="form-control" value="<?php echo $address4; ?>" >
																					<input type="hidden" name="lat" id="lat4" placeholder="Latitude" value="<?php echo $lat4; ?>">
																					<input type="hidden" name="long" id="long4" placeholder="Longitude" value="<?php echo $long4; ?>">

																				</div>
																				<div class="col-sm-5">
																					<input type="text" name="landmark" class="form-control" value="<?php echo $landmark4; ?>" placeholder="Landmark">
																				</div>
																			</div>
																			<br>
																			<div class="row">
																				<div class="col-sm-4">
																					<input type="text" name="email" class="form-control" value="<?php echo $email4; ?>" placeholder="Email">
																				</div>
																				<div class="col-xs-4">
																					<input type="text" name="contact" class="form-control" value="<?php echo $contact4; ?>" placeholder="Contact">
																				</div>
																				<div class="col-xs-4">
																						<input type="hidden" name="ad_id" value="<?php echo $ad_id; ?>">
																						<input type="hidden" name="location_counter" value="4">
																						<?php if($block4 == "display") { ?>
																					<button type="submit" name="DELETE_LOCATION" class="btn btn-warning btn-sm active">DELETE</button>
																					<button type="button" name="SAVE_LOCATION" class="btn btn-info btn-sm disabled">SAVE</button>
																					<?php } else { ?>
																					<button type="button" name="DELETE_LOCATION" class="btn btn-warning btn-sm disabled">DELETE</button>
																					<button type="submit" name="SAVE_LOCATION" class="btn btn-primary btn-sm active">SAVE</button>
																					<?php } ?>
																				</div>
																			</div>
																		</form>
																		</div>
																	</div>
																	<?php 
																		if(isset($saved_ad->locations[4])) {
																			$lat5 = $saved_ad->locations[4]["lat"];
																			$long5 = $saved_ad->locations[4]["long"];
																			$address5 = $saved_ad->locations[4]["state"];
																			$landmark5 = $saved_ad->locations[4]["landmark"];
																			$contact5 = $saved_ad->locations[4]["contact"];
																			$email5 = $saved_ad->locations[4]["email"];
																			$block5 = "display";
																		} else {
																			$lat5 = "";
																			$long5 = "";
																			$address5 = "";
																			$landmark5 = "";
																			$contact5 = "";
																			$email5 = "";
																			$block5 = "none";
																		}
																		?>
																	<div id="location5" class="row" style="display: <?php echo $block5; ?>;">
																		<hr>
																		<div class="col-xs-2">Location 5</div>
																		<div class="col-xs-10">
																			<form method="POST" action="">
																			<div class="row">
																				<div class="col-sm-7">
																					<input type="text" name ="location_state" id="address5" placeholder="Address" class="form-control" value="<?php echo $address5; ?>" >
																					<input type="hidden" name="lat" id="lat5" placeholder="Latitude" value="<?php echo $lat5; ?>">
																					<input type="hidden" name="long" id="long5" placeholder="Longitude" value="<?php echo $long5; ?>">

																				</div>
																				<div class="col-sm-5">
																					<input type="text" name="landmark" class="form-control" value="<?php echo $landmark5; ?>" placeholder="Landmark">
																				</div>
																			</div>
																			<br>
																			<div class="row">
																				<div class="col-sm-4">
																					<input type="text" name="email" class="form-control" value="<?php echo $email5; ?>" placeholder="Email">
																				</div>
																				<div class="col-xs-4">
																					<input type="text" name="contact" class="form-control" value="<?php echo $contact5; ?>" placeholder="Contact">
																				</div>
																				<div class="col-xs-4">
																						<input type="hidden" name="ad_id" value="<?php echo $ad_id; ?>">
																						<input type="hidden" name="location_counter" value="5">
																						<?php if($block5 == "display") { ?>
																					<button type="submit" name="DELETE_LOCATION" class="btn btn-warning btn-sm active">DELETE</button>
																					<button type="button" name="SAVE_LOCATION" class="btn btn-info btn-sm disabled">SAVE</button>
																					<?php } else { ?>
																					<button type="button" name="DELETE_LOCATION" class="btn btn-warning btn-sm disabled">DELETE</button>
																					<button type="submit" name="SAVE_LOCATION" class="btn btn-primary btn-sm active">SAVE</button>
																					<?php } ?>
																				</div>
																			</div>
																		</form>
																		</div>
																	</div>
																	<?php 
																		if(isset($saved_ad->locations[5])) {
																			$lat6 = $saved_ad->locations[5]["lat"];
																			$long6 = $saved_ad->locations[5]["long"];
																			$address6 = $saved_ad->locations[5]["state"];
																			$landmark6 = $saved_ad->locations[5]["landmark"];
																			$contact6 = $saved_ad->locations[5]["contact"];
																			$email6 = $saved_ad->locations[5]["email"];
																			$block6 = "display";
																		} else {
																			$lat6 = "";
																			$long6 = "";
																			$address6 = "";
																			$landmark6 = "";
																			$contact6 = "";
																			$email6 = "";
																			$block6 = "none";
																		}
																		?>
																	<div id="location6" class="row" style="display: <?php echo $block6; ?>;">
																		<hr>
																		<div class="col-xs-2">Location 6</div>
																		<div class="col-xs-10">
																			<form method="POST" action="">
																			<div class="row">
																				<div class="col-sm-7">
																					<input type="text" name ="location_state" id="address6" placeholder="Address" class="form-control" value="<?php echo $address6; ?>" >
																					<input type="hidden" name="lat" id="lat6" placeholder="Latitude" value="<?php echo $lat6; ?>">
																					<input type="hidden" name="long" id="long6" placeholder="Longitude" value="<?php echo $long6; ?>">

																				</div>
																				<div class="col-sm-5">
																					<input type="text" name="landmark" class="form-control" value="<?php echo $landmark6; ?>" placeholder="Landmark">
																				</div>
																			</div>
																			<br>
																			<div class="row">
																				<div class="col-sm-4">
																					<input type="text" name="email" class="form-control" value="<?php echo $email6; ?>" placeholder="Email">
																				</div>
																				<div class="col-xs-4">
																					<input type="text" name="contact" class="form-control" value="<?php echo $contact6; ?>" placeholder="Contact">
																				</div>
																				<div class="col-xs-4">
																						<input type="hidden" name="ad_id" value="<?php echo $ad_id; ?>">
																						<input type="hidden" name="location_counter" value="6">
																						<?php if($block6 == "display") { ?>
																					<button type="submit" name="DELETE_LOCATION" class="btn btn-warning btn-sm active">DELETE</button>
																					<button type="button" name="SAVE_LOCATION" class="btn btn-info btn-sm disabled">SAVE</button>
																					<?php } else { ?>
																					<button type="button" name="DELETE_LOCATION" class="btn btn-warning btn-sm disabled">DELETE</button>
																					<button type="submit" name="SAVE_LOCATION" class="btn btn-primary btn-sm active">SAVE</button>
																					<?php } ?>
																				</div>
																			</div>
																		</form>
																		</div>
																	</div>
																	<?php 
																		if(isset($saved_ad->locations[6])) {
																			$lat7 = $saved_ad->locations[6]["lat"];
																			$long7 = $saved_ad->locations[6]["long"];
																			$address7 = $saved_ad->locations[6]["state"];
																			$landmark7 = $saved_ad->locations[6]["landmark"];
																			$contact7 = $saved_ad->locations[6]["contact"];
																			$email7 = $saved_ad->locations[6]["email"];
																			$block7 = "display";
																		} else {
																			$lat7 = "";
																			$long7 = "";
																			$address7 = "";
																			$landmark7 = "";
																			$contact7 = "";
																			$email7 = "";
																			$block7 = "none";
																		}
																		?>
																	<div id="location7" class="row" style="display: <?php echo $block7; ?>;">
																		<hr>
																		<div class="col-xs-2">Location 7</div>
																		<div class="col-xs-10">
																			<form method="POST" action="">
																			<div class="row">
																				<div class="col-sm-7">
																					<input type="text" name ="location_state" id="address7" placeholder="Address" class="form-control" value="<?php echo $address7; ?>" >
																					<input type="hidden" name="lat" id="lat7" placeholder="Latitude" value="<?php echo $lat7; ?>">
																					<input type="hidden" name="long" id="long7" placeholder="Longitude" value="<?php echo $long7; ?>">

																				</div>
																				<div class="col-sm-5">
																					<input type="text" name="landmark" class="form-control" value="<?php echo $landmark7; ?>" placeholder="Landmark">
																				</div>
																			</div>
																			<br>
																			<div class="row">
																				<div class="col-sm-4">
																					<input type="text" name="email" class="form-control" value="<?php echo $email7; ?>" placeholder="Email">
																				</div>
																				<div class="col-xs-4">
																					<input type="text" name="contact" class="form-control" value="<?php echo $contact7; ?>" placeholder="Contact">
																				</div>
																				<div class="col-xs-4">
																						<input type="hidden" name="ad_id" value="<?php echo $ad_id; ?>">
																						<input type="hidden" name="location_counter" value="7">
																						<?php if($block7 == "display") { ?>
																					<button type="submit" name="DELETE_LOCATION" class="btn btn-warning btn-sm active">DELETE</button>
																					<button type="button" name="SAVE_LOCATION" class="btn btn-info btn-sm disabled">SAVE</button>
																					<?php } else { ?>
																					<button type="button" name="DELETE_LOCATION" class="btn btn-warning btn-sm disabled">DELETE</button>
																					<button type="submit" name="SAVE_LOCATION" class="btn btn-primary btn-sm active">SAVE</button>
																					<?php } ?>
																				</div>
																			</div>
																		</form>
																		</div>
																	</div>
																	<?php 
																		if(isset($saved_ad->locations[7])) {
																			$lat8 = $saved_ad->locations[7]["lat"];
																			$long8 = $saved_ad->locations[7]["long"];
																			$address8 = $saved_ad->locations[7]["state"];
																			$landmark8 = $saved_ad->locations[7]["landmark"];
																			$contact8 = $saved_ad->locations[7]["contact"];
																			$email8 = $saved_ad->locations[7]["email"];
																			$block8 = "display";
																		} else {
																			$lat8 = "";
																			$long8 = "";
																			$address8 = "";
																			$landmark8 = "";
																			$contact8 = "";
																			$email8 = "";
																			$block8 = "none";
																		}
																		?>
																	<div id="location8" class="row" style="display: <?php echo $block8; ?>;">
																		<hr>
																		<div class="col-xs-2">Location 8</div>
																		<div class="col-xs-10">
																			<form method="POST" action="">
																			<div class="row">
																				<div class="col-sm-7">
																					<input type="text" name ="location_state" id="address8" placeholder="Address" class="form-control" value="<?php echo $address8; ?>" >
																					<input type="hidden" name="lat" id="lat8" placeholder="Latitude" value="<?php echo $lat8; ?>">
																					<input type="hidden" name="long" id="long8" placeholder="Longitude" value="<?php echo $long8; ?>">
																				</div>
																				<div class="col-sm-5">
																					<input type="text" name="landmark" class="form-control" value="<?php echo $landmark8; ?>" placeholder="Landmark">
																				</div>
																			</div>
																			<br>
																			<div class="row">
																				<div class="col-sm-4">
																					<input type="text" name="email" class="form-control" value="<?php echo $email8; ?>" placeholder="Email">
																				</div>
																				<div class="col-xs-4">
																					<input type="text" name="contact" class="form-control" value="<?php echo $contact8; ?>" placeholder="Contact">
																				</div>
																				<div class="col-xs-4">
																						<input type="hidden" name="ad_id" value="<?php echo $ad_id; ?>">
																						<input type="hidden" name="location_counter" value="8">
																						<?php if($block8 == "display") { ?>
																					<button type="submit" name="DELETE_LOCATION" class="btn btn-warning btn-sm active">DELETE</button>
																					<button type="button" name="SAVE_LOCATION" class="btn btn-info btn-sm disabled">SAVE</button>
																					<?php } else { ?>
																					<button type="button" name="DELETE_LOCATION" class="btn btn-warning btn-sm disabled">DELETE</button>
																					<button type="submit" name="SAVE_LOCATION" class="btn btn-primary btn-sm active">SAVE</button>
																					<?php } ?>
																				</div>
																			</div>
																			<form method="POST" action="">
																		</div>
																	</div>
																	<?php 
																		if(isset($saved_ad->locations[8])) {
																			$lat9 = $saved_ad->locations[8]["lat"];
																			$long9 = $saved_ad->locations[8]["long"];
																			$address9 = $saved_ad->locations[8]["state"];
																			$landmark9 = $saved_ad->locations[8]["landmark"];
																			$contact9 = $saved_ad->locations[8]["contact"];
																			$email9 = $saved_ad->locations[8]["email"];
																			$block9 = "display";
																		} else {
																			$lat9 = "";
																			$long9 = "";
																			$address9 = "";
																			$landmark9 = "";
																			$contact9 = "";
																			$email9 = "";
																			$block9 = "none";
																		}
																		?>
																	<div id="location9" class="row" style="display: <?php echo $block9; ?>;">
																		<hr>
																		<div class="col-xs-2">Location 9</div>
																		<div class="col-xs-10">
																			<form method="POST" action="">
																			<div class="row">
																				<div class="col-sm-7">
																					<input type="text" name ="location_state" id="address9" placeholder="Address" class="form-control" value="<?php echo $address9; ?>" >
																					<input type="hidden" name="lat" id="lat9" placeholder="Latitude" value="<?php echo $lat9; ?>">
																					<input type="hidden" name="long" id="long9" placeholder="Longitude" value="<?php echo $long9; ?>">
																				</div>
																				<div class="col-sm-5">
																					<input type="text" name="landmark" class="form-control" value="<?php echo $landmark9; ?>" placeholder="Landmark">
																				</div>
																			</div>
																			<br>
																			<div class="row">
																				<div class="col-sm-4">
																					<input type="text" name="email" class="form-control" value="<?php echo $email9; ?>" placeholder="Email">
																				</div>
																				<div class="col-xs-4">
																					<input type="text" name="contact" class="form-control" value="<?php echo $contact9; ?>" placeholder="Contact">
																				</div>
																				<div class="col-xs-4">
																						<input type="hidden" name="ad_id" value="<?php echo $ad_id; ?>">
																						<input type="hidden" name="location_counter" value="9">
																						<?php if($block9 == "display") { ?>
																					<button type="submit" name="DELETE_LOCATION" class="btn btn-warning btn-sm active">DELETE</button>
																					<button type="button" name="SAVE_LOCATION" class="btn btn-info btn-sm disabled">SAVE</button>
																					<?php } else { ?>
																					<button type="button" name="DELETE_LOCATION" class="btn btn-warning btn-sm disabled">DELETE</button>
																					<button type="submit" name="SAVE_LOCATION" class="btn btn-primary btn-sm active">SAVE</button>
																					<?php } ?>
																				</div>
																			</div>
																		</form>
																		</div>
																	</div>
																	<?php 
																		if(isset($saved_ad->locations[9])) {
																			$lat10 = $saved_ad->locations[9]["lat"];
																			$long10 = $saved_ad->locations[9]["long"];
																			$address10 = $saved_ad->locations[9]["state"];
																			$landmark10 = $saved_ad->locations[9]["landmark"];
																			$contact10 = $saved_ad->locations[9]["contact"];
																			$email10 = $saved_ad->locations[9]["email"];
																			$block10 = "display";
																		} else {
																			$lat10 = "";
																			$long10 = "";
																			$address10 = "";
																			$landmark10 = "";
																			$contact10 = "";
																			$email10 = "";
																			$block10 = "none";
																		}
																		?>
																	<div id="location10" class="row" style="display: <?php echo $block10; ?>;">
																		<hr>
																		<div class="col-xs-2">Location 10</div>
																		<div class="col-xs-10">
																			<form method="POST" action="">
																			<div class="row">
																				<div class="col-sm-7">
																					<input type="text" name ="location_state" id="address10" placeholder="Address" class="form-control" value="<?php echo $address10; ?>" >
																					<input type="hidden" name="lat" id="lat10" placeholder="Latitude" value="<?php echo $lat10; ?>">
																					<input type="hidden" name="long" id="long10" placeholder="Longitude" value="<?php echo $long10; ?>">
																				</div>
																				<div class="col-sm-5">
																					<input type="text" name="landmark" class="form-control" value="<?php echo $landmark10; ?>" placeholder="Landmark">
																				</div>
																			</div>
																			<br>
																			<div class="row">
																				<div class="col-sm-4">
																					<input type="text" name="email" class="form-control" value="<?php echo $email10; ?>" placeholder="Email">
																				</div>
																				<div class="col-xs-4">
																					<input type="text" name="contact" class="form-control" value="<?php echo $contact10; ?>" placeholder="Contact">
																				</div>
																				<div class="col-xs-4">
																					<input type="hidden" name="ad_id" value="<?php echo $ad_id; ?>">
																					<input type="hidden" name="location_counter" value="10">
																					<?php if($block10 == "display") { ?>
																					<button type="submit" name="DELETE_LOCATION" class="btn btn-warning btn-sm active">DELETE</button>
																					<button type="button" name="SAVE_LOCATION" class="btn btn-primary btn-sm disabled">SAVE</button>
																					<?php } else { ?>
																					<button type="button" name="DELETE_LOCATION" class="btn btn-warning btn-sm disabled">DELETE</button>
																					<button type="submit" name="SAVE_LOCATION" class="btn btn-primary btn-sm active">SAVE</button>
																					<?php } ?>
																				</div>
																			</div>
																		</form>
																		</div>
																	</div>
																	<br>
																	<!-- <?php if(empty($saved_ad->locations)) {
																		?>
																		<center><button id="save_location_button" class="btn btn-primary" type="submit" name="SAVE_AD_LOCATIONS" style="display: none;">SAVE AD LOCATIONS</button></center>
																		<?php
																	} else {
																		?>
																		<center><button id="save_location_button" class="btn btn-primary" type="submit" name="UPDATE_AD_LOCATIONS" style="">UPDATE AD LOCATIONS</button></center>
																		<?php
																	} ?>
															  </form> -->
															</div>

															<hr />
															<div class="row">
																<div class="pull-right">
																	<form action="" method="POST">
																		<input type="hidden" name="FROM_LOCATION">
																		<button class="btn" name="FORM_BACK">
																			<i class="ace-icon fa fa-arrow-left"></i>
																			Back
																		</button>
																		<button class="btn btn-success" name="FORM_NEXT">
																			Continue
																			<i class="ace-icon fa fa-arrow-right icon-on-right"></i>
																		</button>
																	</form>
																</div>
															</div>

														</div>
													</div>

<div class="step-pane" data-step="8">
														<div class="col-xs-12 col-sm-6">
															<div class="space visible-xs"></div>

															<div class="profile-user-info profile-user-info-striped">
																<div class="profile-info-row">
																	<div class="profile-info-name"> Ads Name </div>
																	<div class="profile-info-value">
																		<span><?php echo $ad_detail->ad_name; ?></span>
																	</div>
																</div>
																
																<div class="profile-info-row">
																	<div class="profile-info-name">Campaign Name </div>
																	<div class="profile-info-value">
																		<!-- <i class="fa fa-map-marker light-orange bigger-110"></i> -->
																		<span><?php echo $campaign_detail->campaign_name; ?></span>
																	</div>
																</div>
																
																<div class="profile-info-row">
																	<div class="profile-info-name"> Product Name, Url </div>
																	<div class="profile-info-value">
																		<span><a href="<?php echo $ad_detail->product_url; ?>" target="_blank"><?php echo $ad_detail->product_name; ?></a></span>
																	</div>
																</div>

																<div class="profile-info-row">
																	<div class="profile-info-name"> Company Name, Url </div>
																	<div class="profile-info-value">
																		<span><a href="<?php echo $ad_detail->company_url; ?>" target="_blank"><?php echo $ad_detail->company_name; ?></a></span>
																	</div>
																</div>

																<div class="profile-info-row">
																	<div class="profile-info-name"> Coverage Radius</div>
																	<div class="profile-info-value">
																		<span><?php echo $ad_detail->coverage_radius; ?></span>
																	</div>
																</div>

																<div class="profile-info-row">
																	<div class="profile-info-name"> Checkin Reward </div>
																	<div class="profile-info-value">
																		<span><?php echo $ad_detail->reward_amount; ?></span>
																	</div>
																</div>
																<div class="profile-info-row">
																	<div class="profile-info-name"> Store Name </div>
																	<div class="profile-info-value">
																		<span>Associate Store Id</span>
																	</div>
																</div>
																<div class="profile-info-row">
																	<div class="profile-info-name"> Deal </div>
																	<div class="profile-info-value">
																		<span><?php echo $ad_detail->off_deal; ?></span>
																	</div>
																</div>
																<div class="profile-info-row">
																	<div class="profile-info-name"> Coupon Code, Link </div>
																	<div class="profile-info-value">
																		<span><?php echo $ad_detail->coupon_code; ?>, <a href="<?php echo $ad_detail->deal_link; ?>" target="_blank">Link</a></span>
																	</div>
																</div>
															</div>
														</div>
														<div id="dvMap" style="width: 45%;  height: 380px;" class="col-md-offset-1"></div>
														<div class="row">
															<div class="col-sm-10 col-sm-offset-1">
																<div class="widget-box transparent">
																	<div class="widget-header widget-header-large">
																		<h3 class="widget-title grey lighter">
																			<i class="ace-icon fa fa-question green"></i> Questions
																		</h3>
																	</div>
																	<div class="widget-body">
																		<div class="widget-main padding-24">
																			<div class="row">
																				<div class="col-sm-12">
																				<?php 
																				foreach ($quiz_detail as $key => $value) {
																					$options = explode("*,*", $value["options"]);
																					$answer = intval($value["answer"]) - 1;
																					?>
																					<div class="row">
																						<div class="col-xs-12  alert alert-info ">
																							<b><?php echo $value["question"]; ?></b>
																							
																						</div>
																					</div>
																					<ul class="list-unstyled spaced">
																						<?php 
																						foreach ($options as $o_key => $option) {
																							$check_correct = "fa-times red";
																							if($answer == $o_key) {
																								$check_correct = "fa-check green";
																							} 
																							?>
																							<li>
																								<i class="ace-icon fa  <?php echo $check_correct; ?>"></i><?php echo $option; ?>
																							</li>
																							<?php
																								} 
																							?>
																						<li class="divider"></li>
																					</ul>
																					<?php 
																					}
																					?>
																				</div><!-- /.col -->
																			</div><!-- /.row -->
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-xs-2 col-xs-offset-3">
																<form method="GET" action="?AD_VIEW">
																	<input type="hidden" name="ad_id" value="<?php echo $ad_id; ?>">
																	<button type="submit" class="btn btn-warning pull-right " name="AD_VIEW">Edit</button>
																</form>
															</div>
															<div class="col-xs-2">
																<form method="GET" action="">
																	<center>
																	<input type="hidden" name="ad_id" value="<?php echo $ad_id; ?>">
																	<input type="hidden" name="draft">
																	<button type="submit" class="btn btn-info" name="SHOW_ALL_ADS">Draft</button>
																	</center>
																</form>
															</div>
															<div class="col-xs-2">
																<form method="GET" action="">
																	<input type="hidden" name="ad_id" value="<?php echo $ad_id; ?>">
																	<input type="hidden" name="publish">
																	<button type="submit" class="btn btn-primary" name="SHOW_ALL_ADS">Publish</button>
																</form>
															</div>
														</div>

														<hr />
														<div class="row">
															<div class="pull-right">
																<form action="" method="POST">
																	<input type="hidden" name="FROM_FINAL_CONFIRMATION">
																	<button class="btn" name="FORM_BACK">
																		<i class="ace-icon fa fa-arrow-left"></i>
																		Back
																	</button>
																	<button class="btn btn-success" name="FORM_NEXT" disabled="true">
																		Continue
																		<i class="ace-icon fa fa-arrow-right icon-on-right"></i>
																	</button>
																</form>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div><!-- /.widget-main -->
									</div><!-- /.widget-body -->
								</div>
							</div><!-- /.col -->
						</div><!-- /.row -->
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
		<script src="assets/js/bootstrap-datepicker.min.js"></script>
		<script src="assets/js/bootstrap-timepicker.min.js"></script>
		<script src="assets/js/moment.min.js"></script>
		<script src="assets/js/daterangepicker.min.js"></script>
		<script src="assets/js/bootstrap-datetimepicker.min.js"></script>

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

				$('input[name=date-range-picker]').daterangepicker({
					'applyClass' : 'btn-sm btn-success',
					'cancelClass' : 'btn-sm btn-default',
					locale: {
						applyLabel: 'Apply',
						cancelLabel: 'Cancel',
					}
				})
				.prev().on(ace.click_event, function(){
					$(this).next().focus();
				});

			})
		</script>
		<script>
		//******************wamique*************// 

		var map; //Will contain map object.
		var marker = false; ////Has the user plotted their location marker?
		<?php 
		if(sizeof($saved_ad->locations) > 0) {
			?>
			var counter = <?php echo sizeof($saved_ad->locations); ?>;
			<?php
		} else {
			?>
			var counter = 0;
			<?php
		}
		?>
		
		
		var geocoder;

		function initMap() {

			//The center location of our map.
			var centerOfMap = new google.maps.LatLng(28.613939, 77.209021);
			//Map options.
			var options = {
				center: centerOfMap, //Set center.
				zoom: 13 //The zoom value.
			};
			geocoder = new google.maps.Geocoder();
			//Create the map object.
			map = new google.maps.Map(document.getElementById('map'), options);
			var service = new google.maps.places.PlacesService(map);
			map.addListener('click', function(event) {
				counter +=1;
				placeMarkerAndPanTo(event.latLng, map);

			});

			google.maps.event.addListener(map, 'click', function(event) {
				//Get the location that the user clicked.
				var clickedLocation = event.latLng;
				//If the marker hasn't been added.
				if(marker === false) {
					//Create the marker.
					marker = new google.maps.Marker({
						position: clickedLocation,
						map: map,
						draggable: false //make it draggable
					});
					//Listen for drag events!
					// google.maps.event.addListener(marker, 'dragend', function(event) {
						// markerLocation(counter);
					// });
				} else {
					//Marker has already been added, so just change its location.
					
					marker.setPosition(clickedLocation);
				}

				//Get the marker's location.
				markerLocation(counter);
			});

			// Create the search box and link it to the UI element.
			var input = document.getElementById('searchInput');
			var searchBox = new google.maps.places.SearchBox(input);
			map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

			// Bias the SearchBox results towards current map's viewport.
			map.addListener('bounds_changed', function(event) {
				searchBox.setBounds(map.getBounds());
			});

			var markers = [];
			// Listen for the event fired when the user selects a prediction and retrieve
			// more details for that place.
			searchBox.addListener('places_changed', function(event) {
				var places = searchBox.getPlaces();

				if (places.length == 0) {
					return;
				}

				// Clear out the old markers.
				markers.forEach(function(marker) {
					marker.setMap(null);
				});
				markers = [];

				// For each place, get the icon, name and location.
				var bounds = new google.maps.LatLngBounds();
				places.forEach(function(place) {
					if (!place.geometry) {
						console.log("Returned place contains no geometry");
						return;
					}
					var icon = {
						url: place.icon,
						size: new google.maps.Size(71, 71),
						origin: new google.maps.Point(0, 0),
						anchor: new google.maps.Point(17, 34),
						scaledSize: new google.maps.Size(25, 25)
					};

					// Create a marker for each place.
					markers.push(new google.maps.Marker({
						map: map,
						icon: icon,
						title: place.name,
						position: place.geometry.location
					}));

					if (place.geometry.viewport) {
						// Only geocodes have viewport.
						bounds.union(place.geometry.viewport);
					} else {
						bounds.extend(place.geometry.location);
					}
				});
				map.fitBounds(bounds);
			});
		}

		function placeMarkerAndPanTo(latLng, map) {
			var marker = new google.maps.Marker({
				position: latLng,
				map: map,
				label: {
					text: "Location "+counter,
					color: "#0000FF",
					fontSize: "16px",
					fontWeight: "bold",
					backgroundColor: "#fff"
				}
			});
			map.panTo(latLng);
		}

		function markerLocation(counter) {
			//Get location.
			// alert("Location"+counter);
			var currentLocation = marker.getPosition();
			var lat = "lat"+counter;
			var lng = "long"+counter;
			var location = "location"+counter;
			$("#"+location).show();
			//Add lat and lng values to a field that we can save.
			document.getElementById(lat).value = currentLocation.lat(); //latitude
			document.getElementById(lng).value = currentLocation.lng(); //longitude
			$("#save_location_button").show();
			getAddress(currentLocation);
		}

		var markerView = <?php echo json_encode($saved_ad->locations); ?>;
		window.onload = function () {
			var mapOptions = {
				center: new google.maps.LatLng(markerView[0].lat, markerView[0].long),
				zoom: 10,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			var map = new google.maps.Map(document.getElementById("dvMap"), mapOptions);
			var infoWindow = new google.maps.InfoWindow();
			var lat_lng = new Array();
			var latlngbounds = new google.maps.LatLngBounds();
			for (i = 0; i < markerView.length; i++) {
				var data = markerView[i]
				var myLatlng = new google.maps.LatLng(data.lat, data.long);
				lat_lng.push(myLatlng);
				var marker = new google.maps.Marker({
					position: myLatlng,
					map: map
				});
				latlngbounds.extend(marker.position);
				(function (marker, data) {
					google.maps.event.addListener(marker, "click", function (e) {
						infoWindow.setContent(data.description);
						infoWindow.open(map, marker);
					});
				})(marker, data);
			}
			map.setCenter(latlngbounds.getCenter());
			map.fitBounds(latlngbounds);
		}

		function getAddress(latLng) {
			var address = "address"+counter;

			geocoder.geocode( {'latLng': latLng},
			function(results, status) {
				//alert(results[0].address_components[4].long_name)
				//alert(JSON.stringify(results));
				if(status == google.maps.GeocoderStatus.OK) {
					if(results[0]) {
						document.getElementById(address).value = results[0].formatted_address;
					} else {
						document.getElementById(address).value = "No results";
					}
				}
				else {
					document.getElementById(address).value = status;
				}
			});
		}

		//Load the map when the page has finished loading.
		google.maps.event.addDomListener(window, 'load', initMap);
		</script>
		

	    <script type="text/javascript">
				function addTextBox(div_id){
					if(div_id == "remove_campaign_button") {
						$("#create_campaign_button").show();
						$("#remove_campaign_button").hide();
						$("#save_campaign_button").hide();
						$("#create_campaign_div").hide();
					} else {
						$("#create_campaign_button").hide();
						$("#remove_campaign_button").show();
						$("#save_campaign_button").show();
						document.getElementById("add_camaign").innerHTML="<div class='form-group' id='create_campaign_div'><label class='control-label col-xs-12 col-sm-3 no-padding-right' >Enter Campaign Name:</label>  <div class='col-xs-12 col-sm-7'>  <input type='text' name='campaign_name' id='compaign' class='col-xs-12 col-sm-7 form-control' placeholder='Enter a Campaign name' /></div> </div>";
					}
				}
	    </script>

			<script type="text/javascript">
				jQuery(function($) {
					//range slider tooltip example
					$( "#slider-range" ).css('width','200px').slider({
						orientation: "horizontal",
						range: true,
						min: 0,
						max: 100,
						values: [ <?php echo $saved_ad->min_entry_age; ?>, <?php echo $saved_ad->max_entry_age; ?> ],
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
					$( "#slider-range-max" ).slider({
						range: "max",
						min: 1,
						max: 10,
						value: 2
						
					});
					
				});
			</script>
			<script type="text/javascript">
				
				function goFullscreen(id) {
					// alert("full");
					// Get the element that we want to take into fullscreen mode
					var element = document.getElementById(id);
					//element.style.width = '';

					// These function will not exist in the browsers that don't support fullscreen mode yet, 
					// so we'll have to check to see if they're available before calling them.
					// Create the search box and link it to the UI element.
					var input = document.getElementById('searchInput');
					var searchBox = new google.maps.places.SearchBox(input);
					map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

					// Bias the SearchBox results towards current map's viewport.
					map.addListener('bounds_changed', function(event) {
						searchBox.setBounds(map.getBounds());
					});

					var markers = [];
					// Listen for the event fired when the user selects a prediction and retrieve
					// more details for that place.
					searchBox.addListener('places_changed', function(event) {
						var places = searchBox.getPlaces();

						if (places.length == 0) {
							return;
						}

						// Clear out the old markers.
						markers.forEach(function(marker) {
							marker.setMap(null);
						});
						markers = [];

						// For each place, get the icon, name and location.
						var bounds = new google.maps.LatLngBounds();
						places.forEach(function(place) {
							if (!place.geometry) {
								console.log("Returned place contains no geometry");
								return;
							}
							var icon = {
								url: place.icon,
								size: new google.maps.Size(71, 71),
								origin: new google.maps.Point(0, 0),
								anchor: new google.maps.Point(17, 34),
								scaledSize: new google.maps.Size(25, 25)
							};

							// Create a marker for each place.
							markers.push(new google.maps.Marker({
								map: map,
								icon: icon,
								label: place.name,
								position: place.geometry.location
							}));

							if (place.geometry.viewport) {
								// Only geocodes have viewport.
								bounds.union(place.geometry.viewport);
							} else {
								bounds.extend(place.geometry.location);
							}
						});
						map.fitBounds(bounds);
					});

					if (element.mozRequestFullScreen) {
						// This is how to go into fullscren mode in Firefox
						// Note the "moz" prefix, which is short for Mozilla.
						//element.style.width = '100%';
						element.mozRequestFullScreen();
					} else if (element.webkitRequestFullScreen) {
						// This is how to go into fullscreen mode in Chrome and Safari
						// Both of those browsers are based on the Webkit project, hence the same prefix.
						element.style.width = '80%';
						element.style.height = '80%';

						element.webkitRequestFullScreen();
					}
					// Hooray, now we're in fullscreen mode!
				}

				function takeAudienceType() {
					var min_age = document.getElementById("min_age").value;
					var max_age = document.getElementById("max_age").value;

					var gender = "";
					if(document.getElementById('all_gender').checked) {
						gender = "all";
					} 
					if(document.getElementById('male_gender').checked) {
						gender = "male";
					} 
					if(document.getElementById('female_gender').checked) {
						gender = "female";
					} 
					// alert(min_age);
					// alert(max_age);
					// alert(gender);

					var club_membership = document.getElementById("club_membership").value;
					var salary_group = document.getElementById("salary_group").value;
					var defence_service = document.getElementById("defence_service").value;
					var work_type = document.getElementById("work_type").value;
					var watch_brand = document.getElementById("watch_brand").value;
					var car_brand = document.getElementById("car_brand").value;
					var residence_type = document.getElementById("residence_type").value;
					var transport_type = document.getElementById("transport_type").value;
					var miles_card = document.getElementById("miles_card").value;
					var credit_card = document.getElementById("credit_card").value;

					$.ajax({
						
						url: 'classes/requestHandler.php',
						type: 'POST',
						dataType: 'Json',
						data: {'json_identifier' : 'GET_TARGETED_AUDIENCE', 'min_age' : min_age, 'max_age' : max_age, 'gender' : gender, 'club_membership': club_membership, 'salary_group': salary_group, 'defence_service': defence_service, 'work_type': work_type, 'watch_brand': watch_brand, 'car_brand': car_brand, 'residence_type': residence_type, 'transport_type': transport_type, 'miles_card': miles_card, 'credit_card': credit_card},

						contentType: 'application/x-www-form-urlencoded; charset=utf-8',

						//if received a response from the server
						success: function( data, textStatus, jqXHR) {
							
							if(!data.error){
								var total_audience = data.message.all_audience;
								var tagert_audience = data.message.targeted_audience;
								var left_audience = data.message.audience_left_behind;
								$("#targeted_audience").html("<br><br><strong>Total Audience = "+total_audience+"<br>Targed Audience = "+tagert_audience+"<br>Audience Left = "+left_audience+"</strong>");
								// alert("Targed Audience = "+tagert_audience+"Audience Left = "+left_audience);
							} else {
								alert("Error in getting Data");
							}
						},

						//If there was no resonse from the server
						error: function(jqXHR, textStatus, errorThrown){
							// alert("jqXHR"+jqXHR.responseText+".."+textStatus+".."+errorThrown);
						},

						//this is called after the response or error functions are finsihed
						//so that we can take some action
						complete: function(jqXHR, textStatus){
							//alert("Request Completed Successfully");
						}
					}); 
				}


			</script>
			<script type="text/javascript">
			var data = [];
			var placeholder = $('#piechart-placeholder').css({'width':'90%' , 'height':'200px'});

			function loadAudienceChart(targeted_audience, audience_not_targeted) {
				data = [
				{ label: "Targeted Audience",  data: targeted_audience, color: "#68BC31"},
				{ label: "Audience not Targeted",  data: audience_not_targeted, color: "#2091CF"}
				];
				drawPieChart(placeholder, data);
			}
			  
			function drawPieChart(placeholder, data, position) {
				$.plot(placeholder, data, {
					series: {
						pie: {
							show: true,
							tilt:0.8,
							highlight: {
								opacity: 0.25
							},
							stroke: {
								color: '#fff',
								width: 2
							},
							startAngle: 2
						}
					},
					legend: {
						show: true,
						position: position || "ne", 
						labelBoxBorderColor: null,
						margin:[-30,15]
					},
					grid: {
						hoverable: true,
						clickable: true
					}
				})
			}
			drawPieChart(placeholder, data);
		
			/**
			we saved the drawing function and the data to redraw with different position later when switching to RTL mode dynamically
			so that's not needed actually.
			*/
			placeholder.data('chart', data);
			placeholder.data('draw', drawPieChart);


			//pie chart tooltip example
			var $tooltip = $("<div class='tooltip top in'><div class='tooltip-inner'></div></div>").hide().appendTo('body');
			var previousPoint = null;

			placeholder.on('plothover', function (event, pos, item) {
				if(item) {
					if (previousPoint != item.seriesIndex) {
						previousPoint = item.seriesIndex;
						var tip = item.series['label'] + " : " + item.series['percent']+'%';
						$tooltip.show().children(0).text(tip);
					}
					$tooltip.css({top:pos.pageY + 10, left:pos.pageX + 10});
				} else {
					$tooltip.hide();
					previousPoint = null;
				}
			});

			loadAudienceChart(40, 20);
			
			

			function openModyAudienceBlock() {
				$("#moby_audience").show();
			}
			function closeMobyAudienceBlock() {
				$("#moby_audience").hide();
			}
		</script>

		
		<style>
		#map {
			margin: auto; width: 60%; border: 3px solid #454447; padding: 200px;
		}
		</style>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAPHnw9tDjgI0Ab_Fn4ylpbP9PcKMebkrE&libraries=places&callback=initMap" ></script>
		
	</body>
</html>