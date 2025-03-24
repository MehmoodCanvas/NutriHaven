@include('admin.inc.header')

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Categorys</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Category</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Edit Category</h5>

              <!-- General Form Elements -->
              <form action="{{url('admin/edit-category/'.$category->category_id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Category Name</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" value="{{$category->category_name}}" name='category_name' placeholder="Write Category Name"> 
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="inputNumber" class="col-sm-2 col-form-label">Image of Category</label>
                  <div class="col-sm-10">
                    <input class="form-control" type="file" id="formFile"  name='category_image'>
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="inputNumber" class="col-sm-2 col-form-label">Banner Image of Category</label>
                  <div class="col-sm-10">
                    <input class="form-control" type="file" id="formFile"  name='category_banner_image'>
                  </div>
                </div>


                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Heading of Category</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" value="{{$category->category_heading}}" name='category_heading' placeholder="Write Heading"> 
                  </div>
                </div>
                
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Text of Category</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" value="{{$category->category_text}}"  name='category_text' placeholder="Write Text"> 
                  </div>
                </div>
                
                <div class="row mb-3">
                  <div class="col-sm-10">
                      <input type="submit" value="Edit Category" class='btn btn-success'>
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