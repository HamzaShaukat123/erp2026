<header class="page-header bg-white shadow-sm border-bottom">

    <!-- LOADER -->
    <div id="loader">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <!-- ================= MOBILE HEADER ================= -->
    <div class="logo-container d-flex d-md-none justify-content-between align-items-center px-3 py-2">

        <!-- LEFT: LOGO -->
        <a href="/" class="logo d-flex align-items-center">
            <img src="/assets/img/logo.png" width="65" alt="MFI Logo" />
        </a>

        <!-- RIGHT: USER + TOGGLE -->
        <div class="d-flex align-items-center gap-2">

            <!-- SIDEBAR TOGGLE (IMPORTANT FIX) -->
            <i class="fas fa-bars toggle-sidebar-left fs-5"
               data-toggle-class="sidebar-left-opened"
               data-target="html"
               data-fire-event="sidebar-left-opened"
               style="cursor:pointer;"></i>

            <!-- USER -->
            <div class="dropdown">

                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                   data-bs-toggle="dropdown">

                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center shadow-sm"
                         style="width:36px;height:36px;font-weight:600;">
                        {{ strtoupper(substr(session('user_name'),0,1)) }}
                    </div>

                </a>

                <div class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 p-2 rounded-3">

                    <a href="#changePassword" class="dropdown-item">
                        <i class="bx bx-lock text-primary me-2"></i>
                        Change Password
                    </a>

                    <form action="/logout" method="POST">
                        @csrf
                        <button class="dropdown-item text-danger" type="submit">
                            <i class="bx bx-power-off me-2"></i>
                            Logout
                        </button>
                    </form>

                    @if(session('user_role')==1 || session('user_role')==2)
                        <a href="{{ route('backup.database') }}" class="dropdown-item text-success">
                            DB Backup
                        </a>
                        <a href="{{ route('backup.files') }}" class="dropdown-item text-warning">
                            Files Backup
                        </a>
                    @endif

                </div>
            </div>

        </div>

    </div>

    <!-- ================= DESKTOP HEADER ================= -->
    <div class="logo-container d-none d-md-flex justify-content-between align-items-center px-3 py-2">

        <!-- LEFT: LOGO -->
        <a href="/" class="logo d-flex align-items-center">
            <img src="/assets/img/logo.png" width="65" alt="MFI Logo" />
        </a>

        <!-- RIGHT: ACTIONS -->
        <div class="d-flex align-items-center gap-3">

            <!-- POS -->
            <a href="/pos" class="btn btn-success px-3 py-2 fw-semibold shadow-sm rounded-3">
                <i class="bx bx-cart me-2"></i>
                POS System
            </a>

            <!-- USER -->
            <div class="dropdown">

                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                   data-bs-toggle="dropdown">

                    <div class="text-end me-2 lh-sm">
                        <div class="fw-semibold">
                            {{ session('user_name') }}
                        </div>
                        <small class="text-muted">
                            {{ session('role_name') }}
                        </small>
                    </div>

                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center shadow-sm"
                         style="width:38px;height:38px;font-weight:600;">
                        {{ strtoupper(substr(session('user_name'),0,1)) }}
                    </div>

                </a>

                <div class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 p-2 rounded-3">

                    <a href="#changePassword" class="dropdown-item">
                        <i class="bx bx-lock text-primary me-2"></i>
                        Change Password
                    </a>

                    <form action="/logout" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="bx bx-power-off me-2"></i>
                            Logout
                        </button>
                    </form>

                    @if(session('user_role')==1 || session('user_role')==2)
                        <a href="{{ route('backup.database') }}" class="dropdown-item text-success">
                            DB Backup
                        </a>
                        <a href="{{ route('backup.files') }}" class="dropdown-item text-warning">
                            Files Backup
                        </a>
                    @endif

                </div>

            </div>

        </div>

    </div>

</header>