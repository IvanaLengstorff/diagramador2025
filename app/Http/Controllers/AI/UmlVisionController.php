<?php

namespace App\Http\Controllers\AI;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UmlVisionController extends Controller
{
    public function analyze(Request $request)
    {
        if (!config('services.openai.enabled')) {
            return response()->json(['error' => 'IA deshabilitada'], 501);
        }

        $key = config('services.openai.key');
        if (!$key) {
            return response()->json(['error' => 'OPENAI_API_KEY no configurada'], 500);
        }

        $request->validate([
            'image' => ['required', 'file', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
        ]);

        $mime = $request->file('image')->getMimeType();
        $base64 = base64_encode(file_get_contents($request->file('image')->getRealPath()));
        $dataUrl = "data:{$mime};base64,{$base64}";

        $payload = [
            'model' => config('services.openai.vision_model'),
            'input' => [[
                'role' => 'user',
                'content' => [
                    [
                        'type' => 'input_text',
                        'text' => $this->prompt()
                    ],
                    [
                        'type' => 'input_image',
                        'image_url' => $dataUrl
                    ]
                ]
            ]]
        ];

        $response = Http::withToken($key)
            ->post('https://api.openai.com/v1/responses', $payload);

        if (!$response->successful()) {
            return response()->json([
                'error' => 'Error OpenAI',
                'details' => $response->body()
            ], 500);
        }

        $json = $response->json();
        $content = $json['output_text'] ?? '';

        return response()->json([
            'content' => $content
        ]);
    }

    private function prompt(): string
    {
        return <<<PROMPT
Analiza la imagen de un diagrama UML.

Devuelve SOLO JSON válido con este formato:
{
  "classes": [
    {
      "name": "Clase",
      "attributes": ["- atributo: Tipo"],
      "methods": ["+ metodo(): Tipo"],
      "position": {"row": 0, "col": 0}
    }
  ],
  "relationships": [
    {"type":"association","from":"A","to":"B"}
  ]
}

Si no es UML devuelve:
{"classes":[], "relationships":[]}

NO agregues texto adicional.
PROMPT;
    }
}
