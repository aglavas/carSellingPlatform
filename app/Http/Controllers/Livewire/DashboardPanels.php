<?php

namespace App\Http\Controllers\Livewire;

use App\Transaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DashboardPanels extends Component
{

    /**
     * @var integer
     */
    public $openSellerRequests = 0;

    /**
     * @var integer
     */
    public $acceptedSellerRequests = 0;

    /**
     * @var integer
     */
    public $declinedSellerRequests = 0;

    /**
     * @var integer
     */
    public $openRequests = 0;

    /**
     * @var integer
     */
    public $acceptedRequests = 0;

    /**
     * @var integer
     */
    public $declinedRequests = 0;


    public function mount()
    {
        $previous_week = strtotime("-2 week");
        $end_week = strtotime("now");
        $start_week = date("Y-m-d H:i", $previous_week);
        $end_week = date("Y-m-d H:i", $end_week);

        $this->openRequests = Transaction::ofBuyer()->where('status', 'in_progress')->count();
        $this->acceptedRequests = Transaction::ofBuyer()->where('status', 'approved')->whereBetween('updated_at', [$start_week, $end_week])->count();
        $this->declinedRequests = Transaction::ofBuyer()->where('status', 'denied')->whereBetween('updated_at', [$start_week, $end_week])->count();
        
        $this->openSellerRequests = Transaction::ofSeller()->where('status', 'in_progress')->count();
        $this->acceptedSellerRequests = Transaction::ofSeller()->where('status', 'approved')->whereBetween('updated_at', [$start_week, $end_week])->count();
        $this->declinedSellerRequests = Transaction::ofSeller()->where('status', 'denied')->whereBetween('updated_at', [$start_week, $end_week])->count();
    }

    /**
     * Get open requests URL
     *
     */
    public function openRequests()
    {
        $user = Auth::user();

        if ($user->isBuyerAndSeller()) {
            $routePath = route('enquiry.list', ['userType' => 'buyer', 'listType' => 'enquiries']);

            return $routePath;
        } elseif ($user->isBuyer()) {
            $routePath = route('enquiry.list', ['userType' => 'buyer', 'listType' => 'enquiries']);

            return $routePath;
        } elseif ($user->isSeller()) {
            $routePath = route('enquiry.list', ['userType' => 'seller', 'listType' => 'enquiries']);

            return $routePath;
        }
    }

    /**
     * Get open requests URL
     *
     */
    public function openBuyingRequests()
    {
        $user = Auth::user();

        if ($user->isBuyerAndSeller()) {
            $routePath = route('enquiry.list', ['userType' => 'seller', 'listType' => 'enquiries']);

            return $routePath;
        } elseif ($user->isBuyer()) {
            $routePath = route('enquiry.list', ['userType' => 'buyer', 'listType' => 'enquiries']);

            return $routePath;
        } elseif ($user->isSeller()) {
            $routePath = route('enquiry.list', ['userType' => 'seller', 'listType' => 'enquiries']);

            return $routePath;
        }
    }

    /**
     * Get open requests URL
     *
     */
    public function acceptedRequests()
    {
        $user = Auth::user();

        if ($user->isBuyerAndSeller()) {
            $routePath = route('enquiry.list', ['userType' => 'buyer', 'listType' => 'orders']);

            return $routePath;
        } elseif ($user->isBuyer()) {
            $routePath = route('enquiry.list', ['userType' => 'buyer', 'listType' => 'orders']);

            return $routePath;
        } elseif ($user->isSeller()) {
            $routePath = route('enquiry.list', ['userType' => 'seller', 'listType' => 'orders']);

            return $routePath;
        }
    }

    /**
     * Get open requests URL
     *
     */
    public function acceptedBuyingRequests()
    {
        $user = Auth::user();

        if ($user->isBuyerAndSeller()) {
            $routePath = route('enquiry.list', ['userType' => 'seller', 'listType' => 'orders']);

            return $routePath;
        } elseif ($user->isBuyer()) {
            $routePath = route('enquiry.list', ['userType' => 'buyer', 'listType' => 'orders']);

            return $routePath;
        } elseif ($user->isSeller()) {
            $routePath = route('enquiry.list', ['userType' => 'seller', 'listType' => 'orders']);

            return $routePath;
        }
    }

    /**
     * Get open requests URL
     *
     */
    public function declinedRequests()
    {
        $user = Auth::user();

        if ($user->isBuyerAndSeller()) {
            $routePath = route('enquiry.list', ['userType' => 'buyer', 'listType' => 'orders']);

            return $routePath;
        } elseif ($user->isBuyer()) {
            $routePath = route('enquiry.list', ['userType' => 'buyer', 'listType' => 'orders']);

            return $routePath;
        } elseif ($user->isSeller()) {
            $routePath = route('enquiry.list', ['userType' => 'seller', 'listType' => 'orders']);

            return $routePath;
        }
    }

    /**
     * Get open requests URL
     *
     */
    public function declinedBuyingRequests()
    {
        $user = Auth::user();

        if ($user->isBuyerAndSeller()) {
            $routePath = route('enquiry.list', ['userType' => 'seller', 'listType' => 'orders']);

            return $routePath;
        } elseif ($user->isBuyer()) {
            $routePath = route('enquiry.list', ['userType' => 'buyer', 'listType' => 'orders']);

            return $routePath;
        } elseif ($user->isSeller()) {
            $routePath = route('enquiry.list', ['userType' => 'seller', 'listType' => 'orders']);

            return $routePath;
        }
    }

    /**
     * Render the component
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('frontend.livewire.dashboard-panels');
    }
}
