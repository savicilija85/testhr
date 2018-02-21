<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = 'admin/categories';

    /**
     * Create a new controller instance.
     * UsersController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function showCategories(){
        $categories = Category::all();
        return view('admin.categories', compact('categories'));
    }

    public function deleteCategory($id){
        $category = Category::find($id);
        $category->destroy($id);

        return \Redirect::to('admin/categories');
    }

    public function createCategory(Request $request){
        $name = $request->all();

        $category = new Category();
        $category->name = $name['name'];
        $category->save();

        return \Redirect::to('admin/categories');
    }
}
