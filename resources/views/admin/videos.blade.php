@include('admin.inc.header')

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Videos</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Videos</li>
        </ol>
      </nav>
    </div>

    <section>
    <a  class="btn btn-success" href="{{url('/admin/add-new-video')}}">Add New Video</a>
      <table class="table datatable">
        <thead>
            <th>S.No</th>
            <th>Video Title</th>
            <th>Video Description</th>
            <th>Video</th>
            <th>Category</th>
            <th>Action</th>
        </thead>
        <tbody>
          @foreach($videos as $video)
          <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$video->workout_videos_title}}</td>
            <td>${{$video->workout_videos_description}}</td>
            <td> <video src="{{ $video->workout_videos_cdn_url }}"></video> </td>
            
            <td>${{$video->workout_videos_category_id}}</td>
            <td><a href='{{url('admin/product-edit/'.$video->workout_videos_id)}}' target='_blank' class="btn btn-secondary"><i class="bi bi-pencil-square"></i></a><a  href='{{url('admin/product-delete/'.$video->workout_videos_id)}}' class="btn btn-danger"><i class="bi bi-archive"></i></a></td>
          </tr>
          @endforeach
        </tbody>
    </table>
     
        </div><!-- End Left side columns -->

      
      </div>
    </section>

  </main>
  <!-- End #main -->
@include('admin.inc.footer')