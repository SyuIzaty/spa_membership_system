@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-table'></i> Arkib
        </h1>
    </div>
    <div class="row">
      @foreach($main as $mains)
      <div class="col-md-12 mb-2">
        <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-4">
                  <img src="{{ asset('img/intec_logo_new.png') }}" class="ml-5 mt-2 mb-2" style="width: 300px; height:100px"/>
                </div>
                <div class="col-8">
                    <table class="table w-10">  
                      <tr>
                        <td style="width:30px">Title</td>
                        <td style="width:20px">:</td>
                        <td>{{ $mains->title }}</td>
                      </tr>
                      <tr>
                        <td>Description</td>
                        <td>:</td>
                        <td>{{ $mains->description }}</td>
                      </tr>
                      <tr>
                        <td>Description</td>
                        <td>:</td>
                        <td>{{ $mains->department_code }}</td>
                      </tr>
                      <tr>
                        <td>Created At</td>
                        <td>:</td>
                        <td>{{ $mains->created_at }}</td>
                      </tr>
                    </table>
                </div>
              </div>
            </div>
        </div>
      </div>
      @endforeach
      <div class="text-center">
        {{ $main->links() }}
      </div>
    </div>
</main>
@endsection

@section('script')

<script>
</script>


@endsection
