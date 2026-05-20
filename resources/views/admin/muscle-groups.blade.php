@include('admin.inc.header')

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Muscle Groups</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">Muscle Groups</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">All Muscle Groups <span class="badge bg-secondary text-white">{{ count($muscleGroups) }}</span></h5>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMuscleGroupModal">
                                <i class="bi bi-plus-circle me-1"></i> Add New
                            </button>
                        </div>

                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Exercises Count</th>
                                    <th scope="col">Created</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($muscleGroups as $group)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if($group->muscle_image && !str_contains($group->muscle_image, 'demo'))
                                            <img src="{{ $group->muscle_image }}" alt="{{ $group->name }}" width="45" height="45" style="object-fit:cover; border-radius:8px;">
                                        @else
                                            <span class="badge bg-light text-muted"><i class="bi bi-image"></i></span>
                                        @endif
                                    </td>
                                    <td><strong>{{ $group->name }}</strong></td>
                                    <td><span class="badge bg-info">{{ \App\Models\MasterExercise::where('muscle_group_id', $group->id)->count() }}</span></td>
                                    <td>{{ $group->created_at ? $group->created_at->format('d M Y') : '—' }}</td>
                                    <td>
                                        <a href="{{ url('admin/muscle-groups/'.$group->id.'/edit') }}" class="btn btn-sm btn-outline-primary me-1" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ url('admin/muscle-groups/'.$group->id.'/delete') }}" method="POST" class="d-inline delete-form">
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

<!-- Add Muscle Group Modal -->
<div class="modal fade" id="addMuscleGroupModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ url('admin/muscle-groups/store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>New Muscle Group</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" required placeholder="e.g. Chest, Back, Legs...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image</label>
                        <input type="file" class="form-control" name="muscle_image" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Create</button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('admin.inc.footer')
