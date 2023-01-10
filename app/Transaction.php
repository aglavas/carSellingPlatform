<?php

namespace App;

use App\Export\TransactionExport;
use App\Interfaces\Exportable;
use App\Traits\Export;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Transaction extends Model implements Exportable
{
    use Export;

    const VEHICLE_STATUS_AVAILABLE = 'available';
    const VEHICLE_STATUS_REVIEWED = 'reviewed';
    const VEHICLE_STATUS_RESERVED = 'reserved';

    const TRANSACTION_STATUS_APPROVED = 'approved';
    const TRANSACTION_STATUS_DENIED = 'denied';
    const TRANSACTION_STATUS_IN_PROGRESS = 'in_progress';
    const TRANSACTION_STATUS_VEHICLE_REMOVED_DURING_TRANSACTION = 'vehicle_removed_during_transaction';

    public $exportFileName = 'transactions.xlsx';

    /**
     * @var string
     */
    public $exportClass = TransactionExport::class;

    /**
     * @var array
     */
    protected $casts = [
        'car_data' => 'json',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * @var array
     */
    protected $fillable = [
        'buyer_id',
        'seller_id',
        'vin',
        'car_data',
        'country',
        'status',
        'vehicle_type',
        'vehicle_ident',
        'seller_company_id'
    ];

    use HasFactory;

    /**
     * Transaction belongs to seller
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id', 'id');
    }

    /**
     * Transaction belongs to buyer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id', 'id');
    }

    /**
     * Transaction belongs to buyer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'seller_company_id', 'id');
    }

    /**
     * Transaction has one seller
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function enquiry()
    {
        return $this->belongsTo(Enquiry::class, 'enquiry_id', 'id');
    }

    /**
     * Transaction belongs to vehicle
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function vehicle()
    {
        $type = new $this->vehicle_type;

        $identColumn = $type->identColumn;

        return $this->morphTo(__FUNCTION__, 'vehicle_type', 'vehicle_ident', $identColumn);
    }

    /**
     * Check if transaction belongs to enquiry
     *
     * @param  Enquiry  $enquiry
     * @return bool
     */
    public function belongsToEnquiry(Enquiry $enquiry)
    {
        if ($this->enquiry_id == $enquiry->id) {
            return true;
        }

        return false;
    }

    /**
     * Scope users transactions
     *
     * @param $query
     * @return mixed
     */
    public function scopeOfUser($query)
    {
        return $query->where('seller_company_id', Auth::user()->company->id)->where(
            'country',
            Auth::user()->country
        )->orWhere('buyer_id', Auth::user()->id);
    }

    /**
     * Scope seller transactions
     *
     * @param $query
     * @return mixed
     */
    public function scopeOfSeller($query)
    {
        return $query->where('seller_company_id', Auth::user()->company->id)->where(
            'country',
            Auth::user()->country
        );
    }

    /**
     * Scope buyer transactions
     *
     * @param $query
     * @return mixed
     */
    public function scopeOfBuyer($query)
    {
        return $query->where('buyer_id', Auth::user()->id);
    }

    /**
     * Return additional data collection
     *
     * @return mixed
     */
    public function exportAdditionalData()
    {
        return User::role('Logistics')
            ->with('company')
            ->orderBy('name', 'ASC')
            ->get();
    }
}
