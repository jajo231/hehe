<?php

namespace App\Http\Controllers;

use App\Http\Resources\AttributeResource;
use App\Http\Resources\GameResource;
use App\Models\Attribute;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class GameController extends Controller
{
    public function index(Request $request) {
        $query = Game::with('attribute')->orderBy('created_at', 'desc');

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('release_date', [$request->from_date, $request->to_date]);
        }

        $games = $query->paginate(3); // Use pagination

        return Inertia::render('Games/Index', [
            'games' => GameResource::collection($games),
            'filter' => [
                'from_date' => $request->from_date ?? '',
                'to_date' => $request->to_date ?? ''
            ],
            'flash' => [
                'success' => session('success'), // Retrieve the flash message from the session
            ],
        ]);
    }

    public function create() {
        $attributes = Attribute::all();

        return Inertia::render('Games/Create', [
            'attributes' => AttributeResource::collection($attributes),
        ]);
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'name'         => 'required|max:255', // Change to match your form field names
            'attribute_id' => 'required|exists:attributes,id',
            'description'  => 'required',
            'image'        => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'type'         => 'required',
            'release_date' => 'required|date',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('games', 'public');
            $validatedData['image'] = $imagePath;
        }

        $game = Game::create($validatedData);

        return redirect()->route('games.index')->with('success', 'Game created successfully.');
    }


   public function edit(Game $game) {
        $game->load('attribute');

        $attributes = Attribute::all();

        return Inertia::render('Games/Edit', [
            'game' => new GameResource($game),
            'attributes' => AttributeResource::collection($attributes),
        ]);
    }

    public function update(Request $request, Game $game) {
        $validatedData = $request->validate([
            'name'          => 'required',
            'attribute_id'  => 'required|exists:attributes,id',
            'description'   => 'required',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'type'          => 'required',
            'release_date'  => 'required|date',
        ]);

        if ($request->hasFile('image')) {
            if ($game->image) {
                Storage::delete($game->image);
            }
            $imagePath = $request->file('image')->store('games', 'public');
            $validatedData['image'] = $imagePath;
        }

        $game->update($validatedData);

        return redirect()->route('games.index')->with('message', 'Game updated successfully.');
    }

    public function destroy($id)
    {
        $game = Game::find($id);

        if (!$game) {
            return response()->json(['message' => 'Game not found'], 404);
        }

        $game->delete();

        return response()->json(['message' => 'Game deleted successfully'], 200);
    }
}
