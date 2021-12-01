@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-folder-open' style="text-transform: uppercase"></i> #{{ $evaluate->id }} : {{ $evaluate->evaluation }} 
        </h1>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        {{-- EvaluationID : #{{ $evaluate->id }} --}}
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>

                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 mb-4">
                                <div class="card card-primary card-outline mb-4">
                                    <div class="card-header">
                                        <h5 class="card-title w-100"><i class="fal fa-cube width-2 fs-xl"></i> NEW HEADER </h5>
                                    </div>
                                    <div class="card-body m-3">
                                        @if ($result < 1)
                                            {!! Form::open(['action' => 'TrainingController@storeHeader', 'method' => 'POST'])!!}
                                                <table class="table table-bordered text-center" id="head_field">
                                                    <tr class="bg-primary-50">
                                                        <td>Question Header</td>
                                                        <td>Color</td>
                                                        <td>Action</td>
                                                    </tr>
                                                    <tr>
                                                        <input type="hidden" name="te_id" value="{{ $id }}">
                                                        <td><input type="text" name="head[]" placeholder="Question Header" class="form-control head" required/></td>
                                                        <td style="width: 20%"><input type="color" value="#ffffff" class="form-control" id="color" name="color[]" required></td>
                                                        <td><button type="button" name="addhead" id="addhead" class="btn btn-success btn-sm"><i class="fal fa-plus"></i></button></td>
                                                    </tr>
                                                </table>
                                                <div class="footer">
                                                    <button type="submit" class="btn btn-primary ml-auto float-right" name="submit" id="submithead"><i class="fal fa-save"></i> Save</button>
                                                    <a href="/evaluation-question" class="btn btn-success ml-auto float-right mr-2" ><i class="fal fa-arrow-alt-left"></i> Back</a>
                                                </div>
                                                <br><br>
                                            {!! Form::close() !!}
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-6 mb-4">
                                <div class="card card-primary card-outline mb-4">
                                    <div class="card-header">
                                        <h5 class="card-title w-100"><i class="fal fa-cube width-2 fs-xl"></i> HEADER LIST 
                                            @if($evaluation->first())
                                                <a data-page="/question-pdf/{{ $id }}" class="float-right" style="cursor: pointer" onclick="Print(this)"><i class="fal fa-file-pdf" style="color: red; font-size: 20px"></i></a>
                                            @endif
                                        </h5>
                                    </div>
                                    <div class="card-body m-3">
                                        @if (Session::has('message'))
                                            <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('message') }}</div>
                                        @endif
                                        <table class="table table-bordered headedit" id="headedit">
                                            <thead class="bg-primary-50 text-center">
                                                <tr>
                                                    <td style="width: 5px">No</td>
                                                    <td>Question Header</td>
                                                    <td>Color</td>
                                                </tr>
                                            </thead>
                                            <tbody data-eid="{{ $id }}">
                                                @foreach ($evaluation as $eval)
                                                <tr class="data-row">
                                                    <td>{{ isset($eval->sequence) ? $eval->sequence : $loop->iteration }}</td>
                                                    <td class="quest_id" style="display: none">{{ $eval->id }}</td>
                                                    <td class="question">{{ $eval->question_head }}</td>
                                                    <td style="display:none" id={{ $eval->sequence }}>{{ $eval->sequence }}</td>
                                                    <td style="display:none">{{ $eval->trainingEvaluationQuestions->count() }}</td>
                                                    <td style="display:none">{{ $result }}</td>
                                                    <td class="category_color" data-selected="{{ $eval->color }}"></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                @foreach ($evaluation as $count => $eval)
                                <div class="accordion accordion-outline" id="js_demo_accordion-3">
                                    <div class="card">
                                        <div class="card-header">
                                            <a href="javascript:void(0);" class="card-title collapsed" data-toggle="collapse" data-target="#org{{$eval->sequence}}" aria-expanded="true">
                                                <i class="fal fa-list-ul width-2 fs-xl"></i>
                                                {{ strtoupper($eval->question_head) }}
                                                <span class="ml-auto">
                                                    <span class="collapsed-reveal">
                                                        <i class="fal fa-minus fs-xl"></i>
                                                    </span>
                                                    <span class="collapsed-hidden">
                                                        <i class="fal fa-plus fs-xl"></i>
                                                    </span>
                                                </span>
                                            </a>
                                        </div>
                                        <div id="org{{$eval->sequence}}" class="collapse {{ ($eval->sequence == '1' ? 'show' : '') }}" data-parent="#org{{$eval->sequence}}">
                                            <div class="card-body">
                                                @if($result < 1)
                                                    {!! Form::open(['action' => 'TrainingController@storeQuestion', 'method' => 'POST'])!!}
                                                        <table class="table table-bordered text-center" id="question_field{{ $eval->id }}">
                                                            <tr class="bg-primary-50 text-center">
                                                                <td>Question</td>
                                                                <td>Type</td>
                                                                <td>Action</td>
                                                            </tr>
                                                            <tr class="data-row">
                                                                <input type="hidden" name="te_id" value="{{ $eval->evaluation_id }}" id="te_id">
                                                                <input type="hidden" name="ques_head" value="{{ $eval->id}}">
                                                                <td><input type="text" name="question[]" placeholder="Question" class="form-control question" required/></td>
                                                                <td>
                                                                    <select class="form-control ques_type" name="eval_rate[]" required>
                                                                        <option value="" disabled selected>Please Select</option>
                                                                        <option value="R">Rating</option>
                                                                        <option value="C">Comment</option>
                                                                    </select>
                                                                </td>
                                                                <td><button type="button" name="addquestion" class="btn btn-success btn-sm addquestion" data-id="{{ $eval->id }}"><i class="fal fa-plus"></i></button></td>
                                                            </tr>
                                                        </table>
                                                        <div class="footer">
                                                            <button type="submit" class="btn btn-primary ml-auto float-right submitQuestion" name="submit"><i class="fal fa-save"></i> Save</button>
                                                        </div>
                                                        <br><br>
                                                    {!! Form::close() !!}
                                                @endif
                                                <table class="table table-bordered editable mt-5 w-100" id="editable">
                                                    <thead class="bg-primary-50">
                                                        <tr>
                                                            <td style="width: 5px">No</td>
                                                            <td style="width: 900px">Question</td>
                                                            <td>Type</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody data-teid="{{ $eval->evaluation_id }}">
                                                        @foreach ($eval->trainingEvaluationQuestions as $question)
                                                            <tr class="data-row">
                                                                <td>{{ isset($question->sequence) ? $question->sequence : $loop->iteration }}</td>
                                                                <td class="quest_id" style="display:none">{{ $question->id }}</td>
                                                                <td class="question">{{ $question->question }}</td>
                                                                <td style="display:none" id={{ $question->sequence }}>{{ $question->sequence }}</td>
                                                                <td class="eval_rate_select" data-selected="{{ $question->eval_rate }}"></td>
                                                                <td style="display:none">{{ $question->trainingEvaluationResults->count() }}</td>
                                                                <td style="display:none">{{ $result }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
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

    $(document).ready(function() 
    {
        $('#status, .ques_type, .eval_rate').select2();

        // Start Question
            $('.addquestion').click(function(){
                var id = $(this).attr("data-id");
                i++;
                $('#question_field'+id).append(`
                <tr id="row${i}" class="head-added">
                    <td><input type="text" name="question[]" placeholder="Question" class="form-control question" required/></td>
                    <td>
                        <select class="form-control ques_type" name="eval_rate[]" required>
                            <option disabled selected>Please Select</option>
                            <option value="R">Rating</option>
                            <option value="C">Comment</option>
                        </select>
                    </td>
                    <td><button type="button" name="remove" id="${i}" class="btn btn-sm btn-danger btn_remove"><i class="fal fa-trash"></i></button></td>
                </tr>
                `);
                $('.ques_type').select2();
            });
        //End Question

        // Start Header
            $('#addhead').click(function(){
                i++;
                $('#head_field').append(`
                <tr id="row${i}" class="head-added">
                <td><input type="text" name="head[]" placeholder="Question Header" class="form-control head" required/></td>
                <td><input type="color" value="#ffffff" class="form-control" id="color" name="color[]" required></td>
                <td><button type="button" name="remove" id="${i}" class="btn btn-sm btn-danger btn_remove"><i class="fal fa-trash"></i></button></td>
                </tr>
                `);
                // $('.eval_rate').select2();
            });

            var postURL = "<?php echo url('addmore'); ?>";
            var i=1;

            $.ajaxSetup({
                headers:{
                'X-CSRF-Token' : $("input[name=_token]").val()
                }
            });

            $(document).on('click', '.btn_remove', function(){
                var button_id = $(this).attr("id");
                $('#row'+button_id+'').remove();
            });

            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        // End Header

        // Start Question
            $('.editable').Tabledit({
                url:'{{ route("updateQuestion") }}',
                dataType:"json",
                columns:{
                    identifier:[1, 'id'],
                    editable:[[2, 'question'],[4,'eval_rate']]
                },
                restoreButton:false,

                onSuccess:function(data, textStatus, jqXHR){
                    console.log(data);
                    if(data.action == 'delete'){
                        $('#'+data.id).remove();
                    }
                    location.reload();
                }
            });

            $('.eval_rate_select').each(function(){
                var selected = $(this).data('selected');
                var select = `<input type="hidden" name="eval_rate" data-type="changed" class="select" value="${selected}"><select class="eval_rate form-control">
                                        <option value="R">Rating</option>
                                        <option value="C">Comment</option>
                                </select>`;
                $(this).html(select);
                $(this).children('select').val(selected).change();
            });

            $('.eval_rate').on('change',function(){
                var selected = $(this).val();
                $(this).siblings('.select').val(selected);
            });

            $('.tabledit-edit-button').on('click',function(){
                $('input[data-type="changed"]').each(function(){
                    if($(this).hasClass('tabledit-input')){
                        $(this).removeClass('tabledit-input');
                    }
                });
                $(this).closest('tr').find('.select').addClass('tabledit-input');
            });

            $('.eval_rate').select2();

            $('.editable').find('tr').each(function() {
                var $tds = $(this).find('td'),
                all = $tds.eq(5).text();
                result = $tds.eq(6).text();
                if(all >= 1){
                    $tds.eq(7).html("<p class='badge border border-danger text-danger'>Exist</p>");
                }
                if(result >= 1){
                    $tds.eq(7).html("<p class='badge border border-danger text-danger'>Exist</p>");
                }
            });
        // End Question

        // Start Header
            $('.headedit').Tabledit({
                url:'{{ route("updateHeader") }}',
                dataType:"json",
                columns:{
                    identifier:[1, 'id'],
                    editable:[[2, 'question'],[5, 'color']]
                },
                restoreButton:false,

                onSuccess:function(data, textStatus, jqXHR){
                    if(data.action == 'delete'){
                        $('#'+data.id).remove();
                    }
                    location.reload();
                }
            });
            
            $('.category_color').each(function(){
                var selected = $(this).data('selected');
                var color = `<input type="hidden" name="color" data-type="changed" class="select_color" value="${selected}"><input type="color" class="color form-control" value="${selected}">`;
                $(this).html(color);
                $(this).children('select').val(selected).change();
            });

            $('.color').on('change',function(){
                var selected = $(this).val();
                $(this).siblings('.select_color').val(selected);
            });

            $('.tabledit-edit-button').on('click',function(){
                $('input[data-type="changed"]').each(function(){
                    if($(this).hasClass('tabledit-input')){
                        $(this).removeClass('tabledit-input');
                    }
                });
                $(this).closest('tr').find('.select,.select_color').addClass('tabledit-input');
            });

            $('table.editable thead').each(function(){
                $(this).find('tr:eq(1)').each(function(){
                    $(this).children('td').eq(3).html('');
                });
            });

            $('#editable tbody').sortable({
                placeholder : "ui-state-highlight",
                opacity: 0.9,
                update: function(event, ui)
                {
                    var te_id = $(this).data('teid');
                    var sequence = new Array();
                    $(this).children('tr').each(function(){
                        sequence.push($(this).attr('id'));
                    });

                    $.ajax({
                        url:'{{ route("reorderQuestion") }}',
                        method:"POST",
                        data:{sequence:sequence, action:'update',te_id:te_id},
                        success:function()
                        {
                            location.reload();
                        }
                    })
                }
            });

            $('.headedit').find('tr').each(function() {
                var $tda = $(this).find('td'),
                total = $tda.eq(5).text();
                result = $tda.eq(6).text();
                if(total >= 1){
                    $tda.eq(8).html("<p class='badge border border-danger text-danger'>Exist</p>");
                }
                if(result >= 1){
                    $tda.eq(8).html("<p class='badge border border-danger text-danger'>Exist</p>");
                }
            })

            $('#headedit tbody').sortable({
                placeholder : "ui-state-highlight",
                opacity: 0.9,
                update: function(event, ui)
                {
                    var e_id = $(this).data('eid');
                    var sequence = new Array();

                    $(this).children('tr').each(function(){
                        sequence.push($(this).attr('id'));
                    });

                    $.ajax({
                        url:'{{ route("reorderHeader") }}',
                        method:"POST",
                        data:{sequence:sequence, action:'update', e_id:e_id},
                        success:function()
                        {
                            location.reload();
                        }
                    })
                }
            });
        // End Header

        $(document).on('click', '.btn_remove', function(){
            var button_id = $(this).attr("id");
            $('#row'+button_id+'').remove();
        });

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#submit').click(function(){
            $.ajax({
                url:postURL,
                method:"POST",
                data:$('#add_name').serialize(),
                type:'json',
                success:function(data)
                {
                    if(data.error){
                        printErrorMsg(data.error);
                    }else{
                        i=1;
                        $('.dynamic-added').remove();
                    }
                }
            });
        });

        $('#submithead').click(function(){
            $.ajax({
                url:postURL,
                method:"POST",
                data:$('#add_name').serialize(),
                type:'json',
                success:function(data)
                {
                    if(data.error){
                        printErrorMsg(data.error);
                    }else{
                        i=1;
                        $('.head-added').remove();
                    }
                }
            });
        });

        $('.submitQuestion').click(function(){
            $.ajax({
                url:postURL,
                method:"POST",
                data:$('#add_name').serialize(),
                type:'json',
                success:function(data)
                {
                    if(data.error){
                        printErrorMsg(data.error);
                    }else{
                        i=1;
                        $('.head-added').remove();
                    }
                }
            });
        });
       
        function printErrorMsg (msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display','block');
            $(".print-success-msg").css('display','none');
            $.each( msg, function( key, value ) {
            $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
            });
        }

        $('.tabledit-view-mode').find('select').each(function(){
            $(this).attr('disabled','disabled');
        });

        $('.tabledit-view-mode').find('.color').each(function(){
            $(this).attr('disabled','disabled');
        });

        $('.tabledit-edit-button').on('click',function(){
            if($(this).hasClass('active')){
                $(this).parents('tr').find('select').attr('disabled','disabled');
                $(this).parents('tr').find('.color').attr('disabled','disabled');
            }else{
                $(this).parents('tr').find('select').removeAttr('disabled');
                $(this).parents('tr').find('.color').removeAttr('disabled');
            }
        });

        $('.tabledit-save-button').on('click',function(){
            $(this).parents('tr').find('select').attr('disabled','disabled');
            $(this).parents('tr').find('.color').attr('disabled','disabled');
        })

    });

    function Print(button)
    {
        var url = $(button).data('page');
        var printWindow = window.open( '{{url("/")}}'+url+'', 'Print', 'left=200, top=200, width=950, height=500, toolbar=0, resizable=0');
        printWindow.addEventListener('load', function(){
            printWindow.print();
        }, true);
    }

</script>

@endsection
