<div id="loader">
    <div class="spinner-border" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>

<header class="page-header bg-white shadow-sm px-3 py-2">

    <div class="d-flex align-items-center justify-content-between">

        <!-- LEFT: Logo -->
        <div class="d-flex align-items-center">
            <a href="/" class="d-flex align-items-center">
                <img src="/assets/img/logo.png" width="70" alt="MFI Logo">
            </a>
        </div>

        <!-- RIGHT: Actions -->
        <div class="d-flex align-items-center gap-3">

            <!-- POS Button -->
            <a href="/pos" class="btn btn-success btn-sm fw-semibold">
                <i class="bx bx-cart me-1"></i> POS System
            </a>

            <!-- User Dropdown -->
            <div class="dropdown">

                <a class="d-flex align-items-center text-decoration-none" href="#" data-bs-toggle="dropdown">

                    <div class="text-end me-2 d-none d-sm-block">
                        <div class="fw-semibold">{{ session('user_name') }}</div>
                        <div class="text-muted small">{{ session('role_name') }}</div>
                    </div>

                    <i class="fa fa-user-circle fs-5"></i>

                </a>

                <ul class="dropdown-menu dropdown-menu-end shadow-sm">

                    <li>
                        <a class="dropdown-item" href="#changePassword">
                            <i class="bx bx-lock me-2"></i> Change Password
                        </a>
                    </li>

                    <li>
                        <form action="/logout" method="POST">
                            @csrf
                            <button class="dropdown-item text-danger" type="submit">
                                <i class="bx bx-power-off me-2"></i> Logout
                            </button>
                        </form>
                    </li>

                    @if(session('user_role')==1 || session('user_role')==2)

                        <li><hr class="dropdown-divider"></li>

                        <li>
                            <a class="dropdown-item" href="{{ route('backup.database') }}">
                                <i class="bx bx-cloud-download me-2"></i> DB Backup
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="{{ route('backup.files') }}">
                                <i class="bx bx-file me-2"></i> Files Backup
                            </a>
                        </li>

                    @endif

                </ul>
            </div>

            <!-- Sidebar Toggle -->
            <button class="btn btn-light btn-sm">
                <i class="fas fa-bars"></i>
            </button>

        </div>
    </div>

</header>

<!-- Change Password Modal -->
<div id="changePassword" class="mfp-hide white-popup-block p-4 bg-white rounded shadow">

    <form action="{{ route('change-user-password') }}" method="POST">
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
            <button class="btn btn-primary">Change</button>
            <button type="button" class="btn btn-secondary modal-dismiss">Cancel</button>
        </div>

    </form>
</div>