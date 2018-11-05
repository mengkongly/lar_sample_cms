@extends('../layouts.app')

@section('content')

<h2>Edit Form</h2>
<!-- <form action="/posts/{{$post->id}}" method="post">
    {{csrf_field()}}
    <input type="hidden" name="_method" value="PUT">
    <input type="text" name="title" placeholder="Enter Title" value="{{$post->title}}"><br/><br/>
    <textarea name="content" id="" cols="30" rows="10" placeholder="Enter Content">{{$post->content}}</textarea><br/><br/>
    <input type="submit" value="Submit">
</form>
 -->

<!-- <form action="/posts/{{$post->id}}" method="post">
    {{csrf_field()}}
    <input type="hidden" name="_method" value="DELETE">
    <input type="submit" value="Delete">
</form> -->


{!! Form::model($post,['method'=>'PUT','action'=>['PostsController@update',$post->id]]) !!}
    {{ csrf_field()}}
    <div class="form-group">
        {!! Form::label('title','Title') !!}
        {!! Form::text('title',$post->title,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('content','Description') !!}
        {!! Form::textarea('content',$post->content,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::submit('Update Post',['class'=>'btn btn-info']) !!}
    </div>

{!! Form::close() !!}

{!! Form::model($post,['method'=>'DELETE','action'=>['PostsController@destroy',$post->id]]) !!}

    <div class="form-group">
        {!! Form::submit('Delete',['class'=>'btn btn-danger']) !!}
    </div>
    
{!! Form::close() !!}

@if(count($errors)>0)
    <div class="alert alert-danger">
    
        <ul>
        
            @foreach($errors->all() as $error)

                <li>{{$error}}</li>

            @endforeach
        
        </ul>

    </div>

@endif


@endsection