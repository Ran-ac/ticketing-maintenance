<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route ('ticket.TicketingDashboard') }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Ticketing <sup>maintenance</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="{{ route ('ticket.TicketingDashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Home
            </div>
            <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item"> 
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" 
                        aria-expanded="true" aria-controls="collapseTwo"> 
                        <i class="fas fa-fw fa-cog"></i> 
                        <span>Ticketing Management</span> 
                    </a> 
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar"> 
                        <div class="bg-white py-2 collapse-inner rounded"> 
                            <h6 class="collapse-header">Ticketing Type:</h6> 
                            <a class="collapse-item" href="{{ route('ticket.index_clinics') }}">GAOC / Novodental - IR</a>
                            @unless(auth()->user()->role === 'fdo')
                                <a class="collapse-item" href="{{ route('ticket.index_offices') }}">
                                    GSS / GGC OFFICE - IR
                                </a>
                            @endunless

                        </div> 
                    </div> 
                </li>

            <!-- Nav Item - Tables -->
            @unless(auth()->user()->role === 'fdo')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('myTask.index') }}">
                        <i class="fas fa-fw fa-table"></i>
                        <span>My Task</span>
                    </a>
                </li>
            @endunless

            @if(auth()->user()->role === 'superadmin')
                        <!-- Divider -->
                    <hr class="sidebar-divider">
                    <!-- Heading -->
                    <div class="sidebar-heading">
                        Admin
                    </div>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('clinic.index') }}">
                            <i class="fas fa-fw fa-table"></i>
                            <span>Clinics</span></a>
                    </li>

                                <!-- Nav Item - Tables -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('department.index') }}">
                            <i class="fas fa-fw fa-table"></i>
                            <span>Department</span></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users.index') }}">
                            <i class="fas fa-fw fa-table"></i>
                            <span>Users</span></a>
                    </li>
            @endif
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>