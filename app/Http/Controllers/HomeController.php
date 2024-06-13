<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class HomeController extends Controller
{
    public function index()
    {
        $comments = Comment::with('user')->where('status', 'approved')->get();
        return view('index', compact('comments'));
    }

    public function showApprovedComments()
    {
        $comments = Comment::with('user')->where('status', 'approved')->get();
        return view('comments', compact('comments'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'comment' => 'required|string',
        ]);

        Comment::create([
            'user_id' => $validatedData['user_id'],
            'comment' => $validatedData['comment'],
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Comentário criado com sucesso!');
    }
}
