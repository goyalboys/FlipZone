@extends('navbar')
@section('content')
<div class="contact-us">
    Contact us
</div>
<div class="contact-Form">
    <form name="contactForm" method="post" action='/register_user'>
         {{ csrf_field() }}
            <label>Name</label><br>
            <input type="text" name="name" value="{{ old('name') }}" autocomplete="off">
            @if($errors->has('name'))
                    <div id='warning'>{{ $errors->first('name') }}</div>
            @endif
            <br>
            <label>Phone No.</label><br>
            <input type="text" name="phone_number" value="{{ old('phone_number') }}" autocomplete="off" class="login__input">
            @if($errors->has('phone_number'))
                    <div id='warning'>{{ $errors->first('phone_number') }}</div>
            @endif
            <br>
            <label>Subject</label><br>
            <input type="text" name="subject" id="subject" >
            <br>
            <label>Problem</label><br>
            <textarea name="problem" id="problem" vlaue="" >
            </textarea><br>
            <hr>
            <input type="submit">
        </form>
</div>
<br>
<br>
<div style="width:100%; height:50px;  background-color:black; ">
    <div style="text-align:center; color:white;padding-top:10px;">
        CopyRight@FlipZone
    </div>
</div>


@endsection