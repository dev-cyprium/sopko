<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DataRefresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs both migrate:fresh and db:seed commands';

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
        $this->call("migrate:fresh");
        $this->call("db:seed");
    }
}
