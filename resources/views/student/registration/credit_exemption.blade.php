@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2 style="font-size: 25px;">
                        Credit Exemption <small>| list of credit exemption</small> <span class="fw-300"><i> </i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        {{-- <div class="pull-right mb-4">
                        </div> --}}

                        <div class="alert alert-warning alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fal fa-info"></i> Message</h5>
                            Please check your credit exemption details. If have an errors, please consult your academic advisor or faculty
                        </div> 

                        <div class="card-header">
                            <h5 class="card-title w-100">CREDIT EXEMPTION REGISTERED</h5>
                        </div><br>

                        <table id=" " class="table table-bordered table-hover table-striped w-100">
                            <thead>
                                <tr class="bg-highlight">
                                    <th>Course Code</th>
                                    <th>Course Name</th>
                                    <th>Credit</th>
                                    <th>Session</th>
                                </tr>
                                <tr>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Course Code"></td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Course Name"></td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Credit"></td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Session"></td>
                                </tr>
                            </thead>
                            <tbody>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                            </tbody>

                        </table>
                    </div>

                    <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex  pull-right">
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
        $('#course_exemp thead tr .hasinput').each(function(i)
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


        var table = $('#course_exemp').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/data-allCourse_exemp",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { data: '', name: '' },
                    { data: '', name: '' },
                    { data: '', name: '' },
                    { data: '', name: '' },
                    // { data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 1, "asc" ]],
                "initComplete": function(settings, json) {

                }
        });

        // $('#course_exemp').on('click', '.btn-delete[data-remote]', function (e) {
        //     e.preventDefault();
        //     $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         }
        //     });
        //     var url = $(this).data('remote');
        //     Swal.fire({
        //         title: 'Are you sure?',
        //         text: "You won't be able to revert this!",
        //         icon: 'warning',
        //         showCancelButton: true,
        //         confirmButtonColor: '#3085d6',
        //         cancelButtonColor: '#d33',
        //         confirmButtonText: 'Yes, delete it!'
        //     }).then((result) => {
        //         if (result.value) {
        //             var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        //             $.ajax({
        //             url: url,
        //             type: 'DELETE',
        //             dataType: 'json',
        //             data: {method: '_DELETE', submit: true}
        //             }).always(function (data) {
        //                 $('#course_exemp').DataTable().draw(false);
        //             });
        //         }
        //     })
        // });


    });

</script>

@endsection
