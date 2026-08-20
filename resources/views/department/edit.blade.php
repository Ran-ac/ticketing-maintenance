<form id="update_department" method="POST" action="{{ route('department.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <input type="hidden" name="id" value="{{ $department->id }}">
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" id="name" value="{{ $department->name }}" class="form-control" placeholder="Enter department Name">
        @error('name')
            <div class="alert alert-danger mt-2">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="contact_number" class="form-label">Contact Number</label>
        <input type="number" name="contact_number" id="contact_number" value="{{$department->contact_number}}" class="form-control" placeholder="Enter the contact_number of clinic">
        @error('contact_number')
            <div class="alert alert-danger mt-2">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" value="{{$department->email}}" class="form-control" placeholder="Enter the email of clinic">
        @error('address')
            <div class="alert alert-danger mt-2">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-flex justify-content-between">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>




<script>
    $(document).ready(function () {

            $('#update_department').on('submit', function(e){
                e.preventDefault();
                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('department.update') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response){
                        if (response.success) {
                            alert('Updated department successfully!');
                            $('#formModalEdit').modal('hide'); // Hide modal after success
                            location.reload();
                        } else {
                            alert('Something went wrong!');
                        }
                    },
                    error: function(xhr){
                        let errors = xhr.responseJSON.errors;
                        $('.alert-danger').remove(); // Remove old error messages

                        $.each(errors, function(key, value){
                            $('#' + key).after('<div class="alert alert-danger mt-2">' + value + '</div>');
                        });
                    }
                });
            });
    });

</script>



