@include('admin.inc.header')

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Edit User</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('admin/users')}}">App Users</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body pt-4">
                        <form action="{{ url('admin/users/'.$member->member_id.'/update') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="member_full_name" value="{{ $member->member_full_name }}" required>
                                    @error('member_full_name')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="member_email" value="{{ $member->member_email }}" required>
                                    @error('member_email')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Gender</label>
                                    <select class="form-select" name="member_gender">
                                        <option value="">Select Gender</option>
                                        <option value="Male" {{ $member->member_gender == 'Male' ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ $member->member_gender == 'Female' ? 'selected' : '' }}>Female</option>
                                        <option value="Other" {{ $member->member_gender == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Age</label>
                                    <input type="number" class="form-control" name="member_age" value="{{ $member->member_age }}" min="1">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Status</label>
                                    <select class="form-select" name="member_status">
                                        <option value="active" {{ $member->member_status == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ $member->member_status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Weight</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="member_weight" value="{{ $member->member_weight }}" step="0.1" min="1">
                                        <select class="form-select" name="member_weight_unit" style="max-width:80px;">
                                            <option value="lbs" {{ $member->member_weight_unit == 'lbs' ? 'selected' : '' }}>lbs</option>
                                            <option value="kg" {{ $member->member_weight_unit == 'kg' ? 'selected' : '' }}>kg</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Height (ft)</label>
                                    <input type="number" class="form-control" name="member_height_ft" value="{{ $member->member_height_ft }}" step="0.1">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Height (in)</label>
                                    <input type="number" class="form-control" name="member_height_in" value="{{ $member->member_height_in }}" step="0.1">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Goal</label>
                                    <input type="text" class="form-control" name="member_goal" value="{{ $member->member_goal }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Experience</label>
                                    <select class="form-select" name="member_exp">
                                        <option value="">Select Experience</option>
                                        <option value="Beginner" {{ $member->member_exp == 'Beginner' ? 'selected' : '' }}>Beginner</option>
                                        <option value="Intermediate" {{ $member->member_exp == 'Intermediate' ? 'selected' : '' }}>Intermediate</option>
                                        <option value="Advanced" {{ $member->member_exp == 'Advanced' ? 'selected' : '' }}>Advanced</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Exercise Place</label>
                                    <select class="form-select" name="member_excerise_place">
                                        <option value="">Select Place</option>
                                        <option value="Gym" {{ $member->member_excerise_place == 'Gym' ? 'selected' : '' }}>Gym</option>
                                        <option value="Home" {{ $member->member_excerise_place == 'Home' ? 'selected' : '' }}>Home</option>
                                        <option value="Outdoor" {{ $member->member_excerise_place == 'Outdoor' ? 'selected' : '' }}>Outdoor</option>
                                    </select>
                                </div>
                            </div>

                            <div class="d-flex gap-2 mt-2">
                                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Update User</button>
                                <a href="{{ url('admin/users') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>

@include('admin.inc.footer')
