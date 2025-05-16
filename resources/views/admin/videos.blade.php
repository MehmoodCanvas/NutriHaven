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
    <a  class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">Add New Video</a>
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
            <td>{{$video->workout_videos_description}}</td>
            <td> <video src="{{ $video->workout_videos_cdn_url }}"></video> </td>
           
            <td>{{$video->category_name}}</td>
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

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
   
      <div class="modal-body">
        <form  action="{{url('admin/post-video/')}}" method='post' enctype="multipart/form-data" >
          @csrf
          <section class="section">
            <div class="row">
              <div class="col-lg-12">
      
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">New Video</h5>
         
      
                        <div id='slideupload' class="row mb-3">
                          <label for="inputText" class="col-sm-12 col-form-label">Media Content</label>
                          <div class="col-sm-12">
                           <input type="file" class="form-control" name="file" id="file" required>  
                          </div>
                          <label for="inputText" class="col-sm-12 col-form-label">Title</label>
                          <div class="col-sm-12">
                           <input type="text" class="form-control" name="workout_videos_title" id="workout_videos_title" required>  
                          </div>
                          <label for="inputText" class="col-sm-12 col-form-label">Description</label>
                          <div class="col-sm-12">
                           <input type="text" class="form-control" name="workout_videos_description" id="workout_videos_description">  
                          </div>
                          <label for="inputText" class="col-sm-12 col-form-label">Category</label>
                          <div class="col-sm-12">
                            <select name="workout_videos_category_id" required id="workout_videos_category_id" class="form-control">
                              <option value="">Select Category</option>
                              @foreach($categories as $category)
                              <option value="{{$category->category_id}}">{{$category->category_name}}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>                     
                        <div class="row mb-3">
                          <div class="col-sm-10">
                              <input type="submit" value="Update Gallery" class='btn btn-success'>
                          </div>
                        </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </section>
      </div>
    </div>
  </div>
</div>