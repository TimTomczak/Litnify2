<?php

namespace Database\Seeders;

use App\Helpers\Helper;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MediumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Eloquent::unguard(); // Disable all mass assignable restrictions.

        $file=storage_path("sql\\medien.sql"); // path to sql file in storage
        $file_data=Helper::parseSqlAddPrefix($file); // adds prefix to INSERT INTO commands
        $file_data_chunks=Helper::chunkSql($file_data);
        $i=0;
        foreach ($file_data_chunks as $chunks){
            $i++;
            DB::unprepared($chunks);   // runs the sql file
            $this->command->info('Seeding Medien ... Teil '.$i.' seeded'); // console output that the table has been seeded
        }
        $this->command->info('Medien seeded!'); // console output that the table has been seeded
    }
}
