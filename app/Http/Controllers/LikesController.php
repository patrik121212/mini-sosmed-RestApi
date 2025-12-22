<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Like;
use Illuminate\Support\Facades\Validator;


class LikesController extends Controller
{
    // Method Store
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'post_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 400);
        }
        // jika validasi berhasil, simpan data like baru
        $like = Like::create([
            'user_id' => $request->user_id,
            'post_id' => $request->post_id,

        ]);

        return response()->json([
            'success' => true,
            'message' => 'berhasil membuat like baru',
            'data' => $like,
        ], 201);
    }


    // Method Destroy
    public function destroy($id)
    {
        $like = Like::find($id);
        if (!$like) {
            return response()->json([
                'success' => false,
                'message' => 'Like tidak ditemukan'
            ], 404);
        }
        $like->delete();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil menghapus like'
        ]);
    }
}
