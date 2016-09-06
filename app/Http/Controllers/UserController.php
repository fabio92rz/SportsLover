<?php
namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Model\Posts;
use App\Model\Categories;
use Illuminate\Http\Request;


class UserController extends Controller {
    /*
     * Display active posts of a particular user
     *
     * @param int $id
     * @return view
     */
    public function user_posts($id)
    {
        //
        $categories = Categories::orderBy('id', 'desc')->get();
        $posts = Posts::where('author_id',$id)->where('active',1)->orderBy('created_at','desc')->paginate(5);

        $posts = Posts::select('*', 'categories.category as categoryname' )->join('categories', 'categories.id', '=', 'posts.category_id')->where(function ($query) use ($id){
            $query->where('author_id', '=', $id);
        })->paginate(3);

        $title = 'I miei Post';
        return view('posts.myposts')->withPosts($posts)->withTitle($title)->withCategories($categories);
    }
    /*
     * Display all of the posts of a particular user
     *
     * @param Request $request
     * @return view
     */
    public function user_posts_all(Request $request)
    {
        //
        $categories = Categories::orderBy('id', 'desc')->get();
        $user = $request->user();
        $posts = Posts::where('author_id',$user->id)->orderBy('created_at','desc')->paginate(5);
        $title = $user->name;
        return view('posts.myposts')->withPosts($posts)->withTitle($title)->withCategories($categories);
    }
    /*
     * Display draft posts of a currently active user
     *
     * @param Request $request
     * @return view
     */
    public function user_posts_draft(Request $request)
    {
        //
        $categories = Categories::orderBy('id', 'desc')->get();

        $user = $request->user();
        $posts = Posts::where('author_id',$user->id)->where('active',0)->orderBy('created_at','desc')->paginate(5);
        $title = $user->name;
        return view('home')->withPosts($posts)->withTitle($title)->withCategories($categories);
    }
    /**
     * profile for user
     */
    public function profile(Request $request, $id)
    {
        $categories = Categories::orderBy('id', 'desc')->get();
        $title = 'Il tuo profilo';

        $data['user'] = User::find($id);
        if (!$data['user'])
            return redirect('/');
        if ($request -> user() && $data['user'] -> id == $request -> user() -> id) {
            $data['author'] = true;
        } else {
            $data['author'] = null;
        }
        $data['comments_count'] = $data['user'] -> comments -> count();
        $data['posts_count'] = $data['user'] -> posts -> count();
        $data['posts_active_count'] = $data['user'] -> posts -> where('active', '1') -> count();
        $data['posts_draft_count'] = $data['posts_count'] - $data['posts_active_count'];
        $data['latest_posts'] = $data['user'] -> posts -> where('active', '1') -> take(5);
        $data['latest_comments'] = $data['user'] -> comments -> take(5);

        return view('admin.profile', $data)->withCategories($categories)->withTitle($title);
    }
}
