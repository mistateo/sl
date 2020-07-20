<?php

namespace App\Console\Commands;

use App\Jobs\SendEmail;
use App\Models\User;
use Illuminate\Console\Command;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendEmails:welcome';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a bare-bones welcome email';

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
        //Seed a queue system with 100k+ messages to process (UserSeeder added 150k users)
        User::chunk(1000, function ($users) {
            foreach ($users as $user) {
                SendEmail::dispatch($user);
            }
        });

        return 0;
    }
}
