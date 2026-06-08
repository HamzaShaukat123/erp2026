<div id="loader">
    <div class="spinner-border" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>

<header class="page-header bg-white shadow-sm px-3 py-2">

    <div class="d-flex justify-content-between align-items-center">

        <!-- LEFT: LOGO -->
        <div class="d-flex align-items-center">
            <a href="/" class="d-flex align-items-center">
                <img src="/assets/img/logo.png" width="70" alt="MFI Logo">
            </a>
        </div>

        <!-- RIGHT: ACTIONS -->
        <div class="logo-container d-none d-md-flex justify-content-end align-items-center">

            <!-- POS BUTTON -->
            <a class="btn btn-success me-3 px-3 py-2 fw-semibold shadow-sm" href="/pos">
                <i class="bx bx-cart me-1"></i> POS System
            </a>

            <!-- USER BOX -->
            <div id="userbox" class="userbox dropdown">

                <a href="#" class="d-flex align-items-center text-decoration-none" data-bs-toggle="dropdown">

                    <!-- USER INFO -->
                    <div class="profile-info text-end me-2">
                        <div class="fw-semibold text-dark" style="font-size: 14px;">
                            {{ session('user_name') }}
                        </div>
                        <small class="text-muted">
                            {{ session('role_name') }}
                        </small>
                    </div>

                    <!-- AVATAR -->
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                         style="width:35px;height:35px;font-weight:600;">
                        {{ strtoupper(substr(session('user_name'),0,1)) }}
                    </div>

                    <i class="bx bx-chevron-down ms-2 text-muted"></i>

                </a>

                <!-- DROPDOWN -->
                <div class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 p-2"
                     style="min-width:220px; border-radius:10px;">

                    <!-- CHANGE PASSWORD -->
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

                    <!-- LOGOUT -->
                    <form action="/logout" method="POST">
                        @csrf
                        <button type="submit"
                                class="dropdown-item d-flex align-items-center text-danger">
                            <i class="bx bx-power-off me-2"></i> Logout
                        </button>
                    </form>

                </div>
            </div>

        </div>

        <!-- MOBILE MENU BUTTON -->
        <div class="d-md-none">
            <button class="btn btn-light">
                <i class="fas fa-bars"></i>
            </button>
        </div>

    </div>
</header>

<!-- CHANGE PASSWORD MODAL -->
<div id="changePassword" class="mfp-hide white-popup-block p-4 bg-white rounded shadow">

    <form method="POST" action="{{ route('change-user-password') }}">
        @csrf

        <h5 class="mb-3">Change Password</h5>

        <div class="mb-3">
            <label class="form-label">Current Password</label>
            <input type="password" name="current_password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">New Password</label>
            <input type="password" name="new_password" class="form-control" minlength="8" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="confirm_new_password" class="form-control" minlength="8" required>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary">Change Password</button>
            <button type="button" class="btn btn-secondary modal-dismiss">Cancel</button>
        </div>

    </form>
</div>