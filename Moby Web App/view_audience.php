<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo APP_NAME." | View Audience"; ?></title>
	    
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
							<h1>View Audience</h1>
						</div><!-- /.page-header -->
						<table id="datatable-buttons" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>Audience Id</th>
									<th>Name</th>
									<th>Email</th>
									<th>Contact</th>
									<th>Gender</th>
									<th>Street Address</th>
									<th>Location</th>
									<th>City</th>
									<th>State</th>
									<th>Pincode</th>
									<th>Date of Birth</th>
									<th>Salary Group</th>
									<th>Club Membership</th>
									<th>defence Service</th>
									<th>Work Type</th>
									<th>User Profession</th>
									<th>Watch Brand</th>
									<th>Car Brand</th>
									<th>Residence Type</th>
									<th>Locality</th>
									<th>Transport Type</th>
									<th>Miles Card</th>
									<th>Credit Card</th>
									<th>Wallet Amount</th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach ($all_audience as $key => $audience) {
									?>
									<tr>
										<td><?php echo $audience["audience_id"]; ?></td>
										<td><?php echo $audience["user_name"]; ?></td>
										<td><?php echo $audience["user_email"]; ?></td>
										<td><?php echo $audience["user_contact"]; ?></td>
										<td><?php echo $audience["user_gender"]; ?></td>
										<td><?php echo $audience["user_address"]; ?></td>
										<td><?php echo $audience["user_location"]; ?></td>
										<td><?php echo $audience["user_city"]; ?></td>
										<td><?php echo $audience["user_state"]; ?></td>
										<td><?php echo $audience["user_pincode"]; ?></td>
										<td><?php echo $audience["user_dob"]; ?></td>
										<td><?php echo $audience["user_salary"]; ?></td>
										<td><?php echo $audience["club_membership"]; ?></td>
										<td><?php echo $audience["defence_service"]; ?></td>
										<td><?php echo $audience["work_type"]; ?></td>
										<td><?php echo $audience["user_profession"]; ?></td>
										<td><?php echo $audience["watch_brand"]; ?></td>
										<td><?php echo $audience["car_brand"]; ?></td>
										<td><?php echo $audience["residence_type"]; ?></td>
										<td><?php echo $audience["locality"]; ?></td>
										<td><?php echo $audience["transport_type"]; ?></td>
										<td><?php echo $audience["miles_card"]; ?></td>
										<td><?php echo $audience["credit_card"]; ?></td>
										<td><?php echo $audience["wallet_amount"]; ?></td>
									</tr>
									<?php
								}
								 ?>
							</tbody>
						</table>
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

		<!-- ace scripts -->
		<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>

		<!-- Datatables -->
			<script src="vendors/datatables.net/js/jquery.dataTables.min.js"></script>
			<script src="vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
			<script src="vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
			<script src="vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
			<script src="vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
			<script src="vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
			<script src="vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
			<script src="vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
			<script src="vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
			<script src="vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
			<script src="vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
			<!-- Datatables -->
			<script>
				$(document).ready(function() {
					var handleDataTableButtons = function() {
						if ($("#datatable-buttons").length) {
							$("#datatable-buttons").DataTable({
								dom: "Bfrtip",
								buttons: [
								{
									extend: "copy",
									className: "btn-sm"
								},
								{
									extend: "csv",
									className: "btn-sm"
								},
								{
									extend: "excel",
									className: "btn-sm"
								},
								{
									extend: "pdfHtml5",
									className: "btn-sm"
								},
								{
									extend: "print",
									className: "btn-sm"
								},
								],
								responsive: true
							});
						}
					};

					TableManageButtons = function() {
						"use strict";
						return {
							init: function() {
								handleDataTableButtons();
							}
						};
					}();

					$('#datatable').dataTable();
					$('#datatable-keytable').DataTable({
						keys: true
					});

					$('#datatable-responsive').DataTable();

					$('#datatable-scroller').DataTable({
						// ajax: "js/datatables/json/scroller-demo.json",
						deferRender: true,
						scrollY: 380,
						scrollCollapse: true,
						scroller: true
					});

					var table = $('#datatable-fixed-header').DataTable({
						fixedHeader: true
					});

					TableManageButtons.init();
				});
			</script>

	</body>
</html>
