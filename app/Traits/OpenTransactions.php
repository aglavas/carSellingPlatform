<?php


namespace App\Traits;

use App\Transaction;
use App\User;
use Illuminate\Support\Facades\Auth;

trait OpenTransactions
{
    /**
     * Get open transactions
     *
     * @return mixed
     */
    public function openTransactions()
    {
        $identColumn = $this->identColumn;

        return Transaction::where('vehicle_type', get_class($this))->where('vehicle_ident', $this->$identColumn)->where(
            'status',
            Transaction::TRANSACTION_STATUS_IN_PROGRESS
        )->get();
    }

    /**
     * Get closed transactions for vehicle
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function closedTransactions()
    {
        $identColumn = $this->identColumn;

        return Transaction::with('buyer')->where('vehicle_type', get_class($this))->where('vehicle_ident', $this->$identColumn)->where(
            'status',
            '!=',
            Transaction::TRANSACTION_STATUS_IN_PROGRESS
        )->get();
    }

    /**
     * Get closed transactions for vehicle
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function approvedTransactions()
    {
        $identColumn = $this->identColumn;

        return Transaction::with('buyer')->where('vehicle_type', get_class($this))->where('vehicle_ident', $this->$identColumn)->where(
            'status',
            Transaction::TRANSACTION_STATUS_APPROVED
        )->get();
    }

    /**
     * Get open prospects
     *
     * @return mixed
     */
    public function openProspects()
    {
        return $this->openTransactions()->map(
            function ($transaction) {
                $user = Auth::user();
                $vehicle = $transaction->vehicle;
                $totalVehiclesRequested = Transaction::where('seller_company_id', $user->company_id)
                    ->where('car_data->country', $vehicle->country)
                    ->where('status', Transaction::TRANSACTION_STATUS_IN_PROGRESS)
                    ->where('buyer_id', $transaction->buyer_id)->count();
                return [
                    'user' => User::find($transaction->buyer_id),
                    'transaction' => $transaction,
                    'count' => $totalVehiclesRequested
                ];
            }
        );
    }
}
