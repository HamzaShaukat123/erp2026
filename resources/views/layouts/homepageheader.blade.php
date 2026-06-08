<header class="page-header bg-white border-bottom shadow-sm">

    <!-- LOADER -->
    <div id="loader">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <div class="container-fluid">

        <div class="d-flex align-items-center justify-content-between py-2">

            <!-- LEFT: LOGO + MOBILE MENU -->
            <div class="d-flex align-items-center gap-3">

                <!-- MOBILE SIDEBAR TOGGLE -->
                <i class="fas fa-bars fs-5 d-md-none toggle-sidebar-left"
                   data-toggle-class="sidebar-left-opened"
                   data-target="html"
                   data-fire-event="sidebar-left-opened"
                   style="cursor:pointer;"></i>

                <!-- LOGO -->
                <a href="/" class="d-flex align-items-center">
                    <img src="/assets/img/logo.png" width="65" alt="MFI Logo">
                </a>

            </div>

            <!-- RIGHT ACTIONS -->
            <div class="d-flex align-items-center gap-3">

                <!-- POS BUTTON -->
                <a href="/pos"
                   class="btn btn-success btn-sm px-3 fw-semibold shadow-sm d-none d-md-inline-flex align-items-center">
                    <i class="bx bx-cart me-2"></i>
                    POS System
                </a>

                <!-- USER DROPDOWN -->
                <div class="dropdown">

                    <a href="#"
                       class="d-flex align-items-center text-decoration-none dropdown-toggle"
                       data-bs-toggle="dropdown">

                        <!-- TEXT -->
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
                             style="width:38px;height:38px;font-weight:600;">
                            {{ strtoupper(substr(session('user_name'),0,1)) }}
                        </div>

                    </a>

                    <!-- DROPDOWN -->
                    <div class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 p-2 rounded-3">

                        <a href="#changePassword" class="dropdown-item py-2">
                            <i class="bx bx-lock text-primary me-2"></i>
                            Change Password
                        </a>

                        @if(session('user_role')==1 || session('user_role')==2)

                            <a href="{{ route('backup.database') }}" class="dropdown-item py-2">
                                <i class="bx bx-cloud-download text-success me-2"></i>
                                DB Backup
                            </a>

                            <a href="{{ route('backup.files') }}" class="dropdown-item py-2">
                                <i class="bx bx-folder text-warning me-2"></i>
                                Files Backup
                            </a>

                        @endif

                        <div class="dropdown-divider"></div>

                        <form action="/logout" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger py-2">
                                <i class="bx bx-power-off me-2"></i>
                                Logout
                            </button>
                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</header>