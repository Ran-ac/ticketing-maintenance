<form id="update_clinic" method="POST" action="{{ route('ticket.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')


    <input type="hidden" name="id" value="{{ $ticket->id }}">
    <!-- type of concern -->
        <div class="mb-6">
            <label class="form-label">Type of Concern <span class="text-danger">*</span></label>

            <div class="form-check">
                <input class="form-check-input" 
                    type="radio" 
                    name="type_of_concern" 
                    id="concern1" 
                    value="Clinical"
                    {{ old('type_of_concern', $ticket->type_of_concern ?? '') == 'Clinical (dental equipment/machine/instruments)' ? 'checked' : '' }}>
                <label class="form-check-label" for="concern1">
                    Clinical (dental equipment/machine/instruments)
                </label>
            </div>

            <!-- type of concern -->
            <div class="form-check">
                <input class="form-check-input" 
                    type="radio" 
                    name="type_of_concern" 
                    id="concern2" 
                    value="Non Clinical"
                    {{ old('type_of_concern', $ticket->type_of_concern ?? '') == 'Non Clinical' ? 'checked' : '' }}>
                <label class="form-check-label" for="concern2">
                    Non Clinical (non dental equipment)
                </label>
            </div>

            @error('type_of_concern')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <!-- Branch  -->
        <div class="mb-3"> 
            <label for="branch_id" class="form-label">
                Branch: <span class="text-danger">*</span>
            </label>

            <select class="form-control" name="branch_id" id="branch_id">
                <option value="">Please select branch</option>

                @foreach ($clinic as $clinics)
                    <option value="{{ $clinics->id }}"
                        {{ old('clinics_id', $ticket->clinics_id) == $clinics->id ? 'selected' : '' }}>
                        {{ $clinics->name }}
                    </option>
                @endforeach
            </select>

            @error('branch_id')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

    <!-- equipment or machine -->
    <div class="mb-6">
        <label for="title" class="form-label">Equipment or machine<span class="text-danger">*</span></label>
        <input type="text" name="equipment_or_machine" id="equipment_or_machine" value="{{ $ticket->type_equipment_or_machine }}" class="form-control">
        @error('equipment_or_machine')
            <div class="alert alert-danger mt-2">{{ $message }}</div>
        @enderror
    </div>

        <!-- equipment or machine brand -->
    <div class="mb-6">
        <label for="title" class="form-label">Equipment or machine brand<span class="text-danger">*</span></label>
        <input type="text" name="equipment_or_machine_brand" id="equipment_or_machine_brand" value="{{ $ticket->equipment_or_machine_brand }}" class="form-control">
        @error('equipment_or_machine_brand')
            <div class="alert alert-danger mt-2">{{ $message }}</div>
        @enderror
    </div>

    <!-- serial number -->
    <div class="mb-6">
        <label for="title" class="form-label">Serial Number of unit<span class="text-danger">*</span></label>
        <input type="text" name="serial_number" id="serial_number" 
            value="{{ old('serial_number', $ticket->serial_number) }}" 
            class="form-control">
        @error('serial_number')
            <div class="alert alert-danger mt-2">{{ $message }}</div>
        @enderror
    </div>
        
        <!-- conern description -->
    <div class="mb-6">
        <label for="title" class="form-label">Concern Description<span class="text-danger">*</span></label>
        <textarea name="concern_description" class="form-control" id="concern_description">{{ $ticket->concern_description }}</textarea>  
        @error('concern_description')
            <div class="alert alert-danger mt-2">{{ $message }}</div>
        @enderror
    </div>

        <!-- reported by -->
        <div class="mb-6">
            <label for="title" class="form-label">
                Reported by<span class="text-danger">*</span>
            </label>

            <input type="text"
                name="reported_by"
                id="reported_by"
                value="{{ $ticket->reporter->name ?? '' }}"
                class="form-control"
                disabled>

            @error('reported_by')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

            <!-- Email Address -->
    <div class="mb-6">
        <label for="title" class="form-label">Email<span class="text-danger">*</span></label>
        <input type="email" name="email" id="email" value="{{ $ticket->email }}"class="form-control">   
        @error('email')
            <div class="alert alert-danger mt-2">{{ $message }}</div>
        @enderror
    </div>

        <!-- Status -->
    <div class="mb-3">
        <label for="status" class="form-label">
            Status <span class="text-danger">*</span>
        </label>

        <select class="form-control" name="status" id="status">
            <option value="">Please select status</option>
            <option value="Pending" {{ old('status', $ticket->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
            <option value="Cancelled" {{ old('status', $ticket->status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
            <option value="Done" {{ old('status', $ticket->status) == 'Done' ? 'selected' : '' }}>Done</option>
        </select>

        @error('status')
            <div class="alert alert-danger mt-2">{{ $message }}</div>
        @enderror
    </div>

    
    <!-- File -->
    <div class="mb-6">
        <label for="file" class="form-label">
            File<span class="text-danger">*</span>
        </label>

        <input type="file" name="file" id="file" class="form-control" onchange="previewFile(event)">   

        <!-- Current file -->
        @if(!empty($ticket->file))
            <div id="currentContainer">
                <p>Current file:</p>
                <img id="currentImage" src="{{ asset('storage/' . $ticket->file) }}" width="120">
            </div>
        @endif

        <!-- New preview -->
        <div id="newPreview" style="display:none;">
            <p>New file:</p>
            <img id="previewImage" width="120">
        </div>

        @error('file')
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


    // image preview 
function previewFile(event) {
    const file = event.target.files[0];

    if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
            // show new image
            document.getElementById('previewImage').src = e.target.result;
            document.getElementById('newPreview').style.display = 'block';

            // hide old image
            const current = document.getElementById('currentContainer');
            if (current) {
                current.style.display = 'none';
            }
        }

        reader.readAsDataURL(file);
    }
}

   $(document).ready(function () {
    $('#update_clinic').on('submit', function(e){
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            url: "{{ route('ticket.update') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,

            success: function(response){
                alert('Ticket updated successfully!');
                $('#formModalCreate').modal('hide');
            },

            error: function(xhr){
                console.log(xhr.responseText); // debug

                let errors = xhr.responseJSON?.errors;
                $('.alert-danger').remove();

                if (errors) {
                    $.each(errors, function(key, value){
                        $('<div class="alert alert-danger mt-2"></div>')
                            .text(value)
                            .insertAfter('#' + key);
                    });
                }
            }
        });
    });
});

</script>