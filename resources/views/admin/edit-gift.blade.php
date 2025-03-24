@include('admin.inc.header')

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Gifts</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active">Gifts</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Add Gifts</h5>

            <!-- General Form Elements -->
            <form action="{{ url('admin/update-gift/') }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method("PUT")
              @if(session()->has('success'))
                <div class="alert alert-success">
                  {{ session()->get('success') }}
                </div>
              @endif
              <div class="row mb-3">
                <label for="inputText" class="col-sm-2 col-form-label">Gift Code</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name='gift_code' placeholder="Write Title....">
                </div>
              </div>

              <div class="row mb-3">
                <label for="inputText" class="col-sm-2 col-form-label">Gift Discount</label>
                <div class="col-sm-10">
                  <input type="number" class="form-control" name='gift_discount' placeholder="50">
                </div>
              </div>
              <div class="row mb-3">
                <label for="inputText" class="col-sm-2 col-form-label">Gift Expiry</label>
                <div class="col-sm-10">
                  <input type="date" class="form-control" name='gift_expirty' placeholder="50">
                </div>
              </div>
              <div class="row mb-3">
                <label for="inputNumber" class="col-sm-2 col-form-label">Image of Gift</label>
                <div class="col-sm-10">
                  <input class="form-control" type="file" id="formFile" name='gift_image'>
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-sm-10">
                  <input type="submit" value="Update Gift" class='btn btn-success'>
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
