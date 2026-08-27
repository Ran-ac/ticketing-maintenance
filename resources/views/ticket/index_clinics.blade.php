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

    <!-- Optional: Bootstrap 5 Theme (better styling) -->
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    <!-- jQuery (if not already included) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

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

$(document).ready(function() {

    // Initialize Tom Select
    let tomSelect = null;

    $('#assignModal').on('show.bs.modal', function() {
        if (!tomSelect) {
            tomSelect = new TomSelect('#assigned_user', {
                create: false,
                placeholder: 'Search and select users...',
                searchField: 'text',
                maxItems: null,  // Unlimited selections
                plugins: {
                    remove_button: {
                        title: 'Remove this item'
                    }
                }
            });
        }
    });

    // Assign button click
    $(document).on('click', '.assignBtn', function() {
        let ticketId = $(this).data('id');
        $('#ticket_id').val(ticketId);
        if (tomSelect) {
            tomSelect.clear();
        }
    });

    // Save assign click
    $('#saveAssign').on('click', function(e) {
        e.preventDefault();

        let ticketId = $('#ticket_id').val();
        let assignedUsers = $('#assigned_user').val();

        alert(assignedUsers);


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

                    $('#ticketTable').DataTable().ajax.reload();
                }
            },
            error: function(xhr) {
                alert('Error: ' + (xhr.responseJSON?.message || 'Unknown error'));
            }
        });
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

    // Close first modal
    bootstrap.Modal.getInstance(document.getElementById('createTicketModal')).hide();

    $.get(route, { ticket_type: selected }, function(data) {
        $('#modalContentCreate').html(data);

        // Inject ticket_type into the loaded form
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
            scrollX: true,
            ajax: "{{ route('ticket.fetchClinicalTicketData') }}",
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

                { data: "status", name: "status",
                    render: function(data) {
                        const map = {
                            'New':      'text-info',
                            'On hold':  'text-muted',
                            'On pause': 'text-primary',
                            'For continuation': 'text-warning',
                            'Done':     'text-success',
                            'Pending':  'text-secondary',
                        };
                        return `<span class="${map[data] ?? ''}">${data}</span>`;
                    }
                },
                { data: "reported_name",name: "reported_by" },
                { data: "email",name: "email" },
                // { data: "remarks",name: "remarks" },
                {
                    data: "assignees",
                    name: "assignees",
                    orderable: false,
                    render: function(data, type, row) {
                        let html = '';

                        // Show assigned users as badges
                        if (data && data.length > 0) {
                            data.forEach(user => {
                                html += `<span class="badge bg-success">${user.name}</span> `;
                            });
                        } else {
                            html = '<span class="badge bg-secondary">Unassigned</span>';
                        }

                        // Add assign button only for superadmin, and only if not Done
                        if (isSuperAdmin && row.status !== 'Done') {
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

                        if(userRole === "Maintenance"){
                            return '';
                        }

                        // Done ticket
                        if (row.status === 'Done') {
                            return `<div class="text-success">
                                        <small>Resolved by ${row.resolved_by ?? '—'}</small>
                                    </div>`;
                        }

                        // FDO: show Done button only when status is For Approved
                        if (userRole === 'fdo') {

                            if (row.status === 'For Approved') {
                                return `
                                    <button class="btn btn-sm btn-success updateStatusBtn"
                                            data-id="${data}"
                                            data-status="Done">
                                        Done
                                    </button>
                                `;
                            }

                            // Otherwise, no actions for FDO
                            return '';
                        }

                        // Other roles: Edit/Delete
                        return `
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-info openEditModal" data-id="${data}">
                                    Edit
                                </button>
                                <button class="btn btn-sm btn-danger deleteTicket" data-id="${data}">
                                    Delete
                                </button>
                            </div>
                        `;
                    }
                }
            ]
    });

        $(document).on('click', '.updateStatusBtn', function () {

            let ticketId = $(this).data('id');
            let status = $(this).data('status');

            if (!confirm(`Change status to "${status}"?`)) {
                return;
            }

            $.ajax({
                url: `{{ route('ticket.update-ticket-status', ':id') }}`.replace(':id', ticketId),
                type: 'PUT',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    status: status
                },
                success: function () {
                    table.ajax.reload(null, false);
                },
                error: function (xhr) {
                    alert('Failed to update ticket status.');
                    console.error(xhr.responseText);
                }
            });

        });

        $(document).on('click', '.openEditModal', function (event) {
			event.preventDefault();
			let ticketId = $(this).data('id');

	   		$.get("{{ route('ticket.editTicketGaoc', ':id') }}".replace(':id', ticketId), function (data) {
                $('#modalContentEdit').html(data);
                $('#formModalEdit').modal('show');
            }).fail(function(xhr) {
                console.error("Error loading edit modal:", xhr.responseText);
            });
		});

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
