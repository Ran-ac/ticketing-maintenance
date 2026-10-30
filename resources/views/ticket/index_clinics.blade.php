<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ticketing System Maintenance</title>
    <link rel="icon" type="image/png" href="{{ asset('gaoc.png') }}">
    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

	<!-- DataTables CDN -->
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

	<!-- Bootstrap CDN -->

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Optional: Bootstrap 5 Theme (better styling) -->
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    <!-- jQuery (if not already included) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

    <style>
        .history-timeline {
    list-style: none;
    margin: 0;
    padding: 0 0 0 34px;
    position: relative;
}

/* the vertical line */
.history-timeline::before {
    content: '';
    position: absolute;
    left: 13px;
    top: 4px;
    bottom: 4px;
    width: 2px;
    background: #e3e6f0;
}

.history-timeline li {
    position: relative;
    margin-bottom: 1.25rem;
}

.history-timeline li:last-child {
    margin-bottom: 0;
}

/* the colored dot with icon */
.history-timeline .tl-dot {
    position: absolute;
    left: -34px;
    top: 0;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    box-shadow: 0 0 0 4px #fff; /* gap between the dot and the line */
}

.history-timeline .tl-card {
    background: #f8f9fc;
    border: 1px solid #e3e6f0;
    border-radius: 8px;
    padding: 10px 14px;
}

.history-timeline .tl-change {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-top: 6px;
    flex-wrap: wrap;
}

.history-timeline .tl-remarks {
    margin-top: 8px;
    padding-left: 10px;
    border-left: 3px solid #d1d3e2;
    color: #6c757d;
    font-size: 0.9rem;
}
        </style>

</head>



<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
            @include('partials.sidebar')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
                <!-- Main Content -->
                <div id="content">

                    <!-- Topbar -->
                    @include('partials.navbar')
                    <!-- End of Topbar -->

                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Tickets</h1>
                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item active">Tickets from GAOC / NOVODENTAL </li>
                        </ol>

                        <div class="d-flex justify-content-between mb-3">
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createTicketModal">
                                Create New Ticket
                            </button>
                        </div>
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="table-responsive" >
                                    <table class="table table-bordered table-striped table-hover" id="ticketTable" width="100%" cellspacing="0">
                                        
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Ticket Type</th>
                                                <th>Type of concern</th>
                                                <th>Clinics name</th>
                                                <th>Equipment or machine</th>
                                                <th>Equipment or machine brand</th>
                                                <th>Serial number</th>
                                                <th>Concern description</th>
                                                <th>Status</th>
                                                <th>Reported by</th>
                                                <th>Email</th>
                                                <th>Assigned by</th>
                                                <th>Created at</th>
                                                <th>File</th>
                                                <th>Remarks</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody id="tableBody">
                                            <!--table populate here -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <!-- Footer -->
                @include('partials.footer')
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
	<!-- Logout -->
		@include('partials.logout');
	<!-- End of Logout -->

                <!-- Create Ticket Modal -->
        <div class="modal fade" id="formModalCreate" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTitle">Add new ticket</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                    <div class="modal-body" id="modalContentCreate"></div>
                </div>
            </div>
        </div>

                <!-- Edit Ticket Modal -->
        <div class="modal fade" id="formModalEdit" tabindex="-1" aria-labelledby="modalTitleEdit" aria-hidden="true">
            <div class="modal-dialog modal-l">
                <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTitleEdit">Edit Ticket</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                    <div class="modal-body" id="modalContentEdit"></div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="createTicketModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Create New Ticketff</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="ticketForm">
                            <div class="mb-3">
                                <label class="form-label">Type of Ticket</label>
                                <select class="form-control" name="type_of_concern" id="ticketType">
                                    <option value="">Select Type</option>
                                    <option value="GAOC - Maintenance IR Form">GAOC - Maintenance IR Form</option>
                                    <option value="Novodental - Maintenance IR Form">Novodental - Maintenance IR Form</option>
                                    @unless(auth()->user()->role == 'fdo')
                                        <option value="GSS - Maintenance IR Form">
                                            GSS - Maintenance IR Form
                                        </option>

                                        <option value="GGC Offices - Maintenance IR Form">
                                            GGC Offices - Maintenance IR Form
                                        </option>
                                    @endunless
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" form="ticketForm" class="btn btn-primary">Open Ticket</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="imageModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-body text-center">
                    <img id="modalImage" src="" class="img-fluid">
                </div>
                </div>
            </div>
        </div>
        <!-- Assign Modal -->
    <div class="modal fade" id="assignModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Assign Users</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="ticket_id">

                    <label for="assigned_user" class="form-label">Select Users</label>
                    <select id="assigned_user" class="form-select" multiple placeholder="Search users...">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" id="saveAssign">Save</button>
                </div>
            </div>
        </div>
    </div>

        <!-- Ticket Details Modal -->
<!-- Ticket Details Modal -->
<div class="modal fade" id="ticketDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">View Ticket #<span id="detailId"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <ul class="nav nav-tabs mb-3" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#detailsTab" type="button">
                            Details
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#historyTab" type="button">
                            History
                        </button>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="detailsTab">
                        <div id="ticketDetailsBody"></div>
                    </div>
                    <div class="tab-pane fade" id="historyTab">
                        <div id="ticketHistoryBody"></div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


        <!-- Bootstrap core JavaScript-->

        <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

        <!-- Core plugin JavaScript-->
        <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

        <!-- Custom scripts for all pages-->
        <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

        <!-- Page level plugins -->
        <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>

        <!-- Page level custom scripts -->
        <script src="{{ asset('js/demo/chart-area-demo.js') }}"></script>
        <script src="{{ asset('js/demo/chart-pie-demo.js') }}"></script>
		<script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>


		<!-- jQuery -->
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
		<!-- DataTables JS -->
		<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

   </body>

</html>

<script>
$(function () {

    const isSuperAdmin = @json(auth()->user()->role === 'superadmin');
    const userRole     = @json(auth()->user()->role);
    const users        = @json($users);

    const STORAGE_URL = '/ticketing_system_maintenance/public/storage';
    const csrfToken   = $('meta[name="csrf-token"]').attr('content');

    const ROUTES = {
        assign:       "{{ route('ticket.task_assign') }}",
        tableData:    "{{ route('ticket.fetchClinicalTicketData') }}",
        updateStatus: "{{ route('ticket.update-ticket-status', ':id') }}",
        history:       "{{ route('ticket.history', ':id') }}",
        edit:         "{{ route('ticket.editTicketGaoc', ':id') }}",
        destroy:      "{{ route('ticket.ticket-destroy', ':id') }}",
    };

    const TICKET_FORM_ROUTES = {
        'GAOC - Maintenance IR Form':        "{{ route('ticket.gaoc') }}",
        'Novodental - Maintenance IR Form':  "{{ route('ticket.novo') }}",
        'GSS - Maintenance IR Form':         "{{ route('ticket.gss') }}",
        'GGC Offices - Maintenance IR Form': "{{ route('ticket.gcc') }}",
    };

    const TICKET_TYPE_COLORS = {
        'GAOC - Maintenance IR Form':        'primary',
        'Novodental - Maintenance IR Form':  'success',
        'GSS - Maintenance IR Form':         'warning',
        'GGC Offices - Maintenance IR Form': 'info',
    };

    const STATUS_CLASSES = {
        'New':              'text-info',
        'On hold':          'text-muted',
        'On pause':         'text-primary',
        'For continuation': 'text-warning',
        'Done':             'text-success',
        'Pending':          'text-secondary',
    };

    /* ------------------------------------------------------------------
     * Helpers
     * ------------------------------------------------------------------ */
    const url = (template, id) => template.replace(':id', id);

    const esc = (value) => $('<div>').text(value ?? '').html();

    const formatDate = (value) =>
        new Date(value).toLocaleString('en-US', {
            month: 'long', day: '2-digit', year: 'numeric',
            hour: '2-digit', minute: '2-digit', hour12: true,
        });

    const reloadTable = (resetPaging = true) => table.ajax.reload(null, resetPaging);

    const ajaxError = (message) => (xhr) => {
        console.error(xhr.responseText);
        alert(message);
    };

    /* ------------------------------------------------------------------
     * Column renderers
     * ------------------------------------------------------------------ */
    const renderTicketType = (data) =>
        `<span class="badge bg-${TICKET_TYPE_COLORS[data] ?? 'secondary'}">${esc(data)}</span>`;

    const renderStatus = (data) =>
        `<span class="${STATUS_CLASSES[data] ?? ''}">${esc(data)}</span>`;

    const renderAssignees = (data, type, row) => {
        let html = data?.length
            ? data.map(u => `<span class="badge bg-success">${esc(u.name)}</span>`).join(' ')
            : '<span class="badge bg-secondary">Unassigned</span>';

        if (isSuperAdmin && row.status !== 'Done') {
            html += `
                <button class="btn btn-primary btn-sm py-0 px-2 ms-2 assignBtn"
                        data-id="${row.id}"
                        data-bs-toggle="modal"
                        data-bs-target="#assignModal">
                    Add
                </button>`;
        }
        return html;
    };

    const renderFile = (data) => {
        if (!data) return '<span class="text-muted">No file</span>';

        const src = `${STORAGE_URL}/${data}`;
        return `<img src="${src}" data-image="${src}" class="view-image"
                     width="50" height="50"
                     style="object-fit:cover; border-radius:5px; cursor:pointer;">`;
    };

    const renderActions = (id, type, row) => {
        if (userRole === 'Maintenance') return '';

        if (row.status === 'Done') {
            const resolvedName = users.find(u => u.id === row.resolved_by)?.name ?? '—';
            return `<div class="text-success"><small>Resolved by ${esc(resolvedName)}</small></div>`;
        }

        if (userRole === 'fdo') {
            if (row.status !== 'For Approval') return '';

            const assignedUserName = row.assignees?.[0]?.name ?? '';
            return `
                <button class="btn btn-sm btn-success updateStatusBtn"
                        data-id="${id}"
                        data-status="Done"
                        data-assigned-user="${esc(assignedUserName)}">
                    Done
                </button>`;
        }

        return `
            <div class="d-flex gap-2">
                <button class="btn btn-sm btn-info openEditModal" data-id="${id}">Edit</button>
                <button class="btn btn-sm btn-danger deleteTicket" data-id="${id}">Delete</button>
            </div>`;
    };

    /* ------------------------------------------------------------------
     * DataTable
     * ------------------------------------------------------------------ */
    const table = $('#ticketTable').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        ajax: ROUTES.tableData,
        createdRow: (row, data) => $(row).attr('data-id', data.id),
        columns: [
            { data: 'id',                         name: 'id' },
            { data: 'ticket_type',                name: 'ticket_type', render: renderTicketType },
            { data: 'type_of_concern',            name: 'type_of_concern' },
            { data: 'branch',                     name: 'branch' },
            { data: 'type_equipment_or_machine',  name: 'type_equipment_or_machine' },
            { data: 'equipment_or_machine_brand', name: 'equipment_or_machine_brand' },
            { data: 'serial_number',              name: 'serial_number' },
            { data: 'concern_description',        name: 'concern_description' },
            { data: 'status',                     name: 'status', render: renderStatus },
            { data: 'reported_name',              name: 'reported_by' },
            { data: 'email',                      name: 'email' },
            { data: 'assignees',                  name: 'assignees', orderable: false, render: renderAssignees },
            { data: 'created_at',                 name: 'created_at', render: formatDate },
            { data: 'file',                       name: 'file', render: renderFile },
            { data: 'latest_remark',              defaultContent: '-', render: (data) => data || '-' },
            { data: 'id',                         orderable: false, render: renderActions },
        ],
    });

    /* ------------------------------------------------------------------
     * Row click -> ticket id
     * ------------------------------------------------------------------ */
$('#ticketTable tbody').on('click', 'tr', function (e) {
    // Ignore clicks on interactive elements inside the row
    if ($(e.target).closest('button, a, img').length) return;

    const rowData = table.row(this).data();
    if (!rowData) return;

    const ticketId = rowData.id;

    const fields = {
        'Ticket Type':        rowData.ticket_type,
        'Type of Concern':    rowData.type_of_concern,
        'Clinic / Branch':    rowData.branch,
        'Equipment':          rowData.type_equipment_or_machine,
        'Brand':              rowData.equipment_or_machine_brand,
        'Serial Number':      rowData.serial_number,
        'Concern Description':rowData.concern_description,
        'Status':             rowData.status,
        'Reported By':        rowData.reported_name,
        'Email':              rowData.email,
        'Assigned To':        rowData.assignees?.map(u => u.name).join(', ') || 'Unassigned',
        'Created At':         formatDate(rowData.created_at),
        'Remarks':            rowData.latest_remark || '-',
    };

    const rows = Object.entries(fields)
        .map(([label, value]) => `
            <tr>
                <th class="w-25">${label}</th>
                <td>${esc(value)}</td>
            </tr>`)
        .join('');

    const image = rowData.file
        ? `<div class="text-center mt-3">
               <img src="${STORAGE_URL}/${rowData.file}" class="img-fluid rounded" style="max-height:300px;">
           </div>`
        : '';

    $('#detailId').text(ticketId);
    $('#ticketDetailsBody').html(`<table class="table table-bordered mb-0">${rows}</table>${image}`);

    // Always open on the Details tab, then load history
    bootstrap.Tab.getOrCreateInstance('[data-bs-target="#detailsTab"]').show();
    loadHistory(ticketId);

    bootstrap.Modal.getOrCreateInstance('#ticketDetailsModal').show();

});

const ACTION_META = {
    created:        { label: 'Ticket created',  color: 'primary',   icon: 'fa-plus' },
    status_changed: { label: 'Status changed',  color: 'info',      icon: 'fa-exchange-alt' },
    assigned:       { label: 'Assigned',        color: 'success',   icon: 'fa-user-check' },
    edited:         { label: 'Edited',          color: 'warning',   icon: 'fa-pen' },
    deleted:        { label: 'Deleted',         color: 'danger',    icon: 'fa-trash' },
};

const getActionMeta = (action) =>
    ACTION_META[action] ?? {
        label: (action ?? 'Update').replace(/_/g, ' '),
        color: 'secondary',
        icon: 'fa-circle',
    };

    const loadHistory = (ticketId) => {
    const $body = $('#ticketHistoryBody');
    $body.html('<div class="text-center text-muted py-3">Loading history...</div>');

    $.get(url(ROUTES.history, ticketId))
        .done((items) => {
            if (!items.length) {
                $body.html(`
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-history fa-2x mb-2"></i>
                        <p class="mb-0">No history yet.</p>
                    </div>`);
                return;
            }

            const html = items.map((h) => {
                const meta = getActionMeta(h.action);

                const change = (h.old_value || h.new_value)
                    ? `<div class="tl-change">
                           <span class="badge bg-light text-dark border">${esc(h.old_value ?? '-')}</span>
                           <i class="fas fa-arrow-right text-muted small"></i>
                           <span class="badge bg-${meta.color}">${esc(h.new_value ?? '-')}</span>
                       </div>`
                    : '';

                const remarks = h.remarks
                    ? `<div class="tl-remarks">${esc(h.remarks)}</div>`
                    : '';

                return `
                    <li>
                        <span class="tl-dot bg-${meta.color}">
                            <i class="fas ${meta.icon}"></i>
                        </span>
                        <div class="tl-card">
                            <div class="d-flex justify-content-between align-items-start flex-wrap gap-1">
                                <strong>${esc(meta.label)}</strong>
                                <small class="text-muted">${formatDate(h.created_at)}</small>
                            </div>
                            <div class="small text-muted">
                                <i class="fas fa-user fa-xs me-1"></i>${esc(h.user_name ?? 'System')}
                            </div>
                            ${change}
                            ${remarks}
                        </div>
                    </li>`;
            }).join('');

            $body.html(`<ul class="history-timeline">${html}</ul>`);
        })
        .fail((xhr) => {
            console.error('History error:', xhr.status, xhr.responseText);
            $body.html(`<p class="text-danger mb-0">Failed to load history (${xhr.status}).</p>`);
        });
};

    $(document).on('click', '.updateStatusBtn', function () {
        const { id, status, assignedUser } = $(this).data();

        if (!confirm(`Change status to "${status}"?`)) return;

        $.ajax({
            url: url(ROUTES.updateStatus, id),
            type: 'PUT',
            data: { _token: csrfToken, status, resolved_by: assignedUser },
            success: () => reloadTable(false),
            error: ajaxError('Failed to update ticket status.'),
        });
    });

    $(document).on('click', '.openEditModal', function (e) {
        e.preventDefault();

        $.get(url(ROUTES.edit, $(this).data('id')), (html) => {
            $('#modalContentEdit').html(html);
            $('#formModalEdit').modal('show');
        }).fail((xhr) => console.error('Error loading edit modal:', xhr.responseText));
    });

    $(document).on('click', '.deleteTicket', function (e) {
        e.preventDefault();

        if (!confirm('Are you sure you want to delete this ticket?')) return;

        $.ajax({
            type: 'DELETE',
            url: url(ROUTES.destroy, $(this).data('id')),
            data: { _token: csrfToken },
            success: () => {
                alert('Ticket deleted successfully!');
                reloadTable();
            },
            error: ajaxError('Failed to delete ticket.'),
        });
    });

    $(document).on('click', '.view-image', function () {
        $('#modalImage').attr('src', $(this).data('image'));
        $('#imageModal').modal('show');
    });

    /* ------------------------------------------------------------------
     * Assign users (Tom Select)
     * ------------------------------------------------------------------ */
    let tomSelect = null;

    $('#assignModal').on('show.bs.modal', function () {
        if (tomSelect) return;

        tomSelect = new TomSelect('#assigned_user', {
            create: false,
            placeholder: 'Search and select users...',
            searchField: 'text',
            maxItems: null, // unlimited selections
            plugins: { remove_button: { title: 'Remove this item' } },
        });
    });

    $(document).on('click', '.assignBtn', function () {
        $('#ticket_id').val($(this).data('id'));
        tomSelect?.clear();
    });

    $('#saveAssign').on('click', function (e) {
        e.preventDefault();

        const ticketId      = $('#ticket_id').val();
        const assignedUsers = $('#assigned_user').val();

        if (!ticketId || !assignedUsers?.length) {
            alert('Please select ticket and at least one user');
            return;
        }

        $.ajax({
            url: ROUTES.assign,
            type: 'POST',
            data: { ticket_id: ticketId, user_ids: assignedUsers, _token: csrfToken },
            success: (response) => {
                if (!response.success) return;

                alert('Users assigned successfully!');
                $('#assignModal').modal('hide');
                tomSelect?.clear();
                reloadTable(false);
            },
            error: (xhr) => alert('Error: ' + (xhr.responseJSON?.message || 'Unknown error')),
        });
    });

    /* ------------------------------------------------------------------
     * Create ticket (pick type -> load form into modal)
     * ------------------------------------------------------------------ */
    $('#ticketForm').on('submit', function (e) {
        e.preventDefault();

        const selected = $('#ticketType').val();
        const route    = TICKET_FORM_ROUTES[selected];

        if (!route) {
            alert('Please select a valid ticket type');
            return;
        }

        bootstrap.Modal.getInstance(document.getElementById('createTicketModal')).hide();

        $.get(route, { ticket_type: selected }, (html) => {
            const $content = $('#modalContentCreate').html(html);

            // Inject ticket_type into the loaded form
            $content.find('form').append(
                $('<input>', { type: 'hidden', name: 'ticket_type', value: selected })
            );

            new bootstrap.Modal(document.getElementById('formModalCreate')).show();
        });
    });

});
</script>
