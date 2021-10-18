<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo APP_NAME." | Transactions"; ?></title>
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
							<h1>View Transaction</h1>
						</div><!-- /.page-header -->
						<table id="datatable-buttons" class="table table-bordered">
							<thead>
								<tr>
									<th>Transaction Id</th>
									<th>Transaction Status</th>
									<th>Amount</th>
									<th>Account Detail</th>
									<th>Ad Name</th>
									<th>Name</th>
									<th>Contact</th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach ($all_transaction as $key => $transaction) {
									?>
									<tr>
										<td><?php echo $transaction["transaction_id"]; ?></td>
										<td><?php echo $transaction["transaction_status"]; ?></td>
										<td><?php echo $transaction["amount"]; ?></td>
										<td><?php echo $transaction["store_name"]; ?></td>
										<td><?php echo $transaction["ad_name"]; ?></td>
										<td><?php echo $transaction["user_name"]; ?></td>
										<td><?php echo $transaction["user_contact"]; ?></td>
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
