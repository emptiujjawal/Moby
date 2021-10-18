
<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>

			<div id="sidebar" class="sidebar responsive ace-save-state">
				<script type="text/javascript">
					try{ace.settings.loadState('sidebar')}catch(e){}
				</script>

				
				<ul class="nav nav-list">
					<?php if($user_type == "store") { ?>
					<li class="">
						<a href="?ADD_NEW_AD">
							<i class="menu-icon fa fa-caret-right"></i>
							Create An Retailer  Ad
						</a>
						<b class="arrow"></b>
					</li>
					<li class="">
						<a href="?ADD_bank">
							<i class="menu-icon fa fa-caret-right"></i>
							Bank Ad
						</a>
						<b class="arrow"></b>
					</li>
					<li class="">
						<a href="?SHOW_ALL_ADS">
							<i class="menu-icon fa fa-caret-right"></i>
							View All Ad
						</a>
						<b class="arrow"></b>
					</li>
					<?php } 
					if($user_type == "admin") {
					?>
					
					<li class="">
						<a href="?MESSAGES">
							<i class="menu-icon fa fa-caret-right"></i>
							Create Message
						</a>
						<b class="arrow"></b>
					</li>
					<li class="">
						<a href="?CREATE_STORE">
							<i class="menu-icon fa fa-caret-right"></i>
							Create Account
						</a>
						<b class="arrow"></b>
					</li>
					<li class="">

						<a href="?VIEW_STORES">
							<i class="menu-icon fa fa-caret-right"></i>
							View Accounts
						</a>
						<b class="arrow"></b>
					</li>
					<li class="">
						<a href="?VIEW_AUDIENCE">
							<i class="menu-icon fa fa-caret-right"></i>
							Audience
						</a>
						<b class="arrow"></b>
					</li>
					<li class="">
						<a href="?UPLOAD_AUDIENCE">
							<i class="menu-icon fa fa-caret-right"></i>
							Upload Audience
						</a>
						<b class="arrow"></b>
					</li>
					<li class="">
						<a href="?GET_TRANSACTION">
							<i class="menu-icon fa fa-caret-right"></i>
							View Transactions
						</a>
						<b class="arrow"></b>
					</li>
					<?php } ?>
				</ul>
			</div>
		