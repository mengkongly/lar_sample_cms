@extends('../layouts.app')

@section('content')

<h2>Create Form</h2>
<!-- <form action="/posts" method="post"> -->
{!! Form::open(['method'=>'POST','action'=>'PostsController@store','files'=>true]) !!}
    {{csrf_field()}}

    

    <div class="form-group">
        {!! Form::label('title','Title') !!}
        {!! Form::text('title',null, ['class'=>'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::file('file',['class'=>'form-control']) !!}
    </div>
    
    <div class="form-group">
        {!! Form::label('content','Description') !!}
        {!! Form::textarea('content',null,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::submit('Submit',['class'=>'btn btn-primary']) !!}
    </div>
    <!-- <input type="text" name="title" placeholder="Enter Title"><br/><br/>
    <textarea name="content" id="" cols="30" rows="10" placeholder="Enter Content"></textarea><br/><br/>
    <input type="submit" value="Submit"> -->



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