<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function getGroups($id) {
        dd($id);
        $user = User::find($id);
        return response()->json([
            'id' => $id,
        ]);
    }
}
