<?php

namespace App\Console\Commands;

use App\Models\BasicControl;
use App\Models\ManageDay;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ListingCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'listing:cron';

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
		$day = BasicControl::firstOrFail();
		$orders = Order::get();
		$cur_date = Carbon::now()->format('M d, Y');
		foreach ($orders as $order)
		{
			$delivery_date = Carbon::parse($order->delivery_date);
			$pay_date = $delivery_date->addDays($day->days)->format('M d, Y');

			if (strtotime($pay_date) <= strtotime($cur_date))
			{
				if((!$order->file) && ($order->amount))
				{

					returnWallet($order->amount,$order->user_id,$order->id, 0);
					returnWallet($order->amount,$order->influencer_id,$order->id, 1);

				}

				elseif(($order->payable_amount == 0) && ($order->file))
				{
					addWallet($order->amount,$order->user_id,$order->id,0);
					addWallet($order->amount,$order->influencer_id,$order->id,1);

				}

			}
			else{
				\Log::info('no');
			}
		}
        return 0;
    }
}
