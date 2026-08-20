<form id="create_users" method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
        @csrf

        <!-- Name -->
        <div class="mb-6">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Enter name">
            @error('name')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" name="email" id="email" class="form-control" placeholder="Enter email">
            @error('email')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <!-- Address -->
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" name="address" id="address" class="form-control" placeholder="Enter address">
            @error('address')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

                <!-- Branch  -->
        <div class="mb-3">
            <label for="branch" class="form-label">Branch:</label>
                <select class="form-control" name="branch" id="branch">
                    @foreach ($clinic as $brac)
                        <option value="{{ $brac->id }}">
                            {{ $brac->name }}
                        </option>
                    @endforeach
                </select>

            @error('branch')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <!-- Contact Number -->
        <div class="mb-3">
            <label for="contact_number" class="form-label">Contact Number</label>
            <input type="number" name="contact_number" id="contact_number" class="form-control" placeholder="Enter contact number">
            @error('contact_number')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <!-- Department  -->
        <div class="mb-3">
            <label for="branch" class="form-label">Department:</label>
                <select class="form-control" name="department[]" id="department" multiple>
                    @foreach ($department as $dept)
                        <option value="{{ $dept->id }}">
                            {{ $dept->name }}
                        </option>
                    @endforeach
                </select>

            @error('branch')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <!-- Role -->
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select class="form-select" name="role" id="role">
                <option value="">Please Select role</option>
                <option value="head">Head</option>
                <option value="admin">Admin</option>
                <option value="IT">IT</option>
                <option value="Maintenance">Maintenance</option>
                <option value="Fdo">FDO</option>
            </select>
            @error('role')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required autocomplete="new-password">
            @error('password')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm password" required autocomplete="new-password">
            @error('password_confirmation')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <!-- Button save and cancel -->
        <div class="flex items-center justify-end mt-4">
            <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
    </form>


<script>
    
    $(document).ready(function () {
        var tagSelector = new MultiSelectTag('department', {
            // maxSelection: 30,     
            required: true,          
            placeholder: 'Please select department',
            onChange: function(selected) { 
                console.log('Selection changed:', selected);
            }
        });

        // console.log(tagSelector);
        
        $('#create_users').on('submit', function(e){
            e.preventDefault();
            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('users.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response){
                    console.log(response.success);
                    if (response.success) {
                        alert('Users added successfully!');
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