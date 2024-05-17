<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\QuizScore;
use Illuminate\Http\Request;

class QuizScoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return QuizScore::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'score' => 'required',
        ]);

        QuizScore::create([
            'user_id' => $request->get('user_id'),
            'score' => $request->get('score'),
            'created_at' => now()->timestamp,
        ]);

        return response('New score is saved.');
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
