<?php

namespace App\Http\Controllers;

use App\Actions\ApproveTransaction;
use App\Http\Requests\Transaction\TransactionApprovalRequest;
use App\Transaction;
use Illuminate\Http\Request;

class ApproveTransactionController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param TransactionApprovalRequest $request
     * @param Transaction $transaction
     * @return Transaction|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(TransactionApprovalRequest $request, Transaction $transaction)
    {
        (new ApproveTransaction())->execute($transaction);
        if ($request->ajax()) {
            return $transaction;
        }
        return back();
    }
}
