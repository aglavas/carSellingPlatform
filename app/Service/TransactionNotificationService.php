<?php

namespace App\Service;

use App\Notifications\TransactionsCompleted;
use App\Transaction;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

class TransactionNotificationService
{
    /**
     * Notify buyers
     *
     * @return bool
     */
    public function __invoke()
    {
        $transactionCollection = Transaction::where('status', '!=', Transaction::TRANSACTION_STATUS_IN_PROGRESS)->where('notified_at', null)->get();

        $transactionIdArray = $transactionCollection->pluck('id')->toArray();

        $transactionCollection = $transactionCollection->groupBy('buyer_id');

        foreach ($transactionCollection as $userId => $transactions) {
            $user = User::find($userId);

            $transactionCount = count($transactions);

            Notification::route('mail', $user->email)->notify(new TransactionsCompleted($transactionCount));
        }

        if (count($transactionIdArray)) {
            Transaction::whereIn('id', $transactionIdArray)->update(['notified_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        }

        return true;
    }

}
