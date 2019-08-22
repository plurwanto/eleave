<?php

namespace App\Console\Commands;

use App\ElaHelper;
use Illuminate\Console\Command;

class NotifApproval extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notif:Approval';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'notification for approval if pending > 7 days';

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
     * @return mixed
     */
    public function handle()
    {
        $api = ElaHelper::myCurl('eleave/mail-notif/pending-leave-approval');
        $this->info($api);
    }
}
