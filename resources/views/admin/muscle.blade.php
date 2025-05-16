@include('admin.inc.header')

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Muscle</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Muscle</li>
        </ol>
      </nav>
    </div>

    <section >
    <a  class="btn btn-success" data-bs-toggle="modal" data-bs-target="#muscleexampleModal">Add New Muscle</a>
      <table class="table datatable">
        <thead>
            <th>S.No</th>
            <th>Muscle Name</th>
            <th>Muscle Image</th>
            <th>Action</th>
        </thead>
        <tbody>
          @foreach($muscles as $muscle)
          <tr>
            <td> {{$loop->iteration}}</td>
            <td> {{$muscle->muscle_name}}</td>
            <td> <img src="{{$muscle->muscle_image}}" alt="{{$muscle->muscle_name}}" width="100"></td>
            <td><a href='{{url('admin/muscle-edit/'.$muscle->muscle_id)}}' class="btn btn-secondary"><i class="bi bi-pencil-square"></i></a><button class="btn btn-danger"><i class="bi bi-archive"></i></button></td>
          </tr>
          @endforeach
        </tbody>
    </table>
     
        </div><!-- End Left side columns -->

      </div>
    </section>

  </main><!-- End #main -->
@include('admin.inc.footer')