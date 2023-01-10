<?php

namespace App\Http\Controllers;

use App\CartItem;
use App\Enquiry;
use App\Service\EnquiryService;
use App\Service\TransactionNotificationService;
use App\StockListUpload;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UploadController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, StockListUpload $upload)
    {
        if ($upload->status == 1) {
            $upload->totalErrors = 0;
        } else {
            $errorArray = explode('Line', $upload->status);
            $upload->totalErrors = count($errorArray);
        }

        return view('frontend.upload', [
            'upload' => $upload
        ]);
    }

    /**
     * Show upload info
     *
     * @param Request $request
     * @param StockListUpload $upload
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function info(Request $request, StockListUpload $upload)
    {
        if ($upload->status == 1) {
            $upload->totalErrors = 0;
        } else {
            $errorArray = explode('Line', $upload->status);
            $upload->totalErrors = count($errorArray);
        }

        return view('frontend.uploadInfo', [
            'upload' => $upload
        ]);
    }
}
