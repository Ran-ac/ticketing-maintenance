<div class="modal-header border-0 pb-0" style="background: linear-gradient(135deg, #59bfa8 0%, #1e3c70 100%); border-radius: 8px 8px 0 0;">
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
        <label class="form-label fw-semibold">
            Type of Concern <span class="text-danger">*</span>
        </label>

        <div class="form-check">
            <input class="form-check-input @error('type_of_concern') is-invalid @enderror"
                type="radio"
                name="type_of_concern"
                id="concern1"
                value="Clinical"
                {{ old('type_of_concern') === 'Clinical' ? 'checked' : '' }}
                required>
            <label class="form-check-label" for="concern1">
                Clinical (dental equipment/machine/instruments)
            </label>
        </div>

        <div class="form-check">
            <input class="form-check-input @error('type_of_concern') is-invalid @enderror"
                type="radio"
                name="type_of_concern"
                id="concern2"
                value="Non Clinical"
                {{ old('type_of_concern') === 'Non Clinical' ? 'checked' : '' }}
                required>
            <label class="form-check-label" for="concern2">
                Non Clinical (non dental equipment)
            </label>
        </div>

        @error('type_of_concern')
            <div class="alert alert-danger mt-2">{{ $message }}</div>
        @enderror
    </div>
    
    <!-- Equipment or machine -->
    <div class="mb-3">
        <label for="type_equipment_or_machine" class="form-label fw-semibold">
            Equipment or Machine <span class="text-danger">*</span>
        </label>
        <div class="input-group">
            <span class="input-group-text bg-light text-muted">
                <i class="bi bi-gear"></i>
            </span>
            <input type="text" name="type_equipment_or_machine" id="type_equipment_or_machine"
                class="form-control @error('type_equipment_or_machine') is-invalid @enderror"
                placeholder="e.g. Air Compressor, Forklift, Printer"
                aria-describedby="equipment_help"
                value="{{ old('type_equipment_or_machine', $ticket->type_equipment_or_machine ?? '') }}">
        </div>
        <div id="equipment_help" class="form-text text-muted" style="font-size: 0.75rem;">
            <i class="bi bi-info-circle me-1"></i>Enter "N/A" if not applicable.
        </div>
        @error('type_equipment_or_machine')
            <div class="text-danger mt-1" style="font-size: 0.8rem;">{{ $message }}</div>
        @enderror
    </div>

    <!-- Equipment or machine brand -->
    <div class="mb-3">
        <label for="equipment_or_machine_brand" class="form-label fw-semibold">
            Equipment or Machine Brand <span class="text-danger">*</span>
        </label>
        <div class="input-group">
            <span class="input-group-text bg-light text-muted">
                <i class="bi bi-tag"></i>
            </span>
            <input type="text" name="equipment_or_machine_brand" id="equipment_or_machine_brand"
                class="form-control @error('equipment_or_machine_brand') is-invalid @enderror"
                placeholder="e.g. Ritter, Compressor, Lights"
                aria-describedby="brand_help"
                value="{{ old('equipment_or_machine_brand', $ticket->equipment_or_machine_brand ?? '') }}">
        </div>
        <div id="brand_help" class="form-text text-muted" style="font-size: 0.75rem;">
            <i class="bi bi-info-circle me-1"></i>Enter "N/A" if not applicable.
        </div>
        @error('equipment_or_machine_brand')
            <div class="text-danger mt-1" style="font-size: 0.8rem;">{{ $message }}</div>
        @enderror
    </div>

    <!-- Serial number -->
    <div class="mb-3">
        <label for="serial_number" class="form-label fw-semibold">
            Serial Number of Unit <span class="text-danger">*</span>
        </label>
        <div class="input-group">
            <span class="input-group-text bg-light text-muted">
                <i class="bi bi-upc-scan"></i>
            </span>
            <input type="text" name="serial_number" id="serial_number"
                class="form-control @error('serial_number') is-invalid @enderror"
                placeholder="e.g. SN-2024-001234"
                aria-describedby="serial_help"
                value="{{ old('serial_number', $ticket->serial_number ?? '') }}">
        </div>
        <div id="serial_help" class="form-text text-muted" style="font-size: 0.75rem;">
            <i class="bi bi-info-circle me-1"></i>Usually found on the unit's nameplate or sticker. Enter "N/A" if not available.
        </div>
        @error('serial_number')
            <div class="text-danger mt-1" style="font-size: 0.8rem;">{{ $message }}</div>
        @enderror
    </div>

    <!-- Concern description -->
    <div class="mb-3">
        <label for="concern_description" class="form-label fw-semibold">
            Concern Description <span class="text-danger">*</span>
        </label>
        <textarea name="concern_description" id="concern_description"
            class="form-control @error('concern_description') is-invalid @enderror"
            rows="4"
            placeholder="Describe the issue, when it started, and any error messages or unusual behavior..."
            aria-describedby="concern_help">{{ old('concern_description', $ticket->concern_description ?? '') }}</textarea>
        <div id="concern_help" class="form-text text-muted" style="font-size: 0.75rem;">
            <i class="bi bi-info-circle me-1"></i>The more detail you give, the faster we can help.
        </div>
        @error('concern_description')
            <div class="text-danger mt-1" style="font-size: 0.8rem;">{{ $message }}</div>
        @enderror
    </div>
    
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
                location.reload();
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