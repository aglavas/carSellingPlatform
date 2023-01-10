<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Enquiry extends Model
{
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_FINISHED = 'reviewed';

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'status'
    ];

    /**
     * @var array
     */
    protected $dates = ['created_at'];

    use HasFactory;

    /**
     * Enquiry has many transactions
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'enquiry_id', 'id');
    }

    public function transactionsInProgress() {
        return Transaction::where('enquiry_id', $this->id)->where(
            'status',
            Transaction::TRANSACTION_STATUS_IN_PROGRESS
        )->count();
    }
}
