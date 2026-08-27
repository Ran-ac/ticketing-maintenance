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
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover" id="ticketTable" width="100%" cellspacing="0">
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
                                            <th>Resolved at</th>
                                            <th>Created at</th>
                                            <th>file</th>
                                            <th>Remarks</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                        <tbody id="tableBody"></tbody>
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
        @include('partials.logout')
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

    <div class="modal fade" id="createTicketModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Create New Ticket</h5>
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

    <!-- For Approved remarks modal -->
    <div class="modal fade" id="approvalModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Send for Approval</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="approveTicketId">
                    <label for="approveRemarks" class="form-label">Remarks</label>
                    <textarea id="approveRemarks" class="form-control" rows="3"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="confirmApproveBtn" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Assign Modal -->
    <!-- NOTE: modal-body is currently empty but JS (#saveAssign, assignBtn) expects
         a #ticket_id hidden input and a #assigned_user <select>. This modal is
         referenced/used, just not fully built out yet — see chat notes. -->
    <div class="modal fade" id="assignModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Assign User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="saveAssign">
                        Save
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- On Hold remarks modal -->
    <div class="modal fade" id="onHoldModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Put Ticket On Hold</h5>
                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                    </button>
                </div>

                <div class="modal-body">

                    <input type="hidden" id="onHoldTicketId">

                    <div class="mb-3">
                        <label class="form-label">Reason</label>

                        <textarea
                            id="onHoldRemarks"
                            class="form-control"
                            rows="4"
                            placeholder="Enter reason for putting this ticket on hold..."
                        ></textarea>
                    </div>

                </div>
                {{-- testing comment --}}
                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button type="button"
                            class="btn btn-warning"
                            id="saveOnHold">
                        Put On Hold
                    </button>

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

const isSuperAdmin = @json(auth()->user()->role === 'superadmin');
const userRole = @json(auth()->user()->role);

$(document).on('click', '.assignBtn', function() {
    let ticketId = $(this).data('id');
    $('#ticket_id').val(ticketId);
    $('#assigned_user').val(null).trigger('change');
});

$(document).ready(function() {
    $('#assigned_user').select2({
        placeholder: 'Select users...',
        allowClear: true,
        width: '100%'
    });
});

$('#saveAssign').on('click', function(e) {
    e.preventDefault();

    let ticketId = $('#ticket_id').val();
    let assignedUsers = $('#assigned_user').val();

    if (!ticketId || !assignedUsers || assignedUsers.length === 0) {
        alert('Please select ticket and at least one user');
        return;
    }

    $.ajax({
        url: "{{ route('ticket.task_assign') }}",
        type: "POST",
        data: {
            ticket_id: ticketId,
            user_ids: assignedUsers,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                alert('Users assigned successfully!');
                $('#assignModal').modal('hide');
                $('#assigned_user').val(null).trigger('change');
                location.reload();
            }
        },
        error: function(xhr) {
            alert('Error: ' + (xhr.responseJSON?.message || 'Unknown error'));
        }
    });
});

const routeMap = {
    'GAOC - Maintenance IR Form':       "{{ route('ticket.gaoc') }}",
    'Novodental - Maintenance IR Form': "{{ route('ticket.novo') }}",
    'GSS - Maintenance IR Form':        "{{ route('ticket.gss') }}",
    'GGC Offices - Maintenance IR Form': "{{ route('ticket.gcc') }}",
};

document.getElementById('ticketForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const selected = document.getElementById('ticketType').value;
    const route    = routeMap[selected];

    if (!route) {
        alert('Please select a valid ticket type');
        return;
    }

    bootstrap.Modal.getInstance(document.getElementById('createTicketModal')).hide();

    $.get(route, { ticket_type: selected }, function(data) {
        $('#modalContentCreate').html(data);

        $('form', '#modalContentCreate').append(
            `<input type="hidden" name="ticket_type" value="${selected}">`
        );

        new bootstrap.Modal(document.getElementById('formModalCreate')).show();
    });
});

$(document).on('click', '.view-image', function () {
    let imgSrc = $(this).data('image');
    $('#modalImage').attr('src', imgSrc);
    $('#imageModal').modal('show');
});

$(document).ready(function () {
    let table = $("#ticketTable").DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('myTask.fetchMyTaskTickets') }}",
        columns: [
            { data: "id",          name: "id" },
            { data: "ticket_type", name: "ticket_type",
                render: function(data) {
                    const colors = {
                        'GAOC - Maintenance IR Form':       'primary',
                        'Novodental - Maintenance IR Form': 'success',
                        'GSS - Maintenance IR Form':        'warning',
                        'GGC Offices - Maintenance IR Form':'info',
                    };
                    const color = colors[data] || 'secondary';
                    return `<span class="badge bg-${color}">${data}</span>`;
                }
            },
            { data: "type_of_concern",       name: "type_of_concern" },
            { data: "branch",       name: "branch" },
            { data: "type_equipment_or_machine",       name: "type_equipment_or_machine" },
            { data: "equipment_or_machine_brand",       name: "equipment_or_machine_brand" },
            { data: "serial_number",       name: "serial_number" },
            { data: "concern_description",       name: "concern_description" },

            {
                data: "status",
                name: "status",
                render: function(data, type, row) {

                    const map = {
                        'New':          'btn-info',
                        'Pending':      'btn-secondary',
                        'On hold':      'btn-secondary',
                        'For Approval': 'btn-danger',
                        'Done':         'btn-success',
                    };

                    const buttonClass = map[data] ?? 'btn-secondary';

                    // Done is final — no dropdown
                    if (data === 'Done') {
                        return `
                            <button class="btn ${buttonClass} btn-sm" type="button" disabled>
                                ${data}
                            </button>
                        `;
                    }

                    // For Approval is final — no dropdown
                    if (data === 'For Approved') {
                        return `
                            <button class="btn ${buttonClass} btn-sm" type="button" disabled>
                                ${data}
                            </button>
                        `;
                    }

                    // On hold -> can only go back to Pending
                    if (data === 'On hold') {
                        return `
                            <div class="dropdown">
                                <button class="btn ${buttonClass} btn-sm dropdown-toggle"
                                        type="button"
                                        data-toggle="dropdown">
                                    ${data}
                                </button>

                                <div class="dropdown-menu">
                                    <a class="dropdown-item change-status" href="#"
                                    data-id="${row.id}"
                                    data-status="Pending">
                                        Back to Pending
                                    </a>
                                </div>
                            </div>
                        `;
                    }

                    // New / Pending -> can be put On hold
                    return `
                        <div class="dropdown">
                            <button class="btn ${buttonClass} btn-sm dropdown-toggle"
                                    type="button"
                                    data-toggle="dropdown">
                                ${data}
                            </button>

                            <div class="dropdown-menu">
                                <a class="dropdown-item change-status" href="#"
                                data-id="${row.id}"
                                data-status="On hold">
                                    On hold
                                </a>
                            </div>
                        </div>
                    `;
                }
            },
            
            { data: "reported_name",name: "reported_by" },
            { data: "email",name: "email" },
            {
                data: "assignees",
                name: "assignees",
                orderable: false,
                render: function(data, type, row) {
                    let html = '';

                    if (data && data.length > 0) {
                        data.forEach(user => {
                            html += `<span class="badge bg-success">${user.name}</span> `;
                        });
                    } else {
                        html = '<span class="badge bg-secondary">Unassigned</span>';
                    }

                    if (isSuperAdmin) {
                        html += `<button
                                    class="btn btn-primary assignBtn py-0 px-2 btn-sm ms-2"
                                    data-id="${row.id}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#assignModal">
                                    Add
                                </button>`;
                    }

                    return html;
                }
            },
            { data: "updated_at",    name: "updated_at",
                render: function(data) {
                    return new Date(data).toLocaleString('en-US', {
                        month: 'long', day: '2-digit', year: 'numeric',
                        hour: '2-digit', minute: '2-digit', hour12: true
                    });
                }
            },
            { data: "created_at",    name: "created_at",
                render: function(data) {
                    return new Date(data).toLocaleString('en-US', {
                        month: 'long', day: '2-digit', year: 'numeric',
                        hour: '2-digit', minute: '2-digit', hour12: true
                    });
                }
            },
            { data: "file", name: "file",
                render: function(data) {
                    if (!data) return '<span class="text-muted">No file</span>';
                    return `<img src="/storage/${data}" width="50" height="50"
                                style="object-fit:cover; border-radius:5px; cursor:pointer;"
                                class="view-image" data-image="/storage/${data}">`;
                }
            },
            { data: "remarks",       name: "remarks" },
            {
                data: "id",
                orderable: false,
                render: function(data, type, row) {

                    if (row.status === 'Done') {
                        return `
                            <span class="badge bg-success">
                                Done
                            </span>
                        `;
                    }

                    // Pending -> Approval with remarks
                    if (row.status === 'Pending') {
                        return `
                            <button class="btn btn-sm btn-warning updateStatusBtn"
                                    data-id="${data}"
                                    data-status="For Approved">
                                For Approved
                            </button>
                        `;
                    }

                    // FDO only can finish
                    if (row.status === 'For Approved') {

                        if (userRole === 'fdo') {
                            return `
                                <button class="btn btn-sm btn-success updateStatusBtn"
                                        data-id="${data}"
                                        data-status="Done">
                                    Done
                                </button>
                            `;
                        }

                        return `
                            <span class="badge bg-info">
                                Waiting for FDO
                            </span>
                        `;
                    }

                    return '-';
                }
            }
        ]
    });

    // Status dropdown: On hold / back to Pending  commit test
    $(document).on('click', '.change-status', function(e) {
        e.preventDefault();

        let id = $(this).data('id');
        let status = $(this).data('status');

        if (status === 'On hold') {
            $('#onHoldTicketId').val(id);
            $('#onHoldRemarks').val('');
            $('#onHoldModal').modal('show');
            return;
        }

        updateTicketStatus(id, status);
    });

    $(document).on('click', '#saveOnHold', function() {

        let ticketId = $('#onHoldTicketId').val();
        let remarks = $('#onHoldRemarks').val().trim();

        if (remarks === '') {
            alert('Please enter the reason for putting this ticket on hold.');
            return;
        }

        updateTicketStatus(ticketId, 'On hold', remarks);
        $('#onHoldModal').modal('hide');
    });

    // Action button: For Approved / Done
    $(document).on('click', '.updateStatusBtn', function () {
        let ticketId = $(this).data('id');
        let status = $(this).data('status');

        if (status === 'For Approved') {
            $('#approveTicketId').val(ticketId);
            $('#approveRemarks').val('');
            $('#approvalModal').modal('show');
            return;
        }

        if (status === 'Done') {
            if (!confirm('Mark this ticket as Done?')) return;
            updateTicketStatus(ticketId, 'Done');
        }
    });

    $(document).on('click', '#confirmApproveBtn', function () {

        let ticketId = $('#approveTicketId').val();
        let remarks  = $('#approveRemarks').val().trim();

        if (remarks === '') {
            alert('Please enter a reason/remarks for approval.');
            return;
        }

        updateTicketStatus(ticketId, 'For Approved', remarks);
        $('#approvalModal').modal('hide');
    });

    function updateTicketStatus(ticketId, status, remarks = null)
    {
        $.ajax({
            url: `{{ route('ticket.update-ticket-status', ':id') }}`.replace(':id', ticketId),
            type: 'PUT',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                status: status,
                remarks: remarks
            },
            success: function() {
                table.ajax.reload(null, false);
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                alert('Failed updating ticket.');
            }
        });
    }

    $(document).on("click", ".deleteTicket", function (event) {
        event.preventDefault();

        let ticketId = $(this).data("id");

        if (!confirm("Are you sure you want to delete this ticket?")) return;

        $.ajax({
            type: "DELETE",
            url: "{{ route('ticket.ticket-destroy', ':id') }}".replace(':id', ticketId),
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {
                alert("Ticket deleted successfully!");
                $('#ticketTable').DataTable().ajax.reload();
            },
            error: function (xhr, status, error) {
                console.error("Error deleting ticket:", xhr.responseText);
                alert("Failed to delete ticket.");
            }
        });
    });

});

</script>