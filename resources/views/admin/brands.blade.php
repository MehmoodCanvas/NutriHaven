@include('admin.inc.header')

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Brands</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Brands</li>
        </ol>
      </nav>
    </div>

    <section>
    <a class="btn btn-success" href="{{url('/admin/add-new-brand')}}">Add New Brand</a>
      <table class="table datatable">
        <thead>
            <th>S.No</th>
            <th>Brand Name</th>
            <th>Brand Image</th>
            <th>Action</th>
        </thead>
        <tbody>
          @foreach($brands as $brand)
          <tr>
            <td> {{$brand->brands_id}}</td>
            <td> {{$brand->brands_name}}</td>
            <td> <image src='{{asset('storage/brand/'.$brand->brands_image)}}' loading='lazy' class='img-fluid'></td>
            <td><a href='{{url('admin/brand-edit/'.$brand->brands_id)}}' class="btn btn-secondary"><i class="bi bi-pencil-square"></i></a><button class="btn btn-danger"><i class="bi bi-archive"></i></button></td>
          </tr>
          @endforeach
        </tbody>
    </table>
     
        </div><!-- End Left side columns -->

      
      </div>
    </section>

  </main><!-- End #main -->
@include('admin.inc.footer')