<?php

namespace Efdi\CarUploadNotification;

use App\Service\NotificationService;
use Laravel\Nova\Card;

class CarUploadNotification extends Card
{
    /**
     * The width of the card (1/3, 1/2, or full).
     *
     * @var string
     */
    public $width = '1/3';

    /**
     * Get the component name for the element.
     *
     * @return string
     */
    public function component()
    {
        return 'carUploadNotification';
    }

    /**
     * Get notification messages
     *
     * @return CarUploadNotification
     */
    public function notification()
    {
        $notificationCardArray = NotificationService::getInstance()->getCardNotification();

        return $this->withMeta([
            'carUploadNotification' => $notificationCardArray
        ]);
    }
}
