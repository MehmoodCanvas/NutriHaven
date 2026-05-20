@include('admin.inc.header')

<main id="main" class="main">

    <div class="pagetitle">
        <h1>All Categories</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">Categories</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">Manage Categories</h5>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                                <i class="bi bi-plus-circle me-1"></i> Add Category
                            </button>
                        </div>

                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $cat)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if($cat->category_image)
                                            <img src="{{ $cat->category_image }}" alt="{{ $cat->category_name }}" width="50" height="50" style="object-fit:cover; border-radius:5px;">
                                        @else
                                            <span class="badge bg-light text-muted"><i class="bi bi-image"></i></span>
                                        @endif
                                    </td>
                                    <td><strong>{{ $cat->category_name }}</strong></td>
                                    <td>{{ Str::limit($cat->category_description, 50) }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" data-bs-target="#editCategoryModal{{ $cat->category_id }}" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <form action="{{ url('admin/categories/'.$cat->category_id.'/delete') }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this category?');">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Edit Category Modal -->
                                <div class="modal fade" id="editCategoryModal{{ $cat->category_id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ url('admin/categories/'.$cat->category_id.'/update') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Category</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Category Name <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="category_name" value="{{ $cat->category_name }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Description</label>
                                                        <textarea class="form-control" name="category_description" rows="3">{{ $cat->category_description }}</textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Current Image</label>
                                                        @if($cat->category_image)
                                                            <div class="mb-2">
                                                                <img src="{{ $cat->category_image }}" width="100" style="border-radius:5px;">
                                                            </div>
                                                        @endif
                                                        <label class="form-label">Replace Image</label>
                                                        <input type="file" class="form-control" name="file" accept="image/*">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary">Update Category</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ url('admin/categories/store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Category Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="category_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="category_description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category Image <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="file" accept="image/*" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('admin.inc.footer')