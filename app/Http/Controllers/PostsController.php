<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Model\Post;
use App\Http\Requests\PostRequest;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts       =   Post::latest();
        //$posts       =   Post::orderBy('id','desc')->get();
    
        
        return view('/posts.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('/posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // PostRequest is use in requests folder to make it validation
    public function store(PostRequest $request)
    {
        // $this->validate($request,[
        //     'title'=>'required',
        //     'content'=>'required'
        // ]);

        $input      =   $request->all();

        if($file = $request->file('file')){ //..check if file existed
            $file_name  =   time().'_'.$file->getClientOriginalName();
            // it will create images folder in public directory to store images
            $file->move('images',$file_name);

            $input['path']  =   $file_name;
        }
        
        $user   =   User::findOrFail(1);
        $isSuccess  =   $user->posts()->create($input);
        return redirect('/posts');
        
        //return $request->all();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post   =   Post::whereId($id)->first();
        return view('/posts.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post   =   Post::whereId($id)->first();
        return view('/posts.edit',compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, $id)
    {
        // $this->validate($request,[

        //     'title'=>'required|max:50',
        //     'content'=>'required|max:250'
        // ]);

        $user   =   User::findOrFail(1);
        $post['title']   =   $request->title;
        $post['content']    =   $request->content;
        $user->posts()->whereId($id)->update($post);
        return redirect('/posts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //$user   =   User::findOrFail(1);
        //$user->posts()->whereId($id)->delete();

        Post::findOrFail($id)->delete();
        return redirect('/posts');
    }

    public function contact(){
        $peoples    =   ['Mengkong','Jose','Peter','Maria'];

        return view('contact',compact('peoples'));
    }
}
