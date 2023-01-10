<?php

namespace Efdi\Announcement;

use Illuminate\Mail\Markdown;
use Laravel\Nova\Card;

class Announcement extends Card
{
    /**
     * The width of the card (1/3, 1/2, or full).
     *
     * @var string
     */
    public $width = '1/2';

    /**
     * Get the component name for the element.
     *
     * @return string
     */
    public function component()
    {
        return 'announcement';
    }

    public function latestAnnouncements()
    {
        return $this->withMeta([
            'latestAnnouncements' => \App\Announcement::take(5)->latest()->get()->transform(function ($item, $key) {
                $item->content = (string)Markdown::parse($item->content);
                return $item;
            }),
        ]);
    }
}
