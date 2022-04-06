
@extends('navbar')
@section('mytitle', 'Edit Profile')
@section('content')

<img src="{{url('/images/registration-banner.jpg')}}" height='900px' width='100%' style="position: relative;" id="image-register"">

    <div class="form-content">
   
        <h2>
            Change Password
        </h2>
        <form name="editForm" method="post" action='/update_password'>
         {{ csrf_field() }}
            <label>Old Password</label><br>
            <input type="password" name="old_password" value="{{ old('old_password') }}" autocomplete="off">
            @if($errors->has('old_password'))
                    <div id='warning'>{{ $errors->first('old_password') }}</div>
                @endif
            <label> New Password</label><br>
            <input type="password" name="password" value="{{ old('password') }}" autocomplete="off">
            @if($errors->has('password'))
                    <div id='warning'>{{ $errors->first('password') }}</div>
                @endif
            <label>Confirm Password</label><br>
            <input type="password" name="password_confirmation" value="{{ old('password_confirmation') }}" autocomplete="off">
            @if($errors->has('password_confirmation'))
                    <div id='warning'>{{ $errors->first('password_confirmation') }}</div>
                @endif
         <br>
         <hr>
   
    
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