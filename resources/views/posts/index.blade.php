@extends('../layouts.app')

@section('content')

<ul>
    @foreach($posts as $post)
        <li>
            @if ($post->path!='/images/')
                <img src="{{$post->path}}" width="50"/>
            @endif
            <a href="/posts/{{$post->id}}">{{$post->title}}</a>
        </li>
    @endforeach
</ul>


@endsection