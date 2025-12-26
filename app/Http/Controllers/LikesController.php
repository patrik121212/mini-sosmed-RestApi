<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Like;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;


class LikesController extends Controller
{
    // Method Store
    public function store(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $validator = Validator::make($request->all(), [
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
            'user_id' => $user->id,
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
