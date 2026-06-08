<header class="page-header bg-white shadow-sm border-bottom">

    <!-- LOADER (unchanged) -->
    <div id="loader">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <div class="logo-container d-md-none">

        <!-- LEFT: LOGO -->
        <a href="/" class="logo d-flex align-items-center px-3 py-2">
            <img src="/assets/img/logo.png" width="65" alt="MFI Logo" />
        </a>

        <!-- RIGHT: USER -->
        <div id="userbox" class="dropdown d-flex align-items-center gap-2 px-3">

            <a href="#"
               class="d-flex align-items-center text-decoration-none dropdown-toggle"
               data-bs-toggle="dropdown">

                <!-- USER INFO -->
                <div class="text-end me-2 lh-sm d-none d-sm-block">
                    <div class="fw-semibold text-dark" style="font-size:14px;">
                        {{session('user_name')}}
                    </div>
                    <small class="text-muted">
                        {{session('role_name')}}
                    </small>
                </div>

                <!-- AVATAR -->
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center shadow-sm"
                     style="width:38px;height:38px;font-weight:600;">
                    {{ strtoupper(substr(session('user_name'),0,1)) }}
                </div>

            </a>

            <!-- DROPDOWN -->
            <div class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 p-2 rounded-3"
                 style="min-width:240px;">

                <a href="#changePassword"
                   class="dropdown-item d-flex align-items-center py-2 rounded-2">
                    <i class="bx bx-lock text-primary me-2 fs-5"></i>
                    Change Password
                </a>

                @if(session('user_role')==1 || session('user_role')==2)

                    <a href="{{ route('backup.database') }}"
                       class="dropdown-item d-flex align-items-center py-2 rounded-2">
                        <i class="bx bx-cloud-download text-success me-2 fs-5"></i>
                        DB Backup
                    </a>

                    <a href="{{ route('backup.files') }}"
                       class="dropdown-item d-flex align-items-center py-2 rounded-2">
                        <i class="bx bx-folder text-warning me-2 fs-5"></i>
                        Files Backup
                    </a>

                @endif

                <div class="dropdown-divider my-2"></div>

                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit"
                            class="dropdown-item d-flex align-items-center py-2 text-danger">
                        <i class="bx bx-power-off me-2 fs-5"></i>
                        Logout
                    </button>
                </form>

            </div>

        </div>

    </div>

    <!-- DESKTOP HEADER -->
    <div class="logo-container d-none d-md-flex justify-content-between align-items-center px-3 py-2">

        <!-- LEFT: LOGO -->
        <a href="/" class="logo d-flex align-items-center">
            <img src="/assets/img/logo.png" width="65" alt="MFI Logo" />
        </a>

        <!-- RIGHT: ACTIONS -->
        <div class="d-flex align-items-center gap-3">

            <!-- POS BUTTON -->
            <a href="/pos"
               class="btn btn-success d-flex align-items-center px-3 py-2 fw-semibold shadow-sm rounded-3">
                <i class="bx bx-cart me-2 fs-5"></i>
                POS System
            </a>

            <!-- USER BOX -->
            <div class="dropdown d-flex align-items-center gap-2">

                <a href="#"
                   class="d-flex align-items-center text-decoration-none dropdown-toggle"
                   data-bs-toggle="dropdown">

                    <div class="text-end me-2 lh-sm">
                        <div class="fw-semibold text-dark" style="font-size:14px;">
                            {{session('user_name')}}
                        </div>
                        <small class="text-muted">
                            {{session('role_name')}}
                        </small>
                    </div>

                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center shadow-sm"
                         style="width:38px;height:38px;font-weight:600;">
                        {{ strtoupper(substr(session('user_name'),0,1)) }}
                    </div>

                </a>

                <div class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 p-2 rounded-3"
                     style="min-width:240px;">

                    <a href="#changePassword" class="dropdown-item py-2">
                        <i class="bx bx-lock text-primary me-2 fs-5"></i>
                        Change Password
                    </a>

                    @if(session('user_role')==1 || session('user_role')==2)

                        <a href="{{ route('backup.database') }}" class="dropdown-item py-2">
                            <i class="bx bx-cloud-download text-success me-2 fs-5"></i>
                            Database Backup
                        </a>

                        <a href="{{ route('backup.files') }}" class="dropdown-item py-2">
                            <i class="bx bx-folder text-warning me-2 fs-5"></i>
                            Files Backup
                        </a>

                    @endif

                    <div class="dropdown-divider"></div>

                    <form action="/logout" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger py-2">
                            <i class="bx bx-power-off me-2 fs-5"></i>
                            Logout
                        </button>
                    </form>

                </div>

            </div>

        </div>

    </div>

    <!-- CHANGE PASSWORD MODAL (UNCHANGED) -->
    <div id="changePassword" class="zoom-anim-dialog modal-block modal-block-danger mfp-hide">

        <form id="changePasswordForm"
              method="post"
              action="{{ route('change-user-password') }}"
              style="width: 75%"
              enctype="multipart/form-data"
              onkeydown="return event.key != 'Enter';">

            @csrf

            <header class="card-header">
                <h2 class="card-title">Change Password</h2>
            </header>

            <div class="card-body">

                <div class="row form-group">

                    <div class="col-12 mb-2">
                        <label>Current Password</label>
                        <input type="password" class="form-control"
                               id="current_password"
                               name="current_password"
                               required>
                    </div>

                    <div class="col-12 mb-2">
                        <label>New Password</label>
                        <input type="password" class="form-control"
                               id="new_password"
                               minlength="8"
                               name="new_password"
                               required>
                    </div>

                    <div class="col-12 mb-2">
                        <label>Confirm New Password</label>
                        <input type="password" class="form-control"
                               id="confirm_new_password"
                               required>
                    </div>

                </div>

            </div>

            <footer class="card-footer text-end">

                <button type="submit" class="btn btn-primary">
                    Change Password
                </button>

                <button type="button" class="btn btn-secondary modal-dismiss">
                    Cancel
                </button>

            </footer>

        </form>

    </div>

</header>