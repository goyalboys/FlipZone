@extends('navbar')
@section('content')
<div class="contact-us">
    Contact us
</div>
<div class="contact-Form">
    <form name="contactForm" method="post" action='/contact_us'>
         {{ csrf_field() }}
            <label>Name</label><br>
            <input type="text" name="name" value="{{ old('name') }}" autocomplete="off">
            @if($errors->has('name'))
                    <div id='warning'>{{ $errors->first('name') }}</div>
            @endif
            
            <label>Phone No.</label><br>
            <input type="text" name="phone_number" value="{{ old('phone_number') }}" autocomplete="off" class="login__input">
            @if($errors->has('phone_number'))
                    <div id='warning'>{{ $errors->first('phone_number') }}</div>
            @endif
            <label>Subject</label><br>
            <input type="text" name="subject" id="subject" value="{{ old('subject') }}" >
            @if($errors->has('subject'))
                    <div id='warning'>{{ $errors->first('subject') }}</div>
            @endif
            <br>
            <label>Problem</label><br>
            <textarea name="problem" id="problem" vlaue=" " >
            {{ old('problem') }}
            </textarea><br>
            @if($errors->has('problem'))
                    <div id='warning'>{{ $errors->first('problem') }}</div>
            @endif
            <hr>
            <input type="submit">
        </form>
</div>
<br>
<br>
<div style="width:100%; height:50px; position:fixed; bottom:0px;  background-color:black; ">
    <div style="text-align:center; color:white;padding-top:10px;">
        CopyRight@FlipZone
    </div>
</div>


@endsection