<?php

namespace App\Console\Commands;

use App\Jobs\SendWelcomeEmailJob;
use App\Models\User;
use Illuminate\Console\Command;

class SendWelcomeEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:welcome-email {user_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a welcome email to a specific user';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->argument('user_id');
        $user = User::find($userId);

        if (!$user) {
            $this->error('User not found');
            return;
        }

        // Dispatch the job
        SendWelcomeEmailJob::dispatch($user);
        $this->info("Welcome email queued for user: {$user->name}");
    }
}
