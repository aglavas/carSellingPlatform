<?php

namespace App\Http\Controllers;

use App\Actions\DenyTransaction;
use App\Transaction;
use Illuminate\Http\Request;

class DenyTransactionController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Transaction $transaction)
    {
        (new DenyTransaction())->execute($transaction);
        if ($request->ajax()) {
            return $transaction;
        }
        return back();
    }
}
