<?php

namespace App\Http\Controllers\Livewire;

use App\Transaction;
use Livewire\Component;

class TransactionManagement extends Component
{
    /**
     * @var bool
     */
    public $show = false;

    /**
     * @var Transaction
     */
    public $transaction;

    /**
     * @var array
     */
    protected $listeners = ['openTransactionModal'];

    /**
     * Render the component
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('frontend.livewire.transaction-management');
    }

    /**
     * Open transaction management modal
     *
     * @param $transactionId
     */
    public function openTransactionModal($transactionId)
    {
        $this->transaction = Transaction::findOrFail($transactionId);
        $this->show = true;
    }

    /**
     * Approve transaction
     */
    public function approve()
    {
        $this->redirectAction(route('transaction.approve', $this->transaction));
    }

    /**
     * Deny transaction
     */
    public function deny()
    {
        $this->redirectAction(route('transaction.deny', $this->transaction));
    }

    /**
     * Close the modal
     */
    public function close()
    {
        $this->show = false;
    }
}
