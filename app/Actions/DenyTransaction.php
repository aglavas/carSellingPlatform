<?php

namespace App\Actions;

use App\FrontendNotification;
use Illuminate\Support\Facades\DB;
use App\Transaction;
use Illuminate\Support\Facades\Auth;use Illuminate\Support\Facades\Notification;

class DenyTransaction
{

    public function execute(Transaction $transaction)
    {
        DB::beginTransaction();

        try {
            $transaction->status = Transaction::TRANSACTION_STATUS_DENIED;
            $transaction->save();
            (new UpdateEnquiryStatus())->execute($transaction->enquiry);

            $user = Auth::user();

            FrontendNotification::create([
                'causer_id' => $user->id,
                'user_id' => $transaction->buyer_id,
                'type' => FrontendNotification::TRANSACTION_DENIED,
                'user_type' => FrontendNotification::USER_BUYER,
            ]);

        } catch (\Exception $exception) {
            DB::rollBack();
            activity('carmarket')
                ->withProperties(['error' => $exception->getMessage()])
                ->log('Transaction approval failed.');
        }

        DB::commit();
    }
}
