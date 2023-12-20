<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class DateController extends Controller
{
    public function dateIndex()
{
    $games = Game::all(['name', 'release_date']);

    $events = [];

    foreach ($games as $game) {
        $events[] = [
            'title' => $game->name,
            'start' => Carbon::parse($game->release_date)->toDateString(),
        ];
    }

    return Inertia::render('Date', [
        'events' => $events,
    ]);
}
}
