<div id="loader">
    <div class="spinner-border" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>


<style>
	/* Smooth hover effect for dropdown items */
	.userbox .dropdown-menu .dropdown-item {
		transition: all 0.2s ease-in-out;
		border-radius: 6px;
		padding: 8px 10px;
	}

	/* Hover highlight */
	.userbox .dropdown-menu .dropdown-item:hover {
		background: #0d6efd;   /* Bootstrap primary */
		color: #fff !important;
		transform: translateX(4px);
	}

	/* Icon color change on hover */
	.userbox .dropdown-menu .dropdown-item:hover i {
		color: #fff !important;
	}

	/* Optional: logout special hover */
	.userbox .dropdown-menu .text-danger:hover {
		background: #dc3545 !important;
	}
</style>


<header class="header header-nav-menu header-nav-top-line ">
	<div class="logo-container">
		<a href="/home" class="logo" style="float:left !important">						
			<img src="/assets/img/logo.png" width="55" height="35" alt="MFI Logo" />
		</a>	
		<div id="userbox" class="userbox" style="float:right !important;margin:16px 10px 0 0px">
			<a href="#" data-bs-toggle="dropdown">
				<div class="profile-info">
					<span class="name text-primary" style="font-weight: 600;">{{session('user_name')}}</span>
					<span class="role" style="color:#6c757d;">{{session('role_name')}}</span>
				</div>

				<i class="fa custom-caret"></i>
			</a>

			<div class="dropdown-menu" >
				<ul class="list-unstyled">
					<!-- <li>
						<a role="menuitem" tabindex="-1" href="#"><i class="bx bx-user"></i> Profile</a>
					</li> -->
					<!-- <li>
						<a role="menuitem" tabindex="-1" href="#changePassword" class="mb-1 mt-1 me-1 modal-with-zoom-anim ws-normal"><i class="bx bx-lock"></i> Change Password</a>
					</li> -->
					<a href="#changePassword"
					class="dropdown-item d-flex align-items-center gap-2 modal-with-zoom-anim">
						<i class="bx bx-lock text-primary"></i>
						Change Password
					</a>
					<!-- <li>	
						<form action="/logout" method="POST">
							@csrf
							<button style="background: transparent;border: none;font-size: 14px;" type="submit" role="menuitem" tabindex="-1"><i class="bx bx-power-off"></i> Logout</button>
						</form>
					</li> -->

					<div class="dropdown-divider"></div>

					<form action="/logout" method="POST" class="m-0">
						@csrf
						<button type="submit"
								class="dropdown-item d-flex align-items-center gap-2 text-danger">
							<i class="bx bx-power-off"></i>
							Logout
						</button>
					</form>
				</ul>
			</div>
		</div>				
	</div>


	<div id="changePassword" class="zoom-anim-dialog modal-block modal-block-danger mfp-hide">
		<form id="changePasswordForm" method="post" action="{{ route('change-user-password') }}" 
			  style="width: 75%" enctype="multipart/form-data" 
			  onkeydown="return event.key != 'Enter';">
			@csrf
			<header class="card-header">
				<h2 class="card-title">Change Password</h2>
			</header>
			<div class="card-body">
				<div class="row form-group">    
					<div class="col-12 mb-2">
						<label>Current Password</label>
						<input type="password" class="form-control" placeholder="Current Password" id="current_password" name="current_password" required>
					</div> 
					<div class="col-12 mb-2">
						<label>New Password</label>
						<input type="password" class="form-control" placeholder="New Password" id="new_password" minlength="8" name="new_password" required>
					</div>
					<div class="col-12 mb-2">
						<label>Confirm New Password</label>
						<input type="password" class="form-control" placeholder="Confirm New Password" minlength="8" id="confirm_new_password" required>
					</div>
				</div>
			</div>
			<footer class="card-footer">
				<div class="row">
					<div class="col-md-12 text-end">
						<button type="submit" class="btn btn-primary">Change Password</button>
						<button type="button" class="btn btn-default modal-dismiss">Cancel</button>
					</div>
				</div>
			</footer>
		</form>
	</div>
</header>