<form id="create_clinic" method="POST" action="{{ route('clinic.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" id="name" class="form-control" placeholder="Enter the clinic name">
        @error('name')
            <div class="alert alert-danger mt-2">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-16">
        <label for="company" class="form-label">Company</label>
        <select  class="form-control"  name="company" id="company">
            <option value="">Please Select company</option>
            <option value="GAOC">GAOC</option>
            <option value="Novodental">Novodental</option>
            <option value="Jentlederm">JentleDerm</option>
             <option value="Samurai">Samurai</option>
          </select>
        @error('status')
            <div class="alert alert-danger mt-2">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="address" class="form-label">Address</label>
        <input type="text" name="address" id="address" class="form-control" placeholder="Enter the address of clinic">
        @error('address')
            <div class="alert alert-danger mt-2">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="contact_number" class="form-label">Contact Number</label>
        <input type="number" name="contact_number" id="contact_number" class="form-control" placeholder="Enter the contact_number of clinic">
        @error('contact_number')
            <div class="alert alert-danger mt-2">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" class="form-control" placeholder="Enter the email of clinic">
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
        $('#create_clinic').on('submit', function(e){
            e.preventDefault();
            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('clinic.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response){
                    console.log(response.success);
                    if (response.success) {
                        alert('Clinic added successfully!');
                        $('#formModalCreate').modal('hide'); // Hide modal after success
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



