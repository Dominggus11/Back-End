<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Models\Note;


class NoteController extends Controller
{
    public function index(){
        $notes = Note::all();

        if (count($notes) > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $notes,
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400);
    }

    public function show($id)
    {
        $note = Note::find($id);

        if (!is_null($note)) {
            return response([
                'message' => 'Retrieve Note Success',
                'data' => $note
            ], 200);
        }

        return response([
            'message' => 'Note Not Found',
            'data' => null
        ], 404);
    }

    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'bidang' => 'required',
            'catatan' => 'required'
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $note = Note::create($storeData);
        return response([
            'message' => 'Add Note Success',
            'data' => $note
        ], 200);
    }

    public function destroy($id)
    {
        $note = Note::find($id);

        if(is_null($note)) {
            return response([
                'message' => 'Note Not Found',
                'data' => null
            ], 404);
        }

        if($note->delete()) {
            return response([
                'message' => 'Delete Note Success',
                'data' => $note
            ], 200);
        }

        return response([
            'message' => 'Delete Note Failed',
            'data' => null,
        ], 400);
    }

    public function update(Request $request, $id){
        $note = Note::find($id);
        if (is_null($note)) {
            return response([
                'message' => 'Note Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'bidang' => ['max:60', 'required', Rule::unique('notes')->ignore($note)],
            'catatan' => 'required'
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $note->bidang = $updateData['bidang'];
        $note->catatan = $updateData['catatan'];
        
        if ($note->save()) {
            return response([
                'message' => 'Update Note Success', 
                'data' => $note
            ], 200);
        }


        return response([
            'message' => 'Update Note Failed',
            'data' => null,
        ], 400);
    }
}
