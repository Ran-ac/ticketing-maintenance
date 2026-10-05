<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route ('ticket.TicketingDashboard') }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-tools"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Ticketing <sup>maintenance</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="{{ route ('ticket.TicketingDashboard') }}">
                    <i class="fas fa-fw fas fa-home"></i>
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
                    <a class="nav-link collapsed d-flex align-items-center" href="#" data-toggle="collapse" data-target="#collapseTwo"
                        aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-fw fa-tasks"></i>
                        <span>Ticket Manager</span>

                    @if(in_array(auth()->user()->role, ['fdo']))
                        <span id="ticketBadge" class="badge badge-danger badge-pill ml-auto mr-1"
                            style="font-size: 0.6rem; display: none;">
                            <i class="fas fa-bell" style="font-size: 0.555rem;"></i>
                            <span id="ticketCount">0</span>
                        </span>
                    @endif
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
                            <i class="fas fa-fw fas fa-clinic-medical"></i>
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
                            <i class="fas fa-fw fa-users"></i>
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
        document.addEventListener('DOMContentLoaded', function () {
        const badge = document.getElementById('ticketBadge');
        const count = document.getElementById('ticketCount');
        if (!badge || !count) return; // badge isn't rendered for this role

        const userId   = "{{ auth()->id() }}";
        const userRole = "{{ strtolower(auth()->user()->role) }}";
        const seenKey  = `ticketSeenCount_${userId}`;
        const endpoint = userRole === 'maintenance'
            ? "{{ route('myTask.assigned-count') }}"
            : "{{ route('myTask.for-approval-count') }}";

        let latestCount = 0;

        const getSeen = () => parseInt(localStorage.getItem(seenKey) || '0', 10);
        const setSeen = (n) => localStorage.setItem(seenKey, n);

        function renderBadge() {
            const seen = getSeen();

            // Count dropped (tickets handled) -> reset baseline
            if (latestCount < seen) setSeen(latestCount);

            const unseen = latestCount - getSeen();
            if (unseen > 0) {
                count.textContent = unseen;
                badge.style.display = 'inline-block';
            } else {
                badge.style.display = 'none';
            }
        }

        function updateTicketCount() {
            fetch(endpoint, { headers: { 'Accept': 'application/json' } })
                .then(r => r.json())
                .then(data => {
                    latestCount = data.count || 0;
                    renderBadge();
                })
                .catch(err => console.error('Error:', err));
        }

        function markViewed() {
            setSeen(latestCount);
            badge.style.display = 'none';

            // optional: also tell the server
            fetch("{{ route('myTask.mark-viewed') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                keepalive: true
            });
        }

        // Ticket Manager sub-links (FDO) AND My Tickets link (others)
        document.querySelectorAll(
            '#collapseTwo .collapse-item, a[href="{{ route('myTask.index') }}"]'
        ).forEach(link => link.addEventListener('click', markViewed));

        updateTicketCount();
        setInterval(updateTicketCount, 30000);
        });
</script>