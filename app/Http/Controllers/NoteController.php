<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Repositories\NoteRepository;
use App\Http\Requests\NoteFetchRequest;
use App\Http\Requests\NoteCreateRequest;
use App\Http\Requests\NoteUpdateRequest;
use App\Http\Requests\NoteDeleteRequest;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class NoteController extends Controller {

    private NoteRepository $noteRepository;

    public function __construct(NoteRepository $noteRepository)
    {
        $this->noteRepository = $noteRepository;
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function createNote(NoteCreateRequest $request): JsonResponse
    {
        $note = $this->noteRepository->createNote($request);

        return response()->json([
            'status' => true,
            'message' => 'Note created successfully',
            'data' => $note
        ], status: ResponseAlias::HTTP_CREATED);
    }

    /**
     * @param \App\Http\Requests\NoteUpdateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateNote(NoteUpdateRequest $request): JsonResponse
    {
        $note = $this->noteRepository->updateNote($request);

        return response()->json([
            'status' => true,
            'message' => 'Note updated successfully',
            'data' => $note
        ], status: ResponseAlias::HTTP_OK);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNotes(Request $request): JsonResponse
    {
        $notes = $this->noteRepository->getMyNotes($request);

        return response()->json([
            'status' => true,
            'message' => 'Notes fetched successfully',
            'data' => $notes
        ], status: ResponseAlias::HTTP_OK);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNoteById(NoteFetchRequest $request): JsonResponse
    {
        $note = $this->noteRepository->getNoteById($request);
        if ($note) {
            return response()->json([
                'status' => true,
                'message' => 'Note fetched successfully',
                'data' => $note
            ], status: ResponseAlias::HTTP_OK);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Note not found',
            ], status: ResponseAlias::HTTP_OK);
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteNote(NoteDeleteRequest $request): JsonResponse
    {
        $this->noteRepository->delete($request);
        return response()->json([
            'status' => true,
            'message' => 'Note deleted successfully',
        ], status: ResponseAlias::HTTP_OK);
    }
}
