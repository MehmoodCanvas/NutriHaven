@include('admin.inc.header')
<main id="main" class="main">

  <div class="pagetitle">
    <h1>Gallery</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
        <li class="breadcrumb-item active">Gallery</li>
      </ol>
    </nav>
  </div>

  <section>
  <a  class="btn btn-success" >Add New Media</a>
  @if(session()->has('success'))
  <div class="alert alert-success">
      {{ session()->get('success') }}
  </div>
  @endif
    <table class="table datatable">
      <thead>
          <th>S.No</th>
          <th>Gallery Media</th>
          <th>Action</th>
      </thead>
      <tbody>
        @foreach($gallery as $gal)
        <tr>
          <td>{{$loop->iteration}}</td>
          <td>
            @if(in_array(pathinfo($gal->gallery_media, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
              <img src="{{asset('storage/gallery/'.$gal->gallery_media)}}" alt="" class="img-fluid galmedia">
            @else
              <video width="320" height="240" controls>
                <source src="{{asset('storage/gallery/'.$gal->gallery_media)}}" type="video/{{ pathinfo($gal->gallery_media, PATHINFO_EXTENSION) }}">
                Your browser does not support the video tag.
              </video>
            @endif
          </td>
          <td><a href='{{url('admin/delete-gallery/'.$gal->gallery_id.'?filename='.$gal->gallery_media)}}' class="btn btn-danger"><i class="bi bi-archive"></i></a></td>
        </tr>
        @endforeach
      </tbody>
  </table>
   
      </div>
      <!-- End Left side columns -->

    
    </div>
  </section>

</main>



  
  <!-- End #main -->
@include('admin.inc.footer')    