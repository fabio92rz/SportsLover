<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Comments;
use App\Model\Posts;
use App\Model\Categories;
use App\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostFormRequest;
use Illuminate\Support\Facades\View;
use PhpParser\Node\Stmt\Echo_;


class CategoryController extends Controller
{

    public function index()
    {

        $categories = Categories::orderBy('id', 'desc')->get();
        return view('category.create')->withCategories($categories);


    }

    public function create()
    {

        $categories = Categories::orderBy('id', 'desc')->get();
        return View::make('category.create', array('categories2' => $categories))->withCategories($categories);
    }

    public function store(Request $request)
    {

        $categories = Categories::orderBy('id', 'desc')->get();
        $category = new Categories();
        $category->timestamps = false;
        $category->category = $request->get('category');

        if ($request->has('save')) {
            $message = 'Categoria aggiunta!';
        } else {
            $message = 'Categoria Aggiunta!';
        }

        $category->save();

        return redirect('new-category/')->withMessage($message)->withCategories($categories);
    }

    public function edit(Request $request)
    {

        $category_id = $request->input('categoryid');
        $categories = Categories::orderBy('id', 'desc')->get();
        $category = Posts::find($category_id);

        $category->category = $request->get('category');

        if ($request->has('save')) {
            $message = 'Post saved successfully';
        } else {
            $message = 'Post updated successfully';
        }
        $category->save();

        return redirect('new-category/')->withMessage($message)->withCategories($categories);

    }
}
