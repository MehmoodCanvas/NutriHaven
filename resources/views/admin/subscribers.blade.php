@include('admin.inc.header')

<main id="main" class="main">

    <div class="pagetitle">
      <h1>All Subscribers</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Subscribers</li>
        </ol>
      </nav>
    </div>

    <section >
      <table class="table datatable">
        <thead>
            <th>S.No</th>
            <th>Subscibers Email</th>
            <th>Action</th>
        </thead>
        <tbody>
            @foreach($subscribers as $email)
          <tr>
            <td>{{$email->newsletter_id}}</td>
            <td>{{$email->newsletter_email}}</td>
            <td><button class="btn btn-secondary"><i class="bi bi-pencil-square"></i></button><button class="btn btn-danger"><i class="bi bi-archive"></i></button></td>
          </tr>
          @endforeach
        </tbody>
    </table>
     
        </div><!-- End Left side columns -->

      
      </div>
    </section>

  </main><!-- End #main -->
@include('admin.inc.footer')