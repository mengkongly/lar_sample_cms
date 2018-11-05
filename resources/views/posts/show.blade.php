@extends('../layouts.app')

@section('content')


    <h4>{{$post->id.'   '.$post->title}}</h4>
    <a href="/posts/{{$post->id}}/edit">Edit this post</a>




@endsection