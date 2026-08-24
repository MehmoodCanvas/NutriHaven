@include('admin.inc.header')

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Master Exercises</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">Master Exercises</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">All Master Exercises <span class="badge bg-secondary text-white">{{ count($exercises) }}</span></h5>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addExerciseModal">
                                <i class="bi bi-plus-circle me-1"></i> Add New
                            </button>
                        </div>

                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Difficulty</th>
                                    <th scope="col">Muscle Group</th>
                                    <th scope="col">Equipment</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($exercises as $exercise)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if($exercise->exercise_image && !str_contains($exercise->exercise_image, 'demo_exercises'))
                                            <img src="{{ $exercise->exercise_image }}" alt="{{ $exercise->name }}" width="45" height="45" style="object-fit:cover; border-radius:8px;">
                                        @else
                                            <span class="badge bg-light text-muted"><i class="bi bi-image"></i></span>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $exercise->name }}</strong>
                                        @if($exercise->is_time_based)
                                            <br><span class="badge bg-info mt-1"><i class="bi bi-stopwatch"></i> Time Based</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($exercise->difficulty == 'Beginner')
                                            <span class="badge bg-success">Beginner</span>
                                        @elseif($exercise->difficulty == 'Intermediate')
                                            <span class="badge bg-warning text-dark">Intermediate</span>
                                        @elseif($exercise->difficulty == 'Advanced')
                                            <span class="badge bg-danger">Advanced</span>
                                        @else
                                            <span class="badge bg-light text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>{{ $exercise->muscleGroup->name ?? '—' }}</td>
                                    <td>{{ $exercise->equipmentRequired->name ?? '—' }}</td>
                                    <td>
                                        <a href="{{ url('admin/master-exercises/'.$exercise->id.'/edit') }}" class="btn btn-sm btn-outline-primary me-1" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ url('admin/master-exercises/'.$exercise->id.'/delete') }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>

<!-- Add Exercise Modal -->
<div class="modal fade" id="addExerciseModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ url('admin/master-exercises/store') }}" method="POST" enctype="multipart/form-data" id="createExerciseForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>New Master Exercise</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Exercise Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" required placeholder="e.g. Bench Press">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Difficulty</label>
                            <select class="form-select" name="difficulty">
                                <option value="">Select Difficulty</option>
                                <option value="Beginner">Beginner</option>
                                <option value="Intermediate">Intermediate</option>
                                <option value="Advanced">Advanced</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Muscle Group <span class="text-danger">*</span></label>
                            <select class="form-select" name="muscle_group_id" required>
                                <option value="">Select Muscle Group</option>
                                @foreach($muscleGroups as $mg)
                                    <option value="{{ $mg->id }}">{{ $mg->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Equipment</label>
                            <select class="form-select" name="equipment_required_id">
                                <option value="">None</option>
                                @foreach($equipments as $eq)
                                    <option value="{{ $eq->id }}">{{ $eq->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Aux Equipment</label>
                            <select class="form-select" name="aux_equipment_id">
                                <option value="">None</option>
                                @foreach($auxEquipments as $ae)
                                    <option value="{{ $ae->id }}">{{ $ae->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Primary Muscles</label>
                            <select class="form-select select2-muscles-create-primary" name="primary_muscles[]" multiple="multiple">
                                @foreach($muscleOptions as $muscle)
                                    <option value="{{ $muscle }}">{{ $muscle }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Secondary Muscles</label>
                            <select class="form-select select2-muscles-create-secondary" name="secondary_muscles[]" multiple="multiple">
                                @foreach($muscleOptions as $muscle)
                                    <option value="{{ $muscle }}">{{ $muscle }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Goals</label>
                            <select class="form-select select2-goals-create" name="goals[]" multiple>
                                @foreach($goalOptions as $goal)
                                    <option value="{{ $goal }}">{{ $goal }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Exercise Video</label>
                            <select class="form-select select2-video-create" name="workout_video_id">
                                <option value="">Select Video</option>
                                @foreach($videos as $video)
                                    <option value="{{ $video->workout_videos_id }}">{{ $video->workout_videos_title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Exercise Image</label>
                            <input type="file" class="form-control" name="exercise_image" accept="image/*">
                        </div>
                    </div>

                    <!-- Default Sets UI -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label mb-0">Default Sets</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" value="1" id="isTimeBased" name="is_time_based">
                                <label class="form-check-label text-muted small" for="isTimeBased">Time Based Exercise (Duration instead of Reps/Weight)</label>
                            </div>
                        </div>
                        <div id="create-sets-container">
                            <!-- Sets rows will be added here -->
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-success mt-2" id="create-add-set-btn">
                            <i class="bi bi-plus-circle me-1"></i>Add Set
                        </button>
                        <input type="hidden" name="default_sets" id="create-default-sets-json">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Create Exercise</button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('admin.inc.footer')

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize Select2 for all selects in create modal
    var modalEl = $('#addExerciseModal');

    $('.select2-goals-create').select2({
        theme: 'bootstrap-5',
        placeholder: 'Select Goals',
        allowClear: true,
        dropdownParent: modalEl
    });

    $('.select2-muscles-create-primary').select2({
        theme: 'bootstrap-5',
        placeholder: 'Select Primary Muscles',
        allowClear: true,
        dropdownParent: modalEl
    });

    $('.select2-muscles-create-secondary').select2({
        theme: 'bootstrap-5',
        placeholder: 'Select Secondary Muscles',
        allowClear: true,
        dropdownParent: modalEl
    });

    $('.select2-video-create').select2({
        theme: 'bootstrap-5',
        placeholder: 'Search & Select Video',
        allowClear: true,
        dropdownParent: modalEl
    });

    // ===== Default Sets Builder (Create) =====
    var createSetCount = 0;
    var isTimeBasedCreate = false;

    $('#isTimeBased').change(function() {
        isTimeBasedCreate = $(this).is(':checked');
        $('#create-sets-container').empty();
        createSetCount = 0;
        $('#create-add-set-btn').click();
    });

    function createSetRow(setNum, reps, weight, duration) {
        reps = reps || 10;
        weight = weight || 0;
        duration = duration || '30s';
        
        if (isTimeBasedCreate) {
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

    $('#create-add-set-btn').on('click', function() {
        createSetCount++;
        $('#create-sets-container').append(createSetRow(createSetCount, 10, 0));
    });

    $('#create-sets-container').on('click', '.remove-set-btn', function() {
        $(this).closest('.set-row').remove();
        // Re-number sets
        createSetCount = 0;
        $('#create-sets-container .set-row').each(function() {
            createSetCount++;
            $(this).attr('data-set', createSetCount);
            $(this).find('input[readonly]').val(createSetCount);
        });
    });

    // Before form submit, build JSON from UI
    $('#createExerciseForm').on('submit', function() {
        var sets = [];
        $('#create-sets-container .set-row').each(function() {
            if (isTimeBasedCreate) {
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
            $('#create-default-sets-json').val(JSON.stringify(sets));
        }
    });
});
</script>
