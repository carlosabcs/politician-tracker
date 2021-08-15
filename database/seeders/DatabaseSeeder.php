<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Visitor::factory(20)->create();
        \App\Models\Reason::factory(20)->create();
        \App\Models\Position::factory(20)->create();
        \App\Models\PublicEntity::factory(20)->create();
        \App\Models\PublicEmployee::factory(20)->create();
        \App\Models\Office::factory(20)->create();
        \App\Models\Meeting::factory(20)->create();
    }
}
