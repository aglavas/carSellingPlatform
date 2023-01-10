<?php

namespace App\Actions;

use App\FrontendNotification;
use App\StockVehicle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Transaction;

class ApproveTransaction
{

    public function execute(Transaction $transaction)
    {
        DB::beginTransaction();

        $user = Auth::user();

        try {
            $transaction->status = Transaction::TRANSACTION_STATUS_APPROVED;
            $transaction->save();

            /** @var StockVehicle $vehicle */
            $vehicle = new $transaction->vehicle_type;
            $vehicle = $vehicle->where($vehicle->identColumn, $transaction->vehicle_ident)->firstOrFail();
            $vehicle->openTransactions()->each(
                function ($transaction) {
                    (new DenyTransaction())->execute($transaction);
                }
            );

            $vehicle->reserveVehicle();
            $vehicle->save();

            (new UpdateEnquiryStatus())->execute($transaction->enquiry);

            FrontendNotification::create([
                'causer_id' => $user->id,
                'user_id' => $transaction->buyer_id,
                'type' => FrontendNotification::TRANSACTION_APPROVED,
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
