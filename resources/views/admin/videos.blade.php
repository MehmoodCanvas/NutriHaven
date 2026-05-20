@include('admin.inc.header')

<main id="main" class="main">

    <div class="pagetitle">
        <h1>All Videos</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">Videos</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">Manage Videos</h5>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addVideoModal">
                                <i class="bi bi-plus-circle me-1"></i> Add Video
                            </button>
                        </div>

                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Video</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($videos as $video)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if($video->workout_videos_cdn_url)
                                            <div style="position: relative; cursor: pointer; display: inline-block;" data-bs-toggle="modal" data-bs-target="#playVideoModal" data-video-src="{{ $video->workout_videos_cdn_url }}" data-video-title="{{ $video->workout_videos_title }}">
                                                <video src="{{ $video->workout_videos_cdn_url }}" style="width: 120px !important; height: 80px !important; max-width: 120px !important; object-fit:cover; border-radius:5px;" muted preload="metadata"></video>
                                                <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: white; background: rgba(0,0,0,0.6); border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                    <i class="bi bi-play-fill" style="font-size: 1.5rem; margin-left: 3px;"></i>
                                                </div>
                                            </div>
                                        @else
                                            <span class="badge bg-light text-muted"><i class="bi bi-camera-video"></i></span>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $video->workout_videos_title }}</strong><br>
                                        <small class="text-muted">{{ Str::limit($video->workout_videos_description, 40) }}</small>
                                    </td>
                                    <td>{{ $video->category_name ?? '—' }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" data-bs-target="#editVideoModal{{ $video->workout_videos_id }}" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <form action="{{ url('admin/videos/'.$video->workout_videos_id.'/delete') }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this video?');">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Edit Video Modal -->
                                <div class="modal fade" id="editVideoModal{{ $video->workout_videos_id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <form action="{{ url('admin/videos/'.$video->workout_videos_id.'/update') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Video</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-12 mb-3">
                                                            <label class="form-label">Title <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="workout_videos_title" value="{{ $video->workout_videos_title }}" required>
                                                        </div>
                                                        <div class="col-md-12 mb-3">
                                                            <label class="form-label">Description</label>
                                                            <textarea class="form-control" name="workout_videos_description" rows="3">{{ $video->workout_videos_description }}</textarea>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Category <span class="text-danger">*</span></label>
                                                            <select name="workout_videos_category_id" class="form-select" required>
                                                                <option value="">Select Category</option>
                                                                @foreach($categories as $category)
                                                                    <option value="{{ $category->category_id }}" {{ $video->workout_videos_category_id == $category->category_id ? 'selected' : '' }}>
                                                                        {{ $category->category_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Replace Media Content</label>
                                                            <input type="file" class="form-control" name="file" accept="video/*">
                                                            <small class="text-muted">Leave empty to keep current video.</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary">Update Video</button>
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

<!-- Add Video Modal -->
<div class="modal fade" id="addVideoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ url('admin/videos/store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">New Video</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="workout_videos_title" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="workout_videos_description" rows="3"></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category <span class="text-danger">*</span></label>
                            <select name="workout_videos_category_id" class="form-select" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Media Content <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" name="file" accept="video/*" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Video</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Play Video Modal -->
<div class="modal fade" id="playVideoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-dark text-white border-0">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title" id="playVideoTitle">Video Player</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-3">
                <video id="modalVideoPlayer" src="" controls style="width: 100%; max-height: 70vh; border-radius: 8px; background: #000;"></video>
            </div>
        </div>
    </div>
</div>

@include('admin.inc.footer')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var playVideoModal = document.getElementById('playVideoModal');
        var modalVideoPlayer = document.getElementById('modalVideoPlayer');
        var playVideoTitle = document.getElementById('playVideoTitle');

        if (playVideoModal) {
            playVideoModal.addEventListener('show.bs.modal', function (event) {
                // Button that triggered the modal
                var button = event.relatedTarget;
                // Extract info from data-* attributes
                var videoSrc = button.getAttribute('data-video-src');
                var videoTitle = button.getAttribute('data-video-title');
                
                // Update the modal's content
                playVideoTitle.textContent = videoTitle;
                modalVideoPlayer.src = videoSrc;
                modalVideoPlayer.play();
            });

            playVideoModal.addEventListener('hidden.bs.modal', function () {
                // Pause and clear video source when modal is closed
                modalVideoPlayer.pause();
                modalVideoPlayer.src = '';
            });
        }
    });
</script>