<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class InviteUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invite:user {user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Invite User';

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
        $userId = $this->argument('user');

        $user = User::findOrFail($userId);
        $token = app(PasswordBroker::class)->createToken($user);
        Notification::send($user, new \App\Notifications\InviteUser($token, $user));
    }
}
