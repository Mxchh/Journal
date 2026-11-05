<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    public function index(Request $request)
    {
        $query = Journal::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }
        $journals = $query->get();

        return response()->json($journals, 200, [], JSON_PRETTY_PRINT);
    }

    public function store(Request $request)
    {

        $data = $request->validate([
            'date' => 'required|date',
            'title' => 'required|string|max:255',
            'mood' => 'required|string|not_in:select',
            'description' => 'required|string'
        ]);

        $journal = Journal::create($data);
        return response()->json(['message' => 'Journal created successfully', 'data' => $journal], 201);
    }

    public function update(Request $request, Journal $journal)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'title' => 'required|string|max:255',
            'mood' => 'required|string|not_in:select',
            'description' => 'required|string'
        ]);

        $journal->update($data);
        return response()->json(['message'=> 'Journal updated successfully', 'data' => $journal], 200);
    }

    public function destroy(Journal $journal) {
        $journal->delete();
        return response()->json(['message'=>'Journal deleted successfully'], 200);
    }

    public function show(Journal $journal) {
        return response()->json($journal);
    }
}