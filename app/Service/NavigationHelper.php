<?php

namespace App\Service;

class NavigationHelper
{
    /**
     * Toggle active by route key
     *
     * @param string $key
     * @return string
     */
    public static function toggleActive(string $key)
    {
        $routeName = request()->route()->getName();

        if ($routeName === $key) {
            return 'text-gray-900 group inline-flex items-center space-x-2 text-base leading-6 font-medium hover:text-gray-900 focus:outline-none focus:text-gray-900 transition ease-in-out duration-150';
        }

        return 'text-gray-500 group inline-flex items-center space-x-2 text-base leading-6 font-medium hover:text-gray-900 focus:outline-none focus:text-gray-900 transition ease-in-out duration-150';
    }
}
