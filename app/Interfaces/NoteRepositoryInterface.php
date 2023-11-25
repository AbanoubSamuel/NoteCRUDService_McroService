<?php

namespace App\Interfaces;


use Closure;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

interface NoteRepositoryInterface {

    public function getNoteById(Request $request);

    public function createNote(Request $request): Note;

    public function updateNote(Request $request): Note;

    public function getMyNotes(Request $request): array|Collection;

}