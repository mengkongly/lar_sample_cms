@extends('layouts.app')

@section('content')

<h1>Contact page</h1>

@if(count($peoples)>0)
    <ul>
    @foreach($peoples as $people)
        <li>{{$people}}</li>
    @endforeach
    </ul>
@endif


@endsection

@section('footer')

<script>alert('Hello visitor');</script>

@endsection