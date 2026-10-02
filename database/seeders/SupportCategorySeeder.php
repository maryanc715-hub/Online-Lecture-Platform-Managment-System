<?php

namespace Database\Seeders;

use App\Models\SupportCategory;
use Illuminate\Database\Seeder;

class SupportCategorySeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Academic', 'Technical', 'Administrative'] as $name) {
            SupportCategory::updateOrCreate(['name' => $name]);
        }
    }
}
