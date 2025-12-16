<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GroqService;

class AiController extends Controller
{
    public function enhance(Request $request, GroqService $groq)
    {
        $request->validate(['text' => 'required|string|min:5']);

        $improvedText = $groq->enhanceClinicalText($request->text);

        return response()->json(['text' => $improvedText]);
    }
}