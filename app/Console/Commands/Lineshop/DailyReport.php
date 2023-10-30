<?php

namespace App\Console\Commands\Lineshop;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use \App\Http\Controllers\Controller;

class DailyReport extends Command
{
    /**
     * The product_name and signature of the console command.
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
        //check time to sent report at 23:00 EAT
        if (date('H:i' == '23:45')) {
            //get all client
            $clients = \App\Models\LineshopCLient::where('status', 1)->get();

            //get CLIENT_ID  from linesho.clients
            foreach ($clients as $key => $client) {
                $client_id = DB::connection('lineshop')->select("select id from sma_clients where name ='" . $client->username . "'");
                if (!empty($client_id)) {
                    $clientId = $client_id[0]->id;
                    $date_from = date('Y-m-d 00:00:00');
                    $date_to = date('Y-m-d 23:59:59');
                    $where = " a.client_id =" . $clientId . " and date between '" . $date_from . "' and '" . $date_to . "'";

                    //daily sales 
                    $sales = DB::connection('lineshop')->select("select sum(total-product_discount) as total from sma_sales a where " . $where);
                    $daily_sales_message = "Total Daily sales: " . number_format($sales[0]->total, 2);

                    // best seller
                    $best_sellers = DB::connection('lineshop')->select("SELECT product_name, product_code, SUM(quantity) as quantity
                FROM sma_sales a
                LEFT JOIN sma_sale_items  ON a.id = sma_sale_items.sale_id
                WHERE " . $where . "and a.client_id = sma_sale_items.client_id
                GROUP BY product_name, product_code
                ORDER BY SUM(quantity) DESC
                LIMIT 10");
                    $best_seller_message = 'Best seller:';
                    if (!empty($best_sellers)) {
                        foreach ($best_sellers as $best_seller) {
                            $best_seller_message .= ' Product name: ' . $best_seller->product_name . '(' . $best_seller->product_code . ') - Quantity: ' . number_format($best_seller->quantity) . ",";
                        }
                    } else {
                        $best_seller_message .= ' 0 ';
                    }

                    // Returned products
                    $returned_products = DB::connection('lineshop')->select("SELECT product_name, product_code, SUM(quantity) as quantity
                FROM sma_returns a
                LEFT JOIN sma_return_items  ON a.id = sma_return_items.return_id
                WHERE " . $where . "and a.client_id = sma_return_items.client_id
                GROUP BY product_name, product_code
                ORDER BY SUM(quantity) DESC");
                    $returned_products_message = '';
                    if (!empty($returned_products)) {
                        foreach ($returned_products as $returned_product) {
                            $returned_products_message .= 'Returned Products: Product name: ' . $returned_product->product_name . '(' . $returned_product->product_code . ') - Quantity: ' . number_format($returned_product->quantity) . ",";
                        }
                    } else {
                        $returned_products_message = 'Returned Products: 0 ';
                    }

                    //Expired Products in 30 days
                    $after = date('Y-m-d', strtotime("+30 days"));
                    $expired_products_message = 'Expired Products: ';
                    $expired_products = DB::connection('lineshop')->select("SELECT COUNT(*) as expired FROM sma_products WHERE  end_date between '" . $date_from . "' AND '" . $after . "' AND client_id = " . $clientId);
                    if (!empty($expired_products) && $expired_products[0]->expired > 0) {
                        $expired_products_message .= $expired_products[0]->expired . " will expire within next 30 days";
                    } else {
                        $expired_products_message .= '0';
                    }
                    // Products that are about to end
                    $low_quantity = DB::connection('lineshop')->select("SELECT COUNT(*) AS total from sma_products where quantity <= alert_quantity and client_id =" . $clientId);
                    $low_quantity_message = 'Low balance Products: ';
                    if (!empty($low_quantity) && $low_quantity[0]->total > 0) {
                        $low_quantity_message .= $low_quantity[0]->total . " products are about to end";
                    } else {
                        $low_quantity_message .= '0';
                    }

                    //client_phone number 
                    $phone = $client->phone;
                    //format phone number
                    $phone = \collect(DB::select("select * from admin.format_phone_number('" . $phone . "')"))->first();
                    $phonenumber = $phone->format_phone_number;
                    //message content/body
                    $message = 'Dear Sir/Madam. ';
                    $message .= 'Kindly find Daily Report of ' . date('Y-m-d') . ' as follows: ';
                    $message .= $daily_sales_message . '. ';
                    $message .= substr($best_seller_message, 0, -1) . '. ';
                    $message .= substr($returned_products_message, 0, -1) . '. ';
                    $message .= $expired_products_message . '. ';
                    $message .= $low_quantity_message . '. ';
                    // save normal message to the database
                    $controller = new Controller;
                    $controller->send_sms($phonenumber, $message, $priority = 1, $sent_from = 'quick-sms', $project='lineshop');

                    // save whatsapp message to the database
                    $controller->send_whatsapp_sms($client->phone, $message, null, 'lineshop');
                    // Print out success message
                    Log::info("Message sent to the client");
                } else {
                    Log::info("Client ID not found for username: " . $client->username);
                }
            }
        }
        return 0;
    }
}
