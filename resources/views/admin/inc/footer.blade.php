
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
   
      <div class="modal-body">
        <form  action="{{url('admin/post-gallery/')}}" method='post' enctype="multipart/form-data" >
          @csrf
        
          <section class="section">
            <div class="row">
              <div class="col-lg-12">
      
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Gallery</h5>
         
      
                        <div id='slideupload' class="row mb-3">
                          <label for="inputText" class="col-sm-12 col-form-label">Media Content</label>
                          <div class="col-sm-12">
                            <div class="input-images"></div>
                          </div>
                        </div>
      
                        
                     
                        <div class="row mb-3">
                          <div class="col-sm-10">
                              <input type="submit" value="Update Gallery" class='btn btn-success'>
                          </div>
                        </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </section>
      </div>
    </div>
  </div>
</div>






<!-- ======= Footer ======= -->
 <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>WalexSolution</span></strong>. All Rights Reserved 
    </div>

    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" ></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="{{asset('assets/admin/vendor/apexcharts/apexcharts.min.js')}}" defer></script>
  <script src="{{asset('assets/admin/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('assets/admin/vendor/chart.js/chart.umd.js')}}" defer></script>
  <script src="{{asset('assets/admin/vendor/echarts/echarts.min.js')}}" defer></script>
  <script src="{{asset('assets/admin/vendor/quill/quill.min.js')}}"></script>
  <script src="{{asset('assets/admin/vendor/simple-datatables/simple-datatables.js')}}"></script>
  <script src="{{asset('assets/admin/vendor/tinymce/tinymce.min.js')}}"></script>
  <!-- Template Main JS File -->
  <script src="{{asset('assets/admin/js/main.js')}}"></script>
  <script src="{{asset('assets/admin/vendor/multi/image-uploader.min.js')}}"></script>
  <script src="{{asset('assets/front/js/lazy.js')}}"></script>
  <script src="{{asset('assets/admin/js/tags.js')}}"></script>
  <script>
     const fpPromise = import('https://openfpcdn.io/fingerprintjs/v4')
      .then(FingerprintJS => FingerprintJS.load())
      fpPromise
      .then(fp => fp.get())
      .then(result => {
        const visitorId = result.visitorId
        const socket = io("http://127.0.0.1:3000", {
            withCredentials: false,
            auth: { deviceId: visitorId }  
        });
        socket.on('total_count',(event) =>{
              document.getElementById('total_vist_counter').innerHTML = event;

         });
    })



  </script>
  <script>
    $('#product_category_id').on('change',function(){
      var main_id = $(this).val();
      $(document.getElementById('product_sub_category_id').options).each(function(index, option) {
        var optionvar = $(this).data('main');
      if( optionvar == main_id ) {
        option.style.display = 'block'
      }
      else {
        option.style.display = 'none' 
      }
    });

    })
  </script>
  <script>
    tinymce.init({
  selector: 'textarea#default-editor'
});

$("#tagsinput").tagsinput('items')	

  </script>
  <script>
        $('.input-images').imageUploader();
        $('.input-images2').imageUploader2();

   </script>
<script>
  $('.selection').on('change', function(){
    var type = $(this).find('option:selected').data('type');
     if(type === 'color') {
       $('#variant_name').prop('type', 'color');
     } else {
       $('#variant_name').prop('type', 'text');
     }
  });
</script>

<script>
    function downloadpdf(){
      document.getElementsByClassName("download_btn")[0].innerHTML='Downloading...';
    var element = document.getElementById('invoice-print');
  var opt = {
  margin:       0,
  filename:     'invoice.pdf',
  image:        { type: 'jpeg', quality: 1 },
  html2canvas:  { scale: 2 },
  jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
};

html2pdf().set(opt).from(element).save().then(function () {
  document.getElementsByClassName("download_btn")[0].innerHTML = 'Completed';
}).catch(function (error) {
  document.getElementsByClassName("download_btn")[0].innerHTML = 'Error In Downloading Invoice, Please Reload';
});

    };

</script>
</body>

</html>