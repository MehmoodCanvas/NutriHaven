@include('admin.inc.header')

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Edit Master Exercise</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('admin/master-exercises')}}">Master Exercises</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body pt-4">
                        <form action="{{ url('admin/master-exercises/'.$exercise->id.'/update') }}" method="POST" enctype="multipart/form-data" id="editExerciseForm">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Exercise Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" value="{{ $exercise->name }}" required>
                                    @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Difficulty</label>
                                    <select class="form-select" name="difficulty">
                                        <option value="">Select Difficulty</option>
                                        <option value="Beginner" {{ $exercise->difficulty == 'Beginner' ? 'selected' : '' }}>Beginner</option>
                                        <option value="Intermediate" {{ $exercise->difficulty == 'Intermediate' ? 'selected' : '' }}>Intermediate</option>
                                        <option value="Advanced" {{ $exercise->difficulty == 'Advanced' ? 'selected' : '' }}>Advanced</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Muscle Group <span class="text-danger">*</span></label>
                                    <select class="form-select" name="muscle_group_id" required>
                                        <option value="">Select Muscle Group</option>
                                        @foreach($muscleGroups as $mg)
                                            <option value="{{ $mg->id }}" {{ $exercise->muscle_group_id == $mg->id ? 'selected' : '' }}>{{ $mg->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Equipment</label>
                                    <select class="form-select" name="equipment_required_id">
                                        <option value="">None</option>
                                        @foreach($equipments as $eq)
                                            <option value="{{ $eq->id }}" {{ $exercise->equipment_required_id == $eq->id ? 'selected' : '' }}>{{ $eq->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Aux Equipment</label>
                                    <select class="form-select" name="aux_equipment_id">
                                        <option value="">None</option>
                                        @foreach($auxEquipments as $ae)
                                            <option value="{{ $ae->id }}" {{ $exercise->aux_equipment_id == $ae->id ? 'selected' : '' }}>{{ $ae->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Primary Muscles</label>
                                    @php
                                        $selectedPrimary = is_array($exercise->primary_muscles) ? $exercise->primary_muscles : [];
                                    @endphp
                                    <select class="form-select select2-muscles-edit-primary" name="primary_muscles[]" multiple="multiple">
                                        @foreach($muscleOptions as $muscle)
                                            <option value="{{ $muscle }}" {{ in_array($muscle, $selectedPrimary) ? 'selected' : '' }}>{{ $muscle }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Secondary Muscles</label>
                                    @php
                                        $selectedSecondary = is_array($exercise->secondary_muscles) ? $exercise->secondary_muscles : [];
                                    @endphp
                                    <select class="form-select select2-muscles-edit-secondary" name="secondary_muscles[]" multiple="multiple">
                                        @foreach($muscleOptions as $muscle)
                                            <option value="{{ $muscle }}" {{ in_array($muscle, $selectedSecondary) ? 'selected' : '' }}>{{ $muscle }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Goals</label>
                                    @php
                                        $selectedGoals = is_array($exercise->goals) ? $exercise->goals : [];
                                    @endphp
                                    <select class="form-select select2-goals-edit" name="goals[]" multiple>
                                        @foreach($goalOptions as $goal)
                                            <option value="{{ $goal }}" {{ in_array($goal, $selectedGoals) ? 'selected' : '' }}>{{ $goal }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Exercise Video</label>
                                    <select class="form-select select2-video-edit" name="workout_video_id">
                                        <option value="">Select Video</option>
                                        @foreach($videos as $video)
                                            <option value="{{ $video->workout_videos_id }}" {{ $exercise->workout_video_id == $video->workout_videos_id ? 'selected' : '' }}>{{ $video->workout_videos_title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Exercise Image</label>
                                    <div class="mb-2">
                                        @if($exercise->exercise_image && !str_contains($exercise->exercise_image, 'demo_exercises'))
                                            <img src="{{ $exercise->exercise_image }}" alt="{{ $exercise->name }}" width="120" style="border-radius:10px; border:2px solid #eee;">
                                        @else
                                            <span class="badge bg-light text-muted"><i class="bi bi-image"></i> No Image</span>
                                        @endif
                                    </div>
                                    <label class="form-label">Replace Image</label>
                                    <input type="file" class="form-control" name="exercise_image" accept="image/*">
                                </div>
                            </div>

                            <!-- Default Sets UI -->
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="form-label mb-0">Default Sets</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" value="1" id="isTimeBasedEdit" name="is_time_based" {{ $exercise->is_time_based ? 'checked' : '' }}>
                                        <label class="form-check-label text-muted small" for="isTimeBasedEdit">Time Based Exercise (Duration instead of Reps/Weight)</label>
                                    </div>
                                </div>
                                <div id="edit-sets-container">
                                    <!-- Existing sets will be loaded here via JS -->
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-success mt-2" id="edit-add-set-btn">
                                    <i class="bi bi-plus-circle me-1"></i>Add Set
                                </button>
                                <input type="hidden" name="default_sets" id="edit-default-sets-json">
                            </div>

                            <div class="d-flex gap-2 mt-2">
                                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Update Exercise</button>
                                <a href="{{ url('admin/master-exercises') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>

@include('admin.inc.footer')

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize Select2
    $('.select2-goals-edit').select2({
        theme: 'bootstrap-5',
        placeholder: 'Select Goals',
        allowClear: true
    });

    $('.select2-muscles-edit-primary').select2({
        theme: 'bootstrap-5',
        placeholder: 'Select Primary Muscles',
        allowClear: true
    });

    $('.select2-muscles-edit-secondary').select2({
        theme: 'bootstrap-5',
        placeholder: 'Select Secondary Muscles',
        allowClear: true
    });

    $('.select2-video-edit').select2({
        theme: 'bootstrap-5',
        placeholder: 'Search & Select Video',
        allowClear: true
    });

    // ===== Default Sets Builder (Edit) =====
    var editSetCount = 0;
    var isTimeBased = $('#isTimeBasedEdit').is(':checked');

    $('#isTimeBasedEdit').change(function() {
        isTimeBased = $(this).is(':checked');
        $('#edit-sets-container').empty();
        editSetCount = 0;
        $('#edit-add-set-btn').click();
    });

    function editSetRow(setNum, reps, weight, duration) {
        reps = reps || 10;
        weight = weight || 0;
        duration = duration || '30s';
        
        if (isTimeBased) {
            return `
            <div class="row align-items-center mb-2 set-row" data-set="${setNum}">
                <div class="col-3">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text">Set</span>
                        <input type="text" class="form-control" value="${setNum}" readonly style="max-width:50px;">
                    </div>
                </div>
                <div class="col-7">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text">Duration</span>
                        <input type="text" class="form-control set-duration" value="${duration}" placeholder="e.g. 30s or 1m">
                    </div>
                </div>
                <div class="col-2">
                    <button type="button" class="btn btn-sm btn-outline-danger remove-set-btn"><i class="bi bi-x-lg"></i></button>
                </div>
            </div>`;
        } else {
            return `
            <div class="row align-items-center mb-2 set-row" data-set="${setNum}">
                <div class="col-3">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text">Set</span>
                        <input type="text" class="form-control" value="${setNum}" readonly style="max-width:50px;">
                    </div>
                </div>
                <div class="col-3">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text">Reps</span>
                        <input type="number" class="form-control set-reps" value="${reps}" min="1">
                    </div>
                </div>
                <div class="col-4">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text">Weight</span>
                        <input type="number" class="form-control set-weight" value="${weight}" min="0" step="0.5">
                    </div>
                </div>
                <div class="col-2">
                    <button type="button" class="btn btn-sm btn-outline-danger remove-set-btn"><i class="bi bi-x-lg"></i></button>
                </div>
            </div>`;
        }
    }

    // Load existing sets from DB
    var existingSets = @json($exercise->default_sets ?? []);
    if (existingSets && existingSets.length > 0) {
        existingSets.forEach(function(s) {
            editSetCount++;
            $('#edit-sets-container').append(editSetRow(
                s.set || editSetCount,
                s.reps || 10,
                s.weight || 0,
                s.duration || '30s'
            ));
        });
    }

    $('#edit-add-set-btn').on('click', function() {
        editSetCount++;
        $('#edit-sets-container').append(editSetRow(editSetCount, 10, 0));
    });

    $('#edit-sets-container').on('click', '.remove-set-btn', function() {
        $(this).closest('.set-row').remove();
        editSetCount = 0;
        $('#edit-sets-container .set-row').each(function() {
            editSetCount++;
            $(this).attr('data-set', editSetCount);
            $(this).find('input[readonly]').val(editSetCount);
        });
    });

    // Before form submit, build JSON
    $('#editExerciseForm').on('submit', function() {
        var sets = [];
        $('#edit-sets-container .set-row').each(function() {
            if (isTimeBased) {
                sets.push({
                    set: parseInt($(this).attr('data-set')),
                    duration: $(this).find('.set-duration').val() || '30s'
                });
            } else {
                sets.push({
                    set: parseInt($(this).attr('data-set')),
                    reps: parseInt($(this).find('.set-reps').val()) || 10,
                    weight: parseFloat($(this).find('.set-weight').val()) || 0
                });
            }
        });
        if (sets.length > 0) {
            $('#edit-default-sets-json').val(JSON.stringify(sets));
        }
    });
});
</script>
