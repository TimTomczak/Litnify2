<?php

namespace App\Console;

use App\Mail\AusleiheEndet;
use App\Models\Ausleihe;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Mail;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        // Alle Nutzer mit Ausleihen, die in 7 Tagen ablaufen: (new Ausleihe())->faelligInTagen(7)->pluck('user')->unique()


        $schedule->call(function (){
            $ausleihen_due_in_seven_days=(new Ausleihe())->faelligInTagen(7);
            $users_with_ausleihen_in_seven_days=$ausleihen_due_in_seven_days->pluck('user')->unique();

            foreach ($users_with_ausleihen_in_seven_days as $user) {
                Mail::to($user->email)->send(
                    (new AusleiheEndet($ausleihen_due_in_seven_days->where('user_id','=',$user->id),$user))
                );
            }
        })->dailyAt('07:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
