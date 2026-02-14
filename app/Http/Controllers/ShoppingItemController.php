<?php

namespace App\Http\Controllers;

use App\Models\ShoppingItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShoppingItemController extends Controller
{
    public function index(): JsonResponse
    {
        $items = ShoppingItem::with('user')
            ->orderBy('completed')
            ->orderByDesc('created_at')
            ->get();

        return response()->json($items->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'completed' => $item->completed,
                'created_at' => $item->created_at->toIso8601String(),
                'user' => [
                    'id' => $item->user->id,
                    'name' => $item->user->name,
                    'initials' => $item->user->initials,
                    'avatar_color' => $item->user->avatar_color,
                ],
            ];
        }));
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ], [
            'name.required' => 'El nombre del artículo es obligatorio.',
        ]);

        $item = ShoppingItem::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'completed' => false,
        ]);

        $item->load('user');

        return response()->json([
            'id' => $item->id,
            'name' => $item->name,
            'completed' => $item->completed,
            'created_at' => $item->created_at->toIso8601String(),
            'user' => [
                'id' => $item->user->id,
                'name' => $item->user->name,
                'initials' => $item->user->initials,
                'avatar_color' => $item->user->avatar_color,
            ],
        ], 201);
    }

    public function destroy(ShoppingItem $shoppingItem): JsonResponse
    {
        $shoppingItem->delete();

        return response()->json(['message' => 'Artículo eliminado correctamente']);
    }

    public function toggleComplete(ShoppingItem $shoppingItem): JsonResponse
    {
        $shoppingItem->update(['completed' => !$shoppingItem->completed]);

        return response()->json([
            'id' => $shoppingItem->id,
            'name' => $shoppingItem->name,
            'completed' => $shoppingItem->completed,
        ]);
    }

    public function clearCompleted(): JsonResponse
    {
        ShoppingItem::where('completed', true)->delete();

        return response()->json(['message' => 'Artículos completados eliminados']);
    }
}
