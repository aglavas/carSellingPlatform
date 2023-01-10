<?php

namespace App\Exceptions;

use Exception;

class NewUserNotInvitedException extends Exception
{
    /**
     * Exception report
     *
     * @return bool
     */
    public function report()
    {
        return false;
    }

    /**
     * Exception render
     *
     * @return \Illuminate\Http\Response
     */
    public function render()
    {
        return response()->view('auth.registerSuccess');
    }
}
