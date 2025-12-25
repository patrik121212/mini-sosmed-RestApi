<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Validator;


class CommentsControler extends Controller
{
    public function store(Request $request)
    {
        $validator = validator::make(
            $request->all(),
            [
                'user_id' => 'required',
                'post_id' => 'required',
                'content' => 'required|string|max:255'
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'succes' => false,
                'message' => $validator->errors()
            ]);
        }
        $comment = Comment::create([
            'user_id' => $request->user_id,
            'post_id' => $request->post_id,
            'content' => $request->content

        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Komentar',
            'data' => $comment
        ]);
    }

    public function destroy($id)
    {
        $comment = Comment::find($id);
        if (!$comment) {
            return response()->json([
                'success' => false,
                'message' => 'Komentar tidak ditemukan'
            ]);
        }
        $comment->delete();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil menghapus komentar'
        ]);
    }
}
