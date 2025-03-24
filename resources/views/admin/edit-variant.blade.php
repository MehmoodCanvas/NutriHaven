@include('admin.inc.header')

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Variant</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Variant</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Update Variant</h5>

              <form action="{{url('admin/edit-variant/'.$variant->variant_id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Variant Name</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name='variant_name' value='{{$variant->variant_name}}' placeholder="Write Variant Name" required> 
                  </div>
                </div>
                <div class="row mb-3">
                    <label for="inputText" class="col-sm-2 col-form-label">Variant Price</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" value='{{$variant->variant_price}}' name='variant_price' placeholder="Write Variant Price"> 
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="inputText" class="col-sm-2 col-form-label">Variant SKU</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" value='{{$variant->variant_sku}}' name='variant_sku' placeholder="Write Variant SKU"> 
                    </div>
                  </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Variant Attribute</label>
                    <div class="col-sm-10">
                      <select class="form-select" name='variant_attrbuite_id' required>
                        <option selected="" disabled>Select Attribute</option>
                        @foreach($attribute as $attributes)
                        <option value="{{$attributes->attribute_id}}" {{ ( $attributes->attribute_id == $variant->variant_attrbuite_id) ? 'selected' : '' }}>{{$attributes->attribute_name}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                
                <div class="row mb-3">
                  <div class="col-sm-10">
                      <input type="submit" value="Update Variant" class='btn btn-success'>
                  </div>
                </div>
                
        

              </form><!-- End General Form Elements -->
            </div>
          </div>
        </div>
      </div>
    </section>

   

  </main><!-- End #main -->
@include('admin.inc.footer')    