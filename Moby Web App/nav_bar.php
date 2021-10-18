
<body class="no-skin">
		<div id="navbar" class="navbar navbar-default ace-save-state">
			<div class="navbar-container ace-save-state" id="navbar-container">
				<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
					<span class="sr-only">Toggle sidebar</span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>
				</button>

				<div class="navbar-header pull-left">
					<a href="index1.php" class="navbar-brand">
						<small>
							<i class="fa fa-leaf"></i>
							<?php echo APP_NAME; ?>
						</small>
					</a>
				</div>
				
				<div class="navbar-buttons navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">
						<li class="light-orange dropdown-modal">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
								<!-- <img class="nav-user-photo" src="assets/images/avatars/user.jpg" alt="Jason's Photo" /> -->
								<span class="user-info">
									<small>Welcome,</small>
									<?php echo $display_name; ?>
								</span>

								<i class="ace-icon fa fa-caret-down"></i>
							</a>

							<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">		
								<?php
								if($user_type == "store") {

								?>
									<li>
										<a href="?PROFILE">
											<i class="ace-icon fa fa-user"></i>
											Profile
										</a>
									</li>
									<li class="divider"></li>
								<?php } else { ?>
									<li>
										<a href="?SETTINGS">
											<i class="ace-icon fa fa-cog"></i>
											Setting
										</a>
									</li>
									<li class="divider"></li>
								<?php } ?>
								<li>
									<a href="index.php?logout=''">
										<i class="ace-icon fa fa-power-off"></i>
										Logout
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
			</div>
		</body>
</html>

