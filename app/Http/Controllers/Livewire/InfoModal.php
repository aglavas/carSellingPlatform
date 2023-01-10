<?php

namespace App\Http\Controllers\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class InfoModal extends Component
{
    /**
     * @var string
     */
    public $content;

    /**
     * @var string
     */
    public $title;

    /**
     * @var bool
     */
    public $carBidder = false;

    /**
     * @var bool
     */
    public $show = false;

    /**
     * @var array
     */
    protected $listeners = ['showInfoModal', 'showCarBidderModal'];

    /**
     * Render the component
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('frontend.livewire.info-modal');
    }

    /**
     * Show info modal
     *
     * @param $title
     * @param $content
     * @param bool $carBidder
     */
    public function showInfoModal($title, $content, $carBidder = false)
    {
        $this->title = $title;
        $this->content = $content;

        if ($carBidder) {
            $this->carBidder = true;
        }

        $this->show = true;
    }

    /**
     * Show CarBidder modal
     *
     * @param $country
     */
    public function showCarBidderModal()
    {
        $this->carBidder = true;
        $this->title = 'Projected price';

        $user = Auth::user();

        $country = $user->country;

        if ($country === 'RS') {
            $this->content = 'The input prices are included all (eco) taxes, import costs, inspection costs and government fees.';
        } elseif ($country === 'HR') {
            $this->content = 'The input prices are included all (eco) taxes, import costs, homologation costs, forwarding service cost and government fees.';
        } elseif ($country === 'SI') {
            $this->content = 'The input prices are included all (eco) taxes, import costs, transport costs, conformity check costs and government fees.';
        } else {
            $this->content = 'The input prices are included all (eco) taxes, import costs and government fees.';
        }

        $this->show = true;
    }

    /**
     * Close modal
     */
    public function closeInfoModal()
    {
        $this->carBidder = false;
        $this->show = false;
    }
}
