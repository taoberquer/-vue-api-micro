<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MainController extends Controller
{
    public function confirmDonation(Request $request)
    {
        $validated = $this->validate($request, [
            'email' => 'required|email|max:255',
        ]);

        $data = array('name'=>'Arunkumar');
        Mail::send('mails.confirm_order', $data, function($message) use ($validated) {
            $message->to($validated['email'], '')->subject('Confirmation de votre donation');
            $message->from('service@echangeaveccredit.fr','EAC');
        });
        echo 'Email Sent. Check your inbox.';
    }
}
