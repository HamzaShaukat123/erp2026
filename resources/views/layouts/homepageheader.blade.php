<div id="loader" style="background:#ffffff;">
    <div class="spinner-border text-primary" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>

<header class="page-header" style="background:linear-gradient(90deg,#f8f9fc,#ffffff); border-bottom:1px solid #e5e7eb; box-shadow:0 2px 6px rgba(0,0,0,0.05);">

	<!-- MOBILE HEADER -->
	<div class="logo-container d-md-none">

		<a href="/" class="logo">
			<img src="/assets/img/logo.png" width="70px" alt="MFI Logo" />
		</a>

		<div id="userbox" class="userbox" style="float:right !important;">

			<a href="#" data-bs-toggle="dropdown" style="margin-right: 15px; color:#111827; display:flex; align-items:center; gap:10px;">

				<div class="profile-info" style="text-align:right;">
					<span class="name" style="display:block; font-weight:600; color:#111827;">
						{{session('user_name')}}
					</span>
					<span class="role" style="font-size:12px; color:#6b7280;">
						{{session('role_name')}}
					</span>
				</div>

				<i class="fa fa-chevron-down" style="color:#6b7280;"></i>

			</a>

			<div class="dropdown-menu shadow-sm" style="border-radius:12px; border:1px solid #e5e7eb; overflow:hidden;">

				<ul class="list-unstyled m-0">

					<li>
						<a href="#changePassword"
						   class="dropdown-item"
						   style="color:#2563eb; font-weight:500;">
						   <i class="bx bx-lock"></i> Change Password
						</a>
					</li>

					<li>
						<form action="/logout" method="POST">
							@csrf
							<button type="submit"
								class="dropdown-item"
								style="background:none; border:none; color:#ef4444; font-weight:500; width:100%; text-align:left;">
								<i class="bx bx-power-off"></i> Logout
							</button>
						</form>
					</li>

					@if(session('user_role')==1 || session('user_role')==2)
					<li>
						<a href="{{ route('backup.database') }}" class="dropdown-item" style="color:#16a34a;">
							<i class="bx bx-cloud-download"></i> DB Backup
						</a>
					</li>
					<li>
						<a href="{{ route('backup.files') }}" class="dropdown-item" style="color:#14b8a6;">
							<i class="bx bx-files"></i> Files Backup
						</a>
					</li>
					@endif

				</ul>

			</div>

			<i class="fas fa-bars toggle-sidebar-left" style="color:#111827;"></i>

		</div>

	</div>

	<!-- DESKTOP HEADER -->
	<div class="logo-container d-none d-md-block">

		<div id="userbox" class="userbox" style="float:right !important; display:flex; align-items:center; gap:15px;">

			<a href="/pos"
			   class="btn"
			   style="background:linear-gradient(135deg,#22c55e,#16a34a); color:white; border:none; padding:8px 16px; border-radius:10px; font-weight:600; box-shadow:0 4px 10px rgba(34,197,94,0.25);">
				POS System
			</a>

			<a href="#" data-bs-toggle="dropdown" style="color:#111827; display:flex; align-items:center; gap:10px;">

				<div class="profile-info" style="text-align:right;">
					<span class="name" style="display:block; font-weight:600;">
						{{session('user_name')}}
					</span>
					<span class="role" style="font-size:12px; color:#6b7280;">
						{{session('role_name')}}
					</span>
				</div>

				<i class="fa fa-chevron-down" style="color:#6b7280;"></i>

			</a>

			<div class="dropdown-menu shadow" style="border-radius:12px; border:1px solid #e5e7eb;">

				<ul class="list-unstyled m-0">

					<li>
						<a href="#changePassword" class="dropdown-item" style="color:#2563eb;">
							<i class="bx bx-lock"></i> Change Password
						</a>
					</li>

					<li>
						<form action="/logout" method="POST">
							@csrf
							<button type="submit"
								class="dropdown-item"
								style="background:none; border:none; color:#ef4444; width:100%; text-align:left;">
								<i class="bx bx-power-off"></i> Logout
							</button>
						</form>
					</li>

					@if(session('user_role')==1 || session('user_role')==2)
					<li>
						<a href="{{ route('backup.database') }}" class="dropdown-item" style="color:#16a34a;">
							<i class="bx bx-cloud-download"></i> DB Backup
						</a>
					</li>
					<li>
						<a href="{{ route('backup.files') }}" class="dropdown-item" style="color:#14b8a6;">
							<i class="bx bx-file"></i> Files Backup
						</a>
					</li>
					@endif

				</ul>

			</div>

		</div>

	</div>

	<!-- CHANGE PASSWORD MODAL -->
	<div id="changePassword" class="zoom-anim-dialog modal-block modal-block-danger mfp-hide">

		<form id="changePasswordForm"
			  method="post"
			  action="{{ route('change-user-password') }}"
			  style="width: 75%"
			  enctype="multipart/form-data"
			  onkeydown="return event.key != 'Enter';">

			@csrf

			<header class="card-header" style="background:linear-gradient(135deg,#2563eb,#1d4ed8); color:white; border-radius:10px 10px 0 0;">
				<h2 class="card-title" style="margin:0;">Change Password</h2>
			</header>

			<div class="card-body" style="background:#ffffff;">

				<div class="row form-group">

					<div class="col-12 mb-3">
						<label style="font-weight:600; color:#374151;">Current Password</label>
						<input type="password" class="form-control"
							   style="border:1px solid #d1d5db; border-radius:8px;"
							   id="current_password"
							   name="current_password"
							   required>
					</div>

					<div class="col-12 mb-3">
						<label style="font-weight:600; color:#374151;">New Password</label>
						<input type="password" class="form-control"
							   style="border:1px solid #22c55e; border-radius:8px;"
							   id="new_password"
							   minlength="8"
							   name="new_password"
							   required>
					</div>

					<div class="col-12 mb-3">
						<label style="font-weight:600; color:#374151;">Confirm Password</label>
						<input type="password" class="form-control"
							   style="border:1px solid #14b8a6; border-radius:8px;"
							   id="confirm_new_password"
							   required>
					</div>

				</div>

			</div>

			<footer class="card-footer" style="background:#f9fafb; border-top:1px solid #e5e7eb;">

				<div class="row">

					<div class="col-md-12 text-end">

						<button type="submit"
							class="btn"
							style="background:linear-gradient(135deg,#2563eb,#1d4ed8); color:white; border-radius:8px;">
							Change Password
						</button>

						<button type="button"
							class="btn modal-dismiss"
							style="background:#6b7280; color:white; border-radius:8px;">
							Cancel
						</button>

					</div>

				</div>

			</footer>

		</form>

	</div>

</header>