<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Event::with('user');

        if ($request->has('start') && $request->has('end')) {
            $query->where(function ($q) use ($request) {
                $q->whereBetween('start_datetime', [$request->start, $request->end])
                  ->orWhereBetween('end_datetime', [$request->start, $request->end])
                  ->orWhere(function ($q2) use ($request) {
                      $q2->where('start_datetime', '<=', $request->start)
                         ->where('end_datetime', '>=', $request->end);
                  });
            });
        }

        if ($request->has('date')) {
            $date = $request->date;
            $query->whereDate('start_datetime', $date)
                  ->orWhereDate('end_datetime', $date);
        }

        $events = $query->orderBy('start_datetime')->get();

        return response()->json($events->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'description' => $event->description,
                'start' => $event->start_datetime->toIso8601String(),
                'end' => $event->end_datetime?->toIso8601String(),
                'all_day' => $event->all_day,
                'color' => $event->color,
                'user' => [
                    'id' => $event->user->id,
                    'name' => $event->user->name,
                    'initials' => $event->user->initials,
                    'avatar_color' => $event->user->avatar_color,
                ],
            ];
        }));
    }

    public function store(StoreEventRequest $request): JsonResponse
    {
        $event = Event::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'start_datetime' => $request->start_datetime,
            'end_datetime' => $request->end_datetime,
            'all_day' => $request->all_day ?? false,
            'color' => $request->color ?? auth()->user()->avatar_color,
        ]);

        $event->load('user');

        return response()->json([
            'id' => $event->id,
            'title' => $event->title,
            'description' => $event->description,
            'start' => $event->start_datetime->toIso8601String(),
            'end' => $event->end_datetime?->toIso8601String(),
            'all_day' => $event->all_day,
            'color' => $event->color,
            'user' => [
                'id' => $event->user->id,
                'name' => $event->user->name,
                'initials' => $event->user->initials,
                'avatar_color' => $event->user->avatar_color,
            ],
        ], 201);
    }

    public function show(Event $event): JsonResponse
    {
        $event->load('user');

        return response()->json([
            'id' => $event->id,
            'title' => $event->title,
            'description' => $event->description,
            'start' => $event->start_datetime->toIso8601String(),
            'end' => $event->end_datetime?->toIso8601String(),
            'all_day' => $event->all_day,
            'color' => $event->color,
            'user' => [
                'id' => $event->user->id,
                'name' => $event->user->name,
                'initials' => $event->user->initials,
                'avatar_color' => $event->user->avatar_color,
            ],
        ]);
    }

    public function update(UpdateEventRequest $request, Event $event): JsonResponse
    {
        $event->update($request->validated());
        $event->load('user');

        return response()->json([
            'id' => $event->id,
            'title' => $event->title,
            'description' => $event->description,
            'start' => $event->start_datetime->toIso8601String(),
            'end' => $event->end_datetime?->toIso8601String(),
            'all_day' => $event->all_day,
            'color' => $event->color,
            'user' => [
                'id' => $event->user->id,
                'name' => $event->user->name,
                'initials' => $event->user->initials,
                'avatar_color' => $event->user->avatar_color,
            ],
        ]);
    }

    public function destroy(Event $event): JsonResponse
    {
        $event->delete();

        return response()->json(['message' => 'Evento eliminado correctamente']);
    }
}
