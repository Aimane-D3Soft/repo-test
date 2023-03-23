<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Tag;

class TagController extends Controller
{
    public function create(Request $request){
        $validate = Validator::make($request->all(),[
            'tag' => 'required|string',
        ]);
        if($validate->fails()){
            return Redirect::back()
            ->withErrors($validate)
            ->withInput($request->input());
        }else{
            $tag = new Tag();
            $tag->tag = $request->input('tag');
            $tag->save();
            return Redirect::back()->with('add', 'Tag '. $request->input('tag'). ' a été bien ajouté');
        }
    }
}
