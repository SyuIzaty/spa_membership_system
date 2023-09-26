@extends('layouts.admin')

@section('content')

<style>
    .nav-link {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: inline-block;
        max-width: 100%;
    }
</style>

<main id="js-page-content" role="main" class="page-content">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-bed'></i> VOTING SETTING MANAGEMENT
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        <span class="fw-300 mr-1">MANAGE</span><span class="mr-4">{{ strtoupper($vote->name) }}</span>
                        @if (\Carbon\Carbon::now() > \Carbon\Carbon::parse($vote->end_date))
                            <b style="color:red">[ Outdated Duration :
                                Start Date : {{ isset($vote->start_date) ? \Carbon\Carbon::parse($vote->start_date)->format('d-m-Y | h:i A') : '' }}
                                -
                                End Date : {{ isset($vote->end_date) ? \Carbon\Carbon::parse($vote->end_date)->format('d-m-Y | h:i A') : '' }} ]
                            </b>
                        @elseif (\Carbon\Carbon::now() >= \Carbon\Carbon::parse($vote->start_date) && \Carbon\Carbon::now() <= \Carbon\Carbon::parse($vote->end_date))
                            <b style="color:green">[ Active Duration :
                                Start Date : {{ isset($vote->start_date) ? \Carbon\Carbon::parse($vote->start_date)->format('d-m-Y | h:i A') : '' }}
                                -
                                End Date : {{ isset($vote->end_date) ? \Carbon\Carbon::parse($vote->end_date)->format('d-m-Y | h:i A') : '' }} ]
                            </b>
                        @else
                            <b>[ Upcoming Duration :
                                Start Date : {{ isset($vote->start_date) ? \Carbon\Carbon::parse($vote->start_date)->format('d-m-Y | h:i A') : '' }}
                                -
                                End Date : {{ isset($vote->end_date) ? \Carbon\Carbon::parse($vote->end_date)->format('d-m-Y | h:i A') : '' }} ]
                            </b>
                        @endif
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        @if (count($vote->categories) > 0)
                            @if (Session::has('message'))
                                <div class="alert alert-success" style="color: #3b6324;"> <i class="icon fal fa-check-circle mr-2"></i> {{ Session::get('message') }}</div>
                            @endif
                            <div class="row">
                                <div class="col-sm-12 col-xl-2">
                                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                        @foreach($vote->categories as $key => $category)
                                            <a class="nav-link mb-2 {{ $key === 0 ? 'active' : '' }}" id="category-tab-{{ $category->id }}" data-toggle="pill" href="#category-pane-{{ $category->id }}" role="tab" aria-controls="category-pane-{{ $category->id }}" aria-selected="{{ $key === 0 ? 'true' : 'false' }}" style="border: 1px solid;">
                                                <i class="fal fa-cube"></i>
                                                <span class="hidden-sm-down ml-1"> {{ $category->category_name }}</span>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-sm-12 col-xl-10">
                                    <div class="tab-content" id="v-pills-tabContent">
                                        @foreach($vote->categories as $key => $category)
                                            <div class="tab-pane fade {{ $key === 0 ? 'show active' : '' }}" id="category-pane-{{ $category->id }}" role="tabpanel" style="margin-top: -30px"><br>
                                                <div class="panel-container show">
                                                    <div class="panel-content">
                                                        <div class="col-sm-12 col-md-12" style="margin-top:-5px">
                                                            <div class="card card-primary card-outline">
                                                                <div class="card-header">
                                                                    <h1 class="subheader-title w-100"><i class="fal fa-cube width-2 fs-xxl"></i> CATEGORY : {{ $category->category_name }}</h1>
                                                                    @php
                                                                        $existInProgramme = \App\EvmProgramme::where('category_id', $category->id)->first();
                                                                    @endphp
                                                                    @if (strtotime(Carbon\Carbon::now()) < strtotime($vote->start_date))
                                                                        <div class="float-right" style="margin-top:-28px">
                                                                            <a href="" data-target="#crud-modal-categories" data-toggle="modal" data-id="{{ $category->id }}" data-name="{{ $category->category_name }}"
                                                                            data-description="{{ $category->category_description }}" class="btn btn-xs btn-warning"><i class="fal fa-pencil"></i></a>
                                                                            @if (!isset($existInProgramme))
                                                                                <form method="POST" action="/voting-setting-delete/{{ $category->id }}" style="display: inline;">
                                                                                    @csrf
                                                                                    @method('DELETE')
                                                                                    <button type="submit" class="btn btn-xs btn-danger btn-delete"><i class="fal fa-trash"></i></button>
                                                                                </form>
                                                                            @endif
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <div class="card-body">
                                                                    @if(count($category->programmes) > 0)
                                                                        <div class="col-md-12 col-sm-12">
                                                                            <div class="card mb-g border shadow-0">
                                                                                <style>
                                                                                    .glow {
                                                                                    font-size: 12px;
                                                                                    text-align: center;
                                                                                    animation: glow 1s ease-in-out infinite alternate;
                                                                                    }

                                                                                    @-webkit-keyframes glow {
                                                                                    from {
                                                                                        text-shadow: 0 0 5px #fff, 0 0 5px #fff, 0 0 5px #039912, 0 0 5px #039912, 0 0 5px #039912, 0 0 5px #039912, 0 0 5px #039912;
                                                                                    }

                                                                                    to {
                                                                                        text-shadow: 0 0 5px #fff, 0 0 5px #039912, 0 0 5px #039912, 0 0 5px #039912, 0 0 5px #039912, 0 0 5px #039912, 0 0 5px #039912;
                                                                                    }
                                                                                    }
                                                                                </style>
                                                                                @foreach($category->programmes as $key => $programmes)
                                                                                    <div class="card border shadow-0">
                                                                                        <div class="card-body p-0">
                                                                                            <div class="row no-gutters row-grid">
                                                                                                <div class="col-12">
                                                                                                    <div class="row no-gutters row-grid align-items-stretch  bg-primary-50"  >
                                                                                                        <div class="col-md">
                                                                                                            <div class="p-3">
                                                                                                                <div class="d-flex">
                                                                                                                    <span class="icon-stack display-4 mr-3 flex-shrink-0" style="font-size:30px">
                                                                                                                        <i class="base-2 icon-stack-3x color-primary-400"></i>
                                                                                                                        <i class="base-10 text-white icon-stack-1x"></i>
                                                                                                                        <i class="fal fa-book color-primary-800 icon-stack-2x"></i>
                                                                                                                    </span>
                                                                                                                    <div class="d-inline-flex flex-column">
                                                                                                                        <a href="#" class="fs-lg fw-500 d-block mt-1" style="color: purple">
                                                                                                                            PROGRAMME : <b>{{ $programmes->programme->programme_name}}</b>
                                                                                                                        </a>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                @php
                                                                                                                    $existInCandidate = \App\EvmCandidate::where('programme_id', $programmes->id)->first();
                                                                                                                @endphp
                                                                                                                @if (strtotime(Carbon\Carbon::now()) < strtotime($vote->start_date))
                                                                                                                    <div class="float-right" style="margin-top:-28px">
                                                                                                                        <a href="" data-target="#crud-modal-programmes" data-toggle="modal" data-id="{{ $programmes->id }}" data-programme="{{ $programmes->programme_code }}"
                                                                                                                        data-min="{{ $programmes->min_vote }}" data-max="{{ $programmes->max_vote }}" class="btn btn-xs btn-warning"><i class="fal fa-pencil"></i></a>
                                                                                                                        @if (!isset($existInCandidate))
                                                                                                                            <form method="POST" action="/voting-programme-delete/{{ $programmes->id }}" style="display: inline;">
                                                                                                                                @csrf
                                                                                                                                @method('DELETE')
                                                                                                                                <button type="submit" class="btn btn-xs btn-danger btn-delete"><i class="fal fa-trash"></i></button>
                                                                                                                            </form>
                                                                                                                        @endif
                                                                                                                    </div>
                                                                                                                @endif
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="col-4 col-md-2 col-xl-1 hidden-md-down">
                                                                                                            <div class="p-3 p-md-3" align="center">
                                                                                                                <a href="javascript:void(0);" class="card-title collapsed text-white" data-toggle="collapse" data-target="#prog_{{ $key }}" aria-expanded="true">
                                                                                                                    <span class="ml-auto">
                                                                                                                        <span class="collapsed-reveal mt-1">
                                                                                                                            <i class="fal fa-minus fs-xl"></i>
                                                                                                                        </span>
                                                                                                                        <span class="collapsed-hidden mt-1">
                                                                                                                            <i class="fal fa-plus fs-xl"></i>
                                                                                                                        </span>
                                                                                                                    </span>
                                                                                                                </a>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div id="prog_{{ $key }}" class="collapse show">
                                                                                                        <div class="card-body">
                                                                                                            <div class="alert alert-danger alert-dismissible fade show">
                                                                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                                                                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                                                                                                                </button>
                                                                                                                <div class="d-flex align-items-center">
                                                                                                                    <div class="flex-1 pl-1">
                                                                                                                        The <b>VERIFICATION</b> checkbox will become visible after the voting end date and remain available for 3 days based on the configured time settings.
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div class="col-12" data-programme-id="{{ $programmes->id }}">
                                                                                                                <table class="table table-bordered table-hover table-striped w-100 candidate-table">
                                                                                                                    <thead>
                                                                                                                        <tr class="text-center" style="white-space: nowrap; background-color:#f7f9fa">
                                                                                                                            <th style="width:30px">NO</th>
                                                                                                                            <th>IMAGE</th>
                                                                                                                            <th>ID</th>
                                                                                                                            <th>NAME</th>
                                                                                                                            {{-- <th>TAGLINE</th> --}}
                                                                                                                            <th>CAST VOTE</th>
                                                                                                                            <th>VERIFICATION</th>
                                                                                                                            <th>VOTER</th>
                                                                                                                            @if (strtotime(Carbon\Carbon::now()) < strtotime($vote->start_date))
                                                                                                                                <th>ACTION</th>
                                                                                                                            @endif
                                                                                                                        </tr>
                                                                                                                    </thead>
                                                                                                                </table>
                                                                                                            </div>
                                                                                                            <div class="panel-content mt-2 py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex pull-right">
                                                                                                                @if (strtotime(Carbon\Carbon::now()) < strtotime($vote->start_date))
                                                                                                                    <a href="javascript:;" data-toggle="modal" class="btn btn-primary ml-auto float-right new-candidate" data-programmeid="{{ $programmes->programme_code }}" data-id="{{ $programmes->id }}"><i class="fal fa-plus-square"></i> Add New Candidate</a>
                                                                                                                @endif
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                        <p>No data available to display.</p>
                                                                    @endif
                                                                    <div class="panel-content mt-2 py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex pull-right">
                                                                        @if (strtotime(Carbon\Carbon::now()) < strtotime($vote->start_date))
                                                                            @if(!isset($existInProgramme))
                                                                                <a href="javascript:;" data-toggle="modal" class="btn btn-primary ml-auto float-right new-programme" data-categoryid="{{ $category->id }}"><i class="fal fa-plus-square"></i> Add New Programme</a>
                                                                            @endif
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @else
                            <p>No data available to display.</p>
                        @endif
                        <div class="panel-content mt-2 mr-3 py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex pull-right">
                            <a href="/voting-manage" class="btn btn-success ml-auto float-right" ><i class="fal fa-arrow-alt-left"></i> Back</a>
                            @if (strtotime(Carbon\Carbon::now()) < strtotime($vote->start_date))
                                <a href="javascript:;" data-toggle="modal" id="new-category" class="btn btn-primary ml-2 float-right"><i class="fal fa-plus-square"></i> Add New Category</a>
                            @endif
                        </div>

                        <div class="modal fade" id="crud-modal-category" aria-hidden="true" data-keyboard="false" data-backdrop="static">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="card-title w-100"><i class="fal fa-info width-2 fs-xl"></i> NEW CATEGORY INFO</h5>
                                    </div>
                                    <div class="modal-body">
                                        {!! Form::open(['action' => 'Voting\VotingManagementController@vote_setting_store', 'method' => 'POST']) !!}
                                            <input type="hidden" id="voteId" name="voteId" value="{{$vote->id}}">
                                            <p><span class="text-danger">*</span> Required Field</p>
                                            <div class="form-group">
                                                <td width="10%"><label class="form-label" for="category_name"><span class="text-danger">*</span> Name :</label></td>
                                                <td colspan="4">
                                                    <input class="form-control" id="category_name" name="category_name" value="{{ old('category_name') }}" required>
                                                    @error('category_name')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror
                                                </td>
                                            </div>
                                            <div class="form-group">
                                                <td width="10%"><label class="form-label" for="category_description"> Description :</label></td>
                                                <td colspan="4">
                                                    <textarea rows="3" id="category_description" name="category_description" class="form-control">{{ old('category_description') }}</textarea>
                                                    @error('category_description')
                                                        <p style="color: red">{{ $message }}</p>
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

                        <div class="modal fade" id="crud-modal-categories" aria-hidden="true" data-keyboard="false" data-backdrop="static">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="card-title w-100"><i class="fal fa-info width-2 fs-xl"></i> EDIT CATEGORY INFO</h5>
                                    </div>
                                    <div class="modal-body">
                                        {!! Form::open(['action' => 'Voting\VotingManagementController@vote_setting_update', 'method' => 'POST']) !!}
                                            <input type="hidden" id="ids" name="ids">
                                            <p><span class="text-danger">*</span> Required Field</p>
                                            <div class="form-group">
                                                <td width="10%"><label class="form-label" for="names"><span class="text-danger">*</span> Name :</label></td>
                                                <td colspan="4">
                                                    <input class="form-control" id="names" name="names" required>
                                                    @error('name')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror
                                                </td>
                                            </div>
                                            <div class="form-group">
                                                <td width="10%"><label class="form-label" for="descriptions"> Description :</label></td>
                                                <td colspan="4">
                                                    <textarea rows="3" id="descriptions" name="descriptions" class="form-control"></textarea>
                                                    @error('description')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror
                                                </td>
                                            </div>
                                            <div class="footer">
                                                <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Update</button>
                                                <button type="button" class="btn btn-success ml-auto float-right mr-2" data-dismiss="modal"><i class="fal fa-window-close"></i> Close</button>
                                            </div>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="crud-modal-programme" aria-hidden="true" data-keyboard="false" data-backdrop="static">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="card-title w-100"><i class="fal fa-info width-2 fs-xl"></i> NEW PROGRAMME INFO</h5>
                                    </div>
                                    <div class="modal-body">
                                        {!! Form::open(['action' => 'Voting\VotingManagementController@vote_programme_store', 'method' => 'POST']) !!}
                                            <input type="hidden" id="categoryId" name="categoryId">
                                            <p><span class="text-danger">*</span> Required Field</p>
                                            <div class="form-group">
                                                <td width="10%"><label class="form-label" for="programme_code"><span class="text-danger">*</span> Programme :</label></td>
                                                <td colspan="4">
                                                    <select name="programme_code" id="programme_code" class="form-control" required>
                                                        <option value=""> Please select</option>
                                                        @foreach ($programme as $program)
                                                            <option value="{{ $program->id }}" {{ old('programme_code') ==  $program->id  ? 'selected' : '' }}>
                                                                {{ $program->id }} - {{ $program->programme_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('programme_code')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror
                                                </td>
                                            </div>
                                            {{-- <div class="form-group">
                                                <td width="10%"><label class="form-label" for="min_vote"><span class="text-danger">*</span> Minimum Vote :</label></td>
                                                <td colspan="4">
                                                    <input type="number" value="{{ old('min_vote') }}" class="form-control" id="min_vote" name="min_vote" required>
                                                    @error('min_vote')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror
                                                </td>
                                            </div>
                                            <div class="form-group">
                                                <td width="10%"><label class="form-label" for="max_vote"><span class="text-danger">*</span> Maximum Vote :</label></td>
                                                <td colspan="4">
                                                    <input type="number" value="{{ old('max_vote') }}" class="form-control" id="max_vote" name="max_vote" required>
                                                    @error('max_vote')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror
                                                </td>
                                            </div> --}}
                                            <div class="footer">
                                                <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Save</button>
                                                <button type="button" class="btn btn-success ml-auto float-right mr-2" data-dismiss="modal"><i class="fal fa-window-close"></i> Close</button>
                                            </div>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="crud-modal-programmes" aria-hidden="true" data-keyboard="false" data-backdrop="static">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="card-title w-100"><i class="fal fa-info width-2 fs-xl"></i> EDIT PROGRAMME INFO</h5>
                                    </div>
                                    <div class="modal-body">
                                        {!! Form::open(['action' => 'Voting\VotingManagementController@vote_programme_update', 'method' => 'POST']) !!}
                                            <input type="hidden" id="ids" name="ids">
                                            <p><span class="text-danger">*</span> Required Field</p>
                                            <div class="form-group">
                                                <td width="10%"><label class="form-label" for="programme_codes"><span class="text-danger">*</span> Programme :</label></td>
                                                <td colspan="4">
                                                    <select name="programme_codes" id="programme_codes" class="form-control" required>
                                                        <option value=""> Please select</option>
                                                        @foreach ($programme as $program)
                                                            <option value="{{ $program->id }}">{{ $program->id }} - {{ $program->programme_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('programme_code')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror
                                                </td>
                                            </div>
                                            {{-- <div class="form-group">
                                                <td width="10%"><label class="form-label" for="min_votes"><span class="text-danger">*</span> Minimum Vote :</label></td>
                                                <td colspan="4">
                                                    <input type="number" class="form-control" id="min_votes" name="min_votes" required>
                                                    @error('min_votes')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror
                                                </td>
                                            </div>
                                            <div class="form-group">
                                                <td width="10%"><label class="form-label" for="max_votes"><span class="text-danger">*</span> Maximum Vote :</label></td>
                                                <td colspan="4">
                                                    <input type="number" class="form-control" id="max_votes" name="max_votes" required>
                                                    @error('max_votes')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror
                                                </td>
                                            </div> --}}
                                            <div class="footer">
                                                <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Update</button>
                                                <button type="button" class="btn btn-success ml-auto float-right mr-2" data-dismiss="modal"><i class="fal fa-window-close"></i> Close</button>
                                            </div>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="crud-modal-candidate" aria-hidden="true" data-keyboard="false" data-backdrop="static">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="card-title w-100"><i class="fal fa-info width-2 fs-xl"></i> NEW CANDIDATE INFO</h5>
                                    </div>
                                    <div class="modal-body">
                                        {!! Form::open(['action' => 'Voting\VotingManagementController@vote_candidate_store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                            <input type="hidden" id="id" name="id">
                                            <input type="hidden" id="programmeId" name="programmeId">
                                            <p><span class="text-danger">*</span> Required Field</p>
                                            <div class="form-group">
                                                <td width="10%"><label class="form-label" for="student_id"><span class="text-danger">*</span> Student :</label></td>
                                                <td colspan="4">
                                                    <select name="student_id" id="student_id" class="form-control" required>
                                                        <option value=""> Please select</option>
                                                        @foreach ($student as $students)
                                                            <option value="{{ $students->students_id }}" {{ old('student_id') ==  $students->students_id  ? 'selected' : '' }}>
                                                                {{ $students->students_id }} - {{ $students->students_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('student_id')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror
                                                </td>
                                            </div>
                                            <div class="form-group">
                                                <td width="10%"><label class="form-label" for="student_tagline"><span class="text-danger">*</span> Tagline :</label></td>
                                                <td colspan="4">
                                                    <textarea rows="3" id="student_tagline" name="student_tagline" class="form-control" required>{{ old('student_tagline') }}</textarea>
                                                    @error('student_tagline')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror
                                                </td>
                                            </div>
                                            <div class="form-group">
                                                <td width="10%"><label class="form-label" for="img_name"><span class="text-danger">*</span> Image :</label></td>
                                                <td colspan="4">
                                                    <input type="file" class="form-control" id="img_name" name="img_name" value="{{ old('img_name') }}" accept="image/png,image/jpg,image/jpeg" required>
                                                    @error('img_name')
                                                        <p style="color: red">{{ $message }}</p>
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

                        <div class="modal fade" id="crud-modal-candidates" aria-hidden="true" data-keyboard="false" data-backdrop="static">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="card-title w-100"><i class="fal fa-info width-2 fs-xl"></i> EDIT CANDIDATE INFO</h5>
                                    </div>
                                    <div class="modal-body">
                                        {!! Form::open(['action' => 'Voting\VotingManagementController@vote_candidate_update', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                            <input type="hidden" id="candidateId" name="candidateId">
                                            <p><span class="text-danger">*</span> Required Field</p>
                                            <div class="form-group">
                                                <td width="10%"><label class="form-label" for="student_ids"><span class="text-danger">*</span> Student :</label></td>
                                                <td colspan="4">
                                                    <select name="student_ids" id="student_ids" class="form-control" required disabled>
                                                        <option value=""> Please select</option>
                                                        @foreach ($student as $students)
                                                            <option value="{{ $students->students_id }}">{{ $students->students_id }} - {{ $students->students_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('student_ids')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror
                                                </td>
                                            </div>
                                            <div class="form-group">
                                                <td width="10%"><label class="form-label" for="student_taglines"><span class="text-danger">*</span> Tagline :</label></td>
                                                <td colspan="4">
                                                    <textarea rows="3" id="student_taglines" name="student_taglines" class="form-control" required></textarea>
                                                    @error('student_taglines')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror
                                                </td>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label" for="img_names"> Image :</label>
                                                <div align="center" class="mb-2">
                                                    <a data-fancybox="gallery" href="#" id="imageLink">
                                                        <img id="currentImage" src="/img/default.png" style="width: 120px;height: 120px;border: solid 1px black;" class="img-fluid">
                                                    </a>
                                                    <p style="color: red">( Current Image )</p>
                                                </div>
                                                <input type="file" class="form-control" id="img_names" name="img_names" accept="image/png,image/jpg,image/jpeg">
                                                @error('img_names')
                                                <p style="color: red">{{ $message }}</p>
                                                @enderror
                                            </div>


                                            <div class="footer">
                                                <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Update</button>
                                                <button type="button" class="btn btn-success ml-auto float-right mr-2" data-dismiss="modal"><i class="fal fa-window-close"></i> Close</button>
                                            </div>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
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

    $(document).ready(function()
    {
        $('#new-category').click(function () {
            $('#crud-modal-category').modal('show');
        });

        $('#crud-modal-categories').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var name = button.data('name');
            var description = button.data('description');

            $('.modal-body #ids').val(id);
            $('.modal-body #names').val(name);
            $('.modal-body #descriptions').val(description);
        });

        $('.new-programme').click(function () {
            var categoryId = $(this).data('categoryid');
            $('#categoryId').val(categoryId);
            $('#crud-modal-programme').modal('show');
        });

        $('#programme_code').select2({
            dropdownParent: $('#crud-modal-programme')
        });

        $('#crud-modal-programmes').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var programme = button.data('programme');
            var min = button.data('min');
            var max = button.data('max');

            $('.modal-body #ids').val(id);
            $('.modal-body #programme_codes').val(programme);
            $('.modal-body #min_votes').val(min);
            $('.modal-body #max_votes').val(max);

            $('#programme_codes').select2({
                dropdownParent: $('#crud-modal-programmes')
            });
        });

        $('.new-candidate').click(function () {
            var programmeId = $(this).data('programmeid');
            var id = $(this).data('id');
            $('#programmeId').val(programmeId);
            $('#id').val(id);

            $.ajax({
                url: '/get-candidate/'+programmeId+'/'+id,
                method: 'GET',
                success: function (data) {

                    var studentDropdown = $('#student_id');
                    studentDropdown.empty();

                    studentDropdown.append('<option value="">Please select</option>');

                    $.each(data, function (index, student) {
                        studentDropdown.append('<option value="' + student.students_id + '">' + student.students_id + ' - ' + student.students_name + '</option>');
                    });

                    $('#crud-modal-candidate').modal('show');
                },
                error: function (error) {
                    console.log('Error fetching students:', error);
                }
            });
        });

        $('#student_id').select2({
            dropdownParent: $('#crud-modal-candidate')
        });

        $('#crud-modal-candidates').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var student = button.data('student');
            var tagline = button.data('tagline');
            var image = button.data('image');

            $('.modal-body #candidateId').val(id);
            $('.modal-body #student_ids').val(student);
            $('.modal-body #student_taglines').val(tagline);

            var currentImage = $('.modal-body #currentImage');
            var imageLink = $('.modal-body #imageLink');

            if (image) {
                currentImage.attr('src', '/get-candidate-image/' + image);
                imageLink.attr('href', '/get-candidate-image/' + image);
            } else {
                currentImage.attr('src', '/img/default.png');
                imageLink.attr('href', '#');
            }

            $('.modal-body #img_names').val(null);

            $('#student_ids').select2({
                dropdownParent: $('#crud-modal-candidates')
            });
        });

    });

    $(document).ready(function () {
        $('.candidate-table').each(function () {
            var $table = $(this);

            var table = $table.DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/data-candidate-list",
                    type: 'POST',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    data: function (d) {
                        d.programme_id = $table.closest('.col-12').data('programme-id');
                    }
                },
                columns: [
                    { className: 'text-center align-middle', data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { className: 'text-center align-middle', data: 'img_name', name: 'img_name' },
                    { className: 'text-center align-middle', data: 'student_id', name: 'student_id' },
                    { className: 'text-center align-middle', data: 'student_name', name: 'student.students_name' },
                    // { className: 'text-center align-middle', data: 'student_tagline', name: 'student_tagline' },
                    { className: 'text-center align-middle', data: 'cast_vote', name: 'cast_vote' },
                    { className: 'text-center align-middle', data: 'verify', name: 'verify', searchable: false },
                    { className: 'text-center align-middle', data: 'voter', name: 'voter', orderable: false, searchable: false },
                    @if (strtotime(Carbon\Carbon::now()) < strtotime($vote->start_date))
                    { className: 'text-center align-middle', data: 'action', name: 'action', orderable: false, searchable: false }
                    @endif
                ],
                orderCellsTop: true,
                "order": [[4, "desc"],[5, "asc"]],
                "initComplete": function (settings, json) {

                }
            });
        });
    });

    $('form[action^="/voting-setting-delete/"]').on('submit', function (e) {
        e.preventDefault();
        var form = this;

        Swal.fire({
            title: 'Delete Category Info?',
            text: "Data cannot be recovered back after deletion process!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: form.action,
                    type: 'DELETE',
                    data: $(form).serialize(),
                    success: function (response) {
                        console.log(response);
                        location.reload();
                    },
                    error: function (xhr) {

                        console.error(xhr.responseText);
                    }
                });
            }
        });
    });

    $('form[action^="/voting-programme-delete/"]').on('submit', function (e) {
        e.preventDefault();
        var form = this;

        Swal.fire({
            title: 'Delete Programme Info?',
            text: "Data cannot be recovered back after deletion process!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: form.action,
                    type: 'DELETE',
                    data: $(form).serialize(),
                    success: function (response) {
                        console.log(response);
                        location.reload();
                    },
                    error: function (xhr) {

                        console.error(xhr.responseText);
                    }
                });
            }
        });
    });

    $('.candidate-table').on('click', '.btn-delete[data-remote]', function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var url = $(this).data('remote');

        Swal.fire({
            title: 'Delete Candidate Info?',
            text: "Data cannot be recovered back after deletion process!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.value) {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                url: url,
                type: 'DELETE',
                dataType: 'json',
                data: {method: '_DELETE', submit: true}
                }).always(function (data) {
                    $('.candidate-table').DataTable().draw(false);
                    location.reload();
                });
            }
        })
    });

    $(document).ready(function() {
        // Handle the verification checkbox change event
        $(document).on('change', '.verification-checkbox', function() {
            var recordId = $(this).data('id');
            var isChecked = $(this).is(':checked');

            // Show a SweetAlert confirmation dialog when the checkbox is checked
            if (isChecked) {
                Swal.fire({
                    title: 'Are you sure?',
                    html: '<p>You are about to verify this candidate.</p><textarea id="verificationReason" class="form-control" placeholder="Fill verification reason" required></textarea>',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, verify it!',
                    cancelButtonText: 'Cancel',
                    preConfirm: function() {
                        // Get the verification reason from the textarea
                        const verificationReason = document.getElementById('verificationReason').value;

                        // Check if the verification reason is empty
                        if (!verificationReason) {
                            Swal.showValidationMessage('Verification reason is required.');
                        } else {
                            // Send an AJAX request to verify the candidate
                            $.ajax({
                                method: 'POST',
                                url: '/voting-candidate-verify/' + recordId,
                                data: {
                                    _token: '{{ csrf_token() }}', // Replace with the actual CSRF token
                                    verificationReason: verificationReason,
                                },
                                success: function(response) {
                                    // Handle success (e.g., display a success message)
                                    Swal.fire('Success', response.message, 'success').then(() => {
                                        // Reload the page after the user clicks "OK"
                                        window.location.reload();
                                    });
                                },
                                error: function(xhr) {
                                    // Handle error (e.g., display an error message)
                                    Swal.fire('Error', 'Error verifying the record: ' + xhr.statusText, 'error');
                                }
                            });
                        }
                    }
                });
            }
        });
    });

</script>

@endsection
