<?php

namespace App\Console\Commands\Lineshop;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DailyReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:report';

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
        //get all client
        $clients = \App\Models\LineshopCLient::where('status', 1)->get();

        //get CLIENT_ID  from linesho.clients
        foreach ($clients as $key => $client) {
            $client_id = DB::connection('lineshop')->select("select id from sma_clients where name ='" . $client->username . "'");
            if (!empty($client_id)) {
                $clientId = $client_id[0]->id;
                $sales = DB::connection('lineshop')->select('select count(*) as total from sma_sales where client_id =' . $clientId);
                Log::info($clientId . ": Total sales:".$sales[0]->total);
            } else {
                Log::info("Client ID not found for username: " . $client->username);
            }
        }
        return 0;
    }
}
