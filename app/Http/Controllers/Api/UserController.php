<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Models\User;

class UserController extends Controller
{
    public function index(){
        $users = User::all();

        if (count($users) > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $users,
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400);
    }

    public function show($id)
    {
        $user = User::find($id);

        if (!is_null($user)) {
            return response([
                'message' => 'Retrieve Course Success',
                'data' => $user
            ], 200);
        }

        return response([
            'message' => 'Course Not Found',
            'data' => null
        ], 404);
    }

    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'name' => 'required|max:60',
            'email' => 'required|email:rfc,dns',
            'password' => 'required'
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $storeData['password'] = bcrypt($request->password);
        $user = User::create($storeData);
        return response([
            'message' => 'Add Course Success',
            'data' => $user
        ], 200);
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if(is_null($user)) {
            return response([
                'message' => 'Course Not Found',
                'data' => null
            ], 404);
        }

        if($user->delete()) {
            return response([
                'message' => 'Delete Course Success',
                'data' => $user
            ], 200);
        }

        return response([
            'message' => 'Delete Course Failed',
            'data' => null,
        ], 400);
    }

    public function update(Request $request, $id){
        $user = User::find($id);
        if (is_null($user)) {
            return response([
                'message' => 'Course Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'name' => 'required|max:60',
            'email' => 'required|email:rfc,dns',
            'password' => 'required'
        ]);

        $updateData['password'] = bcrypt($request->password);
        if ($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $user->name = $updateData['name'];
        $user->email = $updateData['email'];
        $user->password = $updateData['password'];
        
        if ($user->save()) {
            return response([
                'message' => 'Update Course Success', 
                'data' => $user
            ], 200);
        }


        return response([
            'message' => 'Update Course Failed',
            'data' => null,
        ], 400);
    }
}
