<?php

namespace App\Console\Commands;

use Mail;
use App\User;
use App\Stock;
use App\Staff;
use App\Departments;
use App\Mail\Inventory\StockBalanceMail;
use Illuminate\Console\Command;

class StockBalanceReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stock_balance:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reminder for low stock balance, scheduled for every Monday at 9 a.m.';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */

     public function handle()
     {
        $stock = Stock::where('status','1')->with('transaction')->get();

        $collect = [];

        foreach ($stock as $stock_list) {
            $total_bal = 0;

            foreach ($stock_list->transaction as $list) {
                $total_bal += ($list->stock_in - $list->stock_out);
            }

            if ($total_bal <= 10) {
                $collect[] = $stock_list->current_owner;
            }
        }

        $groupedCollect = array_unique($collect);

        $staff = Staff::whereIn('staff_id', $groupedCollect)->get();

        foreach ($staff as $staffs) {

            $email = new StockBalanceMail($staffs);

            $recipientEmail = isset($staffs->staff_email)
                ? $staffs->staff_email
                : 'norsyuhada.kahar@intec.edu.my';

            Mail::to($recipientEmail)->send($email);
        }
     }
}
