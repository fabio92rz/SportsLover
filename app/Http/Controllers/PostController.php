<?php

namespace App\Http\Controllers;

use App\Model\Comments;
use App\Model\Posts;
use App\Model\Categories;
use App\User;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostFormRequest;
use Illuminate\Http\Request;



class PostController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $posts = Posts::select('*', 'categories.category as categoryname' )->join('categories', 'categories.id', '=', 'posts.category_id')->orderBy('created_at', 'desc')->take(3)->get();
        $categories = Categories::orderBy('id', 'desc')->get();
        $title = 'Ultimi Post';

        return view('home')->withPosts($posts)->withTitle($title)->withCategories($categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        //
        $categories = Categories::orderBy('id', 'desc')->get();
        return view('posts.create')->withCategories($categories);

        /**if ($request->user()->can_post()) {
            return view('posts.create');
        } else {
            return redirect('/')->withErrors('You have not sufficient permissions for writing post');
        }**/
    }

    /**
     * Store a newly created resource in storage.
     * @param PostFormRequest $request
     * @return Response
     *
     */
    public function store(PostFormRequest $request)
    {

        /**$duplicate = Posts::where('slug', $post->slug)->first();
        if ($duplicate) {
        return redirect('new-post')->withErrors('Title already exists.')->withInput();
        }**/

        $post = new Posts();
        $post->title = $request->get('title');
        $post->body = $request->get('body');
        $post->slug = str_slug($post->title);
        $post->image = '';
        $post->author_id = $request->user()->id;
        $post->category_id = $request->get('category_id');


        if ($request->has('save')) {
            $post->active = 0;
            $message = 'Post salvato correttamente';
        } else {
            $post->active = 1;
            $message = 'Post pubblicato correttamente';
        }
        $post->save();
        return redirect('edit/' . $post->slug)->withMessage($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */

    public function show($slug)
    {
        //$post = Posts::select('*', 'categories.category as categoryname' )->join('categories', 'categories.id', '=', 'posts.category_id')->where(function ($query) use ($slug){
          //  $query->where('slug', '=', $slug);
        //})->first();

        //$post2 = Posts::where('slug', $slug)->join('categories', '')

        $post = Posts::where('slug',$slug)->first();

        if(!$post)
        {
            return redirect('/')->withErrors('requested page not found');
        }
        $comments = $post->comments;

        $categories = Categories::orderBy('id', 'desc')->get();

        if(!$post)
        {
            return redirect('/')->withErrors('requested page not found');
        }

        return view('posts.show')->withPost($post)->withComments($comments)->withCategories($categories);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit(Request $request, $slug)
    {
        $categories = Categories::orderBy('id', 'desc')->get();
        $post = Posts::where('slug', $slug)->first();
        if ($post && ($request->user()->id == $post->author_id || $request->user()->is_admin()))
            return view('posts.edit')->with('post', $post)->withCategories($categories);
        else {
            return redirect('/')->withErrors('you have not sufficient permissions');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update(Request $request)
    {
        //
        $post_id = $request->input('post_id');
        $post = Posts::find($post_id);
        if ($post && ($post->author_id == $request->user()->id || $request->user()->is_admin())) {
            $title = $request->input('title');
            $slug = str_slug($title);
            $duplicate = Posts::where('slug', $slug)->first();
            if ($duplicate) {
                if ($duplicate->id != $post_id) {
                    return redirect('edit/' . $post->slug)->withErrors('Title already exists.')->withInput();
                } else {
                    $post->slug = $slug;
                }
            }

            $post->title = $title;
            $post->body = $request->input('body');
            $post->category_id = $request->input('category_id');

            if ($request->has('save')) {
                $post->active = 0;
                $message = 'Post saved successfully';
                $landing = 'edit/' . $post->slug;
            } else {
                $post->active = 1;
                $message = 'Post updated successfully';
                $landing = $post->slug;
            }
            $post->save();
            return redirect($landing)->withMessage($message);
        } else {
            return redirect('/')->withErrors('you have not sufficient permissions');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        //
        $post = Posts::find($id);
        if ($post && ($post->author_id == $request->user()->id || $request->user()->is_admin())) {
            $post->delete();
            $data['message'] = 'Post eliminato correttamente';
        } else {
            $data['errors'] = 'Operazione non permessa, non disponi delle autorizzazioni necessarie';
        }

        return redirect('/')->with($data);
    }

    public function categories($category)
    {
        $categories = Categories::orderBy('id', 'desc')->get();

        $posts = Posts::select('*', 'categories.category as categoryname' )->join('categories', 'categories.id', '=', 'posts.category_id')->where(function ($query) use ($category){
            $query->where('category', '=', $category);
        })->orderBy('created_at', 'desc')->get();

        return view('categories')->withCategories($categories)->withPosts($posts)->withTitle($category);
    }
}
