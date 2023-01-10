<?php

namespace App\Service;

use App\Enquiry;
use App\Transaction;

class TransactionService
{
    /**
     * Validate transaction
     *
     * @param Enquiry $enquiry
     * @param Transaction $transaction
     * @return bool
     */
    public function validateTransaction(Enquiry $enquiry, Transaction $transaction)
    {
        if (!$transaction->belongsToEnquiry($enquiry)) {
            abort(404);
        }

        return true;
    }

}
