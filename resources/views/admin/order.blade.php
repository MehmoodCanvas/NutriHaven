@include('admin.inc.header')

<main id="main" class="main">

    <div class="pagetitle">
      <h1>All Orders</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Orders</li>
        </ol>
      </nav>
    </div>

    <section >
      <table class="table datatable">
        <thead>
            <th>Order.No</th>
            <th>Customer Name</th>
            <th>Payment Status</th>
            <th>Action</th>
        </thead>
        <tbody>
          @foreach($order as $orders)
          <tr>
            <td>{{$orders->order_no}}</td>
            <td>{{$orders->order_full_name}}</td>
            <td>
              <span class="badge 
                @if($orders->order_payment_status == 'unpaid') 
                  bg-warning 
                @elseif($orders->order_payment_status == 'Paid') 
                  bg-success 
                @endif">
                {{$orders->order_payment_status}}
              </span>
            </td>
            <td><a href='{{url('admin/order-detail/'.$orders->order_id)}}' class="btn btn-success"><i class="bi bi-eye"></i></a><button class="btn btn-danger"><i class="bi bi-archive"></i></button></td>
          </tr>
          @endforeach
        </tbody>
    </table>
     
        </div><!-- End Left side columns -->

      
      </div>
    </section>

  </main><!-- End #main -->
@include('admin.inc.footer')