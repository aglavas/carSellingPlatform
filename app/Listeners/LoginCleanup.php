<?php

namespace App\Listeners;

use App\Events\ImportFinished;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LoginCleanup
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * @param ImportFinished $importFinished
     */
    public function handle(Login $event)
    {
        session()->remove('url.intended');
    }
}
