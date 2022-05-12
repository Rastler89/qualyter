<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;
use App\Mail\ClientMonthly;
use App\Models\Client;
use App\Models\Stores;
use App\Models\Answer;

class MonthlyNote extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'note:monthly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        info("Cron Job running at ". now());
        $first_day = $this->first_month_day();
        $last_day = $this->last_month_day();

        $fathers = Client::where('delegation','=','00')->get();
        foreach($fathers as $father) {
            $sons = Client::where('father','=',$father->id);
            foreach($son as $client) {
                $stores = Store::where('client','=',$client->id)->get();

            }
        }
        //Mail::to('test@optimaretail.es')->send(new ClientMonthly());

        return 0;
    }
    /** Actual month last day **/
    private function last_month_day() { 
        $month = date('m');
        $year = date('Y');
        $day = date("d", mktime(0,0,0, $month, 0, $year));

        return date('Y-m-d', mktime(0,0,0, $month-1, $day, $year));
    }

    /** Actual month first day **/
    private function first_month_day() {
        $month = date('m');
        $year = date('Y');
        return date('Y-m-d', mktime(0,0,0, $month-1, 1, $year));
    }
}
