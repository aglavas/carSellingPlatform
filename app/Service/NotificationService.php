<?php

namespace App\Service;

use App\Notification;
use Illuminate\Support\Facades\Auth;
use App\Imports\StockUsedCentralEuropeImport;


class NotificationService
{
    /**
     * @var Notification
     */
    private $notification;

    /**
     * @var self
     */
    private static $instance;

    /**
     * @var \Illuminate\Contracts\Auth\Authenticatable|null
     */
    private $user;

    /**
     * NotificationService constructor.
     */
    public function __construct()
    {
        $this->notification = new Notification();
        $this->user = Auth::user();
    }

    /**
     * Get instance
     *
     * @return NotificationService
     */
    public static function getInstance()
    {
        if ( is_null( self::$instance ) )
        {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Get sidebar notification data
     *
     * @return array
     */
    public function getSidebarNotification()
    {
        $notificationCollection = $this->getNotificationMapping();

        $notificationArray = [];

        foreach ($notificationCollection as $notification) {
            $concreteClass = config('importMapping')[$notification->list_type];

            if ($concreteClass) {
                if (isset($notificationArray[$concreteClass])) {
                    $notificationArray[$concreteClass] = $notificationArray[$concreteClass] + $notification->data_count;
                } else {
                    $notificationArray[$concreteClass] = $notification->data_count;
                }
            }
        }

        return $notificationArray;
    }

    /**
     * Get sidebar notification data
     *
     * @return array
     */
    public function getCardNotification()
    {
        $notificationCollection = $this->getNotificationMapping();

        $notificationMessageArray = [];

        foreach ($notificationCollection as $notification) {
            $resourceClass = config('importMapping')[$notification->list_type];

            if ($notification->list_type === StockUsedCentralEuropeImport::class) {
                if ($notification->event_type === \App\Notification::UPLOAD_NEW_VIN) {
                    $message = [
                        'type' => 'Used',
                        'label' => "{$notification->data_count} new cars have been added."
                    ];
                } else {
                    $message = [
                        'type' => 'Used',
                        'label' => "{$notification->data_count} existing cars has updated the price."
                    ];
                }
            } else {
                $list = config('importNotificationMessage')[$notification->list_type];

                $message = [
                    'type' => 'New',
                    'label' => "{$notification->data_count} new cars have been added. " . $list
                ];
            }

            $uriKey = $resourceClass::uriKey();

            $message['uriKey'] = $uriKey;

            array_push($notificationMessageArray, $message);

            $message = [];
        }

        return $notificationMessageArray;
    }

    /**
     * Mark notifications as seen
     *
     * @deprecated
     *
     * @param string $resource
     * @return bool
     */
    public function markAsSeen(string $resource = null)
    {
        if ($resource) {
            $user = $this->user;

            $notificationCollection = Notification::whereDoesntHave('users', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->where('list_type', $resource)->get();

            $unreadNotificationIds = $notificationCollection->pluck('id')->toArray();

            if (count($unreadNotificationIds)) {
                $user->notifications()->attach($unreadNotificationIds);
            }
        }

        return true;
    }

    /**
     * Get updates based on VIN number
     *
     * @param string $listType
     * @return array
     */
    public function getNotificationUpdates(string $listType)
    {
        $user = $this->user;

        $lastLogin = $user->logInActivity()->latest('created_at')->first()->created_at->format('Y-m-d H:i:s');

//        $notificationCollection = Notification::whereDoesntHave('users', function ($query) use ($user) {
//            $query->where('user_id', $user->id);
//        })->where('list_type', $listType)->where('created_at', '>', $lastLogin)->get();

        $notificationCollection = $this->notification->where('user_id', $user->id)->where('created_at', '>', $lastLogin)->get();

        $mergedUpdateArray = [];

        if (count($notificationCollection)) {
            $metaDataIdArray = $notificationCollection->pluck('meta_data')->toArray();

            $mergedUpdateArray = array_merge(...$metaDataIdArray);

            $mergedUpdateCollection = collect($mergedUpdateArray);

            $mergedUpdateVinArray =  $mergedUpdateCollection->pluck('vin')->toArray();

            $duplicateVinArray = array_unique(array_diff_assoc($mergedUpdateVinArray, array_unique($mergedUpdateVinArray)));

            foreach ($duplicateVinArray as $key => $duplicatedVin) {
                if (isset($mergedUpdateArray[$key])) {
                    unset($mergedUpdateArray[$key]);
                }
            }
        }

        return $mergedUpdateArray;
    }

    /**
     * Check if vin updated
     *
     * @param array $updatedVinArray
     * @param string $vin
     * @return bool
     */
    public function checkIfUpdated(array $updatedVinArray, string $vin)
    {
        $updatedVinCollection = collect($updatedVinArray);

        $updatedVinArray = $updatedVinCollection->pluck('vin')->toArray();

        return in_array($vin, $updatedVinArray);
    }

    /**
     * Get notification mapping for logged in user
     *
     * @return mixed
     */
    private function getNotificationMapping()
    {
        $user = $this->user;

        $lastLogin = $user->logInActivity()->latest('created_at')->first()->created_at->format('Y-m-d H:i:s');

//        $notificationCollection = $this->notification->whereDoesntHave('users', function ($query) use ($user, $lastLogin) {
//            $query->where('user_id', $user->id);
//        })->where('created_at', '>', $lastLogin)->get();

        $notificationCollection = $this->notification->where('user_id', $user->id)->where('created_at', '>', $lastLogin)->get();

        return $notificationCollection;
    }
}
