<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mood;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MoodController extends Controller
{
    public function index()
    {
        return response()->json(Mood::all());
    }

    public function show(Mood $mood)
    {
        return response()->json($mood);
    }

    public function store(Request $request) {
        $data = $request->validate([
            'mood'=> ['required', 'string', Rule::unique('moods','mood'), 'max:255'],
            'color' => ['required', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/', Rule::unique('moods','color')],
        ]);

        $mood = Mood::create($data);
        return response()->json(['message'=>'Mood created successfully', 'data'=>$mood], 201);
    }

    public function update(Request $request, Mood $mood) {
        $data = $request->validate([
            'mood'=> ['required', 'string', Rule::unique('moods','mood')->ignore($mood->id), 'max:255'],
            'color' => ['required', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/', Rule::unique('moods','color')->ignore($mood->id)],
        ]);

        if($request->user()->role !== 'admin') {
            return response()->json(['message'=>'It is not an admin role'],403);
        }

        $mood->update($data);
        return response()->json(['message'=>'Mood update successfully', 'data' => $mood], 200);
    }

    public function destroy(Request $request, Mood $mood) {
        if($request->user()->role !== 'admin') {
            return response()->json(['message'=>'It is not an admin role'],403);
        }
    $mood->delete();
        return response()->json(['message'=>'Mood deleted successfully'], 200);
    }
}
