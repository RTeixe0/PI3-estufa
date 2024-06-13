<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class AdminCommentController extends Controller
{
    public function index()
    {
        $comments = Comment::with('user')->where('status', 'pending')->get();
        return view('paineladmin', compact('comments'));
    }

    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'response' => 'nullable|string',
            'status' => 'required|in:approved,rejected',
        ]);

        $comment->update([
            'response' => $request->response,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.comments.index')->with('success', 'Comentário atualizado com sucesso!');
    }
}
