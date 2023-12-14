<?php

namespace App\Console;

use App\Console\Commands\BalanceCron;
use App\Console\Commands\BlockIoIPN;
use App\Console\Commands\DailyLimitCron;
use App\Console\Commands\LimitCron;
use App\Console\Commands\CryptoCurrencyUpdate;
use App\Console\Commands\FiatCurrencyUpdate;
use App\Console\Commands\ListingCron;
use App\Console\Commands\WalletCron;
use App\Models\Gateway;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
		BlockIoIPN::class,
		LimitCron::class,
		BalanceCron::class,
		ListingCron::class,

	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param \Illuminate\Console\Scheduling\Schedule $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{
		$basicControl = basicControl();
		$blockIoGateway = Gateway::where(['code' => 'blockio', 'status' => 1])->count();
		if ($blockIoGateway == 1) {
			$schedule->command('blockIo:ipn')->everyThirtyMinutes();
		}

		$schedule->command('limit:cron')->daily();
		$schedule->command('listing:cron')->everyMinute();
		$schedule->command('balance:cron')->everyMinute();
	}

	/**
	 * Register the commands for the application.
	 *
	 * @return void
	 */
	protected function commands()
	{
		$this->load(__DIR__ . '/Commands');

		require base_path('routes/console.php');
	}
}
