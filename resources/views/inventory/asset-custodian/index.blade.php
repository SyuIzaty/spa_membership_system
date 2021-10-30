@extends('layouts.admin')
{{-- <style>
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
</style> --}}
@section('content')
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-adjust'></i>ASSET MANAGER
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        ASSET MANAGER <span class="fw-300"><i>LIST</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        @if (Session::has('message'))
                            <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('message') }}</div>
                        @endif
                        @if (Session::has('notification'))
                            <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('notification') }}</div>
                        @endif
                        <div class="table-responsive">
                            <table id="ast" class="table table-bordered table-hover table-striped w-100">
                                <thead>
                                    <tr class="text-center bg-primary-50">
                                        <th>NO.</th>
                                        <th>DEPARTMENT</th>
                                        <th>TOTAL MANAGER</th>
                                        <th>ACTION</th>
                                    </tr>
                                    <tr>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Department"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Total Manager"></td>
                                        <td class="hasinput"></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($department as $depart)
                                    <tr class="text-center">
                                        <td>{{ $no++}}</td>
                                        <td>{{ strtoupper($depart->department_name) }}</td>
                                        <td style="font-size: 30px; color: rgb(0, 0, 0); text-align: center; font-style: italic; font-family: fantasy;">{{ $depart->total }}</td>
                                        <td><div class="btn-group">
                                            <form action="{{route('deleteDepartment', $depart->id)}}" method="POST" class="delete_form"> 
                                                @method('DELETE')  
                                                @csrf
                                                <a href="/custodian-list/{{$depart->id}}" class="btn btn-sm btn-warning"><i class="fal fa-pencil"></i></a>
                                                <button type="submit" class="btn btn-danger btn-sm delete-alert"><i class="fal fa-trash"></i></button>               
                                            </form>
                                        </div></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
                            <td colspan="4"><input value="{{ old('department_name') }}" class="form-control" id="department_name" name="department_name" required>
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

        $('#ast thead tr .hasinput').each(function(i)
        {
            $('input', this).on('keyup change', function()
            {
                if (table.column(i).search() !== this.value)
                {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });

            $('select', this).on('keyup change', function()
            {
                if (table.column(i).search() !== this.value)
                {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });

        var table = $('#ast').DataTable({
            columnDefs: [],
                orderCellsTop: true,
                "order": [[ 0, "asc" ]],
                "initComplete": function(settings, json) {
                }
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
            if (willDelete.value) {
                    form[0].submit();
                    Swal.fire({ text: "Successfully delete the data.", icon: 'success'
                });
            } 
        });
    });
</script>

@endsection
