@include('admin.inc.header')

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Sub Category</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Sub Category</li>
        </ol>
      </nav>
    </div>

    <section>
    <a  class="btn btn-success" href="{{url('/admin/add-new-sub-category')}}">Add New Sub Category</a>
      <table class="table datatable">
        <thead>
            <th>S.No</th>
            <th>Category Name</th>
            <th>Main Category Name</th>
            <th>Action</th>
        </thead>
        <tbody>
          @foreach($subcategory as $cat)
          <tr>
            <td>{{$cat->sub_cateogry_id}}</td>
            <td>{{$cat->sub_cateogry_name}}</td>
            <td>{{$cat->categories_name}}</td>
            <td><a href='{{url('admin/sub-category-edit/'.$cat->sub_cateogry_id)}}' class="btn btn-secondary"><i class="bi bi-pencil-square"></i></a><button class="btn btn-danger"><i class="bi bi-archive"></i></button></td>
          </tr>
          @endforeach
        </tbody>
    </table>
     
        </div><!-- End Left side columns -->

      
      </div>
    </section>

  </main><!-- End #main -->
@include('admin.inc.footer')