<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class BackendNoteController extends Controller
{
    public function index(): View|Factory|Application
    {
        $notes = Note::latest()->paginate(20);

        return view('backend.notes.index', compact('notes'));
    }

    public function create(): View|Factory|Application
    {

        return view('backend.notes.note');
    }

    public function store(): Application|Redirector|RedirectResponse
    {

        $note = new Note;

        $note->title = request('title');
        $note->content = request('content');

        $note->save();

        return redirect('/backend/notes');
    }

    public function edit($id): View|Factory|Application
    {
        $note = Note::find($id);

        return view('backend.notes.note', compact('note'));
    }

    public function update($id): Application|Redirector|RedirectResponse
    {

        $note = Note::find($id);

        $note->title = request('title');
        $note->content = request('content');

        $note->save();

        return redirect('/backend/notes');
    }

    public function destroy($id): Application|Redirector|RedirectResponse
    {
        $note = Note::find($id);

        $note->delete();

        return redirect('/backend/notes');
    }
}
