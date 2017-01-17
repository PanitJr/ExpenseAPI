<?php

namespace App\Console\Schedule;

use Log;
use Carbon\Carbon;
use Illuminate\Console\Command;

use App\Sync\ERP\Stock;
use App\Sync\ERP\INV;
use App\Sync\ERP\DOS;

class sync_import_erp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'erp:sync_import_erp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Data form ERP to update salesforce';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        var_dump('run erp:sync_import_erp');
        // Stock::import_erp();   
        // INV::import_erp();   
        DOS::import_erp();   
    }
}
