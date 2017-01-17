<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule as SysSchedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\cc_object::class,
        Commands\cc_field::class,
        Commands\cc_user::class,
        Schedule\promotion_discount_salesforce::class,
        Schedule\sync_import_erp::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(SysSchedule $schedule)
    {
        $schedule->command('sf:promotion_discount_salesforce')->daily();
    }
}
