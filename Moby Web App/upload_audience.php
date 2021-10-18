<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo APP_NAME." | Upload Audience"; ?></title>
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
							<h1>Upload Audience</h1>
						</div><!-- /.page-header -->
						<div class="row">
							<div class="col-xs-6 col-xs-offset-3">
								<form method="POST" action=""  enctype="multipart/form-data"> 
									<center>
										<h3>Upload the audience file.</h3>
										<hr>
										<p>Please upload the same format as you downloaded from the Audience tab. <br>
										To update an audience, please keep in mind that the "Audience Id" is mentioned.<br>
										To Add new audience, the "Audience Id" column should be remain empty.</p>
										<hr>
										<input type="file" name="audience_file" class="form-control" accept=".xlsx, .xlx, .xls, .csv">
										<br>
										<input type="submit" name="SUBMIT_AUDIENCE_FILE" class="btn btn-primary">
									</center>
								</form>
							</div>
						</div>
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
	
	</body>
</html>
