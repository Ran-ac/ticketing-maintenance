<div class="modal-header border-0 pb-0" style="background: linear-gradient(135deg, #1a73e8 0%, #0d47a1 100%); border-radius: 8px 8px 0 0;">
    <div class="d-flex align-items-center gap-3 py-2 px-1">
        <div class="bg-white rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; min-width: 48px;">
            <i class="fas fa-ticket-alt text-primary fs-5"></i>
        </div>
        <div>
            <h4 class="text-white fw-bold mb-0">Create Ticket</h4>
            <small class="text-white opacity-75">GAOC - Maintenance IR Form</small>
        </div>
    </div>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body px-4 pt-3">
<form id="create_ticket" method="POST" action="{{ route('ticket.store') }}" enctype="multipart/form-data">
    @csrf
    <!-- type of concern -->
    <div class="mb-3">
        <label class="form-label fw-semibold">Type of Concern <span class="text-danger">*</span></label>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="type_of_concern" id="concern1" value="Clinical">
            <label class="form-check-label" for="concern1">
                Clinical (dental equipment/machine/instruments)
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="type_of_concern" id="concern2" value="Non Clinical">
            <label class="form-check-label" for="concern2">
                Non Clinical (non dental equipment)
            </label>
        </div>
        @error('type_of_concern')
            <div class="alert alert-danger mt-2">{{ $message }}</div>
        @enderror
    </div>

    {{-- <!-- Branch -->
    <div class="mb-3">
        <label for="branch_id" class="form-label fw-semibold">Branch <span class="text-danger">*</span></label>
        <select class="form-select" name="branch_id" id="branch_id">
            <option value="">Please select branch</option>
            @foreach ($clinic as $clinics)
                <option value="{{ $clinics->id }}"
                    {{ old('branch_id', $ticket->branch_id ?? '') == $clinics->id ? 'selected' : '' }}>
                    {{ $clinics->name }}
                </option>
            @endforeach
        </select>
        @error('branch_id')
            <div class="alert alert-danger mt-2">{{ $message }}</div>
        @enderror
    </div> --}}

    <!-- Equipment or machine -->
    <div class="mb-3">
        <label for="type_equipment_or_machine" class="form-label fw-semibold">Equipment or Machine <span class="text-danger">*</span></label>
        <input type="text" name="type_equipment_or_machine" id="type_equipment_or_machine" class="form-control"
            value="{{ old('type_equipment_or_machine', $ticket->type_equipment_or_machine ?? '') }}">
        @error('type_equipment_or_machine')
            <div class="alert alert-danger mt-2">{{ $message }}</div>
        @enderror
    </div>

    <!-- Equipment or machine brand -->
    <div class="mb-3">
        <label for="equipment_or_machine_brand" class="form-label fw-semibold">Equipment or Machine Brand <span class="text-danger">*</span></label>
        <input type="text" name="equipment_or_machine_brand" id="equipment_or_machine_brand" class="form-control">
        @error('equipment_or_machine_brand')
            <div class="alert alert-danger mt-2">{{ $message }}</div>
        @enderror
    </div>

    <!-- Serial number -->
    <div class="mb-3">
        <label for="serial_number" class="form-label fw-semibold">Serial Number of Unit <span class="text-danger">*</span></label>
        <input type="text" name="serial_number" id="serial_number" class="form-control">
        @error('serial_number')
            <div class="alert alert-danger mt-2">{{ $message }}</div>
        @enderror
    </div>

    <!-- Concern description -->
    <div class="mb-3">
        <label for="concern_description" class="form-label fw-semibold">Concern Description <span class="text-danger">*</span></label>
        <textarea name="concern_description" class="form-control" id="concern_description" rows="3">{{ old('concern_description', $ticket->concern_description ?? '') }}</textarea>
        @error('concern_description')
            <div class="alert alert-danger mt-2">{{ $message }}</div>
        @enderror
    </div>

    {{-- <!-- Email -->
    <div class="mb-3">
        <label for="email" class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
        <input type="email" name="email" id="email" class="form-control">
        @error('email')
            <div class="alert alert-danger mt-2">{{ $message }}</div>
        @enderror
    </div> --}}

    <!-- File -->
    <div class="mb-3">
        <label for="file" class="form-label fw-semibold">File <span class="text-muted fw-normal">(optional)</span></label>
        <input type="file" name="file" id="file" class="form-control">
        @error('file')
            <div class="alert alert-danger mt-2">{{ $message }}</div>
        @enderror
    </div>

    <!-- Buttons -->
    <div class="d-flex justify-content-end gap-2 mt-4">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary px-4">
            <i class="fas fa-save me-1"></i> Save
        </button>
    </div>
</form>
</div>

<script>
$(document).ready(function () {
    $('#create_ticket').on('submit', function(e) {
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            url: "{{ route('ticket.store') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,

            success: function(response) {
                alert('Ticket added successfully!');
                $('#formModalCreate').modal('hide');
            },

            error: function(xhr) {
                console.log(xhr.responseText);

                let errors = xhr.responseJSON?.errors;
                $('.alert-danger').remove();

                if (errors) {
                    $.each(errors, function(key, value) {
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