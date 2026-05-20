@include('admin.inc.header')

<main id="main" class="main">

    <div class="pagetitle">
        <h1>My Profile</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">Profile</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <!-- Profile Info -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body pt-4">
                        <h5 class="card-title"><i class="bi bi-person me-2"></i>Profile Information</h5>

                        <form action="{{ url('admin/profile/update') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" value="{{ $admin->name }}" required>
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" value="{{ $admin->email }}" required>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Update Profile</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Password Change -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body pt-4">
                        <h5 class="card-title"><i class="bi bi-shield-lock me-2"></i>Change Password</h5>

                        <form action="{{ url('admin/profile/update-password') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Current Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="current_password" required>
                                @error('current_password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">New Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="password" required minlength="6">
                                @error('password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Confirm New Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="password_confirmation" required minlength="6">
                            </div>

                            <button type="submit" class="btn btn-warning"><i class="bi bi-key me-1"></i>Change Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>

@include('admin.inc.footer')
