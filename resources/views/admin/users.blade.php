@include('admin.inc.header')

<main id="main" class="main">

    <div class="pagetitle">
        <h1>App Users</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">App Users</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">All Members <span class="badge bg-secondary text-white">{{ count($members) }}</span></h5>

                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Gender</th>
                                    <th scope="col">Age</th>
                                    <th scope="col">Goal</th>
                                    <th scope="col">Experience</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($members as $member)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><strong>{{ $member->member_full_name }}</strong></td>
                                    <td>{{ $member->member_email }}</td>
                                    <td>{{ $member->member_gender ?? '—' }}</td>
                                    <td>{{ $member->member_age ?? '—' }}</td>
                                    <td>
                                        @if($member->member_goal)
                                            <span class="badge bg-info">{{ $member->member_goal }}</span>
                                        @else
                                            <span class="badge bg-light text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($member->member_exp)
                                            <span class="badge bg-primary">{{ $member->member_exp }}</span>
                                        @else
                                            <span class="badge bg-light text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($member->member_status == 'active')
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $member->member_status ?? 'N/A' }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ url('admin/users/'.$member->member_id.'/edit') }}" class="btn btn-sm btn-outline-primary me-1" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ url('admin/users/'.$member->member_id.'/delete') }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this user?');">
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

@include('admin.inc.footer')
