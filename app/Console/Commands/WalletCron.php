<?php

namespace App\Console\Commands;

use App\Models\Escrow;
use Illuminate\Console\Command;
use function Symfony\Component\VarDumper\Dumper\esc;

class WalletCron extends Command
{
    protected $signature = 'Wallet:cron';

    protected $description = 'Update payer_wallet and rec_wallet using cron.';

    public function __construct()
    {
        parent::__construct();
    }

	public function handle()
	{
		$escrows = Escrow::get();
		$cur_date = now()->format('M d, Y');

		foreach ($escrows as $escrow) {
			$escrow->escrow_amount = 10;
		}
	}

	// Define the backWallet method as a static function
	private static function backWallet($amount, $user_id, $action = 0)
	{
		$user = User::find($user_id);
		$balance = 0;
		if ($action == 0) {
			$balance = $user->balance + $amount;
			$user->balance = $balance;
		} elseif ($action == 1) {
			$balance = $user->balance - $amount;
			$user->balance = $balance;
		}
		$user->save();
		return $balance;
	}
}
