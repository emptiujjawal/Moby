<?php  
include("nav_bar.php");
include("sidebar.php");
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title><?php echo APP_NAME."  | Ads Form"; ?></title>

		<meta name="description" content="overview &amp; stats" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />

		<!-- page specific plugin styles -->

		<!-- text fonts -->
		<link rel="stylesheet" href="assets/css/fonts.googleapis.com.css" />

		<!-- ace styles -->
		<link rel="stylesheet" href="assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

		<!--[if lte IE 9]>
			<link rel="stylesheet" href="assets/css/ace-part2.min.css" class="ace-main-stylesheet" />
		<![endif]-->
		<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
		<link rel="stylesheet" href="assets/css/ace-rtl.min.css" />

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- ace settings handler -->
		<script src="assets/js/ace-extra.min.js"></script>

		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
		<![endif]-->
	</head>

		</div>

			<div class="main-content">
				<div class="main-content-inner">
					

					<div class="page-content">
						

						<div class="page-header">
							<h1>
								Create An Ad
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Campaign
								</small>
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								
								<hr></hr>

								<div class="widget-box">

									<div class="widget-body">
										<div class="widget-main">
											<div id="fuelux-wizard-container">
												<div>
													<ul class="steps">
														<li data-step="1" class="active">
															<span class="step">1</span>
															<span class="title">Create Campaign</span>
														</li>

														<li data-step="2">
															<span class="step">2</span>
															<span class="title">Create Ads</span>
														</li>

														<li data-step="3">
															<span class="step">3</span>
															<span class="title">Audiance</span>
														</li>

														<li data-step="4">
															<span class="step">4</span>
															<span class="title">Location</span>
														</li>
														<li data-step="5">
															<span class="step">5</span>
															<span class="title">Add Question</span>
														</li>
													</ul>
												</div>

												<hr />

												<div class="step-content pos-rel">
													<div class="step-pane active" data-step="1">
														<h4 class="lighter block green"><b>Create Campaign</b></h4>

														<form class="form-horizontal" id="sample-form" method="post">

															<div class="form-group">
																<label class="control-label col-xs-12 col-sm-3 no-padding-right">Campaign Name:</label>

																<div class="col-xs-12 col-sm-2">
																	<span class="block input-icon input-icon-right">
																		<select class="chosen-select form-control" id="form-field-select-1" name = "compaign">
																			<option value="">Select One Type</option>
																			<option value="">Campaign1</option>
																			<option value="">Campaign2</option>
																			<option value="">Campaign3</option>
																		</select>
																	</span>
																</div>
															</div>
 
															<div id="add_camaign">
																
															</div>

															<div class="col-md-offset-3 col-md-9">
																<button class="btn btn-sm btn-primary" type="button" onClick="addTextBox();">
																	Add More
																</button>
															</div>
														</form>
													</div>

													<div class="step-pane active" data-step="2">
														<h4 class="lighter block green"><b>Create Ads</b></h3>

														<form class="form-horizontal" id="sample-form">
														

															<div class="form-group">
																<label class="col-xs-12 col-sm-3 control-label no-padding-right">Ad Name</label>

																<div class="col-xs-12 col-sm-5">
																	<span class="block input-icon input-icon-right">
																		<input type="text" id="ad_name" name = "ad_name" class="width-100" placeholder="Ad Name"/>
																		<i class="ace-icon fa fa-info-circle tooltip-primary" data-rel="tooltip" data-placement="right" title="Ad Name" ></i>
																		
																	</span>
																</div>
															</div>

															<div class="form-group">
																<label class="col-xs-12 col-sm-3 control-label no-padding-right">Product Name</label>

																<div class="col-xs-12 col-sm-5">
																	<span class="block input-icon input-icon-right">
																		<input type="text" id="product_name" class="width-100" placeholder="Product Name" />
																		<i class="ace-icon fa fa-info-circle tooltip-primary" data-rel="tooltip" data-placement="right" title="Product Name" ></i>
																		
																	</span>
																</div>
															</div>

															<div class="form-group">
																<label class="col-xs-12 col-sm-3 control-label no-padding-right">Product Url</label>

																<div class="col-xs-12 col-sm-5">
																	<span class="block input-icon input-icon-right">
																		<input type="text" id="product_url" name="product_url" class="width-100" placeholder="Product Url" />
																		<i class="ace-icon fa fa-info-circle tooltip-primary" data-rel="tooltip" data-placement="right" title="Product Url" ></i>
																		
																	</span>
																</div>
															</div>

															<div class="form-group">
																<label class="col-xs-12 col-sm-3 control-label no-padding-right">Company Name</label>

																<div class="col-xs-12 col-sm-5">
																	<span class="block input-icon input-icon-right">
																		<input type="text" id="compamy_name" name = "compamy_name" class="width-100" placeholder="Company Name" />
																		<i class="ace-icon fa fa-info-circle tooltip-primary" data-rel="tooltip" data-placement="right" title="Company Name" ></i>
																		
																	</span>
																</div>
															</div>

															<div class="form-group">
																<label for="inputInfo" class="col-xs-12 col-sm-3 control-label no-padding-right">Company Url</label>

																<div class="col-xs-12 col-sm-5">
																	<span class="block input-icon input-icon-right">
																		<input type="text" id="inputInfo" name="company_url" class="width-100" placeholder="Company Url" />
																		<i class="ace-icon fa fa-info-circle tooltip-primary" data-rel="tooltip" data-placement="right" title="Company Url" ></i>
																		
																	</span>
																</div>
															</div>

															<div class="form-group">
																<label class="col-xs-12 col-sm-3 control-label no-padding-right">Coverage Radius</label>

																<div class="col-xs-12 col-sm-5">
																	<span class="block input-icon input-icon-right">
																		<input type="number" id="coverage_radius" name="coverage_radius" class="width-100" placeholder="Coverage Radius" />
																		<i class="ace-icon fa fa-info-circle tooltip-primary" data-rel="tooltip" data-placement="right" title="Coverage Radius" ></i>
																	</span>
																</div>
															</div>

															<div class="form-group">
																<label class="col-xs-12 col-sm-3 control-label no-padding-right">Reward Amount</label>

																<div class="col-xs-12 col-sm-5">
																	<span class="block input-icon input-icon-right">
																		<input type="number" id="reward_amount" name = "reward_amount" class="width-100" placeholder="Reward Amount" />
																		<i class="ace-icon fa fa-info-circle tooltip-primary" data-rel="tooltip" data-placement="right" title="Reward Amount" ></i>
																	</span>
																</div>
															</div>
														</form>
													</div>

													
													<div class="step-pane" data-step="3">
														<h4 class="lighter block green"><b>Audiance</b></h3>

														<form class="form-horizontal" id="sample-form">
														

															<div class="form-group">
																<label class="col-xs-12 col-sm-3 control-label no-padding-right">Audiance Type</label>

																<div class="col-xs-12 col-sm-5">
																	<span class="block input-icon input-icon-right">
																		<select class="form-control" id="audiance_type" name = "audiance_name">
																			<option value="">Select One Type</option>
																			<option value="">Customer</option>
																			<option value="">Visitor</option>
																			<option value="">Owner</option>
																		</select>
																	</span>
																</div>
															</div>

															<div class="form-group">
																<label class="col-xs-12 col-sm-3 control-label no-padding-right">Your Age</label>

																<div class="col-xs-8 col-sm-5">
																	<span class="block input-icon input-icon-right">
																		
																		
																	</span>
																	<div class="input-daterange input-group">
																		<select class="form-control" id="age" name= "age_from">
																			<option value="">Select Your Age Range</option>
																			<option value="">18</option>
																			<option value="">25</option>
																			<option value="">30</option>
																			<option value="">35</option>
																			<option value="">40</option>
																			<option value="">45</option>
																			<option value="">50</option>
																			<option value="">55</option>
																			<option value="">60</option>
																		</select>
																	<span class="input-group-addon">
																		<i class="fa fa-exchange"></i>
																	</span><select class="form-control" id="age" name = "age_to">
																			<option value="">Select Your Age Range</option>
																			<option value="">18</option>
																			<option value="">25</option>
																			<option value="">30</option>
																			<option value="">35</option>
																			<option value="">40</option>
																			<option value="">45</option>
																			<option value="">50</option>
																			<option value="">55</option>
																			<option value="">60</option>
																		</select>
																</div>
																</div>
															</div>
															


															<div class="form-group">
																<label class="control-label  col-xs-12 col-sm-3 no-padding-right">Gender</label>

																<div class="col-xs-12 col-sm-9">
																	<div>
																		<label class="line-height-1">
																			<input name="gender" value="1" type="radio" class="ace" />
																			<span class="lbl"> All</span>
																		</label>
																	</div>
																	<div>
																		<label class="line-height-1">
																			<input name="gender" value="2" type="radio" class="ace" />
																			<span class="lbl"> Male</span>
																		</label>
																	</div>

																	<div>
																		<label class="line-height-1">
																			<input name="gender" value="3" type="radio" class="ace" />
																			<span class="lbl"> Female</span>
																		</label>
																	</div>
																</div>
															</div>
														</form>
													</div>

													<div class="step-pane" data-step="4">
													<h4 class="lighter block green"><b>Location</b></h3>

														<div class="center">
														
															<input id="searchInput" style="width: 50%" class="controls" type="text" placeholder="Enter a location">
															<div id="map"></div>
															<div style="padding: 20px">
															
																<form>
																Latitude: <input type="text" name="lat1" id="lat1" readonly="" placeholder="Latitude">
																Longitude: <input type="text" name="long1" id="lng1" readonly="" placeholder="Longitude">

																<div id="add_textbox"></div>
																<br/>
																<!-- <button class="btn btn-sm btn-primary" type="button" onClick="addTextArea();">
																	Add More
																</button> -->
															
															   </form>
															
															</div>
        
														</div>
													</div>

													<div class="step-pane" data-step="5">
													<h4 class="lighter block green"><b>Question</b></h3>
														<form class="form-horizontal" id="sample-form">
														
															<div class="control-group">
																
																<input type="text" name = "question1" class="width-50" placeholder="Enter a question?" />

																<input type="text" name="price1" class="width-5" placeholder=" Price INR">
																
																<div class="control-group">
																	<label class="line-height-1">
																		<input name="radio1" type="radio" class="ace" />
																		<span class="lbl"><input type="text" name="option1"  placeholder="First Option"></span>
																	</label>
																</div>

																<div class="control-group">
																	<label class="line-height-1">
																		<input name="radio1" type="radio" class="ace" />
																		<span class="lbl"><input type="text" name="option1" placeholder="Second Option"></span>
																	</label>
																</div>

																<div class="control-group">
																	<label class="line-height-1">
																		<input name="radio1" type="radio" class="ace" />
																		<span class="lbl"><input type="text" name="option1"  placeholder="Third Option"></span>
																	</label>
																</div>

																<div class="control-group">
																	<label class="line-height-1">
																		<input name="radio1" type="radio" class="ace" />
																		<span class="lbl"><input type="text" name="option1" placeholder="Fourth Option"></span>
																	</label>
																</div>
															</div>

															<div id = "add_question"> </div>

															<div class="control-group">
																<button class="btn btn-sm btn-primary" type="button" onClick="addQuestion();">
																Add More Question
																</button>
															</div>
														</form>
													</div>
												</div>
											</div>
											<hr />
											<div class="wizard-actions">
												<button class="btn btn-prev">
													<i class="ace-icon fa fa-arrow-left"></i>
													Back
												</button>

												<button class="btn btn-success btn-next" data-last="Finish">
													Continue
													<i class="ace-icon fa fa-arrow-right icon-on-right"></i>
												</button>
											</div>
										</div><!-- /.widget-main -->
									</div><!-- /.widget-body -->
								</div>
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->
			</div><!-- /.main-content -->



			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->

		<!-- basic scripts -->

		<!--[if !IE]> -->
		<script src="assets/js/jquery-2.1.4.min.js"></script>

		<!-- <![endif]-->

		<!--[if IE]>
<script src="assets/js/jquery-1.11.3.min.js"></script>
<![endif]-->
		

		<!-- inline scripts related to this page -->

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
			
			
				//jump to a step
				/**
				var wizard = $('#fuelux-wizard-container').data('fu.wizard')
				wizard.currentStep = 3;
				wizard.setState();
				*/
			
				//determine selected step
				//wizard.selectedItem().step
			
			
			
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
			
			
			
				//documentation : http://docs.jquery.com/Plugins/Validation/validate
			
			
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
				
				
				/**
				$('#date').datepicker({autoclose:true}).on('changeDate', function(ev) {
					$(this).closest('form').validate().element($(this));
				});
				
				$('#mychosen').chosen().on('change', function(ev) {
					$(this).closest('form').validate().element($(this));
				});
				*/
				
				
				$(document).one('ajaxloadstart.page', function(e) {
					//in ajax mode, remove remaining elements before leaving page
					$('[class*=select2]').remove();
				});
			})
		</script>


		<script>
		//******************wamique*************// 

		var map; //Will contain map object.
		var marker = false; ////Has the user plotted their location marker? 
		var counter = 1;
		function initMap() 
		{

		    //The center location of our map.
		    var centerOfMap = new google.maps.LatLng(28.613939, 77.209021);
		 
		    //Map options.
		    var options = {
		      center: centerOfMap, //Set center.
		      zoom: 13 //The zoom value.
		    };

		    //Create the map object.
		    map = new google.maps.Map(document.getElementById('map'), options);

		   map.addListener('click', function(event) {
		    placeMarkerAndPanTo(event.latLng, map);

		   
		  });

		   google.maps.event.addListener(map, 'click', function(event) 
		    {                
		        //Get the location that the user clicked.
		        var clickedLocation = event.latLng;
		        //If the marker hasn't been added.
		        if(marker === false)
		        {
		            //Create the marker.
		            marker = new google.maps.Marker({
		                position: clickedLocation,
		                map: map,
		                draggable: true //make it draggable
		            });
		            //Listen for drag events!
		            google.maps.event.addListener(marker, 'dragend', function(event){
		                markerLocation();
		            });
		        } else{
		            //Marker has already been added, so just change its location.
		            counter +=1;
		            marker.setPosition(clickedLocation);
		            
					if (counter>1) {
		            alert(counter);

		            document.getElementById("add_textbox").style.padding = "20px";
		            var div = document.getElementById('add_textbox');
		            div.innerHTML += 'Latitude: <input type= "text" id = "lat" placeholder = "Latitude">Longitude: <input type="text" id = "lng" placeholder = "Longitude"><br/>';
		            div.innerHTML += "\n<br />";
					}
		        }
		        //Get the marker's location.
		        markerLocation();
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

		function placeMarkerAndPanTo(latLng, map) 
		{
		  var marker = new google.maps.Marker({
		    position: latLng,
		    map: map
		  });
		  map.panTo(latLng);
		}

		function markerLocation(){
		    //Get location.
		    var currentLocation = marker.getPosition();
		    //Add lat and lng values to a field that we can save.
		    document.getElementById('lat1').value = currentLocation.lat(); //latitude
		    document.getElementById('lng1').value = currentLocation.lng(); //longitude
		}

		
		        
		//Load the map when the page has finished loading.
		google.maps.event.addDomListener(window, 'load', initMap);
		</script>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAPHnw9tDjgI0Ab_Fn4ylpbP9PcKMebkrE&libraries=places&callback=initMap" ></script>


		<!-- <script type="text/javascript">
	        function addTextArea(){
	        	document.getElementById("add_textbox").style.padding = "20px";
	            var div = document.getElementById('add_textbox');
	            div.innerHTML += 'Latitude: <input type= "text" id = "lat" placeholder = "Latitude">Longitude: <input type="text" id = "lng" placeholder = "Longitude"><br/>';
	            div.innerHTML += "\n<br />";
	        }
	    </script> -->


	    
	    <script type="text/javascript">
	        function addTextBox(){
	        	//document.getElementById("add_textbox").style.padding = "20px";
	      //var div = document.getElementById('add_camaign');

	      //   	var div1 = document.createElement('div');
	      //   	div1.setAttribute("class", "form-group");

	      //   	var lable = document.createElement('lable');
	      //   	lable.setAttribute("class", "control-label col-xs-12 col-sm-3 no-padding-right");
			    // lable.innerHTML = "Campaign Name: ";

	      //   	var div2 = document.createElement('div');
	      //   	div2.setAttribute("class", "col-xs-12 col-sm-9");

	      //   	var div3 =document.createElement('div');
	      //   	div3.setAttribute("class", "clearfix");

	      //   	var input = document.createElement('input');
	      //   	input.type = "text";
	      //   	input.setAttribute("name", "campaign_name");
	      //   	input.setAttribute("placeholder", "Enter a campaign name");
	      //   	input.setAttribute("class", "col-xs-12 col-sm-6");

	      //   	div3.appendChild(input);
	      //   	div2.appendChild(div3);
	      //   	div1.appendChild(lable);
	      //   	div1.appendChild(div2);
	      //   	div.appendChild(div1);
	      document.getElementById("add_camaign").innerHTML="<div class='form-group'><label class='control-label col-xs-12 col-sm-3 no-padding-right' >Campaign Name:</label>  <div class='col-xs-12 col-sm-9'>  <input type='text' name='comaign' id='compaign' class='col-xs-12 col-sm-7' placeholder='Enter a Campaign name' /></div> </div>"

	        }
	    </script>

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

<input name="answer" type="radio" class="ace" />
		<style>
		#map {
		    margin: auto; width: 60%; border: 3px solid #454447; padding: 200px;
		}
		</style>
		<?php
			include("footer.php");
		?>
	</body>
</html>
