<?php
namespace App\Console\Commands;

use App\Mail\EmailDigestNews;
use App\Models\News;
use Mail;
use Storage;
use DB;
use Carbon\Carbon;
use Illuminate\Console\Command;

class MailCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check emails.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

    }
}
