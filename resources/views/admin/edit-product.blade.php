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
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Update Product</h5>

              <!-- General Form Elements -->
              <form action="{{url('admin/edit-product/'.$product->product_id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Product Name</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control"  value="{{$product->product_name}}" name='product_name' placeholder="Write Name (Men's T-shirt)...."> 
                  </div>
                </div>

               
                <div class="row mb-3">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Product Short Description</label>
                  <div class="col-sm-10">
                    <textarea class="form-control"  style="height: 100px"  name='product_short_description'>
                    {{$product->product_short_description}}
                    </textarea>
                  </div>
                </div>

                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">Product Category</label>
                  <div class="col-sm-10">
                    <select class="form-select" name='product_category'>
                      <option selected="" disabled>Select Category</option>
                      @foreach($category as $cat)
                       <option value="{{$cat->categories_id}}" {{ ( $cat->categories_id == $product->product_category) ? 'selected' : '' }}>{{$cat->categories_name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">Product Category</label>
                  <div class="col-sm-10">
                    <select class="form-select" name='product_brand'>
                      <option selected="" disabled>Select Brand</option>
                      @foreach($brands as $brand)
                       <option value="{{$brand->brands_id}}" {{ ( $brand->brands_id == $product->product_brand) ? 'selected' : '' }}>{{$brand->brands_name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">Product Category</label>
                  <div class="col-sm-10">
                    <select class="form-select" name='product_country'>
                      <option selected="" disabled>Select Country</option>
                      @foreach($country as $countries)
                       <option value="{{$countries->country_id}}" {{ ( $countries->country_id == $product->product_country) ? 'selected' : '' }}>{{$countries->country_name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Product Price</label>
                  <div class="col-sm-10">
                    <input type="number" class="form-control" name='product_price' value="{{$product->product_price}}">
                  </div>
                </div> 
                
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Product Discounted Price</label>
                  <div class="col-sm-10">
                    <input type="number" class="form-control" name='product_discounted_price' value="{{$product->product_discounted_price}}">
                  </div>
                </div> 
                <div class="row mb-3">
                <div id='slideupload' class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Product Multiple Images</label>
                  <div class="col-sm-10">
                      <div class="input-images"></div>
                  </div>
                </div>
              </div>
              <div class="row mb-3">
                <label for="inputPassword" class="col-sm-2 col-form-label">Product Description</label>
                <div class="col-sm-10">
                  <textarea class="form-control"  id="default-editor" style="height: 100px"  name='product_description' placeholder="Write....">
                  {{$product->product_description}}
                  </textarea>
                </div>
              </div>
                <fieldset class="row mb-3">
                  <legend class="col-form-label col-sm-2 pt-0">Availability</legend>
                  <div class="col-sm-10">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="product_status" id="gridRadios1" value="enable" {{($product->product_status=='enable') ? "checked=checked" :'' }}>
                      <label class="form-check-label" for="gridRadios1">
                        Available
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="product_status" id="gridRadios2" value="disable" {{($product->product_status=='disable') ? "checked=checked" :'' }}>
                      <label class="form-check-label" for="gridRadios2">
                        Out of Stock
                      </label>
                    </div>
                  </div>
                </fieldset>

                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">SKU</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name='product_sku' value="{{$product->product_sku}}">
                  </div>
                </div>

                
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Tags</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="tagsinput" data-role="tagsinput"  name='product_tags' value="{{$product->product_tags}}">
                  </div>
                </div>
                @foreach($attributes as $attribute)
            <div class="row mb-3">
            <legend class="col-form-label col-sm-2 pt-0">{{$attribute->attribute_name}}</legend>
            <div class="col-6 d-flex align-items-center justify-content-between">
            @foreach($variants as $variant)
                @if($variant->variant_attribute_id == $attribute->attribute_id)
                    <div class="form-check">
                        <?php $isChecked = false; ?>
                        @foreach($product_variant as $prod_variant)
                            @if($prod_variant->product_variant_variant_id == $variant->variant_id)
                                <?php $isChecked = true; ?>
                                @break
                            @endif
                        @endforeach
                        <input class="form-check-input" value="{{$variant->variant_id}}" {{ $isChecked ? "checked=checked" : '' }} type="checkbox" name='product_variant[]' id="gridCheck{{$attribute->attribute_id}}">
                        <label class="form-check-label" for="gridCheck{{$attribute->attribute_id}}">
                            {{$variant->variant_name}}
                        </label>
                    </div>
                @endif
            @endforeach
            </div>
        </div>
    @endforeach
                <div class="row mb-3">
                  <div class="col-sm-10">
                      <input type="submit" value="Update Product" class='btn btn-success'>
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