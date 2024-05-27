<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\QuizScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuizScoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return QuizScore::with('user')
        ->orderBy('result', 'desc')
        ->limit(5)
        ->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {    
            $validatedScore = Validator::make($request->all(), [
                'user_id' => 'required',
                'score' => 'required',
                'questions' => 'required',
                'category' => 'required',
                'difficulty' => 'required',
            ]);
    
            if ($validatedScore->fails()) {
                return response()->json(['message' => 'Score saving failed', 'error' => $validatedScore->errors()], 500);
            }
    
            QuizScore::create([
                'user_id' => $request->get('user_id'),
                'score' => $request->get('score'),
                'questions' => $request->get('questions'),
                'category' => $request->get('category'),
                'difficulty' => $request->get('difficulty'),
                'result' => ($request->get('score') / $request->get('questions')) * 100, // percent
                'created_at' => now()->timestamp,
            ]);
    
            return response()->json(['message' => 'Score saved'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Score saving failed', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(QuizScore $quizScore)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, QuizScore $quizScore)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QuizScore $quizScore)
    {
        //
    }
}
