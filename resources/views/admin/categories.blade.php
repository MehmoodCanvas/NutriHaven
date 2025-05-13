@include('admin.inc.header')

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Category</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Category</li>
        </ol>
      </nav>
    </div>

    <section>
    <a  class="btn btn-success"  data-bs-toggle="modal" data-bs-target="#categoryexampleModal">Add New Category</a>
      <table class="table datatable">
        <thead>
            <th>S.No</th>
            <th>Category Name</th>
            <th>Category Description</th>
            <th>Category Image</th>
            <th>Action</th>
        </thead>
        <tbody>
          @foreach($categories as $cat)
          <tr>
            <td>{{$loop->iteration}}</td>
            <td> {{$cat->category_name}}</td>
            <td>{{ $cat->category_description }}</td>
            <td> <image src='{{ $cat->category_image }}' loading='lazy' class='img-fluid'></td>
            <td><a href='{{url('admin/category-edit/'.$cat->category_id)}}' class="btn btn-secondary"><i class="bi bi-pencil-square"></i></a><button class="btn btn-danger"><i class="bi bi-archive"></i></button></td>
          </tr>
          @endforeach
        </tbody>
    </table>
     
        </div><!-- End Left side columns -->

      
      </div>
    </section>

  </main><!-- End #main -->
@include('admin.inc.footer')