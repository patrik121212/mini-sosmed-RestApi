<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::get();

        return response()->json([
            'success' => true,
            'data' => $posts,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'content' => 'required|string|max:255',
            'image_url' => 'nullable',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 400);
        }
        // jika validasi berhasil, simpan data post baru
        $post = Post::create([
            'user_id' => $request->user_id,
            'content' => $request->content,
            'image_url' => $request->image_url,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'berhasil membuat post baru',
            'data' => $post,
        ], 201);
    }

    // Method Show
    public function show($id)
    {
        $post = Post::find($id);
        return response()->json([
            'success' => true,
            'data' => $post,
        ]);
    }

    // Method Update
    public function update($id, Request $request)
    {

        $post = Post::find($id);
        $validator = Validator::make($request->all(), [
            'content' => 'required|string|max:255',
            'image_url' => 'nullable',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 400);
        }
        // jika validasi berhasil, update data post
        $post = Post::find($id);
        $post->content = $request->content;
        $post->image_url = $request->image_url;
        $post->save();
        return response()->json([
            'success' => true,
            'message' => 'berhasil mengupdate post',
            'data' => $post,
        ]);
    }
    // method Destroy

    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();
        return response()->json([
            'success' => true,
            'message' => 'berhasil menghapus post',
        ]);
    }
}
