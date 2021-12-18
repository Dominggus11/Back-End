<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Models\Kamar;

class KamarController extends Controller
{
    public function index(){
        $kamars = Kamar::all();

        if (count($kamars) > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $kamars,
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400);
    }

    public function show($id)
    {
        $kamar = CourKamarse::find($id);

        if (!is_null($kamar)) {
            return response([
                'message' => 'Retrieve Course Success',
                'data' => $kamar
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
            'tipe_kamar' => 'required',
            'kapasitas' => 'required|numeric',
            'harga' => 'required|numeric'
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $kamar = Kamar::create($storeData);
        return response([
            'message' => 'Add Course Success',
            'data' => $kamar
        ], 200);
    }

    public function destroy($id)
    {
        $kamar = Kamar::find($id);

        if(is_null($kamar)) {
            return response([
                'message' => 'Course Not Found',
                'data' => null
            ], 404);
        }

        if($kamar->delete()) {
            return response([
                'message' => 'Delete Course Success',
                'data' => $kamar
            ], 200);
        }

        return response([
            'message' => 'Delete Course Failed',
            'data' => null,
        ], 400);
    }

    public function update(Request $request, $id){
        $kamar = Kamar::find($id);
        if (is_null($kamar)) {
            return response([
                'message' => 'Course Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'tipe_kamar' => ['max:60', 'required', Rule::unique('kamars')->ignore($kamar)],
            'kapasitas' => 'required|numeric',
            'harga' => 'required|numeric'
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $kamar->tipe_kamar = $updateData['tipe_kamar'];
        $kamar->kapasitas = $updateData['kapasitas'];
        $kamar->harga = $updateData['harga'];
        $kamar->urlPhoto = $updateData['urlPhoto'];
        
        if ($kamar->save()) {
            return response([
                'message' => 'Update Course Success', 
                'data' => $kamar
            ], 200);
        }


        return response([
            'message' => 'Update Course Failed',
            'data' => null,
        ], 400);
    }
}
