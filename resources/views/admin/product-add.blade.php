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
              <h5 class="card-title">Add Products</h5>

              <!-- General Form Elements -->
              <form action="{{url('admin/post-product/')}}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Product Name</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name='product_name' placeholder="Write Name (Men's T-shirt)...."> 
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Product Short Description</label>
                  <div class="col-sm-10">
                    <textarea class="form-control" style="height: 60px"  name='product_short_description' placeholder="Write...."></textarea>
                  </div>
                </div>

                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">Product Category</label>
                  <div class="col-sm-10">
                    <select class="form-select" id="product_category_id" name='product_category_id'>
                      <option selected="" disabled>Select Category</option>
                      @foreach($category as $cat)
                        <option value="{{$cat->categories_id}}">{{$cat->categories_name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">Product Sub Category</label>
                  <div class="col-sm-10">
                    <select class="form-select" name='product_sub_category_id' id="product_sub_category_id">
                      <option selected="" disabled>Select Category</option>
                        @foreach($subcategory as $scat)
                        <option style="display: none"  data-main="{{$scat->sub_cateogry_category_id}}" value="{{$scat->sub_cateogry_id}}">{{$scat->sub_cateogry_name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">Product Brand</label>
                  <div class="col-sm-10">
                    <select class="form-select" name='product_category_id'>
                      <option selected="" disabled>Select Brand</option>
                      @foreach($brands as $brand)
                        <option value="{{$brand->brands_id}}">{{$brand->brands_name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">Product Country</label>
                  <div class="col-sm-10">
                    <select class="form-select" name='product_category_id'>
                      <option selected="" disabled>Select Country</option>
                      @foreach($country as $countries)
                        <option value="{{$cat->category_id}}">{{$cat->category_name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Product Price</label>
                  <div class="col-sm-10">
                    <input type="number" class="form-control" name='product_price' required placeholder="1.00">
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Product Discounted Price (Make it Null if disocunt is not applicable)</label>
                  <div class="col-sm-10">
                    <input type="number" class="form-control" name='product_discounted_price' placeholder="0.00">
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
                  <textarea id="default-editor" class="form-control tinymce" style="height: 100px"  name='product_description' placeholder="Write...."></textarea>
                </div>
              </div>
                <fieldset class="row mb-3">
                  <legend class="col-form-label col-sm-2 pt-0">Availability</legend>
                  <div class="col-sm-10">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="product_status" id="gridRadios1" value="enable" checked="">
                      <label class="form-check-label" for="gridRadios1">
                        Available
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="product_status" id="gridRadios2" value="disable">
                      <label class="form-check-label" for="gridRadios2">
                        Out of Stock
                      </label>
                    </div>
                  </div>
                </fieldset>

                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">SKU</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name='product_sku'>
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Tags</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="tagsinput" data-role="tagsinput"  name='product_tags'>
                  </div>
                </div>
                @foreach($attributes as $attribute)
                <div class="row mb-3">
                    <legend class="col-form-label col-sm-2 pt-0">{{$attribute->attribute_name}}</legend>
                    <div class="col-6 d-flex align-items-center justify-content-between">
                        @foreach($variants as $variant)
                          @if($variant->variant_attribute_id==$attribute->attribute_id)
                          
                                <div class="form-check">
                                    <input class="form-check-input" value="{{$variant->variant_id}}" type="checkbox" name='product_variant[]' id="gridCheck{{$attribute->attribute_id}}">
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
                      <input type="submit" value="Insert New Product" class='btn btn-success'>
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