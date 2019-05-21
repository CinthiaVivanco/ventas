<?php

namespace App\Console;

use App\Console\Commands\EmailCumpleanios;
use App\Console\Commands\RefrigerioDosTarde;
use App\Console\Commands\RefrigerioTresMedia;
use App\Console\Commands\SalidaDobleTurno;
use App\Console\Commands\RefrigerioNoche;


use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        EmailCumpleanios::class,
        RefrigerioDosTarde::class,
        RefrigerioTresMedia::class,
        SalidaDobleTurno::class,
        RefrigerioNoche::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //$schedule->command('trabajador:cumpleanios')->dailyAt('17:40');
        $schedule->command('refrigeriodostarde:actualizarrefrigeriodostarde')->dailyAt('14:50');
        $schedule->command('refrigeriotresmedia:actualizarrefrigeriotresmedia')->dailyAt('16:00');

        $schedule->command('salidadobleturno:actualizarsalidadobleturno')->dailyAt('14:00');
        $schedule->command('refrigerionoche:actualizarrefrigerionoche')->dailyAt('23:00');

    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
