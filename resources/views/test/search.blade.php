@extends('layouts.admin')

@section('content')

<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">

<h1>View record</h1>

<table class="table table-bordered table-hover table-striped w-100">
    <tr>
        <td>id</td>
        <td>User id:</td>
        <td>Equipment ID:</td>
        <td>Serial Number:</td>
        <td>Description:</td>
    </tr>

    @foreach ($user as $users)
        <tr>
            <td>{{$users->id}}</td>
            <td>{{$users->staff_id}}</td>
            <td>{{$users->hp_no}}</td>
            <td>{{$users->rent_date}}</td>
            <td>{{$users->return_date}}</td>
            <td>{{$users->purpose}}</td>
            <td>
                <form action="{{route('deleteApplication', $users->id)}}" method="POST" class="delete_form">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm delete-alert"><i class="fal fa-trash"></i> Delete</button>
                </form>
                <a href={{"edit_record/".$users->id}} class="btn btn-primary float-center waves-effect waves-themed" >edit</a>
            </td>
        </tr>
            
    @endforeach
</table>  display user rent
<div>
    <a href="{{ url()->previous() }}" class="btn btn-primary float-right waves-effect waves-themed">Back</a>
</div>

</main>
@endsection