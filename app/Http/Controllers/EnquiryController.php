<?php

namespace App\Http\Controllers;

use App\CartItem;
use App\Enquiry;
use App\Service\EnquiryService;
use App\Service\TransactionNotificationService;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnquiryController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, EnquiryService $enquiryService)
    {
        $enquiryItems = CartItem::where('user_id', Auth::user()->id)->get()->filter(function($item) {
            return $item->vehicle;
        });

        //@todo validate
        //$enquiryService->validateEnquiry($enquiryItems, $request);
        session()->flash('success', 'Enquiry has been started.');
        $enquiry = $enquiryService->handleEnquiry($enquiryItems);

        list($enquiryItems, $totalVehicles, $totalPrice) = $enquiryService->groupEnquiryItems($enquiryItems);

        return view('frontend.enquiry', [
            'enquiryItems' => $enquiryItems,
            'totalVehicles' => $totalVehicles,
            'totalPrice' => $totalPrice,
            'enquiry' => $enquiry
        ]);
    }

    /**
     * List transactions
     *
     * @param Request $request
     * @param $userType
     * @param Enquiry $enquiry
     * @param EnquiryService $enquiryService
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function list(Request $request, $userType, Enquiry $enquiry, EnquiryService $enquiryService)
    {
        $transactions = $enquiryService->getTransactions();

        $routeName = $request->route()->getName();

        $routeNameArray = explode('.', $routeName);

        return view('frontend.enquiry.list', [
            'transactions' => $transactions,
            'type' => $userType,
            'listType' => $routeNameArray[0],
        ]);
    }
}
