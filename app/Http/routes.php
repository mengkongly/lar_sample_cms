<?php
use App\Model\Post;
use App\Model\Country;
use App\Model\Photo;
use App\Model\Video;
use App\Model\Tag;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});


// using route::resource is automatic create route for all resource method in controller 
//such as: index, show, create, store, ...
//Route::resource('post','PostsController');

// using route::get is create route one by one
// Route::get('/post/{id}','PostsController@index');

// Route::get('/contact','PostsController@contact');



/*
|--------------------------------------------------------------------------
| DATABASE RAW SQL Queries
|--------------------------------------------------------------------------
|
*/

/* Route::get('/insert',function(){
    DB::insert('insert into posts (title,content) values(?,?)',['PHP Developer','Requirement of PHP Developer']);

});

Route::get('/query',function(){
    $results    =   DB::select('select * from posts where id=?',[1]);
    $str='';
    foreach($results as $result){
        $str.=$result->title.' '.$result->content.'\n';
    }
    return $str;

});

Route::get('/update',function(){
    $updated=   DB::update('update posts set title=? where id=?',['Updated title',1]);
    return $updated;

});

Route::get('/delete',function(){
    $deleted=   DB::delete('delete from posts where id=?',[1]);

    return $deleted;

}); */


/*
|--------------------------------------------------------------------------
| ELOQUENT or ORM
|--------------------------------------------------------------------------
|
*/

Route::get('/insert',function(){
    $post   =   new Post;
    $post->title    =   'Eloquent Title 3';
    $post->content  =   'Eloquent is awesome class';

    if($post->save()){
        return 'Insert success';
    }

    return 'Insert failed';

});

Route::get('/create',function(){
    if(Post::create(['title'=>'This is create method 2','content'=>'I\'m testing with mass assignment 2'])){
        return 'Insert success';
    }
    return 'Insert failed';
});




Route::get('/read',function(){
    $posts    = Post::all();
    
    return $posts;

    /* foreach($posts as $post){

        return $post->title.'  '.$post->content;
    }
 */

});

Route::get('/find/{id}',function(Request $request){

    $id =   $request->id;
    //$post   =   Post::find($id);
    $post   =   Post::where('id',$id)->get();
    if($post){
        return $post->title;
    }
    return 'Not found';
});

Route::get('/findwhere',function(){
    //$posts  =   Post::orderBy('title','asc')->take(1)->get();
    $posts  =   Post::orderBy('title','asc')->get();
    

    return $posts;
});

Route::get('/update',function(){
    $updated    =   Post::where('id',5)->where('is_admin',0)->update(['title'=>'New PHP','content'=>'New content']);
    if($updated){
        return 'Update success';
    }
    return 'Update failed';

});


Route::get('/delete/{id}',function(Request $request){
    $id =   $request->id;
    if(Post::where('id',$id)->delete()){
        return 'Delete success';
    }
    return 'Delete failed';

});

Route::get('/delete2/{id}',function(Request $request){
    $id =   $request->id;

    // with destroy: we can delete multiple rows by pass array of id to parameter
    //example: Post::destroy([1,2,3,4,5]) //will delete id:1,2,3,4,5
    if(Post::destroy($id)){
        return 'Delete success';
    }
    return 'Delete failed';

});

Route::get('/softdelete/{id}',function(Request $request){
    $id =   $request->id;
    //Post::find($id)->delete();
    $is_deleted =   Post::find($id)->delete();
    if($is_deleted){
        return 'Soft Deleted successfully';
    }
    return 'Soft Deleted failed';

});

Route::get('/readsoftdelete/{id}',function(Request $request){

    $id =   $request->id;
    $post   =   Post::withTrashed()->where('id',$id)->get();
    return $post;
});


//Using withTrashed() method you will get all the softdeleted and regular data
//Using onlyTrashed() method to get only softdeleted data
Route::get('/readallsoftdelete',function(){
    //$posts  =   Post::withTrashed()->get();
    $posts  =   Post::onlyTrashed()->get();

    return $posts;
});

Route::get('/restoresoftdelete',function(){
    if(Post::onlyTrashed()->where('is_admin',0)->restore()){
        return 'Soft Delete is restore successfully';
    }
    return 'Soft Delete restore failed';
});

Route::get('/forcedelete',function(){

    if(Post::onlyTrashed()->forcedelete()){
        return 'Force Delete is succefully';
    }

    return 'Force Delete is failed';

});


/*
|--------------------------------------------------------------------------
| Eloquent Relationship
|--------------------------------------------------------------------------
*/


// One to One relationship using hasOne() method in User model
Route::get('/user/{id}/post',function($id){

    return User::find($id)->post;

});

// Inverse relationship from post to user (One to One)
Route::get('/post/{id}/user',function($id){
    return Post::find($id)->user;
});


// One to Many relationship
Route::get('/user/{id}/posts',function($id){

    return User::find($id)->posts;

});


// Accessing to intermediat table or Pivot table
Route::get('/user/pivot/{id}',function($id){

    $user   =   User::find($id);
    foreach($user->roles as $role){
        return $role->pivot;
    }

});


Route::get('/user/country/{id}',function($id){

    $country    =   Country::find($id);
    return $country->posts;
    /* foreach($country->posts as $post){
        return $post;
    } */

});


// Polymorphic Relation

Route::get('/user/{id}/photos',function($id){

    $user   =   User::find($id);
    return $user->photos;
});

Route::get('/post/{id}/photos',function($id){

    $post   =   Post::find($id);
    return $post->photos;
});

// inverst photo id to find post
Route::get('/photo/{id}',function($id){

    $photo  =   Photo::findOrFail($id);
    return $photo->imagable;
    
});


// Polymorphic Many to Many
Route::get('/post/{id}/tag',function($id){

    $post   =   Post::find($id);
    //return $post;
    foreach($post->tags as $tag){
        echo $tag->name;
    }

});

Route::get('/video/{id}/tag',function($id){

    $video  =   Video::find($id);
    if($video){
        foreach($video->tags as $tag){
            return $tag;
        }
    }
    
});

// Inverst of Polymorphic Many to Many
Route::get('/tag/{id}/posts',function($id){

    $tag    =   Tag::find($id);
    return $tag->posts;
    /* foreach($tag->posts as $post){
        echo $post->title.' <br/>';
    } */
});

Route::get('/tag/{id}/videos',function($id){

    $tag    =   Tag::find($id);
    return $tag->videos;
});




/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    /*
    |--------------------------------------------------------------------------
    | CRUD Application
    |--------------------------------------------------------------------------
    */

    Route::resource('/posts','PostsController');
});


Route::get('/dates',function(){

    //$date   =   new DateTime();
    $date   =   new DateTime('+1 month');
    
    echo 'Using DateTime: '.$date->format('m/d/Y');

    echo '<br/>';

    //using carbon class build-in

    echo 'Using Carbon: '. Carbon::now()->addDays(10)->diffForHumans().'<br/>';
    echo 'Using Carbon: '. Carbon::now()->subMonths(2)->diffForHumans().'<br/>';

    
    


});

Route::get('/getname/{id}',function($id){

    $user   =   User::findOrFail($id);
    echo $user->name;

});

Route::get('/adduser',function(){

    User::create(['name'=>'sok piset','email'=>'piset@gmail.com']);

});
