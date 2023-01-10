<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles, HasFactory;

    protected $with = ['brands', 'company'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'function_description',
        'telephone',
        'mobile',
        'avatar',
        'company_id',
        'country',
        'function_description',
        'telephone',
        'mobile',
        'stock_type',
        'import_types',
        'company_suggestion',
        'new_user',
        'vehicle_type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'vehicle_type' => 'json'
    ];

    public function brands()
    {
        return $this->belongsToMany(Brand::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function getEmailAttribute($value)
    {
        return strtolower($value);
    }

    /**
     * Check if user is seller
     *
     * @return bool
     */
    public function isSeller()
    {
        return $this->hasRole(['Uploader', 'Logistics']);
    }

    /**
     * Check if user is one of roles
     *
     * @param array $roles
     * @return bool
     */
    public function isOneOfRoles(array $roles)
    {
        return $this->hasRole($roles);
    }

    /**
     * Check if user is seller
     *
     * @return bool
     */
    public function isBuyer()
    {
        return $this->hasRole(['Buyer']);
    }

    /**
     * Check if user is seller
     *
     * @return bool
     */
    public function isStaffMember()
    {
        return $this->isUploader() && $this->isLogistics();
    }

    /**
     * Check if user is uploader
     *
     * @return bool
     */
    public function isUploader()
    {
        return $this->hasRole(['Uploader']);
    }

    /**
     * Check if user is uploader
     *
     * @return bool
     */
    public function isLogistics()
    {
        return $this->hasRole(['Logistics']);
    }

    /**
     * Check if user is both buyer and seller
     *
     * @return bool
     */
    public function isBuyerAndSeller()
    {
        return $this->isBuyer() && $this->isSeller();
    }

    /**
     * Check if user is both buyer and seller
     *
     * @return bool
     */
    public function isBuyerAndLogistics()
    {
        return $this->isBuyer() && $this->isLogistics();
    }

    /**
     * Check if user is seller
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->hasRole(['Administrator']);
    }

    /**
     * Get saved filters
     *
     * @param $vehicleType
     * @return mixed
     */
    public function getFilters($vehicleType)
    {
        $this->load(['filterSearches' => function ($query) use ($vehicleType) {
            $query->where('vehicle_type', $vehicleType);
        }]);

        if (count($this->filterSearches)) {
            $filterCollection = $this->filterSearches;

            return $filterCollection;
        }

        return false;
    }

    /**
     * User belongs to many vehicle bookmarks
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function bookmarks()
    {
        return $this->belongsToMany(StockVehicle::class, 'user_vehicle_selected_pivot_table', 'user_id', 'manufacturer_id');
    }

    /**
     * User morphs to many log activity
     */
    public function activity()
    {
        return $this->morphMany(ActivityLog::class, 'subject');
    }

    /**
     * User morphs to many log in activity
     */
    public function logInActivity()
    {
        return $this->morphMany(ActivityLog::class, 'subject')->where('log_name', 'login_success');
    }

    /**
     * User morphs to many invite activity
     */
    public function inviteActivity()
    {
        return $this->morphMany(ActivityLog::class, 'subject')->where('log_name', 'invite_success');
    }

    /**
     * User has many used car uploads
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function usedCarUploads()
    {
        return $this->hasMany(StockListUpload::class, 'uploader_id', 'id');
    }

    /**
     * User can have many cart items
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'user_id', 'id');
    }

    /**
     * User can have many enquiries
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function enquiry()
    {
        return $this->hasMany(Enquiry::class, 'user_id', 'id');
    }

    /**
     * User can have many wishlist items
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function wishlistItems()
    {
        return $this->hasMany(WishlistItems::class, 'user_id', 'id');
    }

    /**
     * User can have many filter searches
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function filterSearches()
    {
        return $this->hasMany(FilterSearch::class, 'user_id', 'id');
    }

    /**
     * User has column preference
     *
     * @param $type
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function columnPreference($type)
    {
        return $this->hasOne(ColumnPreference::class, 'user_id', 'id')->where('vehicle_type', $type);
    }

    /**
     * Get avatar URL
     *
     * @return string
     */
    public function avatarUrl()
    {
        return $this->avatar
            ? Storage::disk('public')->url($this->avatar)
            : 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($this->email)));
    }

    /**
     * User notification
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function notifications()
    {
        return $this->belongsToMany(Notification::class, 'user_notification_pivot', 'user_id', 'notification_id');
    }

    /**
     * User can have many frontend notification
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function frontendNotification()
    {
        return $this->belongsToMany(FrontendNotification::class, 'user_frontend_notification_pivot', 'user_id', 'notification_id');
    }

    /**
     * User can have many seen announcements
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function seenAnnouncements()
    {
        return $this->belongsToMany(Announcement::class, 'user_announcement_pivot', 'user_id', 'announcement_id');
    }

    /**
     * Scope new users
     *
     * @param $query
     * @return mixed
     */
    public function scopeNewUsers($query)
    {
        return $query->where('new_user', 1)->doesnthave('inviteActivity');
    }

    /**
     * Get nova user link
     *
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function getLink()
    {
        return url('nova/resources/users/' . $this->id);
    }

    /**
     * Get users country in iso
     *
     * @return string
     */
    public function getCountry()
    {
        return strtolower($this->country);
    }
}
