<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Models\Student;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();

        if (count($students) > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $students,
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400);

    }

    public function show($id)
    {
        $students = Student::find($id);

        if (!is_null($students)) {
            return response([
                'message' => 'Retrieve Student Success',
                'data' => $students
            ], 200);
        }

        return response([
            'message' => 'Student Not Found',
            'data' => null
        ], 404);
    }

    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'nama_student' => 'required',
            'npm' => 'required|numeric',
            'tanggal_lahir' => 'required|date_format:Y-m-d',
            'no_telp' => 'required|numeric|digits_between:8,13'
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $students = Student::create($storeData);
        return response([
            'message' => 'Add Student Success',
            'data' => $students
        ], 200);
    }

    public function destroy($id)
    {
        $students = Student::find($id);

        if(is_null($students)) {
            return response([
                'message' => 'Student Not Found',
                'data' => null
            ], 404);
        }

        if($students->delete()) {
            return response([
                'message' => 'Delete Student Success',
                'data' => $students
            ], 200);
        }

        return response([
            'message' => 'Delete Student Failed',
            'data' => null,
        ], 400);
    }

    public function update(Request $request, $id){
        $students = Student::find($id);
        if (is_null($students)) {
            return response([
                'message' => 'Student Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'nama_student' => 'required',
            'npm' => 'required|numeric',
            'tanggal_lahir' => 'required|date_format:Y-m-d',
            'no_telp' => 'required|numeric|digits_between:8,13'
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $students->nama_student = $updateData['nama_student'];
        $students->npm = $updateData['npm'];
        $students->tanggal_lahir = $updateData['tanggal_lahir'];
        $students->no_telp = $updateData['no_telp'];
        
        if ($students->save()) {
            return response([
                'message' => 'Update Student Success', 
                'data' => $students
            ], 200);
        }


        return response([
            'message' => 'Update Student Failed',
            'data' => null,
        ], 400);
    }
}
