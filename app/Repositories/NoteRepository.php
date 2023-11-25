<?php

namespace App\Repositories;

use Cache;
use Illuminate\Http\Request;
use App\Interfaces\NoteRepositoryInterface;
use App\Models\Note;
use Illuminate\Database\Eloquent\Collection;


class NoteRepository implements NoteRepositoryInterface {

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \App\Models\Note|null
     */
    public function getNoteById(Request $request): Note|null
    {
        return Note::where('id', '=',$request->query('id'))
            ->where('user_id', '=',Cache::get('user_id'))
            ->first();
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array|\Illuminate\Database\Eloquent\Collection
     */
    public function getMyNotes(Request $request): array|Collection
    {
        $limit = $request->query('limit') ?? 5; // Set your preferred items per page
        return Note::whereUserId(Cache::get('user_id'))->paginate($limit)->items();
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \App\Models\Note
     */
    public function createNote(Request $request): Note
    {
        return Note::create([
            'user_id' => Cache::get('user_id'),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'body' => $request->input('body'),
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \App\Models\Note
     */
    public function updateNote(Request $request): Note
    {
        $note = Note::whereId($request->input('id'))->first();
        $note->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'body' => $request->input('body'),
        ]);
        $note->save();
        return $note;
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    public function delete(Request $request): bool
    {
        $note = Note::whereId($request->query('id'))->first();
        return $note->delete();
    }
}