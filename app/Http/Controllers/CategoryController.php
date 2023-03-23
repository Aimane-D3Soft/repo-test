<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function create(Request $request){
        $validate = Validator::make($request->all(),[
            'categories' => 'required|string|unique:categories',
        ]);
        if($validate->fails()){
            return Redirect::back()
            ->withErrors($validate)
            ->withInput($request->input());
        }else{
            $category = new Category();
            $category->categories = $request->input('categories');
            $category->save();
            return Redirect::back()->with('add', 'Catégorie '.$request->input('categories') .' ajouter avec succèss ');
        }
    }
}
