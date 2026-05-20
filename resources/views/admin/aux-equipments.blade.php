@include('admin.inc.header')

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Aux Equipment</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">Aux Equipment</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">All Aux Equipment</h5>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAuxEquipmentModal">
                                <i class="bi bi-plus-circle me-1"></i> Add New
                            </button>
                        </div>

                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Created</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($auxEquipments as $auxEquipment)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><strong>{{ $auxEquipment->name }}</strong></td>
                                    <td>{{ $auxEquipment->created_at ? $auxEquipment->created_at->format('d M Y') : '—' }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary me-1" title="Edit"
                                            data-bs-toggle="modal" data-bs-target="#editAuxEquipmentModal{{ $auxEquipment->id }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <form action="{{ url('admin/aux-equipments/'.$auxEquipment->id.'/delete') }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editAuxEquipmentModal{{ $auxEquipment->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ url('admin/aux-equipments/'.$auxEquipment->id.'/update') }}" method="POST">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Edit Aux Equipment</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Name <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="name" value="{{ $auxEquipment->name }}" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Update</button>
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

<!-- Add Aux Equipment Modal -->
<div class="modal fade" id="addAuxEquipmentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ url('admin/aux-equipments/store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>New Aux Equipment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" required placeholder="e.g. Bench, Rack, Cable...">
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
