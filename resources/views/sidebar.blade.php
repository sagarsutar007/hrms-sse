<!-- Sidebar -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="{{ URL('images/logo.png') }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Shri Sai Electricals</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar" id="side_bar_main_Div">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Dashboard Link -->
                <li class="nav-item">
                    <a href="/" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Employees Section -->
                @if ($view_menu_items == 1)
                <li class="nav-item">
                    <a href="/employees" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Employees</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('all-attendance-p') }}" class="nav-link">
                        <i class="nav-icon fas fa-list-check"></i>
                        <p>Punched Attendance</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('all-attendance') }}" class="nav-link">
                        <i class="nav-icon fas fa-list-check"></i>
                        <p>Attendance</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="registration" class="nav-link">
                        <i class="nav-icon fas fa-user-plus"></i>
                        <p>Add Employee</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('salary-calculations') }}" class="nav-link">
                        <i class="nav-icon fas fa-calculator"></i>
                        <p>Salary Calculations</p>
                    </a>
                </li>

                <!-- Reports Section (Collapsible) -->
                <li class="nav-item">
                    <a href="#" class="nav-link" data-toggle="collapse" data-target="#report_sub_menu" aria-expanded="false">
                        <i class="nav-icon fas fa-chart-simple"></i>
                        <p>Reports <i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview collapse" id="report_sub_menu">
                        <li class="nav-item">
                            <a href="{{ url('report-1') }}" class="nav-link">
                                <i class="nav-icon fas fa-circle"></i>
                                <p>Report 1</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('total-leave') }}" class="nav-link">
                                <i class="nav-icon fas fa-circle"></i>
                                <p>Leave Report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('Absent-List') }}" class="nav-link">
                                <i class="nav-icon fas fa-circle"></i>
                                <p>Absent List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('Present-List') }}" class="nav-link">
                                <i class="nav-icon fas fa-circle"></i>
                                <p>Present List</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Other Sections -->
                <li class="nav-item">
                    <a href="{{ url('downloade-Id-cards') }}" class="nav-link">
                        <i class="nav-icon fas fa-address-card"></i>
                        <p>Download ID Cards</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('all-holidays') }}" class="nav-link">
                        <i class="nav-icon fas fa-calendar-check"></i>
                        <p>Holidays</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('swipe-list') }}" class="nav-link">
                        <i class="nav-icon fas fa-sync-alt"></i>
                        <p>Swap Day</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('calendar') }}" class="nav-link">
                        <i class="nav-icon fas fa-calendar-alt"></i>
                        <p>Calendar</p>
                    </a>
                </li>

                <!-- Role-Based Sections -->
                @if ($role == 'Super admin')
                <li class="nav-item">
                    <a href="{{ url('super-admin-settings') }}" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>Super Admin Settings</p>
                    </a>
                </li>
                @elseif ($role == 'Admin')
                <li class="nav-item">
                    <a href="{{ url('admin') }}" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>Admin Settings</p>
                    </a>
                </li>
                @elseif ($role == 'HR')
                <li class="nav-item">
                    <a href="{{ url('HR-page') }}" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>HR Settings</p>
                    </a>
                </li>
                @endif

                <!-- Log Out -->
                <li class="nav-item">
                    <a href="{{ url('logout') }}" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Log Out</p>
                    </a>
                </li>
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

<!-- Scripts for Sidebar Collapse -->
<script>
    $(document).ready(function() {
        // Sidebar Toggle (for smaller screens)
        $(".nav-item .nav-link[data-toggle='collapse']").click(function() {
            var target = $(this).attr('data-target');
            $(target).collapse('toggle');
        });
    });
</script>

