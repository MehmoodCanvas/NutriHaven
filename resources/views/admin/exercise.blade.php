@include('admin.inc.header')

<main id="main" class="main">

    <div class="pagetitle">
      <h1>All Excercise</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Excercise</li>
        </ol>
      </nav>
    </div>

    <section >

          <a  class="btn btn-success"  data-bs-toggle="modal" data-bs-target="#exerciseexampleModal">Add New Excerise</a>

      <table class="table datatable">
        <thead>
            <th>S.No</th>
            <th>Exercise Name</th>
            <th>Exercise Video</th>
            <th>Action</th>
        </thead>
        <tbody>
            @foreach($exercises as $exercise)
          <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$exercise->nutrihaven_exercise_name}}</td>
            <td><video src="{{$exercise->nutrihaven_exercise_video_url}}" controls"></video></td>
            <td><button class="btn btn-secondary"><i class="bi bi-pencil-square"></i></button><button class="btn btn-danger"><i class="bi bi-archive"></i></button></td>
          </tr>
          @endforeach
        </tbody>
    </table>
     
        </div><!-- End Left side columns -->

      
      </div>
    </section>

  </main><!-- End #main -->
@include('admin.inc.footer')