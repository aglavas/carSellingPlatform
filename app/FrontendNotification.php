<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FrontendNotification extends Model
{
    const TRANSACTION_APPROVED = 'approved';
    const TRANSACTION_DENIED = 'denied';
    const ENQUIRY_STARTED = 'enquiry';

    const USER_BUYER = 'buyer';
    const USER_SELLER = 'seller';

    /**
     * @var string
     */
    protected $table = 'frontend_notification';

    /**
     * @var array
     */
    protected $fillable = ['type', 'user_id', 'causer_id', 'user_type', 'country', 'company_id'];
}
