<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Junges\ACL\Models\Group;
use Junges\ACL\Models\Permission;
use Illuminate\Support\Facades\Authorization;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
public function createRoles(Request $request){
        $user = User::all();
        if($request->input('group')){
            $group = new Group();
            $group->name = $request->input('group');
            $group->save();
        }else if($request->input('permission')){
            $permission = new Permission();
            $permission->name = $request->input('permission');
            $permission->save();
            $user->assignPermission($permission);
        }else{

        }
        return redirect('roles/show')->with('success', 'Role ajouté avec succèss');
    }
    public function showGroups(){
        $users = User::all();
        $groups = Group::all();
        $permissions = Permission::all();
        $permission = Permission::with('groups')->get();
        // dd($permission);
        return view('/roles/create', [
            'users' => $users, 
            'groups' => $groups,
            'permissions' => $permission
        ]);
    }
    public function createGroup(Request $request){
        $user = User::find($request->input('users'));
        if($request->input('groups')){
            $group = $request->input('groups');
            $user->assignGroup($group);
        }
        if($request->input('permissions')){
            $permission = $request->input('permissions');
            $user->assignPermission($permission);
        }
        return redirect('/roles/create');
    }
    public function show($id)
    {
        $user = User::with('groups')->find($id);
        $groups = Group::all();
        return response()->json([
            'user_groups' => $user->groups->pluck('id')->toArray(),
            'groups' => $groups,
        ]);
    }
    public function permission(Request $request){
        $user_id = $request->get('user_id');
        $product_id = $request->get('product_id');
        // $user = User::with('permissions')->find($id);
    }
    public function createGroupPermssion(Request $request){
        $group = Group::find($request->input('group'));
        $permission = $request->input('permissions');
        $group->assignPermission($permission);
        return redirect('/roles/create');
    }
    public function showPermission($id)
    {
        $group = Group::find($id);
        $permissions = Permission::all();
        return response()->json([
            'group_permissions' => $group->permissions->pluck('id')->toArray(),
            'permissions' => $permissions
        ]);
    }
}
