<?php

namespace App\Http\Controllers;

use App\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StartController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $enquiries = Enquiry::where('user_id', Auth::user()->id);
        return view('frontend.start', [
            'enquiries' => $enquiries
        ]);
    }
}
