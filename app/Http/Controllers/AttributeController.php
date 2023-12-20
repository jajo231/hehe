<?php

namespace App\Http\Controllers;

use App\Http\Resources\AttributeResource;
use App\Http\Resources\GameResource;
use App\Models\Attribute;
use App\Models\Game;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AttributeController extends Controller
{
    public function index() {
        $attributes = Attribute::all();
        return Inertia::render('Attributes/Index', [
            'attributes'    => AttributeResource::collection($attributes)
        ]);
    }

    public function calendar() {
        $query = Game::with('attribute');
        $games = $query->get();

        return Inertia::render('Attributes/Calendar', [
            'games' => GameResource::collection($games),
        ]);
    }


    public function show(Attribute $attribute, Request $request) {
        $query = $attribute->games()->orderBy('created_at', 'desc');

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('release_date', [$request->from_date, $request->to_date]);
        }

        $perPage = 3;

        $games = $query->paginate($perPage);

        return Inertia::render('Attributes/Show', [
            'attribute' => new AttributeResource($attribute),
            'games' => GameResource::collection($games),
            'filter' => [
                'from_date' => $request->from_date ?? '',
                'to_date' => $request->to_date ?? ''
            ]
        ]);
    }

}
