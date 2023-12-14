<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserProfile;
use App\Models\ManageDay;
use Illuminate\Support\Carbon;

class LimitCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'limit:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Daily limit update';

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
		$user_profiles = UserProfile::all();
		$now = Carbon::now()->format('Y-m-d H:i:s');

		foreach($user_profiles as $profile)
		{
			$nextUpdate = Carbon::parse($profile->updated_at)->addDay()->format('Y-m-d H:i:s');
			if($nextUpdate <= $now)
			{
				$profile->daily_limit = basicControl()->daily_limit;
				$profile->save();
			}
		}

        return 0;
    }
}
