<?php

namespace App\Console\Commands;

use App\Models\ManageDay;
use App\Models\User;
use App\Models\Escrow;
use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Console\Command;
use function Symfony\Component\VarDumper\Dumper\esc;

class BalanceCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'balance:cron';

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

	public function handle()
	{
		$day = ManageDay::firsOrFail();
		$escrows = Escrow::get();
		foreach ($escrows as $escrow) {
			$payment_date = Carbon::parse($escrow->payment_date); // Convert the string to a Carbon date object
			$pay_date = $payment_date->addDays($day->days)->format('M d, Y'); // Adding 5 days to the payment_date
			$cur_date = Carbon::now()->format('M d, Y');

			$payerUserId = $escrow->hire->client_id;
			$recUserId = $escrow->hire->proposser_id;
			$fixed_pay = $escrow->budget - $escrow->paid;
			$milestone_pay = $escrow->escrow_amount - $escrow->paid;

			if (strtotime($pay_date) < strtotime($cur_date)) {


				if (($fixed_pay == 0) && (empty($escrow->project_file))) {

					$payer_wallet = backWallet($escrow->paid,$payerUserId,$escrow->id,0);
					$rec_wallet = backWallet($escrow->paid,$recUserId,$escrow->id,1);

				}

				if (($escrow->project_file) && ($escrow->paid == 0))
				{

					$payer_wallet = paymentReceive($escrow->budget,$payerUserId,$escrow->id,1);
					$rec_wallet = paymentReceive($escrow->budget,$recUserId,$escrow->id,0);
				}
				if(($escrow->project_file)  && ($escrow->paid !=0))
				{
					\Log::info('Project completed');

				}
				if ((!$escrow->project_file)&&($escrow->paid == 0))
				{
					\Log::info('Project not completed');
				}

			}
		}
		return 0;
	}

}
