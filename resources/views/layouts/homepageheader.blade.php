<div id="loader">
    <div class="spinner-border" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>

<header class="page-header d-flex justify-content-between align-items-center px-3">

    <!-- Logo -->
    <div class="logo-container d-flex align-items-center">
        <a href="/">
            <img src="/assets/img/logo.png" width="70" alt="MFI Logo">
        </a>
    </div>

    <!-- Right Side -->
    <div class="d-flex align-items-center gap-3">

        <!-- POS Button -->
        <a class="btn btn-success btn-sm" href="/pos">
            <i class="bx bx-cart me-1"></i> POS System
        </a>

        <!-- User Dropdown -->
        <div class="userbox dropdown">

            <a href="#" class="d-flex align-items-center text-decoration-none" data-bs-toggle="dropdown">
                <div class="profile-info text-end me-2">
                    <span class="name d-block">{{ session('user_name') }}</span>
                    <span class="role text-muted small">{{ session('role_name') }}</span>
                </div>
                <i class="fa custom-caret"></i>
            </a>

            <div class="dropdown-menu dropdown-menu-end shadow">

                <a class="dropdown-item" href="#changePassword">
                    <i class="bx bx-lock me-2"></i> Change Password
                </a>

                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger">
                        <i class="bx bx-power-off me-2"></i> Logout
                    </button>
                </form>

                @if(session('user_role')==1 || session('user_role')==2)
                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item" href="{{ route('backup.database') }}">
                        <i class="bx bx-cloud-download me-2"></i> DB Backup
                    </a>

                    <a class="dropdown-item" href="{{ route('backup.files') }}">
                        <i class="bx bx-file me-2"></i> Files Backup
                    </a>
                @endif

            </div>
        </div>

        <!-- Sidebar Toggle -->
        <i class="fas fa-bars toggle-sidebar-left"
           data-toggle-class="sidebar-left-opened"
           data-target="html"
           data-fire-event="sidebar-left-opened"></i>

    </div>
</header>

<!-- Change Password Modal -->
<div id="changePassword" class="zoom-anim-dialog modal-block modal-block-danger mfp-hide">

    <form method="POST" action="{{ route('change-user-password') }}" class="p-3" onkeydown="return event.key != 'Enter';">
        @csrf

        <h4 class="mb-3">Change Password</h4>

        <div class="mb-3">
            <label>Current Password</label>
            <input type="password" name="current_password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>New Password</label>
            <input type="password" name="new_password" class="form-control" minlength="8" required>
        </div>

        <div class="mb-3">
            <label>Confirm Password</label>
            <input type="password" name="confirm_new_password" class="form-control" minlength="8" required>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary">Change Password</button>
            <button type="button" class="btn btn-secondary modal-dismiss">Cancel</button>
        </div>
    </form>
</div>