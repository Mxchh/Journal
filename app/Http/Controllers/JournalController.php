<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use Illuminate\Http\Request;

class JournalController extends Controller
{

    public function index() {
        $journals = Journal::all();

        return view('journal.homepage', compact('journals'));
    }
    public function create(){
        return view('journal.create');
    }

    public function store(Request $request){
        $request -> validate([
            'date'=> 'required|date',
            'title'=>'required|string|max:255',
            'mood'=> 'required|string',
            'description' => 'required|string',
        ]);

        Journal::create($request->all());
        return redirect()->route('journals.index');
    }

    public function edit(Journal $journal) {
        return view('journal.edit', compact('journal'));
    }

    public function update(Request $request, Journal $journal) {
        $request -> validate([
            'date'=> 'required|date',
            'title'=>'required|string|max:255',
            'mood'=> 'required|string',
            'description' => 'required|string',
        ]);

        $journal->update($request->all());
        return redirect()->route('journals.index');
    }

    public function destroy(Journal $journal) {
        $journal->delete();
         return redirect()->route('journals.index');

    }
}