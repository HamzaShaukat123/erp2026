 <!-- Loader -->
    <div id="loader">
        <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

<header class="page-header">

   

    <!-- MAIN HEADER -->
    <div class="logo-container d-md-none">

        <!-- Logo -->
        <a href="/" class="logo ">
			<img src="/assets/img/logo.png" width="70px" alt="MFI Logo" />
		</a>

        <!-- RIGHT SIDE ACTIONS -->
        <div class="d-flex align-items-center gap-2">

            <!-- POS BUTTON -->
            <a class="btn btn-success px-3 py-2 fw-semibold shadow-sm d-flex align-items-center"
               href="/pos">
                <i class="bx bx-cart me-1 text-white"></i>
                <span class="d-none d-sm-inline">POS System</span>
            </a>

            <!-- USER DROPDOWN -->
            <div class="dropdown">

                <a href="#"
                   class="d-flex align-items-center text-decoration-none"
                   data-bs-toggle="dropdown">

                    <!-- USER INFO -->
                    <div class="text-end me-2 d-none d-sm-block">
                        <div class="fw-semibold text-dark" style="font-size:14px;">
                            {{ session('user_name') }}
                        </div>
                        <small class="text-muted">
                            {{ session('role_name') }}
                        </small>
                    </div>

                    <!-- AVATAR -->
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                         style="width:35px;height:35px;">
                        {{ strtoupper(substr(session('user_name'),0,1)) }}
                    </div>

                    <i class="bx bx-chevron-down ms-2 text-secondary"></i>
                </a>

                <!-- DROPDOWN MENU -->
                <div class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 p-2"
                     style="min-width:220px; border-radius:10px;">

                    <a href="#changePassword" class="dropdown-item">
                        <i class="bx bx-lock me-2 text-primary"></i>
                        Change Password
                    </a>

                    @if(session('user_role')==1 || session('user_role')==2)

                        <a href="{{ route('backup.database') }}" class="dropdown-item">
                            <i class="bx bx-cloud-download me-2 text-success"></i>
                            DB Backup
                        </a>

                        <a href="{{ route('backup.files') }}" class="dropdown-item">
                            <i class="bx bx-file me-2 text-warning"></i>
                            Files Backup
                        </a>

                    @endif

                    <div class="dropdown-divider"></div>

                    <form action="/logout" method="POST">
                        @csrf
                        <button class="dropdown-item text-danger">
                            <i class="bx bx-power-off me-2 text-danger"></i>
                            Logout
                        </button>
                    </form>

                </div>

            </div>
        </div>
    </div>

    <!-- CHANGE PASSWORD MODAL -->
    <div id="changePassword"
         class="zoom-anim-dialog modal-block modal-block-danger mfp-hide">

        <form id="changePasswordForm"
              method="post"
              action="{{ route('change-user-password') }}"
              style="width:75%"
              onkeydown="return event.key != 'Enter';">

            @csrf

            <header class="card-header">
                <h2 class="card-title">Change Password</h2>
            </header>

            <div class="card-body">

                <div class="mb-2">
                    <label>Current Password</label>
                    <input type="password" name="current_password" class="form-control" required>
                </div>

                <div class="mb-2">
                    <label>New Password</label>
                    <input type="password" name="new_password" class="form-control" minlength="8" required>
                </div>

                <div class="mb-2">
                    <label>Confirm Password</label>
                    <input type="password" class="form-control" minlength="8" required>
                </div>

            </div>

            <footer class="card-footer text-end">
                <button type="submit" class="btn btn-primary">Change Password</button>
                <button type="button" class="btn btn-default modal-dismiss">Cancel</button>
            </footer>

        </form>
    </div>

</header>