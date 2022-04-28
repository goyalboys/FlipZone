@extends('navbar')
@section('mytitle', 'FlipZone')
@section('content')
<div class="billing-us"> 
    
@if($errors->has('error'))
{{ $errors->first('error') }}
</div>
@endsection