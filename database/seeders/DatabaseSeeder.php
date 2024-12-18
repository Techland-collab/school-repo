<?php

namespace Database\Seeders;

use Database\Seeders\TeacherSeeder as SeedersTeacherSeeder;
use Illuminate\Database\Seeder;
use TeacherSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            SeedersTeacherSeeder::class,
        ]);
    }
    
}
