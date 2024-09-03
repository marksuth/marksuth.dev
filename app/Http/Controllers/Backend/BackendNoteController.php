<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;

class BackendNoteController extends Controller
{
    public function index()
    {
        $notes = Note::latest()->paginate(20);

        return view('backend.notes.index', compact('notes'));
    }

    public function create()
    {

        return view('backend.notes.note');
    }

    public function store(Request $request)
    {

        $note = new Note;

        $note->title = request('title');
        $note->content = request('content');

        $note->save();

        return redirect('/backend/notes');
    }

    public function edit($id)
    {
        $note = Note::find($id);

        return view('backend.notes.note', compact('note'));
    }

    public function update($id)
    {

        $note = Note::find($id);

        $note->title = request('title');
        $note->content = request('content');

        $note->save();

        return redirect('/backend/notes');
    }

    public function destroy($id)
    {
        $note = Note::find($id);

        $note->delete();

        return redirect('/backend/notes');
    }
}
