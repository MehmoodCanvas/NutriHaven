@include('admin.inc.header')

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Update homepage</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Homepage</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
<form  action="{{url('admin/edit-homepage/1')}}" method='post' enctype="multipart/form-data" >
    @csrf
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
              <h5 class="card-title">Homepage Settings</h5>
                  <div class="row mb-3">
                    <label for="inputText" class="col-sm-2 col-form-label">Main Heading</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name='homepage_first_heading' placeholder="Write Heading" > 
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="inputText" class="col-sm-2 col-form-label">Second Heading</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name='homepage_second_heading' placeholder="Write Heading" > 
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="inputText" class="col-sm-2 col-form-label">Second Heading</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name='homepage_second_heading' placeholder="Write Heading" > 
                    </div>
                  </div>
                <div  class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Background Video</label>
                  <div class="col-sm-10">
                    <input type="file"  name='homepage_background_video' class="form-control">
                  </div>
                </div>
                <div class="row mb-3">
                    <label for="inputText" class="col-sm-2 col-form-label">Card Image</label>
                    <div class="col-sm-10">
                      <input type="file" name='homepage_gift_card_img_one' class="form-control" >
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="inputText" class="col-sm-2 col-form-label">Card Image Two</label>
                    <div class="col-sm-10">
                      <input type="file" name='homepage_gift_card_img_two' class="form-control" >
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="inputText" class="col-sm-2 col-form-label">Card Image Three</label>
                    <div class="col-sm-10">
                      <input type="file" name='homepage_gift_card_img_three' class="form-control" >
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="inputText" class="col-sm-2 col-form-label">Section Three Image</label>
                    <div class="col-sm-10">
                      <input type="file" name='homepage_section_three_image' class="form-control" >
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="inputText" class="col-sm-2 col-form-label">Section Three Heading</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name='homepage_section_three_heading' placeholder="Write Heading" > 
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="inputText" class="col-sm-2 col-form-label">Section Three Text</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name='homepage_section_three_text' placeholder="Write Heading" > 
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="inputText" class="col-sm-2 col-form-label">Section Three Button Text</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name='homepage_section_three_button_text' placeholder="Write Heading" > 
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="inputText" class="col-sm-2 col-form-label">Section Three Button Link</label>
                    <div class="col-sm-10">
                      <input type="url" class="form-control" name='homepage_section_three_button_link' placeholder="Write Heading" > 
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="inputText" class="col-sm-2 col-form-label">Section Three Image</label>
                    <div class="col-sm-10">
                      <input type="file" name='homepage_section_three_bottom_image' class="form-control" >
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="inputText" class="col-sm-2 col-form-label">Section Four Heading</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name='homepage_section_four_heading' placeholder="Write Heading" > 
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="inputText" class="col-sm-2 col-form-label">Section Five Heading</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name='homepage_section_five_heading' placeholder="Write Heading" > 
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="inputText" class="col-sm-2 col-form-label">Section Six Heading</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name='homepage_section_six_heading' placeholder="Write Heading" > 
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="inputText" class="col-sm-2 col-form-label">Section Seven Heading</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name='homepage_section_seven_heading' placeholder="Write Heading" > 
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="inputText" class="col-sm-2 col-form-label">Section Seven Description</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name='homepage_section_seven_desc' placeholder="Write Heading" > 
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="inputText" class="col-sm-2 col-form-label">Section Seven Image One</label>
                    <div class="col-sm-10">
                      <input type="file" class="form-control" name='homepage_section_seven_img_one' placeholder="Write Heading" > 
                    </div>
                  </div>            
                  <div class="row mb-3">
                    <label for="inputText" class="col-sm-2 col-form-label">Section Seven Image Two</label>
                    <div class="col-sm-10">
                      <input type="file" class="form-control" name='homepage_section_seven_img_two' placeholder="Write Heading" > 
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="inputText" class="col-sm-2 col-form-label">Section Eight Heading</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name='homepage_section_eight_heading' placeholder="Write Heading" > 
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="inputText" class="col-sm-2 col-form-label">Section Nine Heading</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name='homepage_section_nine_heading' placeholder="Write Heading" > 
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="inputText" class="col-sm-2 col-form-label">Section Tenth Heading</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name='homepage_section_tenth_heading' placeholder="Write Heading" > 
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="inputText" class="col-sm-2 col-form-label">Last Heading</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name='homepage_section_last_heading' placeholder="Write Heading" > 
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-sm-10">
                        <input type="submit" value="Update Homepage" class='btn btn-success'>
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