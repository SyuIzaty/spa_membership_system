@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content">
    {{-- <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">SmartAdmin</a></li>
        <li class="breadcrumb-item">Datatables</li>
        <li class="breadcrumb-item active">ColumnFilter</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol> --}}
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-table'></i>Students with Null Name<!--span class='fw-300'>ColumnFilter</span> <sup class='badge badge-primary fw-500'>ADDON</sup-->
            <!--small>
                Create headache free searching, sorting and pagination tables without any complex configuration
            </small-->
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Student <span class="fw-300"><i>List</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <!--div class="panel-tag">
                            This example demonstrates FixedHeader being used with individual column filters, placed into a second row of the table's header (using <code>$().clone()</code>).
                        </div-->
                        <!-- datatable start -->


                        <table id="students" class="table table-bordered table-hover table-striped w-100">
                            <thead class="bg-highlight">
                                <tr>
                                    <th>StudentID</th>
                                    <th>Student Name</th>
                                    <th>Program</th>
                                    <th>Sponsor</th>
                                    <th>Status</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>IC</th>
                                    <th>Gender</th>
                                    <th>Action</th>
                                </tr>

                                {{-- <tr>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search StudentID"></td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Student Name"></td>
                                    <td class="hasinput">
                                        <select id="program" name="program" class="form-control">
                                            <option value="">Search Program</option>
                                            @foreach($programs as $p)
                                                <option value="{{$p->prog_code}}">{{$p->prog_code}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Campus"></td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Part"></td>
                                    <td class="hasinput">
                                        <select id="group" name="group" class="form-control">
                                            <option value="">Search Group</option>
                                            @foreach($groups as $g)
                                                <option value="{{$g->name}}">{{$g->name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Phone"></td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Process Status"></td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search HEA Status"></td>
                                    <td class="hasinput"></th>
                                </tr> --}}
                            </thead>
                            <tbody>

                            </tbody>

                        </table>
                        <!-- datatable end -->
                    </div>
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

        // $('#studentactive thead tr .hasinput').each(function(i)
        // {
        //     $('input', this).on('keyup change', function()
        //     {
        //         if (table.column(i).search() !== this.value)
        //         {
        //             table
        //                 .column(i)
        //                 .search(this.value)
        //                 .draw();
        //         }
        //     });

        //     $('select', this).on('keyup change', function()
        //     {
        //         if (table.column(i).search() !== this.value)
        //         {
        //             table
        //                 .column(i)
        //                 .search(this.value)
        //                 .draw();
        //         }
        //     });
        // });


        var table = $('#students').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/data_studentWithNullName",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { data: 'sm_student_id', name: 'sm_student_id'},
                    { data: 'sm_student_name', name: 'sm_student_name' },
                    { data: 'sm_program_code', name: 'sm_program_code' },
                    { data: 'sm_sponsor', name: 'sm_sponsor' },
                    { data: 'sm_status', name: 'sm_status' },
                    { data: 'sm_mobile_no', name: 'sm_mobile_no' },
                    { data: 'sm_email', name: 'sm_email' },
                    { data: 'sm_ic_no', name: 'sm_ic_no'},
                    { data: 'sm_gender', name: 'sm_gender'},
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 1, "asc" ]],
                "initComplete": function(settings, json) {


                }
        });

    });

</script>


@endsection
