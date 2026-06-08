<header class="page-header">

    <!-- Loader -->
    <div id="loader">
        <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <!-- MOBILE VIEW (like Code 1 d-md-none) -->
    <div class="logo-container d-md-none d-flex justify-content-between align-items-center px-2 py-2">

        <!-- Logo -->
        <a href="/" class="logo d-flex align-items-center">
            <img src="/assets/img/logo.png" width="70" alt="MFI Logo">
        </a>

        <!-- USER BOX -->
        <div class="dropdown userbox">

            <a href="#" data-bs-toggle="dropdown" class="d-flex align-items-center text-decoration-none">

                <div class="text-end me-2">
                    <div class="fw-semibold" style="font-size:14px;">
                        {{ session('user_name') }}
                    </div>
                    <small class="text-muted">
                        {{ session('role_name') }}
                    </small>
                </div>

                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                     style="width:35px;height:35px;">
                    {{ strtoupper(substr(session('user_name'),0,1)) }}
                </div>

                <i class="fa custom-caret ms-2"></i>
            </a>

            <div class="dropdown-menu">
                <ul class="list-unstyled mb-0">

                    <li>
                        <a href="#changePassword" class="dropdown-item modal-with-zoom-anim">
                            <i class="bx bx-lock"></i> Change Password
                        </a>
                    </li>

                    @if(session('user_role')==1 || session('user_role')==2)
                    <li>
                        <a href="{{ route('backup.database') }}" class="dropdown-item">
                            <i class="bx bx-cloud-download"></i> DB Backup
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('backup.files') }}" class="dropdown-item">
                            <i class="bx bx-file"></i> Files Backup
                        </a>
                    </li>
                    @endif

                    <li>
                        <form action="/logout" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item"
                                style="background:transparent;border:none;">
                                <i class="bx bx-power-off"></i> Logout
                            </button>
                        </form>
                    </li>

                </ul>
            </div>
        </div>
    </div>


    <!-- DESKTOP VIEW (like Code 1 d-none d-md-block) -->
    <div class="logo-container d-none d-md-flex justify-content-between align-items-center px-2 py-2">

        <!-- LEFT: LOGO -->
        <a href="/" class="logo d-flex align-items-center">
            <img src="/assets/img/logo.png" width="70" alt="MFI Logo">
        </a>

        <!-- RIGHT ACTIONS -->
        <div class="d-flex align-items-center gap-2">

            <!-- POS BUTTON -->
            <a class="btn btn-success px-3 py-2 fw-semibold shadow-sm d-flex align-items-center"
               href="/pos">
                <i class="bx bx-cart me-1"></i>
                POS System
            </a>

            <!-- USER DROPDOWN -->
            <div class="dropdown userbox">

                <a href="#" data-bs-toggle="dropdown" class="d-flex align-items-center text-decoration-none">

                    <div class="text-end me-2">
                        <div class="fw-semibold" style="font-size:14px;">
                            {{ session('user_name') }}
                        </div>
                        <small class="text-muted">
                            {{ session('role_name') }}
                        </small>
                    </div>

                    <i class="fa custom-caret"></i>
                </a>

                <div class="dropdown-menu dropdown-menu-end">

                    <a href="#changePassword" class="dropdown-item modal-with-zoom-anim">
                        <i class="bx bx-lock"></i> Change Password
                    </a>

                    @if(session('user_role')==1 || session('user_role')==2)
                    <a href="{{ route('backup.database') }}" class="dropdown-item">
                        <i class="bx bx-cloud-download"></i> DB Backup
                    </a>

                    <a href="{{ route('backup.files') }}" class="dropdown-item">
                        <i class="bx bx-file"></i> Files Backup
                    </a>
                    @endif

                    <div class="dropdown-divider"></div>

                    <form action="/logout" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item" style="background:transparent;border:none;">
                            <i class="bx bx-power-off"></i> Logout
                        </button>
                    </form>

                </div>
            </div>

        </div>
    </div>


    <!-- CHANGE PASSWORD MODAL -->
    <div id="changePassword" class="zoom-anim-dialog modal-block modal-block-danger mfp-hide">

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