@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-laptop'></i> Computer Grant Management
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Report</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            <div class="col-sm-6">
                                <button class="btn btn-info dropdown-toggle waves-effect waves-themed" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    @if ($my == "all")
                                        All
                                    @else
                                        Report on {{$my}}
                                    @endif
                                </button>
                                <div class="dropdown-menu" style="">
                                    <a  href="/report/all" class="dropdown-item" name="months" value="All">All</a>
                                    <div class="dropdown-multilevel">
                                        <div class="dropdown-item">
                                        Select
                                        </div>
                                        <div class="dropdown-menu">
                                            @foreach ($monthyear as $m)
                                                <a  href="/report/{{$m}}" class="dropdown-item" name="months" value="{{$m}}">{{ $m}}</a>
                                            @endforeach 
                                        </div>
                                    </div>                                        
                                </div>
                            </div>
                            <br>
                            <div class="table-responsive">
                                <table id="report" class="table table-bordered table-hover table-striped w-100">
                                    <thead>
                                        <tr class="bg-primary-50 text-center">
                                            <th class="text-center">No.</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Staff ID</th>
                                            <th class="text-center">Contact Number</th>
                                            <th class="text-center">Department/Position</th>
                                            <th class="text-center">Application Date</th>
                                            <th class="text-center">Approval Date</th>
                                            <th class="text-center">Purchase Approval Date</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                        <tbody>
                                                <tr>
                                                    <td class="hasinput"></td>
                                                    <td class="hasinput"></td>
                                                    <td class="hasinput"></td>
                                                    <td class="hasinput"></td>
                                                    <td class="hasinput"></td>
                                                    <td class="hasinput"></td>
                                                    <td class="hasinput"></td>
                                                    <td class="hasinput"></td>
                                                    <td class="hasinput"></td>
                                                </tr>
                                        </tbody>                                    
                                </table>
                                @if ($lists->isNotEmpty())
                                    @if ($my == "all")
                                        <a class="btn btn-success float-right" data-page="/Computer-Grant-Report" onclick="Print(this)" style="color: rgb(0, 0, 0); margin-top: 5px; margin-bottom: 15px;">
                                            <i class="fal fa-download"></i> Report
                                        </a>
                                    
                                        @else
                                        <a class="btn btn-success float-right" data-page="/Computer-Grant-Report-{{$my}}" onclick="Print(this)" style="color: rgb(0, 0, 0); margin-top: 5px; margin-bottom: 15px;">
                                            <i class="fal fa-download"></i> Report
                                        </a>
                                    @endif
                                
                                @endif
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('script')
<script>
    function Print(button)
        {
            var url = $(button).data('page');
            var printWindow = window.open( '{{url("/")}}'+url+'', 'Print', 'left=200, top=200, width=950, height=500, toolbar=0, resizable=0');
            printWindow.addEventListener('load', function(){
            printWindow.print();
            }, true);
        }

        $(document).ready(function()
    {
        var my = @json($my);
        var table = $('#report').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/reportList/" + my,
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { className: 'text-center', data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false },
                    { className: 'text-left', data: 'name', name: 'name' },
                    { className: 'text-center', data: 'staff_id', name: 'staff_id' },
                    { className: 'text-center', data: 'hp_no', name: 'hp_no' },
                    { className: 'text-left', data: 'department', name: 'department' },
                    { className: 'text-center', data: 'application', name: 'application' },
                    { className: 'text-center', data: 'approval', name: 'approval' },
                    { className: 'text-center', data: 'purchase', name: 'purchase' },
                    { className: 'text-left', data: 'status', name: 'status' },

                ],
                orderCellsTop: true,
                "order": [[ 1, "asc" ]],
                "initComplete": function(settings, json) {

                }
        });
    });

</script>
@endsection
