<?php

namespace App\Http\Controllers;

use App\Models\KnowledgeArticle;
use App\Services\Knowledge\KnowledgeAssistant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class KnowledgeAssistantController extends Controller
{
    public function ask(Request $request, KnowledgeAssistant $assistant): JsonResponse
    {
        $data = $request->validate([
            'question' => ['required', 'string', 'min:3', 'max:500'],
            'tipo' => ['nullable', 'string', 'in:'.implode(',', array_keys(KnowledgeArticle::SOLUTION_TYPES))],
        ]);

        if (! $assistant->isConfigured()) {
            return response()->json([
                'configured' => false,
                'message' => 'A resposta automática por IA ainda não foi configurada para este site.',
            ], 200);
        }

        try {
            $result = $assistant->ask($data['question'], $data['tipo'] ?? null);
        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'configured' => true,
                'error' => true,
                'message' => 'Não foi possível obter uma resposta agora. Tente novamente em instantes ou fale com o suporte.',
            ], 200);
        }

        return response()->json([
            'configured' => true,
            'error' => false,
            'answer' => $result['answer'],
            'sources' => $result['sources'],
        ]);
    }
}
