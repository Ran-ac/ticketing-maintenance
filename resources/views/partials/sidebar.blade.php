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
                        <i class="fas fa-fw fa-ticket-alt"></i>
                        <span>My Tickets</span>
                        <span class="badge badge-danger badge-counter ml-2" id="ticketBadge" style="display: none;">
                            <i class="fas fa-bell"></i> <span id="ticketCount">0</span>
                        </span>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    function updateTicketCount() {
        const userRole = "{{ auth()->user()->role }}";
        const isMaintenance = userRole === 'Maintenance';
        const endpoint = isMaintenance 
            ? "{{ route('myTask.assigned-count') }}" 
            : "{{ route('myTask.for-approval-count') }}";
        
        fetch(endpoint)
            .then(response => response.json())
            .then(data => {
                const badge = document.getElementById('ticketBadge');
                const count = document.getElementById('ticketCount');
                if (data.count > 0) {
                    count.textContent = data.count;
                    badge.style.display = 'inline-block';
                } else {
                    badge.style.display = 'none';
                }
            })
            .catch(error => console.error('Error:', error));
    }

    updateTicketCount();
    setInterval(updateTicketCount, 30000);
    });
</script>