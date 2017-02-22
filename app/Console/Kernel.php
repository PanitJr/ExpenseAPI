<?php

namespace App\Console;

use App\Object\Expense\Expense;
use App\Object\Item\Item;
use App\Object\Opportunity\Opportunity;
use Illuminate\Console\Scheduling\Schedule as SysSchedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

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
        //$schedule->command('sf:promotion_discount_salesforce')->daily();
        $schedule->call(function (){
            $users = DB::table('users')->get();
            foreach ($users as $currentUser){
                $ativeOpps = Opportunity::where('active',1)->get();
                //var_dump($currentUser);
                foreach ($ativeOpps as $ativeOpp) {
                    $itemNotSubmit = DB::table('cc_items')->join('entitys', 'cc_items.id', '=', 'entitys.id')
                        ->where('ownerid', '=', $currentUser->id)
                        ->where('status', '<>', 2)
                        ->where('opportunity', '=', $ativeOpp->id)
                        ->select('cc_items.id')
                        ->get();
                    //var_dump($itemNotSubmit);
                    if(!empty($itemNotSubmit)){
                        $expense = new Expense();
                        $expense->opportunity=$ativeOpp->id;
                        $expense->status=1;
                        $expense->user_id=$currentUser->id;
                        $expense->approver = $currentUser->supervisor_id;
                        $expense->save();
                        $savedExpense = Expense::find($expense->id);
                        $totalPrice = 0;
                        foreach ($itemNotSubmit as $item){
                            $loadedItem = Item::find($item->id);
                            $loadedItem->status = 2;
                            $loadedItem->expense_id = $savedExpense->id;
                            $loadedItem->save();
                            $totalPrice += $loadedItem->cost;
                        }
                        $savedExpense->total_price= $totalPrice;
                        $savedExpense->expensename = $currentUser->user_name.'-Expense-'.$savedExpense->id;
                        $savedExpense->save();
                    }
                }
            }
        })->monthlyOn(24, '23:00');
    }
}
