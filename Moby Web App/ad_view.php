
<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo APP_NAME."  | Ad"; ?></title>
	<?php 
	include("header.php");
	include("nav_bar.php");
	include("sidebar.php");
	$location = [];
	$ad_detail = $CommonFunc->getAdDetail($ad_id);
	$campaign_detail = $CommonFunc->getCampaignDetail($ad_detail->campaign_id);
	$quiz_detail = $CommonFunc->getQuizForAds($ad_id, $ad_detail->quiz_count);
	$location_detail = $CommonFunc->getLocationForAds($ad_id, $ad_detail->location_count);
	foreach ($location_detail as $l_key => $l_value) {
		$location_this = [];
		$location_this["location_id"] = $l_value["location_id"];
		$location_this["lat"] = $l_value["location_lat"];
		$location_this["lng"] = $l_value["location_long"];
		array_push($location, $location_this);
	}
	?>
			<div class="main-content">
				<div class="main-content-inner">
					<div class="page-content">
						<div class="page-header">
							<h1>
								Ad Information
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									All Information
								</small>
							</h1>
						</div><!-- /.page-header -->
						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<div class="row">
									<div class="col-xs-12">		
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

									</div>
								</div>

							<div class="row">
								<div class="col-xs-12">
									<!-- PAGE CONTENT BEGINS -->
									<div class="space-6"></div>

									<div class="row">
										<div class="col-sm-10 col-sm-offset-1">
											<div class="widget-box transparent">
												<div class="widget-header widget-header-large">
													<h3 class="widget-title grey lighter">
														<i class="ace-icon fa fa-question green"></i>
														Questions
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
																		<b class="label label-xlg label-success arrowed-right " ><?php echo $value["reward_amount"]; ?> INR</b>
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
									<!-- PAGE CONTENT ENDS -->
								</div><!-- /.col -->
							</div><!-- /.row -->
							<div class="col-md-4 col-md-offset-4">
								<div class="row">
									<div class="col-xs-4"><a class="btn btn-info" href="?AD_UPDATE&ad_id=<?php echo $ad_id ?>">Edit </a></div>
									<div class="col-xs-4"><button class="btn btn-danger">Delete</button></div>
									<div class="col-xs-4">
										<?php if($ad_detail->publish == "no") { ?>
										
											<form method="GET" action="">
												<input type="hidden" name="ad_id" value="<?php echo $ad_id; ?>">
												<input type="hidden" name="publish">
												<button type="submit" class="btn btn-primary" name="SHOW_ALL_ADS">Publish</button>
											</form>
										
										<?php } ?>
									</div>
								</div>
								
								
								
							</div>
						</div><!-- /.page-content -->
					</div>
				</div><!-- /.main-content -->
			</div>
		</div>

		<!--[if !IE]> -->
		<script src="assets/js/jquery-2.1.4.min.js"></script>
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
					
					
					//"bProcessing": true,
			        //"bServerSide": true,
			        //"sAjaxSource": "http://127.0.0.1/table.php"	,
			
					//,
					//"sScrollY": "200px",
					//"bPaginate": false,
			
					//"sScrollX": "100%",
					//"sScrollXInner": "120%",
					//"bScrollCollapse": true,
					//Note: if you are applying horizontal scrolling (sScrollX) on a ".table-bordered"
					//you may want to wrap the table inside a "div.dataTables_borderWrap" element
			
					//"iDisplayLength": 50
			
			
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
					  }, {
							"extend": "copy",
							"text": "<i class='fa fa-copy bigger-110 pink'></i> <span class='hidden'>Copy to clipboard</span>",
							"className": "btn btn-white btn-primary btn-bold"
						}, {
							"extend": "csv",
							"text": "<i class='fa fa-database bigger-110 orange'></i> <span class='hidden'>Export to CSV</span>",
							"className": "btn btn-white btn-primary btn-bold"
					  }, {
							"extend": "excel",
							"text": "<i class='fa fa-file-excel-o bigger-110 green'></i> <span class='hidden'>Export to Excel</span>",
							"className": "btn btn-white btn-primary btn-bold"
					  }, {
							"extend": "pdf",
							"text": "<i class='fa fa-file-pdf-o bigger-110 red'></i> <span class='hidden'>Export to PDF</span>",
							"className": "btn btn-white btn-primary btn-bold"
					  }, {
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
				
				$('.show-details-btn').on('click', function(e) {
					e.preventDefault();
					$(this).closest('tr').next().toggleClass('open');
					$(this).find(ace.vars['.icon']).toggleClass('fa-angle-double-down').toggleClass('fa-angle-double-up');
				});
				
			})
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAPHnw9tDjgI0Ab_Fn4ylpbP9PcKMebkrE&callback=myMap"></script><script type="text/javascript">// <![CDATA[
var markers = <?php echo json_encode($location); ?>;
window.onload = function () {
	var mapOptions = {
		center: new google.maps.LatLng(markers[0].lat, markers[0].lng),
		zoom: 10,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	var map = new google.maps.Map(document.getElementById("dvMap"), mapOptions);
	var infoWindow = new google.maps.InfoWindow();
	var lat_lng = new Array();
	var latlngbounds = new google.maps.LatLngBounds();
	for (i = 0; i < markers.length; i++) {
		var data = markers[i]
		var myLatlng = new google.maps.LatLng(data.lat, data.lng);
		lat_lng.push(myLatlng);
		var marker = new google.maps.Marker({
			position: myLatlng,
			map: map,
			title: data.title
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

// ]]></script>


<?php
include("footer.php");

?>

	</body>
</html>
