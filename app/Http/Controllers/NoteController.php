<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use Illuminate\Http\JsonResponse;

class NoteController extends Controller
{
    public function index(): JsonResponse
    {
        $notes = Note::with('user')
            ->orderByDesc('pinned')
            ->orderByDesc('updated_at')
            ->get();

        return response()->json($notes->map(function ($note) {
            return [
                'id' => $note->id,
                'title' => $note->title,
                'content' => $note->content,
                'pinned' => $note->pinned,
                'created_at' => $note->created_at->toIso8601String(),
                'updated_at' => $note->updated_at->toIso8601String(),
                'user' => [
                    'id' => $note->user->id,
                    'name' => $note->user->name,
                    'initials' => $note->user->initials,
                    'avatar_color' => $note->user->avatar_color,
                ],
            ];
        }));
    }

    public function store(StoreNoteRequest $request): JsonResponse
    {
        $note = Note::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'content' => $request->content,
            'pinned' => $request->pinned ?? false,
        ]);

        $note->load('user');

        return response()->json([
            'id' => $note->id,
            'title' => $note->title,
            'content' => $note->content,
            'pinned' => $note->pinned,
            'created_at' => $note->created_at->toIso8601String(),
            'updated_at' => $note->updated_at->toIso8601String(),
            'user' => [
                'id' => $note->user->id,
                'name' => $note->user->name,
                'initials' => $note->user->initials,
                'avatar_color' => $note->user->avatar_color,
            ],
        ], 201);
    }

    public function show(Note $note): JsonResponse
    {
        $note->load('user');

        return response()->json([
            'id' => $note->id,
            'title' => $note->title,
            'content' => $note->content,
            'pinned' => $note->pinned,
            'created_at' => $note->created_at->toIso8601String(),
            'updated_at' => $note->updated_at->toIso8601String(),
            'user' => [
                'id' => $note->user->id,
                'name' => $note->user->name,
                'initials' => $note->user->initials,
                'avatar_color' => $note->user->avatar_color,
            ],
        ]);
    }

    public function update(UpdateNoteRequest $request, Note $note): JsonResponse
    {
        $note->update($request->validated());
        $note->load('user');

        return response()->json([
            'id' => $note->id,
            'title' => $note->title,
            'content' => $note->content,
            'pinned' => $note->pinned,
            'created_at' => $note->created_at->toIso8601String(),
            'updated_at' => $note->updated_at->toIso8601String(),
            'user' => [
                'id' => $note->user->id,
                'name' => $note->user->name,
                'initials' => $note->user->initials,
                'avatar_color' => $note->user->avatar_color,
            ],
        ]);
    }

    public function destroy(Note $note): JsonResponse
    {
        $note->delete();

        return response()->json(['message' => 'Nota eliminada correctamente']);
    }

    public function togglePin(Note $note): JsonResponse
    {
        $note->update(['pinned' => !$note->pinned]);
        $note->load('user');

        return response()->json([
            'id' => $note->id,
            'title' => $note->title,
            'content' => $note->content,
            'pinned' => $note->pinned,
            'created_at' => $note->created_at->toIso8601String(),
            'updated_at' => $note->updated_at->toIso8601String(),
            'user' => [
                'id' => $note->user->id,
                'name' => $note->user->name,
                'initials' => $note->user->initials,
                'avatar_color' => $note->user->avatar_color,
            ],
        ]);
    }
}
