@extends('navbar')
@section('mytitle', 'Edit Profile')
@section('content')

<img src="{{url('/images/rpslog.jpg')}}" height='900px' width='100%' style="position: relative;" id="image-register"">

    <div class="form-content">
   
        <h2>
            Edit Here
        </h2>
        <form name="editForm" method="post" action='/update_profile'>
         {{ csrf_field() }}
         <label>User Type: </label><br>
            <select name="type_of_user" >
             <option value="merchant" {{ $user->type_of_user == "merchant" ? 'selected' : '' }}> Merchant</option>
             <option value="user" {{ $user->type_of_user == "user" ? 'selected' : '' }}>Customer</option>
            </select>
            <br>
            <label>Name</label><br>
            <input type="text" name="name" value="{{$user->name or old('name') }}" autocomplete="off">
            @if($errors->has('name'))
                    <div id='warning'>{{ $errors->first('name') }}</div>
                @endif
            <label>Email</label><br>
            <input type="text" name="email_id" value="{{$user->email_id or old('email_id') }}" autocomplete="off">
            @if($errors->has('email_id'))
                    <div id='warning'>{{ $errors->first('email_id') }}</div>
                @endif
            <label>Phone No.</label><br>
            <input type="text" name="phone_number" value="{{$user->phone_number or old('phone_number') }}" autocomplete="off" class="login__input" readonly>
            @if($errors->has('phone_number'))
                    <div id='warning' >{{ $errors->first('phone_number')  }}</div>
                @endif
            <label>Gender</label><br>
            <input type="radio" name="gender" value="Male" {{ $user->gender == "Male" ? 'checked' : '' }}>
            <strong>Male</strong>
            <input type="radio" name="gender" value="Female" {{ $user->gender == "Female" ? 'checked' : '' }}>
            <strong>Female</strong>
            <input type="radio" name="gender" value="Other" {{ $user->gender == "Other" ? 'checked' : '' }}> 
            <strong>Other</strong>
            <input type="submit">
        </form>
        <span id="warning">
        @foreach($errors as $error)
        {{$error}}
        @endforeach
        </span>
        <hr>
        
    </div>

@endsection