@include('admin.inc.header')

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Add Brand</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Add Brand</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Add Add Brand</h5>

              <!-- General Form Elements -->
              <form action="{{url('admin/post-brand')}}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Brand Title</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name='brands_name' placeholder="Write Brand Title"> 
                  </div>
                </div>

            
                <div class="row mb-3">
                    <label for="inputText" class="col-sm-2 col-form-label">Brand Image</label>
                    <div class="col-sm-10">
                      <input type="file" class="form-control" name='brands_image'> 
                    </div>
                  </div>
                  

                <div class="row mb-3">
                  <div class="col-sm-10">
                      <input type="submit" value="Insert New Brand" class='btn btn-success'>
                  </div>
                </div>
                </form>
                <!-- End General Form Elements -->
            </div>
          </div>
        </div>
      </div>
    </section>

   

  </main><!-- End #main -->
@include('admin.inc.footer')    