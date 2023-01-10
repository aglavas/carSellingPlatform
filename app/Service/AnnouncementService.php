<?php

namespace App\Service;

use App\Announcement;
use App\UserAnnouncement;
use Illuminate\Support\Facades\Auth;

class AnnouncementService
{
    /**
     * @var Announcement
     */
    private $announcement;

    /**
     * @var \Illuminate\Contracts\Auth\Authenticatable|null
     */
    private $user;

    /**
     * NotificationService constructor.
     */
    public function __construct()
    {
        $this->announcement = new Announcement();
        $this->user = Auth::user();
    }

    /**
     * Get sidebar notification data
     *
     * @return array
     */
    public function getBannerAnnouncement()
    {
        $announcementCollection = $this->getAnnouncements();

        $seenAnnouncementArray = $this->getSeenAnnouncements();

        foreach ($seenAnnouncementArray as $announcementId) {
            if ($announcementCollection->has($announcementId)) {
                $announcementCollection->forget($announcementId);
            }
        }

        if (count($announcementCollection)) {
            return $announcementCollection->first();
        }

        return null;
    }

    /**
     * Mark announcement as seen
     *
     * @param Announcement $announcement
     * @return bool
     */
    public function markAsSeen(Announcement $announcement)
    {
        $user = $this->user;

        $user->seenAnnouncements()->attach($announcement);

        return true;
    }

    /**
     * Get notification mapping for logged in user
     *
     * @return mixed
     */
    private function getAnnouncements()
    {
        $user = $this->user;
        
        $lastLogin = $user->logInActivity()->latest('created_at')->get();

        if (count($lastLogin)) {
            if (isset($lastLogin[1])) {
                $lastLogin = $lastLogin[1]->created_at->format('Y-m-d H:i:s');
            } else {
                $lastLogin = $lastLogin[0]->created_at->format('Y-m-d H:i:s');
            }

            $announcementCollection = $this->announcement->where('created_at', '>', $lastLogin)->get()->keyBy('id');
        } else {
            $announcementCollection = collect([]);
        }


        return $announcementCollection;
    }

    /**
     * Get notification mapping for logged in user
     *
     * @return mixed
     */
    private function getSeenAnnouncements()
    {
        $user = $this->user;

        $seenAnnouncementArray = UserAnnouncement::where('user_id', $user->id)->pluck('announcement_id')->toArray();

        return $seenAnnouncementArray;
    }
}
