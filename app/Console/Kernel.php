<?php

namespace App\Console;

use Guzzle\Http\QueryAggregator\CommaAggregator;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Psy\Command\Command;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\ImportUsaUniversities::class,
        Commands\ImportGamesAndGenres::class,
        Commands\GroupableCheckCreate::class,
        Commands\ExportUniversities::class,
        Commands\ImportCollegeScoreCard::class,
        Commands\ParseUniversityLogo::class,
        Commands\ImportUniversityLogos::class,
        Commands\UniversityNaceSelect::class,
        Commands\ImportUniversityTeamLogos::class,
        Commands\ImportMajors::class,
        Commands\ImportCoaches::class,
        Commands\MailToCoaches::class,
        Commands\MailToSpartaUsers::class,
        Commands\ImportTwitts::class,
        Commands\MakeCoachOfUniversity::class,
        Commands\NotifyConfirmEmail::class,
        Commands\ImportFromUniversityAndVacancyToTeams::class,
        Commands\VarsityParser::class,
        Commands\UsersAvatarUpdate::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

        $schedule->command('users:notify-confirm-email')
                    ->dailyAt('13:00')
                    ->timezone('America/New_York');

        $schedule->command('users:varsity-parser')
                    ->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
