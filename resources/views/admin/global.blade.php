@include('admin.inc.header')

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Global Setting</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Global Setting</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
<form  action="{{url('admin/post-global/1')}}" method='post' enctype="multipart/form-data" >
    @csrf
    @method("PUT")
    @if(session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
@endif
    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Global Settings</h5>
                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">Text Type</label>
                  <div class="col-sm-10">
                    <select class="form-select" name='global_setting_header_text_type' required>
                      <option selected="" disabled>Select Type</option>
                      <option value="static" {{ ( $global_setting->global_setting_header_text_type == 'static') ? 'selected' : '' }}>Static Text</option>
                      <option value="marquee" {{ ( $global_setting->global_setting_header_text_type == 'marquee') ? 'selected' : '' }}>Slider</option>
                    </select>
                  </div>
                </div>

                <div id='videoupload' class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Text</label>
                  <div class="col-sm-10">
                    <input type="text"  name='global_setting_header_text' value="{{$global_setting->global_setting_header_text}}" class="form-control">
                  </div>
                </div>
                <div id='videoupload' class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Global Song</label>
                  <div class="col-sm-10">
                    <input type="file"  name='global_setting_song'  class="form-control">
                  </div>
                </div>
                  <div class="row mb-3">
                    <div class="col-sm-10">
                        <input type="submit" value="Update" class='btn btn-success'>
                    </div>
                  </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>



  </main><!-- End #main -->
@include('admin.inc.footer')    