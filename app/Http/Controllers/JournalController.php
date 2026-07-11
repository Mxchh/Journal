<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use Illuminate\Http\Request;

class JournalController extends Controller
{

    public function index(Request $request)
    {

        $query = Journal::query();
        if($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%' );
            });
        }

        if($request->filled('date')) {
            $query->whereDate('date', '=', $request->date);
        }

        $journals = $query->get();

        return view('journal.homepage', compact('journals'));
    }
    public function create()
    {
        return view('journal.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'title' => 'required|string|max:255',
            'mood' => 'required|string|not_in:select',
            'description' => 'required|string',
        ]);

        Journal::create($request->all());
        return redirect()->route('journals.index');
    }

    public function edit(Journal $journal)
    {
        return view('journal.edit', compact('journal'));
    }

    public function update(Request $request, Journal $journal)
    {
        $request->validate([
            'date' => 'required|date',
            'title' => 'required|string|max:255',
            'mood' => 'required|string|not_in:select',
            'description' => 'required|string',
        ]);

        $journal->update($request->all());
        return redirect()->route('journals.index');
    }

    public function destroy(Journal $journal)
    {
        $journal->delete();
        return redirect()->route('journals.index');
    }

    public function show(Journal $journal)
    {
        return view('journal.view', compact('journal'));
    }
}
