@extends('navbar')
@section('content')


    <img src="../images/rpslog.jpg" height='800px' width='100%' style="position: relative;" id="image-register"">
    <div class="form-content"> 
            
            <h2 id="page"> 
                Login
            </h2>
            <form name="login_form" method="post"  onsubmit="return validateform_login()" action='login'>
                {{ csrf_field() }}
                <label>
                    Phone Number:
                </label>
                <input type="text" name="phone_number" value="{{ old('phone_number') }}" placeholder="Enter phone number">
                @if($errors->has('phone_number'))
                    <div id='warning'>{{ $errors->first('phone_number') }}</div>
                @endif
                <br>
                <label>
                    Password:
                </label>
                <input type="password" name="password" value="{{ old('password') }}" placeholder="Enter password">
                @if($errors->has('password'))
                    <div id='warning'>{{ $errors->first('password') }}</div>
                @endif
                @if ($message = Session::get('error'))
                    <div id="warning">
                        {{ $message }}
                    </div>
                @endif
                <br>
                <br>
                <input type="submit">
                    <h3>
                        <input type="checkbox"  name="remember">
                        Remember me
                    </h3>
                    
                <span id="warning">
                   
                </span>
                <hr>
               <h4 > <a href="register" style="color:red;">Create New Account ??</a></h4>
            </form>  
    </div>
@endsection