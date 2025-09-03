<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            ['name' => 'medis', 'display_name' => 'Medis'],
            ['name' => 'keperawatan', 'display_name' => 'Keperawatan'],
            ['name' => 'umum', 'display_name' => 'Umum'],
        ];
        foreach ($defaults as $cat) {
            Category::firstOrCreate(['name' => $cat['name']], $cat);
        }
    }
}





