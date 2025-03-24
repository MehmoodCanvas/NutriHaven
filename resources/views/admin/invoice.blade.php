@include('admin.inc.header')

<main id="main" class="main">
      <div class="invoice_wrappe" id='invoice-print'>
         <div class="sonic-first-wrap-text">
            <div class="inv_logo mb-3">
               <img src="{{asset('assets/front/images/logo.png')}}" class="img-fluid" alt="{{$order->order_no}}">
            </div>
            <h3>ORDER INVOICE</h3>
            <h6> {{date('F d, Y', strtotime($order->created_at))}}</h6>
         </div>
         <div class="details_wrapper">
            <div class="details_box">
               <p class="title">Customer Details</p>
               <p class="desc"><span>Name:</span> {{$order->order_full_name}}</p>
               <p class="desc"><span>Email:</span> {{$order->order_email}}</p>
               <p class="desc"><span>Phone:</span> {{$order->order_phone}}</p>
               <p class="desc"><span>City:</span> {{$order->order_city}}</p>
               <p class="desc"><span>State:</span> {{$order->order_state}}</p>
            </div>
            <div class="details_box">
               <p class="title">Order Details</p>
               <p class="desc"><span>Order ID:</span> {{$order->order_no}}</p>
               <p class="desc"><span>Subtotal:</span> ${{$order->order_total_amount}}</p>
               <p class="desc"><span>Shipping Fee:</span> $0</p>
               <p class="desc"><span>Tax:</span> $0</p>
               <p class="desc"><span>Discount:</span> $0</p>
               <p class="desc"><span>Total:</span> {{$order->order_total_amount}}</p>
            </div>
         </div>
         <div class="table_container">
            <p class="title">Products</p>
            <table>
               <thead>
                  <tr>
                     <th scope="col">Image</th>
                     <th scope="col">Product Name</th>
                     <th scope="col">Price</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($product as $pro)
                  @foreach($pro as $item)
                  <tr>
                     <td>
                        <div class="p_table_img">
                           <img src="{{asset('storage/product/'.$item->product_images)}}" class="img-fluid" alt="">
                        </div>
                     </td>
                     <td>{{$item->product_name}}</td>
                     <td>${{$item->product_price}}</td>
                  </tr>
                  @endforeach
                  @endforeach
            
               </tbody>
            </table>
         </div>
         <button class="download_btn" onclick="downloadpdf()">DOWNLAOD</button>
      </div>
</main>

@include('admin.inc.footer')
