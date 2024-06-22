<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function respond(Request $request)
    {
        $message = $request->input('message');
        $response = "Desculpe, ainda estou aprendendo. Por favor, reformule sua pergunta.";

        if (strpos(strtolower($message), 'olá') !== false) {
            $response = "Olá! Como posso te ajudar hoje?";
        }

        return response()->json(['response' => $response]);
    }
}
