<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\Event;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    public function run()
    {
        $file = file_get_contents('./database/seeders/attributes.json');
        $data = json_decode($file, true);

        foreach ($data['attributes'] as $attribute) {
            Attribute::create([
                'name' => $attribute['name'],
                'image' => $attribute['image'],
                'description' => $attribute['description'],
            ]);
        }
    }
}
