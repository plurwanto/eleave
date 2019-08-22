<?php

namespace App\Console\Commands;

use App\ElaHelper;
use Illuminate\Console\Command;

class NotifEndContract extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notif:endContract';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'notification contract will end';

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
        $api = ElaHelper::myCurl('hris/notif/exp-contract');
        $this->info($api);
    }
}
