<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\PostsCreateRequest;
use App\Photo;
use App\Post;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminPostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $posts = Post::all();

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = Category::lists('name','id')->all();

        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostsCreateRequest $request)
    {

        $user = Auth::user();
        
        $input = $request->all();

        $input['user_id'] = $user->id;

        if($file = $request['photo']){

            $name = time() . $file->getClientOriginalName();

            $file->move('images/'.$user->id, $name);

            $photo = Photo::create(['path' => $name]);

            $input['photo_id'] = $photo->id;

        }

        Post::create($input);

        return redirect('/admin/posts');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $post = Post::findOrFail($id);

        $categories = Category::lists('name','id')->all();

        return view('admin.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        $input = $request->all();

        $post = Post::find($id);

        if($file = $request['photo']){

            $name = time() . $file->getClientOriginalName();

            $file->move('images/'.$post->user_id, $name);

            if($post->photo_id){

                unlink(public_path() . "/images/". $post->user_id . "/" . $post->photo->path);
                $photo = Photo::find($post->photo->id);
                $photo->update(['path'=>$name]);

            }
            else{

                $photo = Photo::create(['path'=>$name]);
                $input['photo_id'] = $photo->id;

            }

        }
        else{
            $input['photo_id'] = $post->photo_id;
        }

        $post->update($input);

        Session::flash('edited_user', 'The user has been modified');

        return redirect('/admin/posts');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        $post = Post::find($id);

        if($post->photo){

            unlink(public_path() . "/images/" . $post->user_id . "/" . $post->photo->path);
            $photo = Photo::find($post->photo_id);
            $photo->delete();

        }

        $post->delete();

        return redirect('/admin/posts');

    }
}
