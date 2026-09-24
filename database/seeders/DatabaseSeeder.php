<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SiteSettingSeeder::class,
            ProductSeeder::class,
            GuideSeeder::class,
        ]);
    }
}

[executed on device: ubuntu-6gb-dal-x8mx (c447f909-fdcc-4121-9924-27a69d35e9b2)]