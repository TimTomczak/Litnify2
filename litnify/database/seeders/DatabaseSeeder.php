<?php

namespace Database\Seeders;

use App\Helpers\Helper;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->call([
            BerechtigungsrolleSeeder::class,
            LiteraturartSeeder::class,
            RaumSeeder::class,
            ZeitschriftSeeder::class,
            MediumSeeder::class,
            InventarlisteSeeder::class,
        ]);

        \Eloquent::unguard();

        DB::unprepared(File::get(storage_path("sql\weitere_Anpassungen.sql")));   // runs the sql file
        $this->command->info('Weitere Anpassungen durchgeführt!'); // console output that the table has been seeded

        \Eloquent::reguard();
    }
}
