@include('admin.inc.header')

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Variant</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Attributes</li>
        </ol>
      </nav>
    </div>

    <section >
    <a  class="btn btn-success" href="{{url('/admin/add-variant')}}">Add New Variant</a>
      <table class="table datatable">
        <thead>
            <th>S.No</th>
            <th>Variant Name</th>
            <th>Variant Price</th>
            <th>Variant Attribute</th>
            <th>Action</th>
        </thead>
        <tbody>
          @foreach($variant as $variants)
          <tr>
            <td> {{$variants->variant_id}}</td>
            <td> {{$variants->variant_name}}</td>
            <td> {{$variants->variant_price}}</td>
            <td> {{$variants->attribute_name}}</td>
            <td><a href='{{url('admin/variant-edit/'.$variants->variant_id)}}' class="btn btn-secondary"><i class="bi bi-pencil-square"></i></a><button class="btn btn-danger"><i class="bi bi-archive"></i></button></td>
          </tr>
          @endforeach
        </tbody>
    </table>
     
        </div><!-- End Left side columns -->

      
      </div>
    </section>

  </main><!-- End #main -->
@include('admin.inc.footer')