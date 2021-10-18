<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo APP_NAME."  | Ad Update"; ?></title>

<?php 
include("header.php");
include("nav_bar.php");
include("sidebar.php");
//echo $ad_id;
$location = [];
//get campaign for ad_id
$ad_detail = $CommonFunc->getAdDetail($ad_id);

//get campaign detail
$campaign_detail = $CommonFunc->getCampaignDetail($ad_detail->campaign_id);

//get stor detail
$store_detail = $CommonFunc->getStoreDetail($ad_detail->associated_store);
//get location
$location_detail = $CommonFunc->getLocationForAds($ad_id, $ad_detail->location_count);
foreach ($location_detail as $l_key => $l_value) {
	$location_this = [];
	$location_this["location_id"] = $l_value["location_id"];
	$location_this["lat"] = $l_value["location_lat"];
	$location_this["lng"] = $l_value["location_long"];
	array_push($location, $location_this);
}
//get quiz
$quiz_detail = $CommonFunc->getQuizForAds($ad_id, $ad_detail->quiz_count);
foreach ($quiz_detail as $key => $value) {
	$quiz_id = $value["quiz_id"];
}

?>
</head>
		<div class="main-content">
			<div class="main-content-inner">
				
				<div class="page-content">
						<div class="page-header">
							<h1>
								Ad Information
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Update All Information
								</small>
							</h1>
						</div><!-- /.page-header -->

					<div class="row col-sm-12">
						<div class="widget-box">
							<div class="widget-header">
								<h4 class="widget-title">Update  Ad</h4>
							</div>
							<form class="form-horizontal" id="sample-form" method="POST">
								<div class=" form-group widget-main">
										<label class="col-xs-12 col-sm-3 control-label no-padding-right">Campaign Name</label>
										<div class="col-xs-12 col-sm-5">
											<select class="form-control" id="form-field-select-1" name = "campaign_id">
												<option value="<?php echo $ad_detail->campaign_id; ?>"><?php echo $campaign_detail->campaign_name; ?></option>

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
										</div>
								</div>
								<div class="form-group">
									<label class="col-xs-12 col-sm-3 control-label no-padding-right">Ad Name</label>

									<div class="col-xs-12 col-sm-5">
										<span class="block input-icon input-icon-right">
											<input type="text" id="ad_name" name = "ad_name" class="width-100" placeholder="Ad Name" value="<?php echo $ad_detail->ad_name; ?>" />
											
											
										</span>
									</div>
								</div>

								<div class="form-group">
									<label class="col-xs-12 col-sm-3 control-label no-padding-right">Product Name</label>

									<div class="col-xs-12 col-sm-5">
										<span class="block input-icon input-icon-right">
											<input type="text" id="product_name" name="product_name" class="width-100" placeholder="Product Name" value = "<?php echo $ad_detail->product_name; ?>"/>
										</span>
									</div>
								</div>

								<div class="form-group">
									<label class="col-xs-12 col-sm-3 control-label no-padding-right">Product Url</label>

									<div class="col-xs-12 col-sm-5">
										<span class="block input-icon input-icon-right">
											<input type="text" id="product_url" name="product_url" class="width-100" placeholder="Product Url" value = "<?php echo $ad_detail->product_url; ?>" />
										</span>
									</div>
								</div>

								<div class="form-group">
									<label class="col-xs-12 col-sm-3 control-label no-padding-right">Company Name</label>

									<div class="col-xs-12 col-sm-5">
										<span class="block input-icon input-icon-right">
											<input type="text" id="compamy_name" name = "company_name" class="width-100" placeholder="Company Name" value = "<?php echo $ad_detail->company_name; ?>" />
										</span>
									</div>
								</div>

								<div class="form-group">
									<label for="inputInfo" class="col-xs-12 col-sm-3 control-label no-padding-right">Company Url</label>

									<div class="col-xs-12 col-sm-5">
										<span class="block input-icon input-icon-right">
											<input type="text" id="inputInfo" name="company_url" class="width-100" placeholder="Company Url" value = "<?php echo $ad_detail->company_url; ?>" />
										</span>
									</div>
								</div>

								<div class="form-group">
									<label class="col-xs-12 col-sm-3 control-label no-padding-right">Coverage Radius</label>

									<div class="col-xs-12 col-sm-5">
										<span class="block input-icon input-icon-right">
											<input type="number" id="coverage_radius" name="coverage_radius" class="width-100" placeholder="Coverage Radius" value="<?php echo $ad_detail->coverage_radius; ?>" />
										</span>
									</div>
								</div>
								<div class=" form-group widget-main">
										<label class="col-xs-12 col-sm-3 control-label no-padding-right">Store Name</label>
										<div class="col-xs-12 col-sm-5">
											<select class="form-control" id="form-field-select-1" name = "store_id">
												<option value="<?php echo $store_detail->store_id; ?>"><?php echo $store_detail->store_name; ?></option>

												<?php 
												foreach ($store as $store_key => $store_value) {
													if($store_id != "" && $store_id == $store_value["store_id"]) {
														echo '<option value="'.$store_value["store_id"].'" selected>'.$store_value["store_name"].'</option>';
													} else {
														echo '<option value="'.$store_value["store_id"].'">'.$store_value["store_name"].'</option>';
													}
												}
											?>
											</select>
										</div>
								</div>

								<div class="form-group">
									<label for="inputInfo" class="col-xs-12 col-sm-3 control-label no-padding-right">Deal</label>

									<div class="col-xs-12 col-sm-5">
										<span class="block input-icon input-icon-right">
											<input type="text" id="inputInfo" name="off_deal" class="width-100" placeholder="Company Url" value = "<?php echo $ad_detail->off_deal; ?>" />
										</span>
									</div>
								</div>

								<div class="form-group">
									<label for="inputInfo" class="col-xs-12 col-sm-3 control-label no-padding-right">Coupon Code</label>

									<div class="col-xs-12 col-sm-5">
										<span class="block input-icon input-icon-right">
											<input type="text" id="inputInfo" name="coupon_code" class="width-100" placeholder="Company Url" value = "<?php echo $ad_detail->coupon_code; ?>" />
										</span>
									</div>
								</div>

								
								<div class="form-group">
									<label class="col-xs-12 col-sm-3 control-label no-padding-right">Checking Reward</label>
									<div class="col-xs-12 col-sm-5">
										<span class="block input-icon input-icon-right">
											<input type="number" id="reward_amount" name = "reward_amount" class="width-100" placeholder="Reward Amount" value="<?php echo $ad_detail->reward_amount; ?>" />
										</span>
									</div>
								</div>
								<div>
									<!-- <button class="btn btn-success" name="UPDATE_AD_INFORMATION">Update</button> -->
									<!-- <button class="btn btn-primary">Cancel</button> -->
									<center><button class="btn btn-success"  name="UPDATE_AD_INFORMATION">Update Ad Detail</button></center>
								</div>
								<br/>
							</form>

							
								<div class="form-group col-sm-12">
									<h4 class="lighter block blue"><b>Location :</b></h4>
									<div class="center col-xs-10 col-md-offset-1">
										<input id="searchInput" style="width: 50%" class="controls" type="text" placeholder="Enter a location">
										<div id="map"></div>
										<div style="padding: 20px">
										<!-- <div id = "add_latlng"></div> -->
											
											
											<?php 
											foreach ($location_detail as $l_key => $l_value) {

											?>
											<form method="POST" action="">
												<div class="row">
													<div class="col-xs-2">Location 1</div>
													<div class="col-xs-8">
														<input type="hidden" name="location_id" value="<?php  echo $l_value['location_id']; ?>">
														<input type="hidden" name="ad_id" value="<?php echo $ad_id; ?>">
														<input type="hidden" name="campaign_id" value="<?php echo $ad_detail->campaign_id; ?>">

														Latitude: <input type="text" name="lat" value="<?php echo $l_value['location_lat']; ?>">
														Longitude: <input type="text" name="long" value="<?php echo $l_value['location_long']; ?>">
													</div>
													<div class="col-xs-2">
														<input type="submit" value="Delete" name="DELETE_LAT_LONG" class="btn btn-danger">
													</div>
												</div>
											</form>
											
											<?php
											}
											?>
										<form method="POST" action="">
											<input type="hidden" name="ad_id" value="<?php echo $ad_id; ?>">
											<input type="hidden" name="campaign_id" value="<?php echo $ad_detail->campaign_id; ?>">
											<div id="location1" class="row" style="display: none;">
												<h4><center>Delete the data from the input field to delete location</center></h4>
												<br>
												<div class="col-xs-2">Location 1</div>
												<div class="col-xs-8">
													Latitude: <input type="text" name="lat[]" id="lat1" placeholder="Latitude">
													Longitude: <input type="text" name="long[]" id="long1" placeholder="Longitude">
												</div>
											</div>
											<div id="location2" class="row" style="display: none;">
												<div class="col-xs-2">Location 2</div>
												<div class="col-xs-8">
													Latitude: <input type="text" name="lat[]" id="lat2" placeholder="Latitude">
													Longitude: <input type="text" name="long[]" id="long2" placeholder="Longitude">
												</div>
											</div>
											<div id="location3" class="row" style="display: none;">
												<div class="col-xs-2">Location 3</div>
												<div class="col-xs-8">
													Latitude: <input type="text" name="lat[]" id="lat3" placeholder="Latitude">
													Longitude: <input type="text" name="long[]" id="long3" placeholder="Longitude">
												</div>
											</div>
											<div id="location4" class="row" style="display: none;">
												<div class="col-xs-2">Location 4</div>
												<div class="col-xs-8">
													Latitude: <input type="text" name="lat[]" id="lat4" placeholder="Latitude">
													Longitude: <input type="text" name="long[]" id="long4" placeholder="Longitude">
												</div>
											</div>
											<div id="location5" class="row" style="display: none;">
												<div class="col-xs-2">Location 5</div>
												<div class="col-xs-8">
													Latitude: <input type="text" name="lat[]" id="lat5" placeholder="Latitude">
													Longitude: <input type="text" name="long[]" id="long5" placeholder="Longitude">
												</div>
											</div>
											<div id="location6" class="row" style="display: none;">
												<div class="col-xs-2 ">Location 6</div>
												<div class="col-xs-8">
													Latitude: <input type="text" name="lat[]" id="lat6" placeholder="Latitude">
													Longitude: <input type="text" name="long[]" id="long6" placeholder="Longitude">
												</div>
											</div>
											<div id="location7" class="row" style="display: none;">
												<div class="col-xs-2 ">Location 7</div>
												<div class="col-xs-8">
													Latitude: <input type="text" name="lat[]" id="lat7" placeholder="Latitude">
													Longitude: <input type="text" name="long[]" id="long7" placeholder="Longitude">
												</div>
											</div>
											<div id="location8" class="row" style="display: none;">
												<div class="col-xs-2">Location 8</div>
												<div class="col-xs-8">
													Latitude: <input type="text" name="lat[]" id="lat8" placeholder="Latitude">
													Longitude: <input type="text" name="long[]" id="long8" placeholder="Longitude">
												</div>
											</div>
											<div id="location9" class="row" style="display: none;">
												<div class="col-xs-2">Location 9</div>
												<div class="col-xs-8">
													Latitude: <input type="text" name="lat[]" id="lat9" placeholder="Latitude">
													Longitude: <input type="text" name="long[]" id="long9" placeholder="Longitude">
												</div>
											</div>
											<div id="location10" class="row" style="display: none;">
												<div class="col-xs-2">Location 10</div>
												<div class="col-xs-8">
													Latitude: <input type="text" name="lat[]" id="lat10" placeholder="Latitude">
													Longitude: <input type="text" name="long[]" id="long10" placeholder="Longitude">
												</div>
											</div>
											<br>
											
											<center><button class="btn btn-success" id="save_location_button" name="UPDATE_AD_LOCATIONS" style="display: none">Save New Location</button></center>
										</form>
										</div>
									</div>
								</div>
							<form method="POST" action="">
								<div class="form-group col-sm-12">
									<h4 class="lighter block blue"><b>Question :</b></h4>
									<div class=" col-sm-10">
										<div class="control-group col-sm-8">
											<?php 

											foreach ($quiz_detail as $key => $value) {
											$quiz_id = $value["quiz_id"];
												$options = explode("*,*", $value["options"]);
												$answer = intval($value["answer"]);
												$key = $key+1;
											?>
											<input type="hidden" name="ad_id" value="<?php echo $ad_id; ?>">
											<input type="hidden" name="campaign_id" value="<?php echo $ad_detail->campaign_id; ?>">
											<input type="hidden" name = "quiz_id[]" value='<?php echo $quiz_id; ?>' class="width-50" placeholder="Enter a question?" />

											<input type="text" name = "question[]" value='<?php echo $value["question"]; ?>' class="width-50" placeholder="Enter a question?" />
											<input type="text" name="price<?php echo $key; ?>" value='<?php echo $value["reward_amount"]; ?> INR' class="width-5">
												<?php 
												foreach ($options as $o_key => $option) {
												$check_correct = "fa-times red";
												$check_correct = "fa-check green";
												$radio = $o_key + 1;
												?>
												<!-- <?php echo $radio_name ?> -->
												<div class="control-group">
													<label class="line-height-1">
													<?php
													if($answer == $radio){
													echo '<input name="radio'.$key.'" type="radio" value="'.$radio.'" class="ace" checked />';
													}else{
													echo '<input name="radio'.$key.'" type="radio" value="'.$radio.'" class="ace" />';
													}
													?>
														<span class="lbl">
														<input type="text" name="option<?php echo  $key; ?>[]" value="<?php echo $option; ?>">
														</span>
													</label>
												</div>
											<?php

											}
											?>
											<!-- <div class="col-sm-2">
												<button class="btn btn-danger btn-sm" name = "DELETE_QUIZ">
												<i class="ace-icon fa fa-trash-o bigger-200"></i>
												Delete
												</button>
											</div> -->
										</div>
										<?php
										
										
										}
										?>
										<div id = "add_question" class="col-xs-12"> </div>
										
										<div class="control-group col-xs-12">
											<button class="btn btn-primary" type="button" onClick="addQuestion();">
											Add More Question
											</button>
											
											<center><button class="btn btn-success" name = "UPDATE_QUIZ" type="submit">
											Update Quiz
											</button></center>
											
										</div>
										</form>
									</div>
								</div>

								
							
							</div>
						</div>
						
							<div class="center">
								<input id="searchInput" style="width: 50%" class="controls" type="text" placeholder="Enter a location">
							</div>
					</div>
				</div>
			</div>

							
		<!--[if !IE]> -->
		<script src="assets/js/jquery-2.1.4.min.js"></script>

		<!-- <![endif]-->

		<!--[if IE]>
<script src="assets/js/jquery-1.11.3.min.js"></script>
<![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="assets/js/bootstrap.min.js"></script>

		<!-- page specific plugin scripts -->
		<script src="assets/js/jquery.dataTables.min.js"></script>
		<script src="assets/js/jquery.dataTables.bootstrap.min.js"></script>
		<script src="assets/js/dataTables.buttons.min.js"></script>
		<script src="assets/js/buttons.flash.min.js"></script>
		<script src="assets/js/buttons.html5.min.js"></script>
		<script src="assets/js/buttons.print.min.js"></script>
		<script src="assets/js/buttons.colVis.min.js"></script>
		<script src="assets/js/dataTables.select.min.js"></script>

		<!-- ace scripts -->
		<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>

		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($) {
				//initiate dataTables plugin
				var myTable = 
				$('#dynamic-table')
				//.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
				.DataTable( {
					bAutoWidth: false,
					"aoColumns": [
					  { "bSortable": false },
					  null, null,null, null, null,
					  { "bSortable": false }
					],
					"aaSorting": [],
			
			
					select: {
						style: 'multi'
					}
			    } );
			
				
				
				$.fn.dataTable.Buttons.defaults.dom.container.className = 'dt-buttons btn-overlap btn-group btn-overlap';
				
				new $.fn.dataTable.Buttons( myTable, {
					buttons: [
					  {
						"extend": "colvis",
						"text": "<i class='fa fa-search bigger-110 blue'></i> <span class='hidden'>Show/hide columns</span>",
						"className": "btn btn-white btn-primary btn-bold",
						columns: ':not(:first):not(:last)'
					  },
					  {
						"extend": "copy",
						"text": "<i class='fa fa-copy bigger-110 pink'></i> <span class='hidden'>Copy to clipboard</span>",
						"className": "btn btn-white btn-primary btn-bold"
					  },
					  {
						"extend": "csv",
						"text": "<i class='fa fa-database bigger-110 orange'></i> <span class='hidden'>Export to CSV</span>",
						"className": "btn btn-white btn-primary btn-bold"
					  },
					  {
						"extend": "excel",
						"text": "<i class='fa fa-file-excel-o bigger-110 green'></i> <span class='hidden'>Export to Excel</span>",
						"className": "btn btn-white btn-primary btn-bold"
					  },
					  {
						"extend": "pdf",
						"text": "<i class='fa fa-file-pdf-o bigger-110 red'></i> <span class='hidden'>Export to PDF</span>",
						"className": "btn btn-white btn-primary btn-bold"
					  },
					  {
						"extend": "print",
						"text": "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>Print</span>",
						"className": "btn btn-white btn-primary btn-bold",
						autoPrint: false,
						message: 'This print was produced using the Print button for DataTables'
					  }		  
					]
				} );
				myTable.buttons().container().appendTo( $('.tableTools-container') );
				
				//style the message box
				var defaultCopyAction = myTable.button(1).action();
				myTable.button(1).action(function (e, dt, button, config) {
					defaultCopyAction(e, dt, button, config);
					$('.dt-button-info').addClass('gritter-item-wrapper gritter-info gritter-center white');
				});
				
				
				var defaultColvisAction = myTable.button(0).action();
				myTable.button(0).action(function (e, dt, button, config) {
					
					defaultColvisAction(e, dt, button, config);
					
					
					if($('.dt-button-collection > .dropdown-menu').length == 0) {
						$('.dt-button-collection')
						.wrapInner('<ul class="dropdown-menu dropdown-light dropdown-caret dropdown-caret" />')
						.find('a').attr('href', '#').wrap("<li />")
					}
					$('.dt-button-collection').appendTo('.tableTools-container .dt-buttons')
				});
			
				////
			
				setTimeout(function() {
					$($('.tableTools-container')).find('a.dt-button').each(function() {
						var div = $(this).find(' > div').first();
						if(div.length == 1) div.tooltip({container: 'body', title: div.parent().text()});
						else $(this).tooltip({container: 'body', title: $(this).text()});
					});
				}, 500);
				
				
				
				
				
				myTable.on( 'select', function ( e, dt, type, index ) {
					if ( type === 'row' ) {
						$( myTable.row( index ).node() ).find('input:checkbox').prop('checked', true);
					}
				} );
				myTable.on( 'deselect', function ( e, dt, type, index ) {
					if ( type === 'row' ) {
						$( myTable.row( index ).node() ).find('input:checkbox').prop('checked', false);
					}
				} );
			
			
			
			
				/////////////////////////////////
				//table checkboxes
				$('th input[type=checkbox], td input[type=checkbox]').prop('checked', false);
				
				//select/deselect all rows according to table header checkbox
				$('#dynamic-table > thead > tr > th input[type=checkbox], #dynamic-table_wrapper input[type=checkbox]').eq(0).on('click', function(){
					var th_checked = this.checked;//checkbox inside "TH" table header
					
					$('#dynamic-table').find('tbody > tr').each(function(){
						var row = this;
						if(th_checked) myTable.row(row).select();
						else  myTable.row(row).deselect();
					});
				});
				
				//select/deselect a row when the checkbox is checked/unchecked
				$('#dynamic-table').on('click', 'td input[type=checkbox]' , function(){
					var row = $(this).closest('tr').get(0);
					if(this.checked) myTable.row(row).deselect();
					else myTable.row(row).select();
				});
			
			
			
				$(document).on('click', '#dynamic-table .dropdown-toggle', function(e) {
					e.stopImmediatePropagation();
					e.stopPropagation();
					e.preventDefault();
				});
				
				
				
				//And for the first simple table, which doesn't have TableTools or dataTables
				//select/deselect all rows according to table header checkbox
				var active_class = 'active';
				$('#simple-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
					var th_checked = this.checked;//checkbox inside "TH" table header
					
					$(this).closest('table').find('tbody > tr').each(function(){
						var row = this;
						if(th_checked) $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
						else $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
					});
				});
				
				//select/deselect a row when the checkbox is checked/unchecked
				$('#simple-table').on('click', 'td input[type=checkbox]' , function(){
					var $row = $(this).closest('tr');
					if($row.is('.detail-row ')) return;
					if(this.checked) $row.addClass(active_class);
					else $row.removeClass(active_class);
				});
			
				
			
				/********************************/
				//add tooltip for small view action buttons in dropdown menu
				$('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
				
				//tooltip placement on right or left
				function tooltip_placement(context, source) {
					var $source = $(source);
					var $parent = $source.closest('table')
					var off1 = $parent.offset();
					var w1 = $parent.width();
			
					var off2 = $source.offset();
					//var w2 = $source.width();
			
					if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
					return 'left';
				}
				
				
				
				
				/***************/
				$('.show-details-btn').on('click', function(e) {
					e.preventDefault();
					$(this).closest('tr').next().toggleClass('open');
					$(this).find(ace.vars['.icon']).toggleClass('fa-angle-double-down').toggleClass('fa-angle-double-up');
				});
			
			})
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAPHnw9tDjgI0Ab_Fn4ylpbP9PcKMebkrE&callback=myMap"></script><

<script>

var mark = <?php echo json_encode($location); ?>;
		var map; //Will contain map object.
		var marker = false; ////Has the user plotted their location marker? 
		var counter = 1;

		function initMap() {

			//The center location of our map.
			var centerOfMap = new google.maps.LatLng(mark[0].lat, mark[0].lng);
			//Map options.
			var options = {
				center: centerOfMap, //Set center.
				zoom: 10 //The zoom value.

			};

			//Create the map object.
			map = new google.maps.Map(document.getElementById('map'), options);
			map.addListener('click', function(event) {
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
						draggable: true //make it draggable
					});
					//Listen for drag events!
					google.maps.event.addListener(marker, 'dragend', function(event) {
						markerLocation(counter);
					});
				} else {
					//Marker has already been added, so just change its location.
					counter +=1;
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

			//location of add on map
			var infoWindow = new google.maps.InfoWindow();
			var lat_lng = new Array();
			var latlngbounds = new google.maps.LatLngBounds();
			for (i = 0; i < mark.length; i++) {
			var data = mark[i]
			//alert(data.lng);
			var myLatlng = new google.maps.LatLng(data.lat, data.lng);
			lat_lng.push(myLatlng);
			var marked = new google.maps.Marker({
			position: myLatlng,
			map: map,
			title: data.title
			});
			latlngbounds.extend(marked.position);
			(function (marked, data) {
			google.maps.event.addListener(marked, "click", function (e) {
			infoWindow.setContent(data.description);
			infoWindow.open(map, marked);
			});
			})(marked, data);
			}
			map.setCenter(latlngbounds.getCenter());
			map.fitBounds(latlngbounds);
		}

		function placeMarkerAndPanTo(latLng, map) {
		  var marker = new google.maps.Marker({
		    position: latLng,
		    map: map
		  });
		  map.panTo(latLng);
		}

		function markerLocation(counter) {
		    //Get location.
		    var currentLocation = marker.getPosition();
		    
		    var lat = "lat"+counter;
		    var lng = "long"+counter;
		    var location = "location"+counter;
		    $("#"+location).show();
		    //Add lat and lng values to a field that we can save.
		    document.getElementById(lat).value = currentLocation.lat(); //latitude
		    document.getElementById(lng).value = currentLocation.lng(); //longitude
		    $("#save_location_button").show();
		}

		
		        
		//Load the map when the page has finished loading.
		google.maps.event.addDomListener(window, 'load', initMap);
		</script>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAPHnw9tDjgI0Ab_Fn4ylpbP9PcKMebkrE&libraries=places&callback=initMap" ></script>

	    <script type="text/javascript">
	    	var counter = 1;
	        function addQuestion(){
	        	counter += 1; 
	        	//alert(counter);

	        	var question_name = "question"+counter;
	        	var option_name = "option"+counter+[]; 
	        	var radio = "radio"+counter;
	        	var price = "price"+counter;

	        	var mainDiv = document.getElementById('add_question');

	        	var div1 = document.createElement('div');
	        	div1.setAttribute("class", "control-group");

	        	var question_input = document.createElement('input');
	        	question_input.type = "text";
	        	question_input.setAttribute("name", question_name);
	        	question_input.setAttribute("placeholder", "Enter a question");
	        	question_input.setAttribute("class", "width-50");

	        	var price_input = document.createElement('input');
	        	price_input.type = "text";
	        	price_input.setAttribute("name", price);
	        	price_input.setAttribute("placeholder",  "Price INR");
	        	price_input.setAttribute("class", "width-10");

	        	var first_div = document.createElement('div');
	        	first_div.setAttribute("class", "control-group");
	        	var first_lable = document.createElement('lable');
	        	first_lable.setAttribute("class", "line-height-1");
	        	var first_input = document.createElement('input');
	        	first_input.setAttribute("name", option_name);
	        	first_input.type = "text";
	        	first_input.setAttribute("placeholder", "First Option");
	        	var first_span = document.createElement('span');
	        	first_span.setAttribute("class", "lbl");
	        	var first_radio = document.createElement('input');
	        	first_radio.setAttribute("class", "ace");
	        	first_radio.type = "radio";
	        	first_radio.setAttribute("name", radio);

	        	var second_div = document.createElement('div');
	        	second_div.setAttribute("class", "control-group");
	        	var second_lable = document.createElement('lable');
	        	second_lable.setAttribute("class", "line-height-1");
	        	var second_input = document.createElement('input');
	        	second_input.setAttribute("name", option_name);
	        	second_input.type = "text";
	        	second_input.setAttribute("placeholder", "Second Option");
	        	var second_span = document.createElement('span');
	        	second_span.setAttribute("class", "lbl");
	        	var second_radio = document.createElement('input');
	        	second_radio.setAttribute("class", "ace");
	        	second_radio.type = "radio";
	        	second_radio.setAttribute("name", radio);

	        	var third_div = document.createElement('div');
	        	third_div.setAttribute("class", "control-group");
	        	var third_lable = document.createElement('lable');
	        	third_lable.setAttribute("class", "line-height-1");
	        	var third_input = document.createElement('input');
	        	third_input.setAttribute("name", option_name);
				third_input.type = "text";	
	        	third_input.setAttribute("placeholder", "Third Option");
	        	var third_span = document.createElement('span');
	        	third_span.setAttribute("class", "lbl");
	        	var third_radio = document.createElement('input');
	        	third_radio.setAttribute("class", "ace");
	        	third_radio.type = "radio";
	        	third_radio.setAttribute("name", radio);

	        	var fourth_div = document.createElement('div');
	        	fourth_div.setAttribute("class", "control-group");
	        	var fourth_lable = document.createElement('lable');
	        	fourth_lable.setAttribute("class", "line-height-1");
	        	var fourth_input = document.createElement('input');
	       		fourth_input.setAttribute("name", option_name);
	       		fourth_input.type = "text";
	        	fourth_input.setAttribute("placeholder", "Fourth Option");
	        	var fourth_span = document.createElement('span');
	        	fourth_span.setAttribute("class", "lbl");
	        	var fourth_radio = document.createElement('input');
	        	fourth_radio.setAttribute("class", "ace");
	        	fourth_radio.type = "radio";
	        	fourth_radio.setAttribute("name", radio);

				first_span.appendChild(first_input);
	        	first_lable.appendChild(first_radio);
	        	first_lable.appendChild(first_span);
	        	first_div.appendChild(first_lable);

	        	second_span.appendChild(second_input);
	        	second_lable.appendChild(second_radio);
	        	//second_lable.appendChild(radioInput);
	        	second_lable.appendChild(second_span);
	        	second_div.appendChild(second_lable);

	        	third_span.appendChild(third_input);
	        	third_lable.appendChild(third_radio);
	        	//third_lable.appendChild(radioInput);
				third_lable.appendChild(third_span);
	        	third_div.appendChild(third_lable);

	        	fourth_span.appendChild(fourth_input);
	        	fourth_lable.appendChild(fourth_radio);
	        	//fourth_lable.appendChild(radioInput);
	        	fourth_lable.appendChild(fourth_span);
	        	fourth_div.appendChild(fourth_lable);

	        	var mybr = document.createElement('br');
				
	  		

	        	div1.appendChild(question_input);
	        	div1.appendChild(price_input);
	        	div1.appendChild(first_div);
	        	div1.appendChild(second_div);
	        	div1.appendChild(third_div);
	        	div1.appendChild(fourth_div);

	        	mainDiv.appendChild(mybr);
	        	
	        	mainDiv.appendChild(div1);
	        }
	    </script>


		<style>
		#map {
		    margin: auto; width: 100%; border: 2px solid #454447; padding: 200px;
		}

		</style>


<?php
include("footer.php");

?>

	</body>
</html>
