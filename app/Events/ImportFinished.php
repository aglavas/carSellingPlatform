<?php

namespace App\Events;

use App\StockListUpload;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;

class ImportFinished
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var User
     */
    public $user;

    /**
     * @var StockListUpload
     */
    public $stockListUpload;

    /**
     * @var array
     */
    public $vinArray;

    /**
     * ImportFinished constructor.
     * @param User $user
     * @param StockListUpload $stockListUpload
     */
    public function __construct(User $user, StockListUpload $stockListUpload)
    {
        $this->user = $user;

        $this->stockListUpload = $stockListUpload;

        $this->vinArray = App::make('vin_candidates', []);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
