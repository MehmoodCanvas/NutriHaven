@include('admin.inc.header')

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Attributes</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Attributes</li>
        </ol>
      </nav>
    </div>

    <section >
    <a  class="btn btn-success" href="{{url('/admin/add-attribute')}}">Add New Attribute</a>
      <table class="table datatable">
        <thead>
            <th>S.No</th>
            <th>Attribute Name</th>
            <th>Attribute Type</th>
            <th>Action</th>
        </thead>
        <tbody>
          @foreach($attribute as $attributes)
          <tr>
            <td> {{$attributes->attribute_id}}</td>
            <td> {{$attributes->attribute_name}}</td>
            <td> {{$attributes->attribute_type}}</td>
            <td><a href='{{url('admin/attribute-edit/'.$attributes->attribute_id)}}' class="btn btn-secondary"><i class="bi bi-pencil-square"></i></a><button class="btn btn-danger"><i class="bi bi-archive"></i></button></td>
          </tr>
          @endforeach
        </tbody>
    </table>
     
        </div><!-- End Left side columns -->

      
      </div>
    </section>

  </main><!-- End #main -->
@include('admin.inc.footer')