<?php

namespace App\Http\Controllers\Livewire;

use App\FrontendNotification;
use App\Service\ChangeNotificationService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChangeNotification extends Component
{
    /**
     * @var bool
     */
    public $show = false;

    /**
     * @var int
     */
    public $approved = 0;

    /**
     * @var int
     */
    public $denied = 0;

    /**
     * @var int
     */
    public $enquiries = 0;

    /**
     * @var int
     */
    public $totalCount = 0;

    /**
     * @var array
     */
    public $notificationIdArray = [];

    /**
     * Mount the component
     *
     * @param ChangeNotificationService $notificationService
     */
    public function mount(ChangeNotificationService $notificationService)
    {
        $notificationArray = $notificationService->getNotifications();

        if (($notificationArray['approved'] > 0) || (($notificationArray['denied']) > 0) || (($notificationArray['enquiries']) > 0)) {
            $this->show = true;
        }

        $this->approved = $notificationArray['approved'];

        $this->denied = $notificationArray['denied'];

        $this->enquiries = $notificationArray['enquiries'];

        $this->notificationIdArray = $notificationArray['ids'];

        $this->totalCount = $this->approved + $this->denied + $this->enquiries;
    }

    /**
     * Mark notifications as seen
     *
     * @param ChangeNotificationService $notificationService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAsSeen(ChangeNotificationService $notificationService)
    {
        $notificationService->markAsSeen($this->notificationIdArray);

        $this->show = false;

        return redirect()->route('start');
    }

    /**
     * View changes and mark as seen
     *
     * @param ChangeNotificationService $notificationService
     * @param string $url
     * @return \Illuminate\Http\RedirectResponse
     */
    public function viewChanges(ChangeNotificationService $notificationService, string $url)
    {
        $notificationService->markAsSeen($this->notificationIdArray);

        $this->show = false;

        return redirect()->to($url);
    }


    /**
     * Render the component
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('frontend.livewire.change-notification');
    }
}
