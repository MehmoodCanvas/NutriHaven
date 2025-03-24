@include('admin.inc.header')

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Attribute</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Attribute</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Add Attribute</h5>

              <!-- General Form Elements -->
              <form action="{{url('admin/post-attribute')}}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Attribute Name</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name='attribute_name' placeholder="Write Attribute Name"> 
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Attribute Type</label>
                  <div class="col-sm-10">
                    <select name="attribute_type" id="attribute_type" class="form-control" required>
                      <option value="text" selected>Text</option>
                      <option value="color">Color</option>
                    </select>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-sm-10">
                      <input type="submit" value="Insert New Attribute" class='btn btn-success'>
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