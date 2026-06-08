<div id="loader">
    <div class="spinner-border" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>

<header class="page-header d-flex justify-content-between align-items-center">

    <!-- LEFT SIDE (Logo + Toggle) -->
    <div class="d-flex align-items-center">

        <!-- Mobile Logo -->
        <a href="/" class="logo d-md-none me-2">
            <img src="/assets/img/logo.png" width="60" alt="MFI Logo" />
        </a>

        <!-- Sidebar Toggle -->
        <i class="fas fa-bars toggle-sidebar-left me-3"
           data-toggle-class="sidebar-left-opened"
           data-target="html"
           aria-label="Toggle sidebar"
           style="cursor:pointer;"></i>
    </div>

    <!-- RIGHT SIDE -->
    <div class="d-flex align-items-center">

        <!-- POS Button (Desktop only) -->
        <a class="btn btn-success me-3 px-3 py-2 fw-semibold shadow-sm d-none d-md-inline-block" href="/pos">
            <i class="bx bx-cart me-1"></i> POS
        </a>

        <!-- USER DROPDOWN -->
        <div class="dropdown userbox">

            <a href="#" class="d-flex align-items-center text-decoration-none" data-bs-toggle="dropdown">

                <!-- USER INFO -->
                <div class="text-end me-2 d-none d-sm-block">
                    <div class="fw-semibold text-dark" style="font-size: 14px;">
                        {{ session('user_name') }}
                    </div>
                    <small class="text-muted">
                        {{ session('role_name') }}
                    </small>
                </div>

                <!-- AVATAR -->
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center user-avatar">
                    {{ strtoupper(substr(session('user_name'),0,1)) }}
                </div>

                <i class="bx bx-chevron-down ms-2 text-muted"></i>
            </a>

            <!-- DROPDOWN MENU -->
            <div class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 p-2" style="min-width: 220px;">

                <a class="dropdown-item d-flex align-items-center" href="#changePassword">
                    <i class="bx bx-lock me-2"></i> Change Password
                </a>

                @if(session('user_role')==1 || session('user_role')==2)
                <a class="dropdown-item d-flex align-items-center" href="{{ route('backup.database') }}">
                    <i class="bx bx-cloud-download me-2"></i> DB Backup
                </a>

                <a class="dropdown-item d-flex align-items-center" href="{{ route('backup.files') }}">
                    <i class="bx bx-file me-2"></i> Files Backup
                </a>
                @endif

                <div class="dropdown-divider"></div>

                <form action="/logout" method="POST">
                    @csrf
                    <button class="dropdown-item d-flex align-items-center text-danger">
                        <i class="bx bx-power-off me-2"></i> Logout
                    </button>
                </form>

            </div>
        </div>

    </div>
</header>
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
