@include('admin.inc.header')

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Gifts</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Gifts</li>
        </ol>
      </nav>
    </div>

    <section >
    <a  class="btn btn-success" href="{{url('/admin/add-gift')}}">Add New Gift</a>
    @if(session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
  @endif
      <table class="table datatable">
    <thead>
            <th>S.No</th>
            <th>Gift Code</th>
            <th>Gift Discount</th>
            <th>Gift Image</th>
            <th>Action</th>
        </thead>
        <tbody>
          @foreach($gifts as $products)
          <tr>
            <td>{{$products->gift_id}}</td>
            <td>{{$products->gift_code}}</td>
            <td>{{$products->gift_discount}}%</td>
            <td><img src="{{asset('storage/gift/'.$products->gift_image)}}" alt="{{$products->gift_image}}" class="img-fluid"></td>
            <td><a href='{{url('admin/edit-gift/'.$products->gift_id)}}' target='_blank' class="btn btn-secondary"><i class="bi bi-pencil-square"></i></a><a href='{{url('admin/gift-delete/'.$products->gift_id)}}' class="btn btn-danger"><i class="bi bi-archive"></i></a></td>
          </tr>
          @endforeach
        </tbody>
    </table>
     
        </div>
      </div>
    </section>

</main>
  
<!-- End #main -->



@include('admin.inc.footer')