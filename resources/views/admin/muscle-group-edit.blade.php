@include('admin.inc.header')

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Edit Muscle Group</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('admin/muscle-groups')}}">Muscle Groups</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body pt-4">
                        <form action="{{ url('admin/muscle-groups/'.$muscleGroup->id.'/update') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" value="{{ $muscleGroup->name }}" required>
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Current Image</label>
                                <div class="mb-2">
                                    @if($muscleGroup->muscle_image && !str_contains($muscleGroup->muscle_image, 'demo'))
                                        <img src="{{ $muscleGroup->muscle_image }}" alt="{{ $muscleGroup->name }}" width="120" style="border-radius:10px; border:2px solid #eee;">
                                    @else
                                        <span class="badge bg-light text-muted"><i class="bi bi-image"></i> No Image</span>
                                    @endif
                                </div>
                                <label class="form-label">Replace Image</label>
                                <input type="file" class="form-control" name="muscle_image" accept="image/*">
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Update</button>
                                <a href="{{ url('admin/muscle-groups') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>

@include('admin.inc.footer')
