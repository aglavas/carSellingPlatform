<?php

namespace App\Http\Controllers;

use App\Enquiry;
use App\Mail\ContactForm;
use App\Notifications\ContactMessage;
use App\Notifications\InviteComplete;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class ContactController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        activity('contact_form')
            ->withProperties($request->all())
            ->log('Contact Form submitted.');
        $request->merge([
                            'user' => auth()->user()
                        ]);
        $recipients = [
            'andreas.pattynama@emilfrey.ch',
            'kim.pattynama@emilfrey.ch'
        ];
        Mail::to($recipients)->send(new ContactForm($request->all()));
        return view('frontend.contact-sent');
    }

    public function show() {
        return view('frontend.contact');
    }
}
