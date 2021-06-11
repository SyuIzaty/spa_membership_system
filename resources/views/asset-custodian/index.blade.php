@extends('layouts.admin')
<style>
    .circle {
        width: 100px;
        height: 100px;
        line-height: 75px;
        border-radius: 50%;
        font-size: 30px;
        color: rgb(0, 0, 0);
        text-align: center;
        font-style: italic;
        font-family: fantasy;
        /* background: rgb(179, 146, 146) */
    }
</style>
@section('content')
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-adjust'></i>ASSET CUSTODIAN
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        ASSET CUSTODIAN <span class="fw-300"><i>LIST</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="row col-md-12">
                        @foreach ($department as $depart)
                            <div class="col-lg-3 col-md-3 mt-5">
                                <div class="card">
                                    <div class="card-header text-center">
                                        {{ strtoupper($depart->department_name) }}
                                    </div><br>
                                    <div class="card-body circle" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover; margin: auto;">
                                        {{-- <img src="/get-file-club/{{ $clubs->upload_image }}" style=" margin-top: 10px" class="img-fluid"> --}}
                                        {{ $depart->total }}
                                    </div><br>
                                    <div class="card-footer">
                                        <div class="text-center">
                                            <form action="{{route('deleteDepartment', $depart->id)}}" method="POST" class="delete_form"> 
                                                @method('DELETE')  
                                                @csrf
                                                <a href="/custodian-list/{{$depart->id}}" class="btn btn-sm btn-warning"><i class="fal fa-eye"></i> View</a>
                                                <button type="submit" class="btn btn-danger btn-sm delete-alert"><i class="fal fa-trash"></i> Delete</button>               
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                    <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex pull-right">
                        <a href="javascript:;" data-toggle="modal" id="new" class="btn btn-primary ml-auto float-right"><i class="fal fa-plus-square"></i> Add New Department</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="crud-modal" aria-hidden="true" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card-header bg-secondary text-white">
                    <h5 class="card-title w-100"><i class="fal fa-building width-2 fs-xl"></i>NEW DEPARTMENT</h5>
                </div>
                <div class="modal-body">
                    {!! Form::open(['action' => 'AssetCustodianController@addDepartment', 'method' => 'POST']) !!}
                    <p><span class="text-danger">*</span> Required fields</p>
                        <div class="form-group">
                            <td width="10%"><label class="form-label" for="department_name"><span class="text-danger">*</span> Department Name :</label></td>
                            <td colspan="4"><input value="{{ old('department_name') }}" class="form-control" id="department_name" name="department_name">
                                @error('department_name')
                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                @enderror
                            </td>
                        </div>
                     
                    <div class="footer">
                        <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Save</button>
                        <button type="button" class="btn btn-success ml-auto float-right mr-2" data-dismiss="modal"><i class="fal fa-window-close"></i> Close</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

</main>
@endsection

@section('script')

<script>
    $(document).ready(function()
    {
        $('.department').select2({ 
            dropdownParent: $('#crud-modal') 
        }); 

        $('#new').click(function () {
            $('#crud-modal').modal('show');
        });

    });

    $("form.delete_form").submit(function(e){
        e.preventDefault();
        var form = $(this);
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        })
        .then((willDelete) => {
            if (willDelete) {
                    form[0].submit();
                    Swal.fire({ text: "Successfully delete the data.", icon: 'success'
                });
            } 
        });
    });
</script>

@endsection
