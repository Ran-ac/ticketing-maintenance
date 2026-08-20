<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Ticketing System Maintenance</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

        <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/multiple-select@1.7.0/dist/multiple-select.min.css">

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
	
	<!-- DataTables CDN -->
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

	<!-- Bootstrap CDN -->

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css">

    {{-- multi selector  --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@4.0.1/dist/css/multi-select-tag.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/multiselect-tag@latest/dist/css/multi-select-tag.css">
    <script src="https://cdn.jsdelivr.net/npm/multiselect-tag@latest/dist/js/multi-select-tag.js"></script>


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
                    <h1 class="mt-4">Users</h1>
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item active">All users</li>
                    </ol>

                    <div class="d-flex justify-content-between mb-3">
                        <button class="btn btn-success" id="openModalCreate">Create New User</button>
                    </div>
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="usersTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Contact Number</th>
                                    <th>Department</th>
                                    <th>Branch</th>
                                    <th>Address</th>
                                    <th>Role</th>
                                    <th>Created At</th>
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

                <!-- Create User Modal -->
        <div class="modal fade" id="formModalCreate" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTitle">Add new user</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                    <div class="modal-body" id="modalContentCreate"></div>
                </div>
            </div>
        </div>

                <!-- Edit User Modal -->
        <div class="modal fade" id="formModalEdit" tabindex="-1" aria-labelledby="modalTitleEdit" aria-hidden="true">
            <div class="modal-dialog modal-l">
                <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTitleEdit">Edit User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                    <div class="modal-body" id="modalContentEdit"></div>
                </div>
            </div>
        </div>
        <!-- Footer -->
            @include('partials.footer')
        <!-- End Footer -->
    </div> <!-- /.body-wrapper -->

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




        <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@4.0.1/dist/js/multi-select-tag.min.js"></script>

        
</body>

</html>

<script>

$(document).ready(function () {
    
        let table = $("#usersTable").DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('users.fetchUserData') }}", // Fetching data via AJAX
            columns: [
                { data: "id", name: "id" },
                { data: "name", name: "name" },
                { data: "email", name: "email" },
                { data: "contact_number", name: "contact_number" },
                { data: "department", name: "department" },
                { data: "branch", name: "branch" },
                { data: "address", name: "address" },
                { data: "role", name: "role" },
                { data: "created_at", name: "created_at",
                    render: function(data, type, row) {
                        return new Date(data).toLocaleString('en-US', {
                            month: 'long',
                            day: '2-digit',
                            year: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit',
                            hour12: true
                        });
                    }
                },
                { 
                    data: "id",
                    render: function (data, type, row) {
                        return `
                            <div class="d-flex m-2">
                                <button class="btn btn-info me-2 openEditModal" data-id="${data}">Edit</button>
                                <button class="btn btn-danger deleteUser" data-id="${data}">Delete</button>
                            </div>
                        `;
                    },
                    orderable: false
                }
            ]
        });

        $('#openModalCreate').click(function () {
            $.get("{{ route('users.create') }}", function (data) {
                $('#modalContentCreate').html(data);
            $('#formModalCreate').modal('show');
            });
        });


        $(document).on('click', '.openEditModal', function (event) {
			event.preventDefault();
			let clinicId = $(this).data('id');

	   		$.get("{{ route('users.edit', ':id') }}".replace(':id', clinicId), function (data) {
                $('#modalContentEdit').html(data);
                $('#formModalEdit').modal('show');
            }).fail(function(xhr) {
                console.error("Error loading edit modal:", xhr.responseText);
            });
		});


        $(document).on("click", ".deleteUser", function (event) {
			event.preventDefault();

			let userId = $(this).data("id");

			if (!confirm("Are you sure you want to delete this user?")) return;

			$.ajax({
				type: "DELETE",
				url: "{{ route('users.destroy', ':id') }}".replace(':id', userId),
				data: {
					_token: "{{ csrf_token() }}"
				},
				success: function (response) {
					alert("User deleted successfully!");
					location.reload();
				},
				error: function (xhr, status, error) {
					console.error("Error deleting user:", xhr.responseText);
					alert("Failed to delete user.");
				}
			});
		});


    });

</script>
