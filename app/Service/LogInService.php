<?php

namespace App\Service;

use App\Exceptions\NewUserNotInvitedException;
use App\Mail\UserInvite;
use App\Notifications\InviteComplete;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class LogInService
{
    /**
     * Check if user is invited
     *
     * @param User $user
     * @return bool
     * @throws NewUserNotInvitedException
     */
    public function checkIfInvited(User $user)
    {
        $logInActivity = $user->logInActivity()->latest('created_at')->first();

        $inviteActivity = $user->inviteActivity()->latest('created_at')->first();

        if ($user->new_user && (!$inviteActivity)) {
            throw new NewUserNotInvitedException();
        }

        if (is_null($inviteActivity)) {
            return true;
        }

        if ($inviteActivity && is_null($logInActivity)) {
            Notification::send($user, new InviteComplete());
        }

        if ($inviteActivity && $logInActivity) {
            $inviteCarbon = Carbon::parse($inviteActivity->created_at);

            $logInCarbon = Carbon::parse($logInActivity->created_at);

            if ($inviteCarbon->greaterThan($logInCarbon)) {
                Notification::send($user, new InviteComplete());
            }
        }

        return true;
    }
}
