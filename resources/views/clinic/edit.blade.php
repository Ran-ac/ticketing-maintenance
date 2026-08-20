<form id="update_clinic" method="POST" action="{{ route('clinic.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <input type="hidden" name="id" value="{{ $clinic->id }}">
    <div class="mb-3">
        <label for="clinic_name" class="form-label">Name</label>
        <input type="text" name="name" id="clinic_name" value="{{ $clinic->name }}" class="form-control" placeholder="Enter Clinic Name">
        @error('clinic_name')
            <div class="alert alert-danger mt-2">{{ $message }}</div>
        @enderror
    </div>


    <div class="mb-3">
        <label for="company" class="form-label">Company</label>  
        <select class="form-control" name="company" id="company">
            <option value="">Please Select company</option>
            
            <option value="GAOC" {{ old('company', $clinic->company) == 'GAOC' ? 'selected' : '' }}>GAOC</option>
            
            <option value="Novodental" {{ old('company', $clinic->company) == 'Novodental' ? 'selected' : '' }}>Novodental</option>
            
            <option value="Jentlederm" {{ old('company', $clinic->company) == 'Jentlederm' ? 'selected' : '' }}>JentleDerm</option>
            
            <option value="Samurai" {{ old('company', $clinic->company) == 'Samurai' ? 'selected' : '' }}>Samurai</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="clinic_address" class="form-label">Address</label>
        <input type="text" name="address" id="clinic_address" value="{{ $clinic->address }}" class="form-control" placeholder="Enter Clinic Address">
        @error('clinic_address')
            <div class="alert alert-danger mt-2">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="contact_number" class="form-label">Contact Number</label>
        <input type="number" name="contact_number" id="contact_number" value="{{$clinic->contact_number}}" class="form-control" placeholder="Enter the contact_number of clinic">
        @error('contact_number')
            <div class="alert alert-danger mt-2">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" value="{{$clinic->email}}" class="form-control" placeholder="Enter the email of clinic">
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

            $('#update_clinic').on('submit', function(e){
                e.preventDefault();
                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('clinic.update') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response){
                        if (response.success) {
                            alert('Updated clinic successfully!');
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



