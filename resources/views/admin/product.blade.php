@include('admin.inc.header')

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Products</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Products</li>
        </ol>
      </nav>
    </div>

    <section>
    <a  class="btn btn-success" href="{{url('/admin/add-product')}}">Add New Product</a>
      <table class="table datatable">
        <thead>
            <th>S.No</th>
            <th>Product Name</th>
            <th>Product Price</th>
            <th>Product Discounted Price</th>
            <th>Product Image</th>
            <th>Action</th>
        </thead>
        <tbody>
          @foreach($product as $products)
          <tr>
            <td>{{$products->product_id}}</td>
            <td>{{$products->product_name}}</td>
            <td>${{$products->product_price}}</td>
            <td>${{$products->product_discounted_price}}</td>
            <td><img data-sizes="auto" data-src="{{asset('storage/products/'.$products->product_images)}}" data-srcset="{{asset('storage/products/'.$products->product_images)}} 300w, {{asset('storage/products/'.$products->product_images)}} 600w, {{asset('storage/products/'.$products->product_images)}} 900w"  class="img-fluid lazyload"  alt="{{$products->product_name}}"></td>
            <td><a href='{{url('admin/product-edit/'.$products->product_id)}}' target='_blank' class="btn btn-secondary"><i class="bi bi-pencil-square"></i></a><a  href='{{url('admin/product-delete/'.$products->product_id)}}' class="btn btn-danger"><i class="bi bi-archive"></i></a></td>
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