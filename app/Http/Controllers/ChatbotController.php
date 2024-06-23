<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function respond(Request $request)
    {
        $message = $request->input('message');
        $response = $this->generateResponse($message);

        return response()->json(['response' => $response]);
    }

    private function generateResponse($message)
    {
        $message = strtolower($message);

        if (strpos($message, 'olá') !== false || strpos($message, 'oi') !== false) {
            return "Olá! Como posso te ajudar hoje?";
        }

        if (strpos($message, 'temperatura') !== false) {
            return "A temperatura atual é de 24.84°C.";
        }

        if (strpos($message, 'umidade') !== false) {
            return "A umidade atual é de 52.35%.";
        }
        if (strpos($message, 'funciona') !== false) {
            return "O Gerenciador de Estufa, captura dados com diferentes tipos de sensores e exibe em relatorios para o administrador";
        }

        if (strpos($message, 'relatorios') !== false) {
            return "Você pode visualizar estes relatorios em PAINEL ADMIN-> e selecionar o tipo de relatorio que deseja";
        }

        if (strpos($message, 'versão') !== false) {
            return "o Projeto atualmente esta na versão 1.0, futuramente haveram mais funcionalidades e atualizações";
        }

        if (strpos($message, 'cadastro') !== false) {
            return "Para realizar o seu cadastro clique em LOGIN->Registre-se aqui";
        }

        if(strpos($message, 'inicial' ) !== false){
            return "Os dados exibidos na tela Inicial são os ultimos dados por segundo que vieram dos sensores, Há tambem um relatorio por media de tempo em que voce se manteve na tela inical";
        }
        

        return "Desculpe, ainda estou aprendendo. Por favor, reformule sua pergunta.";
    }
}
