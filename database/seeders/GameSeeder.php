<?php

namespace Database\Seeders;

use App\Models\Developer;
use App\Models\Event;
use App\Models\Game;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    public function run()
    {
        $file = file_get_contents('./database/seeders/heroes.json');
        $data = json_decode($file, true);

        foreach ($data['games'] as $game) {
            Game::create([
                'name' => $game['name'],
                'image' => $game['image'],
                'description' => $game['description'],
                'type' => $game['type'],
                'release_date' => $game['release_date'],
                'attribute_id' => $game['attribute_id'] ?? 1,
            ]);
        }
    }
}
