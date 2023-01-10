<?php

namespace App\Nova\Tools;

use App\Service\NotificationService;
use Laravel\Nova\Nova;

class ResourceManager extends \Laravel\Nova\Tools\ResourceManager
{
    /**
     * Build the view that renders the navigation links for the tool.
     *
     * @return \Illuminate\View\View
     */
    public function renderNavigation()
    {
        $notificationArray = NotificationService::getInstance()->getSidebarNotification();

        $request = request();
        $groups = Nova::groups($request);
        $navigation = Nova::groupedResourcesForNavigation($request);

        return view('nova::resources.navigation', [
            'navigation' => $navigation,
            'groups' => $groups,
            'notification' => $notificationArray,
        ]);
    }

}
