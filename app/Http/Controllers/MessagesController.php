<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Validator;

class MessagesController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sender_id' => 'required',
            'receiver_id' => 'required',
            'message_content' => 'required|string|max:255'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 400);
        }

        // jika validasi berhasil, simpan data message baru
        $message = Message::create([
            'sender_id' => $request->sender_id,
            'receiver_id' => $request->receiver_id,
            'message_content' => $request->message_content
        ]);
        return response()->json([
            'success' => true,
            'message' => 'berhasil mengirim pesan baru',
            'data' => $message,
        ], 201);
    }

    // Method Show
    public function show($id)
    {
        $message = Message::find($id);
        return response()->json([
            'success' => true,
            'data' => $message,
        ]);
    }

    // method getmessages
    public function getMessages(int $user_id)
    {
        $messages = Message::where('receiver_id', $user_id)->get();
        return response()->json([
            'success' => true,
            'message' => 'Daftar pesan untuk user_id',
            'data' => $messages,
        ]);
    }

    // Method Destroy
    public function destroy($id)
    {
        $message = Message::find($id);
        if (!$message) {
            return response()->json([
                'success' => false,
                'message' => 'Pesan tidak ditemukan'
            ], 404);
        }
        $message->delete();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil menghapus pesan'
        ]);
    }
}
