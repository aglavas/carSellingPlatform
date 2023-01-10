<?php

namespace App\Service;

use App\FrontendNotification;
use Illuminate\Support\Facades\Auth;

class ChangeNotificationService
{
    /**
     * @var FrontendNotification
     */
    public $notification;

    /**
     * @var \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public $user;

    /**
     * ChangeNotificationService constructor.
     * @param FrontendNotification $frontendNotification
     */
    public function __construct(FrontendNotification $frontendNotification)
    {
        $this->notification = $frontendNotification;
        $this->user = Auth::user();
    }

    /**
     * Get notifications
     *
     * @return array
     */
    public function getNotifications()
    {
        $lastLogin = $this->user->logInActivity()->latest('created_at')->get();

        if (!$lastLogin) {
            return $notificationArray = [
                'approved' => 0,
                'denied' => 0,
                'enquiries' => 0,
                'ids' => [],
            ];
        }

        if (count($lastLogin) == 1) {
            $lastLogin = $lastLogin->first();
        } elseif (count($lastLogin) >= 2) {
            $lastLogin = $lastLogin[1];
        }

        $lastLogin = $lastLogin->created_at->format('Y-m-d H:i:s');

        $notificationArray = [
            'approved' => 0,
            'denied' => 0,
            'enquiries' => 0,
            'ids' => [],
        ];


        $seenNotificationArray = $this->user->frontendNotification()->pluck('notification_id')->toArray();

        if ($this->user->hasRole(['Buyer', 'Administrator'])) {
            $notificationArray = $this->getBuyerNotification($lastLogin, $notificationArray, $seenNotificationArray);
        }

        if ($this->user->hasRole(['Uploader', 'Logistics', 'Administrator'])) {
            $notificationArray = $this->getSellerNotification($lastLogin, $notificationArray, $seenNotificationArray);
        }

        return $notificationArray;
    }

    /**
     * Mark as seen
     *
     * @param array $notificationIds
     * @return bool
     */
    public function markAsSeen(array $notificationIds)
    {
        $this->user->frontendNotification()->attach($notificationIds);

        return true;
    }

    /**
     * Map buyer notification
     *
     * @param string $lastLogin
     * @param array $notificationArray
     * @param array $seenNotificationArray
     * @return array
     */
    private function getBuyerNotification(string $lastLogin, array $notificationArray, array $seenNotificationArray)
    {
        $notificationCollection = $this->notification->where('user_id', $this->user->id)->where('user_type', FrontendNotification::USER_BUYER)->where('created_at', '>', $lastLogin)->whereNotIn('id', $seenNotificationArray)->get();

        foreach ($notificationCollection as $notification) {
            if ($notification->type === FrontendNotification::TRANSACTION_APPROVED) {
                $notificationArray['approved']++;
            } elseif ($notification->type === FrontendNotification::TRANSACTION_DENIED) {
                $notificationArray['denied']++;
            }

            array_push($notificationArray['ids'], $notification->id);
        }

        return $notificationArray;
    }

    /**
     * Map seller notification
     *
     * @param string $lastLogin
     * @param array $notificationArray
     * @param array $seenNotificationArray
     * @return array
     */
    private function getSellerNotification(string $lastLogin, array $notificationArray, array $seenNotificationArray)
    {
        $notificationCollection = $this->notification->where('country', $this->user->country)->where('company_id', $this->user->company_id)->where('user_type', FrontendNotification::USER_SELLER)->where('created_at', '>', $lastLogin)->whereNotIn('id', $seenNotificationArray)->get();

        foreach ($notificationCollection as $notification) {
            $notificationArray['enquiries']++;

            array_push($notificationArray['ids'], $notification->id);
        }

        return $notificationArray;
    }
}
