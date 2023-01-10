<?php

namespace App\Http\Controllers\Livewire;

use App\Announcement;
use App\Service\AnnouncementService;
use Livewire\Component;

class AnnouncementBanner extends Component
{
    /**
     * @var bool
     */
    public $show = false;

    /**
     * @var Announcement
     */
    public $announcement;

    /**
     * Mount the component
     *
     * @param AnnouncementService $announcementService
     */
    public function mount(AnnouncementService $announcementService)
    {
        $this->getAnnouncement($announcementService);
    }

    /**
     * Render the component
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('frontend.livewire.announcement-banner');
    }

    /**
     * Mark the announcement as seen
     */
    public function markAsSeen()
    {
        $announcementService = resolve(AnnouncementService::class);

        $announcementService->markAsSeen($this->announcement);

        $this->getAnnouncement($announcementService);

        $this->redirectRoute('start');
    }

    /**
     * Learn more
     */
    public function learnMore()
    {
        $announcementService = resolve(AnnouncementService::class);

        $announcementService->markAsSeen($this->announcement);

        $this->getAnnouncement($announcementService);

        $this->redirectRoute('announcements');
    }

    /**
     * Get announcement
     *
     * @param AnnouncementService $announcementService
     */
    private function getAnnouncement(AnnouncementService $announcementService)
    {
        $announcement = $announcementService->getBannerAnnouncement();

        if ($announcement) {
            $this->announcement = $announcement;
            $this->show = true;
        } else {
            $this->announcement = null;
            $this->show = false;
        }
    }
}
