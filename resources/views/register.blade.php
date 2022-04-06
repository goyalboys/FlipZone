@extends('navbar')
@section('content')

    <img src="{{url('/images/registration-banner.jpg')}}" height='900px' width='100%' style="position: relative;" id="image-register"">

    <div class="form-content">
   
        <h2>
            Register Here
        </h2>
       <!-- @if ($errors->any())
        <div class="alert alert-danger">
            <ul id='warning'>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif -->
        <form name="myForm" method="post" action='/register'>
         {{ csrf_field() }}
         <label>User Type: </label><br>
            <select name="type_of_user" >
             <option value="merchant">Merchant</option>
             <option value="user" selected>Customer</option>
            </select>
            <br>
            <label>Name</label><br>
            <input type="text" name="name" value="{{ old('name') }}" autocomplete="off">
            @if($errors->has('name'))
                    <div id='warning'>{{ $errors->first('name') }}</div>
                @endif
            <label>Email</label><br>
            <input type="text" name="email_id" value="{{old('email_id') }}" autocomplete="off">
            @if($errors->has('email_id'))
                    <div id='warning'>{{ $errors->first('email_id') }}</div>
                @endif
            <label>Phone No.</label><br>
            <input type="text" name="phone_number" value="{{ old('phone_number') }}" autocomplete="off" class="login__input">
            @if($errors->has('phone_number'))
                    <div id='warning'>{{ $errors->first('phone_number') }}</div>
                @endif
            <label>Password</label><br>
            <input type="password" name="password" value="{{ old('password') }}" autocomplete="off">
            @if($errors->has('password'))
                    <div id='warning'>{{ $errors->first('password') }}</div>
                @endif
            <label>Confirm Password</label><br>
            <input type="password" name="password_confirmation" value="{{ old('password_confirmation') }}" autocomplete="off">
            @if($errors->has('password_confirmation'))
                    <div id='warning'>{{ $errors->first('password_confirmation') }}</div>
                @endif
            <label>Gender</label><br>
            <input type="radio" name="gender" value="Male" checked>
            <strong>Male</strong>
            <input type="radio" name="gender" value="Female">
            <strong>Female</strong>
            <input type="radio" name="gender" value="Other"> 
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