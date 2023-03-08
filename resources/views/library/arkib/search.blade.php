@extends('layouts.admin')
@section('content')
<style>
    .card thead {
        display: none;
    }
    .card tbody tr {
        float: left;
        width: 36.46rem;
        margin: 0.5rem;
        border: 0.0625rem solid rgba(0,0,0,.125);
        border-radius: .25rem;
        box-shadow: 0.25rem 0.25rem 0.5rem rgba(0,0,0,0.25);
    }
    .card tbody td {
        display: block;
    }
    .table tbody label {
        display: none;
    }
    .card tbody label {
        display: inline;
        position: relative;
        font-size: 85%;
        top: -0.5rem;
        float: left;
        color: #808080;
        min-width: 4rem;
        margin-left: 0;
        margin-right: 1rem;
        text-align: left;
    }
    tr.selected label {
        color: #404040;
    }
    
    .table .fa {
        font-size: 2.5rem;
        text-align: center;
    }
    .cards .fa {
        font-size: 7.5rem;
    }
    
</style>
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i> Arkib
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>List of Arkib Paper</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            <div class="col-md-12">
                                <div class="table-responsive mt-2">
                                    <table class="table table-bordered card" id="paper" style="width:100%; border:none">
                                        <thead>
                                            <tr class="bg-primary-50 text-center" style="display:none">
                                                <th>Title</th>
                                                <th>File Classification No</th>
                                                <th>Department</th>
                                                <th>Date</th>
                                                <th>ACTION</th>
                                            </tr>
                                            <tr>
                                                <td class="hasinput"><input type="text" class="form-control" placeholder="Search Title"></td>
                                                <td class="hasinput"><input type="text" class="form-control" placeholder="Search File Classification No"></td>
                                                <td class="hasinput"><input type="text" class="form-control" placeholder="Search Department"></td>
                                                <td class="hasinput"><input type="text" class="form-control" placeholder="Search Date"></td>
                                                <td class="hidden"></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade editModal" id="editModal" aria-hidden="true" >
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Detail</h4>
                                </div>
                                <div class="modal-body">
                                  <table class="table w-10">
                                    <tr>
                                      <td>Title</td>
                                      <td id="arkib_title"></td>
                                    </tr>
                                    <tr>
                                      <td>File Classification No</td>
                                      <td id="arkib_classification"></td>
                                    </tr>
                                    <tr>
                                      <td>Description</td>
                                      <td id="arkib_description"></td>
                                    </tr>
                                    <tr>
                                      <td>Department</td>
                                      <td id="arkib_department"></td>
                                    </tr>
                                    <tr>
                                      <td>Status</td>
                                      <td id="arkib_status"></td>
                                    </tr>
                                    <tr>
                                      <td>Created At</td>
                                      <td id="arkib_date"></td>
                                    </tr>
                                    <tr>
                                      <td>Uploaded</td>
                                      <td>
                                        <div id="existfile">
                  
                                        </div>
                                      </td>
                                    </tr>
                                  </table>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary btn-sm text-white" data-dismiss="modal">Close</button>
                                </div>
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
    $('#new').click(function () {
        $('#crud-modal').modal('show');
    });

    $('#department_code, #status').select2({
        dropdownParent: $('#crud-modal')
    });

    $(document).ready(function()
    {
        $('#paper thead tr .hasinput').each(function(i)
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
        });
        
    
        var table = $('#paper').DataTable({
            processing: true,
            serverSide: true,
            stateSave: true,
            bSortClasses: false,
            ajax: {
                url: "/data_userarkib",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { data: 'title', className: "card", name: 'title'},
                    { data: 'file_classification_no', name: 'file_classification_no'},
                    { data: 'dept', name: 'department.name'},
                    { data: 'created_at', name: 'created_at'},
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 1, "asc" ]],
                "initComplete": function(settings, json) {
                    var labels = [];
                    // $('.dataTables_filter input').unbind();
					$("#paper thead th").each(function () {
                        labels.push($(this).text());
                    });

                },
                "drawCallback": function(settings) {
                    var labels = [];
					$("#paper thead th").each(function () {
                        labels.push($(this).text());
                    });

                    $("#paper tbody tr").each(function () {
						$(this)
							.find("td")
							.each(function (column) {
                                if(labels[column] !== "ACTION") {
                                    $("<span class='colHeader'>" + labels[column] + ": </span>").prependTo(
                                        $(this)
                                    );
                                }
							});
					});
                },
        });

    });

    $.ajaxSetup({
          headers:{
          'X-CSRF-Token' : $("input[name=_token]").val()
          }
      });

      $(document).on('click', '.edit_data', function(){
          var id = $(this).attr("data-id");
          $.ajax({
              url: '{{ url("get-arkib") }}',
              method:"POST",
              data:{id:id},
              dataType:"json",
              success:function(data){
                  $('#arkib_id').html(data.id);
                  $('#arkib_title').html(data.title);
                  $('#arkib_classification').html(data.file_classification_no);
                  $('#arkib_description').html(data.description);
                  $('#arkib_department').html(data.department.name);
                  $('#arkib_status').html(data.arkib_status.arkib_description);
                  $('#arkib_date').html(new Date(data.created_at));
                  $('#existfile').empty();
                  data.arkib_attachments.forEach(function(ele){
                      $('#existfile').append(`
                          <div id="attachment${ele.id}">
                              ${ele.file_name} <a href="/library/arkib/${ele.file_name}" target="_blank">View</a> <br/>
                          </div>
                      `);
                  });
                  $('.editModal').modal('show');
              }
          });
      });

</script>
@endsection
